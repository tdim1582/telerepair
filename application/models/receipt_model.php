<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt_model extends CI_Model {

  var $title   = '';
  var $content = '';
  var $date    = '';

  function __construct()
  {
      // Call the Model constructor
      parent::__construct();
  }

  function create()
  {
    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');
    $pin = $this->input->post('pin');
    $phone_code = $this->input->post('phone_code');
    $product_id = $this->input->post('product_id');
    $description = $this->input->post('description');
    $pickup_time = $this->input->post('pickup_time');
    $no_test = $this->input->post('no_test');
    $paid = $this->input->post('paid');
    $discount = $this->input->post('discount');
    $repair_price = $this->input->post('repair_price');
    $repair_price = $this->input->post('repair_price_existing');
    $comment_status = $this->input->post('comment_status');
    $price_total = array_sum($repair_price);
    $total_after_discount = $price_total;
    $discount_amount = 0;
        
    if($discount){
    $discount_amount = ($price_total * $discount)/100;
    $total_after_discount = $price_total - $discount_amount;
    } else {
        $discount = 0;
    }

    if($product_id == 'diverse'){
      $product_data = array(
        'name'              => $this->input->post('product_name'),
        'boutique_id'       => $this->session->userdata('active_boutique'),
        'created_timestamp' => time()
      );
      $this->db->insert('products',$product_data);

      $product_id = $this->db->insert_id();

      $this->global_model->log_action('product_created',$product_id);
    }

    if($phone && !$this->db->from('customers')->where('phone',$this->input->post('phone'))->count_all_results()){
        $customer_data = array(
          'name' => $name,
          'email' => $email,
          'phone' => $phone,
          'phone_code' => $phone_code,
          'pin' => $pin,
          'created_timestamp' => date("Y-m-d H:i:s")
        );

        $this->db->insert('customers',$customer_data);
    }
    
        
    $string = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'pin' => $pin,
        'pickup_time' => $pickup_time,
        'no_test' => $no_test,
        'phone_code' => $phone_code,
        'paid' => $paid,
        'description' => $description,
        'created_timestamp' => time(),
        'boutique_id' => $this->session->userdata('active_boutique'),
        'uid' => $this->session->userdata('uid'),
        'product_id' => $product_id,
        'discount' => $discount,
        'total' => $price_total,
        'total_after_discount' => $total_after_discount,
        'discount_amount' => $discount_amount,
        'comment_status' => $comment_status,
    );
    $this->db->insert('receipt',$string);

    $inserted_id = $this->db->insert_id();

    $repairs = $this->input->post('repair_name');


		$partName = [];
		$partPrice = [];

    $i = 0;
    foreach($repairs as $repair){
      if ($repair != '') {
        $string = array(
                'name' => $repair,
                'price' => $_POST['repair_price'][$i],
                'receipt_id' => $inserted_id,
                'created_timestamp' => time(),
					      'uid' => $this->session->userdata('uid'),
                'garanti' => 1,
      				  'payment_type' => 'default',
                'discount' => $discount,
                'product_id' => $product_id,
        );
        $this->db->insert('repairs',$string);

				array_push($partName, $repair);
				array_push($partPrice,  $_POST['repair_price'][$i]);

        $i++;
      }
    }

    $model = $product_id;
   $discount_add = $discount;

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
			
			$receipt			   = $inserted_id;
			
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
			$product_discount	=	$discount_add;
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
				$product_discount	=	$discount_add;
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
			
			
			for($i=0;$i<count($partName);$i++){
			// get access
				// create new part
			$stringunique = random_string('alnum', 25);
				$string = array(
					'name' => $partName[$i],
					'price' => $partPrice[$i],
					'product_id' => $model,
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
			$this->db->where('id',$model);
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
			"product_id"				=>	$model,
			"product"					=>	$model_name,
			"part_id"					=>	$access_id,
			"part"					=>	$access_name,
			"price"					=>	$partPrice[$i],
			"qty"						=>	$partQty[$i]?$partQty[$i]:1,
			"total_price"				=>	$partPrice[$i]*$partQty[$i]?$partQty[$i]:1,
			"product_discount"		=>	$discount_add,
			);
			
			$this->db->insert("order_item",$order_item);
			
			// update inventory
			
				$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
				$this->db->where('product_id',$model);
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

    return $inserted_id;
		//redirect('receipt?open_receipt='.$inserted_id.'');

    }


    function update()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $pin = $this->input->post('pin');
        $phone_code = $this->input->post('phone_code');
        $product_id = $this->input->post('product_id');

        $description = $this->input->post('description');

        $pickup_time = $this->input->post('pickup_time');
        $no_test = $this->input->post('no_test');
        $paid = $this->input->post('paid');
        $delivered = $this->input->post('delivered');

        $discount = $this->input->post('discount');
        $repair_price = $this->input->post('repair_price_existing');
        $comment_status = $this->input->post('comment_status');
        $price_total = array_sum($repair_price);
        $total_after_discount = $price_total;
        $discount_amount = 0;
        if($discount){
          $discount_amount = ($price_total * $discount)/100;
          $total_after_discount = $price_total - $discount_amount;
        } else {
            $discount = 0;
        }

        $id = $this->input->post('id');

        if($product_id == 'diverse'){
          $product_data = array(
            'name'              => $this->input->post('product_name'),
            'boutique_id'       => $this->session->userdata('active_boutique'),
            'created_timestamp' => time()
          );
          $this->db->insert('products',$product_data);

          $product_id = $this->db->insert_id();

          $this->global_model->log_action('product_created',$product_id);
        }

        if(!$this->db->from('customers')->where('email',$this->input->post('email'))->count_all_results()){
            $customer_data = array(
              'name' => $name,
              'email' => $email,
              'phone' => $phone,
              'phone_code' => $phone_code,
              'pin' => $pin,
              'created_timestamp' => date("Y-m-d H:i:s")
            );

            $this->db->insert('customers',$customer_data);
        }


        $string = array(
          'name' => $name,
          'email' => $email,
          'phone' => $phone,
          'pin' => $pin,
          'pickup_time' => $pickup_time,
          'no_test' => $no_test,
          'phone_code' => $phone_code,
          'paid' => $paid,
          'description' => $description,
          'delivered' => $delivered,
          'product_id' => $product_id,
          'discount' => $discount,
          'total' => $price_total,
          'total_after_discount' => $total_after_discount,
          'discount_amount' => $discount_amount,
          'comment_status' => $comment_status,
        );

        $this->db->where('id',$id)->update('receipt',$string);


        $repair_existing = $this->input->post('repair_name_existing');

        if($repair_existing){
          foreach($repair_existing as $repid => $repairex){

      			$string = array(
      				'name' => $repairex,
      				'price' => $_POST['repair_price_existing'][$repid],
              'product_id' => $product_id,
      			);

      			$this->db->where('id',$repid)->update('repairs',$string);

      		}
        }



    		$repairs = $this->input->post('repair_name');


    		$i = 0;

        if($repairs){
          foreach($repairs as $repair){
            if ($repair != '') {

              $string = array(
                'name' => $repair,
                'price' => $_POST['repair_price'][$i],
                'receipt_id' => $id,
                'created_timestamp' => time(),
					      'uid' => $this->session->userdata('uid')
              );
              $this->db->insert('repairs',$string);


              $i++;
            }
      		}
        }


    		//redirect('receipt?open_receipt='.$inserted_id.'');

    }
    function get_warranty_text() {
        $this->db->where('id',6); // ID 6 is "Ingen test" warranty for receipt printing.
            
        $result = $this->db->get('garanti')->result();
        
        if($result) {
            return $result[0]->text;
        } else {
            return false;
        }
    }

}

// end of model file
