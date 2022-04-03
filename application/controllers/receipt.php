<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
    }

	public function index()
	{

		if($this->input->post('create') || $this->input->post('create_print')){
			$this->load->model('receipt_model');
			$id = $this->receipt_model->create();
			if ($this->input->post('comment') != '') {
				$string = array(
					'comment' => $this->input->post('comment'),
					'created_timestamp' => time(),
					'receipt_id' => $id,
					'uid' => $this->session->userdata('uid')
				);
				$this->db->insert('receipt_comments',$string);
			}
			redirect('receipt?print_now='.$id);
			if($this->input->post('create_print')){
				redirect('receipt?print_now='.$id);
				//echo "<script>window.open('".base_url('receipt/print_/'.$id)."','_blank');</script>";
				//redirect('receipt/print_/'.$id);
			}else{
				redirect('receipt');
			}
		}


		//$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		//$this->db->order_by('created_timestamp','desc');
		//$data['receipts'] = $this->db->get('receipt')->result();

		$this->load->model('product_model');
		$data['products'] = $this->product_model->get_products();


		$data['yield'] = "receipt/index";
		$this->load->view('layout/application',$data);
	}


	function print_($id){
        $this->load->model('receipt_model'); //Needed to get warranty text.
        $data['warranty'] = $this->receipt_model->get_warranty_text();
        
        if(!$data['warranty']){
            echo "Warranty information missing.";
            die();
		}
		
		$this->db->select('receipt.*,products.name as product_name')->join('products','products.id = receipt.product_id','left');
		$this->db->where('receipt.id',$id);
		$data['receipt'] = $this->db->get('receipt')->result();

		if(!$data['receipt']){
          echo "Receipt information missing.";
          die();
		}

		$this->db->where('receipt_id',$id);
		$data['repairs'] = $this->db->get('repairs')->result();

		// get boutique info
		$this->db->where('id',$data['receipt'][0]->boutique_id);
		$data['boutique_info'] = $this->db->get('boutiques')->result();

		if($data['boutique_info']){
			$data['initial'] = $data['boutique_info'][0]->initial;
			$data['address'] = $data['boutique_info'][0]->address;
			$data['tlcvremail'] = $data['boutique_info'][0]->tlcvremail;
		}else{
			$data['initial'] = '';
			$data['address'] = '';
			$data['tlcvremail'] = '';
		}

		$this->load->view('receipt/print',$data);

	}

	function print_repairs($id){
        $this->load->model('receipt_model'); //Needed to get warranty text.
        $data['warranty'] = $this->receipt_model->get_warranty_text();
        
        if(!$data['warranty']){
            echo "Warranty information missing.";
            die();
		}
		
		$data['ids'] = $id;
		$data['args'] = $_GET['repairs_list'];
		$this->db->select('receipt.*,products.name as product_name')->join('products','products.id = receipt.product_id','left');
		$this->db->where('receipt.id',$id);
		$data['receipt'] = $this->db->get('receipt')->result();

		if(!$data['receipt']){
          echo "Receipt information missing.";
          die();
		}

		// $this->db->where('receipt_id',$id); 
		$where_in_condition = 'id IN (';
		foreach ($_GET['repairs_list'] as $key => $repair_id) {
			if ($key == 0) {
				$where_in_condition .= $repair_id;
			} else {
				$where_in_condition .= ',' . $repair_id;
			}
		}
		$where_in_condition .= ')';
		$this->db->where($where_in_condition);

		$data['repairs'] = $this->db->get('repairs')->result();

		foreach($data['repairs'] as $key => $rep) {
			$this->db->where('id',$rep->product_id);
			$product = $this->db->get('products')->result();
			$data['product_names'][$key] = $product[0]->name;
		}

		// get boutique info
		$this->db->where('id',$data['receipt'][0]->boutique_id);
		$data['boutique_info'] = $this->db->get('boutiques')->result();

		if($data['boutique_info']){
			$data['initial'] = $data['boutique_info'][0]->initial;
			$data['address'] = $data['boutique_info'][0]->address;
			$data['tlcvremail'] = $data['boutique_info'][0]->tlcvremail;
		}else{
			$data['initial'] = '';
			$data['address'] = '';
			$data['tlcvremail'] = '';
		}

		$this->load->view('receipt/print_repairs',$data);

	}

	public function edit($id){
		$this->db->where('id',$id);
		$data['receipt'] = $this->db->get('receipt')->row();

		if(!$data['receipt']){
			die();
		}

		$this->db->where('receipt_id',$id);
		$data['repairs'] = $this->db->get('repairs')->result();

		$this->load->model('product_model');
		$data['products'] = $this->product_model->get_products();


		$this->load->view('receipt/_edit',$data);
	}

	public function update(){
		if($this->input->post('update')){
			$this->load->model('receipt_model');
			$this->receipt_model->update();
			if ($this->input->post('comment') != '') {
				$string = array(
					'comment' => $this->input->post('comment'),
					'created_timestamp' => time(),
					'receipt_id' => $this->input->post('id'),
					'uid' => $this->session->userdata('uid')
				);
				$this->db->insert('receipt_comments',$string);
			}
		}

		redirect('receipt');
	}

	function show($id = false){
		
		$this->db->where('id',$id);
		$data['receipt'] = $this->db->get('receipt')->result();
		
		if(!$data['receipt']){
			redirect('receipt');
			exit;
		}
		
		// get created by info
		$this->db->where('id',$data['receipt'][0]->uid);
		$data['by'] = $this->db->get('users_kasse')->result();
		
		if($data['by']){
			$data['by_name'] = $data['by'][0]->name;
		}else{
			$data['by_name'] = '?';
		}
		
		if($this->input->post('comment_status_update')){
			$string = array(
				'comment_status' => $this->input->post('comment_status')
			);
			$this->db->where('id',$id);
			$this->db->update('receipt',$string);
			
			$this->global_model->log_action('receipt_comment_status_updated',$id,false,$this->input->post('comment_status'),0);
			
			redirect('receipt/show/'.$id);
		}
		
		if($this->input->post('create_comment')){
			if ($this->input->post('comment') != '') {
			
				$string = array(
					'comment' => $this->input->post('comment'),
					'created_timestamp' => time(),
					'receipt_id' => $id,
					'uid' => $this->session->userdata('uid')
				);
				$this->db->insert('receipt_comments',$string);
			}
			redirect('receipt/show/'.$id);
			
		}

		if($this->input->post('create_reparation')){
			if ($this->input->post('name') != '') {
			
				$string = array(
					'name' => $this->input->post('name'),
					'price' => $this->input->post('price'),
					'receipt_id' => $id,
					'created_timestamp' => time(),
					'uid' => $this->session->userdata('uid'),
					'product_id' => $this->input->post('model'),
				);
				$this->db->insert('repairs',$string);
			}
			redirect('receipt/show/'.$id);
			
		}
		
		$this->db->where('id',$data['receipt'][0]->boutique_id);
		$data['boutique_info'] = $this->db->get('boutiques')->result();
		
		if($data['boutique_info']){
			$data['boutique_name'] = $data['boutique_info'][0]->name;
		}else{
			$data['boutique_name'] = '';
		}
		
		$data['yield'] = "receipt/show";
		$this->load->view('layout/application',$data);
		
	}

	function repairs_() {

		$id = $this->input->post('id');
		$repairs_id = $this->input->post('repairs_id');
		
		$data['id'] = $id;
		$data['repairs_id'] = $repairs_id;

		$this->db->where('receipt.id',$id);
		$data['receipt'] = $this->db->get('receipt')->result();

		if(!$data['receipt']){
          echo "Receipt information missing.";
          die();
		}

		// $this->db->where('receipt_id',$id); 
		$where_in_condition = 'id IN (';
		foreach ($repairs_id as $key => $repair_id) {
			if ($key == 0) {
				$where_in_condition .= $repair_id;
			} else {
				$where_in_condition .= ',' . $repair_id;
			}
		}
		$where_in_condition .= ')';
		$this->db->where($where_in_condition);

		$data['repairs'] = $this->db->get('repairs')->result();
		$data['garantiData'] = $this->global_model->selectAllData('garanti');

		$this->load->view('receipt/_repairs',$data);
	}

	function edit_repairs() {
		$repairs_id = $this->input->post('id');
		$receipt_id = $this->input->post('receipt_id');
		$payment_type = $this->input->post('payment_type');
		$garanti = $this->input->post('garanti');
		$model = [];
		$partName = [];
		$partPrice = [];
		$discount_add = [];

        if($repairs_id){
			$repairs_id = explode(',', $repairs_id);
          	foreach($repairs_id as $repair_id){

      			$string = array(
      				'garanti' => $garanti,
      				'payment_type' => $payment_type,
					'name' => $_POST['repair_name_existing'][$repair_id],
					'price' => $_POST['repair_price_existing'][$repair_id],
					'discount' => $_POST['repair_discount_existing'][$repair_id],
					'product_id' => $_POST['repair_product'][$repair_id]
      			);

				array_push($model, $_POST['repair_product'][$repair_id]);
				array_push($partName, $_POST['repair_name_existing'][$repair_id]);
				array_push($partPrice, $_POST['repair_price_existing'][$repair_id]);
				array_push($discount_add, $_POST['repair_discount_existing'][$repair_id]);

      			$this->db->where('id',$repair_id)->update('repairs',$string);

      		}
			
			$gb_name_bought_from = '';
			
			$type = 'access';
			// $model                 = $this->input->post('repair_product');
			$gb                    = $this->input->post('gb');
			$imei                  = $this->input->post('imei');
			$color                 = $this->input->post('color');
			
			$seller_name           = $this->input->post('seller_name');
			$seller_id             = $this->input->post('seller_id');
			$seller_email          = $this->input->post('seller_email');
			
			$errors                = $this->input->post('errors');
			$price                 = $this->input->post('price');
			
			$regnr                 = $this->input->post('reg_nr');
			$account_nr            = $this->input->post('account_nr');
			
			$bought_order_id       = $this->input->post('bought_order_id');
			
			$number                = $this->input->post('number');
			$buyer_name            = $this->input->post('buyer_name');
			$company_name          = $this->input->post('company_name');
			$cvr           		     = $this->input->post('cvr');
			$email           		   = $this->input->post('email');
			$show_name             = $this->input->post('show_name')?$this->input->post('show_name'):0;
			
			$webshop_id            = $this->input->post('order_id');
			
			$condition             = $this->input->post('condition');
			
			$payment_type          = $this->input->post('payment_type');
			
			$access                = $this->input->post('access');
			
			// $partName              = $this->input->post('newAccessName');
			// $partPrice             = $this->input->post('item_pris');
			// $discount_add          = $this->input->post('discount_add');
			$partQty               = $this->input->post('qty');
			$exchange              = $this->input->post('exchange');
			
			$extra_access          = $this->input->post('extra_access');
			$extra_access_to_order_id = $this->input->post('extra_access_to_order_id');
			
			$exchangeId            = $this->input->post('exchangeId');
			$exchangePrice         = $this->input->post('exchangePrice');
			$exchangeBoughtPrice   = $this->input->post('exchangeBoughtPrice');
			
			$legimation_type       = $this->input->post('legimation_type');
			
			$discount_amount       = $this->input->post('discount_add');
			
			$panserBox  		   = $this->input->post('panserBox');
			$headsetBox  		   = $this->input->post('headsetBox');
			$beskyttelseBox  	   = $this->input->post('beskyttelseBox');
			
			
			$insuranceBox          = $this->input->post('insuranceBox');
			$insurancePrice        = $this->input->post('insurancePrice');
			$insuranceYears        = $this->input->post('insurance_years');
			
			$split_cash      	   = $this->input->post('split_cash');
			$split_card			   = $this->input->post('split_card');
			
			$receipt			   = $this->input->post('receipt_id');
			
			$garanti = $this->input->post('garanti');
			
			$subtotal = (float)$this->input->post('subtotal');
			
			if($this->input->post('discount')){
			$discount_amount = $this->input->post('discount_add');
			}
			if(!$payment_type){
				$payment_type = 'cash';
			}
			
			if($type == 'sold'){
				if($payment_type == 'webshop'){
					$set_boutique_id = 4;
				}else{
					$set_boutique_id = $this->session->userdata('active_boutique');
				}
			}else{
				$set_boutique_id = $this->session->userdata('active_boutique');
			}
			
			if($type == 'sold'){
				$this->db->where('id',$bought_order_id);
				$get_order_info = $this->db->get('orders')->result();
			
				if($get_order_info){
					$model = $get_order_info[0]->product_id;
					$gb    = $get_order_info[0]->gb_id;
					$gb_name_bought_from    = $get_order_info[0]->gb;
					$imei  = $get_order_info[0]->imei;
					$color = $get_order_info[0]->color;
				}
			
				$seller_name = $buyer_name;
			
			}elseif($type == 'access'){
				$seller_name = $buyer_name;
			}
			
			
			if(!$price){
			$price = 0;
			$total_price = 0;
			for($i=0;$i<count($partPrice);$i++){
			$product_discount	=	$discount_add[$i];
			$qty = $partQty[$i]?$partQty[$i]:1;
			$unit_price = $partPrice[$i]?$partPrice[$i]:1;
			$price += ($qty * $unit_price);
			$each_discount_price  = (($unit_price * $qty)*$product_discount)/100;
			$total_price = $total_price + ($unit_price * $qty)-$each_discount_price;
			}
			}
			
			if(!$subtotal){
			$subtotal = $price;
			}
			
			// get gb
			$this->db->where('id',$gb);
			$gb_info = $this->db->get('gbs')->result();
			
			if($gb_info){
				$gb_name = $gb_info[0]->name;
			}else{
				$gb_name = '';
			}
			
			if($type == 'sold'){
				$gb_name = $gb_name_bought_from;
			}
			
			if($insuranceBox){
				$price += $insurancePrice;
			}
			
			$company_name = $this->input->post('company_name');
			
			
			if($payment_type == 'invoice'){
				//$company_name = $this->input->post('invoice_company_name');
				//$seller_name = $this->input->post('invoice_buyer_name');
				$number = $this->input->post('invoice_number');
				//$cvr = $this->input->post('invoice_cvr');
			}
			
			if($this->input->post('hidden') == 1){
				$hidden = 1;
			}else{
				$hidden = 0;
			}
			
			if($bought_order_id == ''){
				$bought_order_id = 0;
			}
			
			if($extra_access_to_order_id == ''){
				$extra_access_to_order_id = 0;
			}
			
			if($discount_amount == ''){
				$discount_amount = 0;
			}
			
			if($exchangeId == ''){
				$exchangeId = 0;
			}
			
			if($split_cash == ''){
				$split_cash = '0.00';
			}
			
			if($split_card == ''){
				$split_card = '0.00';
			}
			
			if($exchangePrice == ''){
				$exchangePrice = '0.00';
			}
			
			if($insurancePrice == ''){
				$insurancePrice = '0.00';
			}
			
			if($exchangeBoughtPrice == ''){
				$exchangeBoughtPrice = '0.00';
			}
			
			if($insuranceYears == ''){
				$insuranceYears = 0;
			}
			
			if($panserBox == ''){
				$panserBox = 0;
			}
			
			if($headsetBox == ''){
				$headsetBox = 0;
			}
			
			if($beskyttelseBox == ''){
				$beskyttelseBox = 0;
			}
						
			//Discount calculation
			$discount_calculated = 0;
			$total_price = 0;
					
			$item_count = count($discount_amount);
			var_dump($item_count);
			file_put_contents("dump.txt", ob_get_contents());
			
			
			for ($i = 0; $i < $item_count; $i++) {
					$pQ = $partQty[$i]?$partQty[$i]:1;
					$pP = $pQ * $partPrice[$i]?$partPrice[$i]:0;
					$each_discount_price  =  round($pQ * $pP * $discount_amount[$i] / 100);
					$discount_calculated +=  $each_discount_price;
					$total_price += $pQ * $pP - $each_discount_price;
				} 

			$price = 0;
			$total_price = 0;
			for($i=0;$i<count($partPrice);$i++){
				$product_discount	=	$discount_add[$i];
				$qty = $partQty[$i]?$partQty[$i]:1;
				$unit_price = $partPrice[$i]?$partPrice[$i]:1;
				$price += ($qty * $unit_price);
				$each_discount_price  = (($unit_price * $qty)*$product_discount)/100;
				$total_price = $total_price + ($unit_price * $qty)-$each_discount_price;
				
			}

		
			//var_dump($discount_calculated);
			//var_dump($total_price);
			// $discount_calculated = 0;
			$discount_calculated = $price - $total_price;

				//var_dump($discount_calculated);
				
				//file_put_contents("dump.txt", ob_get_contents());
				//ob_end_clean();
				
			$string = array(
				'name' => $seller_name,
				'imei' => $imei,
							'email' => $email,
				'address' => '',
				'phone_id' => 0,
				'company' => $company_name,
				'color' => $color,
				'seller_id' => $seller_id,
				'number' => $number,
				'seller_email'   => $seller_email,
				'seller_name' => '$seller_name',
				'seller_number' => '',
				'errors' => $errors,
				'payment_type' => $payment_type,
				'type' => $type,
				'transfered' => 0,
				'condition' => $condition,
				'price' => $total_price,
				'reg_nr' => $regnr,
				//'part' => $access_name,
				'part' => '',
				'hidden' => $hidden,
				//'part_id' => $access_id,
				'part_id' => 0,
				'webshop_id' => $webshop_id,
				'account_nr' => $account_nr,
				'created_timestamp' => time(),
				'uid' => $this->session->userdata('uid'),
				'gb_id' => $gb,
				'discount' => $discount_calculated,
				'subtotal' => $subtotal,
				'exchange' => $exchange,
				'wrong' => 0,
				'bought_from_order_id' => $bought_order_id,
				'sold' => 0,
				'product_id' => 0,
				//'product_id' => $model,
				'legimation_type' => $legimation_type,
				'product' => '',
				//'product' => $model_name,
				'gb' => $gb_name,
				'cvr' => $cvr,
				'withPanser' => $panserBox,
				'withHeadset' => $headsetBox,
				'withFilter' => $beskyttelseBox,
				'exchangeId' => $exchangeId,
				'split_cash' => $split_cash,
				'split_card' => $split_card,
				'exchangePrice' => $exchangePrice,
				'exchangeBoughtPrice' => $exchangeBoughtPrice,
				'extra_access_to_order_id' => $extra_access_to_order_id,
				'already_tested' => 0,
				'fraud' => 0,
				'defect' => 0,
				'creditlineConnectedID' => 0,
				'cancelled' => 0,
				'credit_reason' => '',
				'boutique_id' => $set_boutique_id,
				'insurance' => $insuranceBox,
				'insurance_price' => $insurancePrice,
				'insurance_years' => $insuranceYears,
				'garanti' => $garanti,
				'show_name' => $show_name,
				'receipt_id' => $receipt
			);
			$this->db->insert('orders',$string);
			
			$inserted_order_id = $this->db->insert_id();
			
			// update sold order line
			if($type == 'sold'){
				if($this->input->post('hidden') == 1){
					$string = array(
						'sold' => 1,
						'defect' => 1
					);
				}else{
					$string = array(
						'sold' => 1
					);
				}
				$this->db->where('id',$bought_order_id);
				$this->db->update('orders',$string);
			
			}
			
			if($type == 'sold'){
			
				// update inventory
				$this->db->where('boutique_id',$set_boutique_id);
				$this->db->where('product_id',$model);
				$this->db->where('gb',$gb_name);
				$inventory = $this->db->get('inventory')->result();
			
				if($inventory){
					$new_inventory = $inventory[0]->inventory-1;
					$string = array(
						'inventory' => $new_inventory
					);
					$this->db->where('id',$inventory[0]->id);
					$this->db->update('inventory',$string);
				}
			
				redirect('sold?open_receipt='.$inserted_order_id.'');
			
			}elseif($type == 'access'){
			
			
			for($i=0;$i<count($model);$i++){
			// get access
				// create new part
			$stringunique = random_string('alnum', 25);
				$string = array(
					'name' => $partName[$i],
					'price' => $partPrice[$i],
					'product_id' => $model[$i],
					'inventory' => $partQty[$i]?$partQty[$i]:1,
					'hide' => 1,
					'part_of_inventory' => 0,
					'part_order' => 0,
					'created_timestamp' => time(),
					'boutique_id' => $this->session->userdata('active_boutique'),
					'unqiue_string' => $stringunique
				);
				$this->db->insert('parts',$string);
			
				$access_name = $partName[$i];
				$access_id      = $this->db->insert_id();
			
			
			// get model
			$this->db->where('id',$model[$i]);
			$product_info = $this->db->get('products')->result();
			
			if($product_info){
				$model_name = $product_info[0]->name;
			}else{
				$model_name = '';
			}
			
			$order_item = array(
			"order_id"				=>	$inserted_order_id,
			"color" 					=> 	'',
			"gb_id" 					=> 	0,
			"gb" 						=> 	'',
			"product_id"				=>	$model[$i],
			"product"					=>	$model_name,
			"part_id"					=>	$access_id,
			"part"					=>	$access_name,
			"price"					=>	$partPrice[$i],
			"qty"						=>	$partQty[$i]?$partQty[$i]:1,
			"total_price"				=>	$partPrice[$i]*$partQty[$i]?$partQty[$i]:1,
			"product_discount"		=>	$discount_add[$i],
			);
			
			$this->db->insert("order_item",$order_item);
			
			// update inventory
			
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
				$this->db->where('product_id',$model[$i]);
				$this->db->where('unqiue_string',$access[$i]);
				$inventory = $this->db->get('parts')->result();
			
				if($inventory){
					if($inventory[0]->part_of_inventory){
						$new_inventory = $inventory[0]->inventory-($partQty[$i]?$partQty[$i]:1);
						$string = array(
							'inventory' => $new_inventory
						);
						$this->db->where('id',$inventory[0]->id);
						$this->db->update('parts',$string);
					}
				}
			
			} //END OF FOR LOOP
			
			
			
			
			
				if($extra_access == 1 && $extra_access_to_order_id){
					redirect('access/extra/'.$extra_access_to_order_id.'');
				}elseif($extra_access == 1){
					redirect('access/extra/'.$inserted_order_id.'');
				}
			
			}else{
			
				// update inventory
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
				$this->db->where('product_id',$model);
				$this->db->where('gb',$gb_name);
				$inventory = $this->db->get('inventory')->result();
			
			
				if($inventory){
					$new_inventory = $inventory[0]->inventory+1;
					$string = array(
						'inventory' => $new_inventory
					);
					$this->db->where('id',$inventory[0]->id);
					$this->db->update('inventory',$string);
				}else{
					$string = array(
						'color' => 0,
						'condition' => 0,
						'inventory' => 1,
						'product_id' => $model,
						'gb' => $gb_name,
						'boutique_id' => $this->session->userdata('active_boutique'),
						'created_timestamp' => time()
					);
					$this->db->insert('inventory',$string);
				}
				if($this->input->post('unitsFromSamePerson')){
					redirect('bought?open_receipt='.$inserted_order_id.'&cid='.$inserted_order_id.'');
				}else{
					redirect('bought?open_receipt='.$inserted_order_id.'');
				}
			}
		}

		redirect('receipt/show/'.$receipt_id);
	}


	function repairs_delete() {

		$id = $this->input->post('id');
		$receipt_id = $this->input->post('receipt_id');

		$this->db->delete('repairs' ,array('id'=>$id));

		if ($this->db->_error_message()) {
			$result = 'Error! ['.$this->db->_error_message().']';
		} else {
			$result = 'Success';
		}
		$data['response'] = $result;
		echo json_encode( $data );
	}

	function create_reparation() {
		
		$string = array(
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'receipt_id' => $this->input->post('receipt_id'),
			'created_timestamp' => time(),
			'uid' => $this->session->userdata('uid'),
			'product_id' => $this->input->post('model'),
		);
		$this->db->insert('repairs',$string);
		$inserted_id = $this->db->insert_id();
		
		
		echo '<tr>';
        echo '<th> <input type="checkbox" id="repair_'.$string['id'].'" class="repair_check" name="scales" ></th>';
		echo '<th>';
		$this->db->where('id',$string['product_id']);
		$product = $this->db->get('products')->result();
		if (count($product) > 0) {
			echo($product[0]->name);
		} else {
			echo("-");
		}
        echo '</th>';
		echo '<th>';
		if ( strlen($string['name']) > 37 ) {
			echo substr($string['name'], 0, 37) . '...';
		} else {
			echo $string['name'];
		}
		echo '</th>';
		echo '<th>'.$string['price'].'</th>';
        echo '<th>';
		if($string['payment_type']) {
			echo('Ja');
		} else {
			echo('Ingen');
		}
		echo '</th>';
        echo '<th style="display: flex; position: relative;"> <img class="question-mark" src="'. base_url().'assets/images/iconmonstr-clock-thin.svg" />';
        echo ' <div class="hover-display" >';
		$this->db->where('id',$string['uid']);
		$userinfo = $this->db->get('users_kasse')->result();
		
		if($userinfo){
		$username = $userinfo[0]->name;
		}else{
		$username = '?';
		}
		echo $username. ', '.date("d/m/Y H:i",$string['created_timestamp']);
		echo '</div>';
		echo '</th>';
		echo '<th class="repair_delete" id="repair_delete_'. $string['id'].'">';
		echo '<p class="repair_delete_p" style="">  Delete </p>';
		echo '</th>';
		echo '</tr>';
		
	}

	function empty_new_rep() {
		$this->load->model('product_model');
		$products = $this->db->get('products')->result();
		echo '<div class="col-md-12 " style="padding-right: 10px; padding-left: 0;">';
		echo '  <div class="col-md-4" style="margin-top: 10px; padding-left: 0;">';
		echo '    <label>Tilbehør tilhører telefon</label>';
		// echo '    <div class="space"></div>';
		echo '    <select class="new_repair_model" class="form-control selectpicker" name="model[]" required style="width: 187px;height: 26px;">';
		echo '        <option value="">-</option>';
		foreach ($products as $product):
			echo '            <option value="'.$product->id.'">'.$product->name.'</option>';
		endforeach;
		echo '    </select>';
		echo '  </div>';
		echo '  <div class="col-md-4" style="margin-top: 10px;display: flex;flex-direction: column;justify-content: space-between;">';
		echo '    <label>Reparations navn</label>';
		echo '    <input class="new_repair_name" type="text" class="form-control" placeholder="Reparation" value="" name="name[]">';
		echo '  </div>';
		echo '  <div class="col-md-4" style="margin-top: 10px;display: flex;flex-direction: column;justify-content: space-between;">';
		echo '    <label>Reparations pris</label>';
		echo '    <input class="new_repair_price" type="text" class="form-control" placeholder="Reparation pris" value="" name="price[]">';
		echo '  </div>';
		echo '</div>';
		
		echo($new_rep);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
