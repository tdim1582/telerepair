<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
        $this->global_model->check_permission('inventory_overview');
    }
    
	public function index()
	{
		
		$data['title'] = 'Enheder';
		
		$this->load->model('product_model');	
		
		if($this->input->post('submit_product')){
			$this->product_model->create_product();
		}
		
		$data['products'] = $this->product_model->get_products();
		
		$data['loadjscss'] = '';
		
		$data['yield'] = "products/index";
		$this->load->view('layout/application',$data);
	}
	
	
	function hideparts(){
		
		$string = array(
			'hide' => 1
		);
		$this->db->update('parts',$string);
		
	}
	
	public function edit()
	{
		
		$id = $this->input->post('id');
		
		$this->load->model('product_model');	
		
		if($this->input->post('submit_product')){
			$this->product_model->edit($id);
		}
		
		$data['products'] = $this->product_model->get_product_by_id($id);
		
		$data['loadjscss'] = '';
		
		$this->load->view('products/_edit',$data);
	}
		
	
	function inventory($type = false,$id = false){
		
		$data['title'] = 'Lagerstyring';
		
		$this->load->model('product_model');
		$this->load->model('boutique_model');
		$this->load->model('inventory_model');

		if($this->input->post('submit')){
			$this->inventory_model->update_inventory($id);
		}
		
		if($this->input->post('add_part')){
			$this->inventory_model->add_part($id);
		}
		
		if($this->input->post('edit_part')){
			$this->inventory_model->edit_part($id);
		}
		
		if($this->input->post('add_defect')){
			$this->inventory_model->add_defect($id);
		}
		
		if($this->input->post('submit_intervals')){
			$this->inventory_model->update_intervals($id);
		}
		
		// check if gbs is created for product
		$this->inventory_model->check_if_gbs_is_created($id);

		$data['loadjscss'] = '';
		
		$data['products'] = $this->product_model->get_products();
		
		$data['product_info_array'] = $this->product_model->get_product_by_id($id);
		
		$data['colors'] = $this->product_model->get_colors_to_product($id);
		$data['gbs'] = $this->product_model->get_gbs_to_product($id);
		$data['conditions'] = $this->product_model->get_conditions_to_product($id);
		
		$data['access'] = $this->product_model->get_access($id);
		$data['boutiques'] = $this->boutique_model->get();
		
		$data['yield'] = "products/inventory";
		$this->load->view('layout/application',$data);
		
	}
	
	
	function inventory_defects($type = false, $id = false, $boutique_id,$part_id){
		
		$data['title'] = 'Lagerstyring';
		
		$this->load->model('product_model');
		$this->load->model('boutique_model');
		$this->load->model('inventory_model');

		if($this->input->post('submit')){
			$this->inventory_model->update_inventory($id);
		}
		
		if($this->input->post('add_part')){
			$this->inventory_model->add_part($id);
		}
		
		if($this->input->post('edit_part')){
			$this->inventory_model->edit_part($id);
		}
		
		if($this->input->post('add_defect')){
			$this->inventory_model->add_defect($id);
		}
		
		if($this->input->post('submit_intervals')){
			$this->inventory_model->update_intervals($id);
		}
		
		// check if gbs is created for product
		$this->inventory_model->check_if_gbs_is_created($id);

		$data['loadjscss'] = '';
		
		$data['products'] = $this->product_model->get_products();
		
		$data['product_info_array'] = $this->product_model->get_product_by_id($id);
		
		$data['colors'] = $this->product_model->get_colors_to_product($id);
		$data['gbs'] = $this->product_model->get_gbs_to_product($id);
		$data['conditions'] = $this->product_model->get_conditions_to_product($id);
		
		$data['access'] = $this->product_model->get_access($id);
		$data['boutique'] = $this->boutique_model->get_by_id($boutique_id);
		
		if($data['boutique']){
			$data['boutique_name'] = $data['boutique']->name;
		}else{
			$data['boutique_name'] = '?';
		}
		
		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('product_id',$id);
		$this->db->where('part_id',$part_id);
		$data['defects'] = $this->db->get('defects')->result();
		
		$data['yield'] = "products/inventory_defects";
		$this->load->view('layout/application',$data);
		
	}
	
	
	function transfer_back_to_inventory($order_id = false){
		
		
		$this->global_model->check_permission('all');
		
		
		$string = array(
			'fraud' => 0
		);
		$this->db->where('id',$order_id);
		$this->db->update('orders',$string);
		
		$this->global_model->log_action('fraud_order_to_inventory',$order_id);
		
		redirect($this->input->get('r'));
		
	}
	
	
	function inventory_fraud($type = false, $id = false, $boutique_id){
		
		$this->global_model->check_permission('all');
		
		$data['title'] = 'Lagerstyring';
		
		$this->load->model('product_model');
		$this->load->model('boutique_model');
		$this->load->model('inventory_model');

		if($this->input->post('submit')){
			$this->inventory_model->update_inventory($id);
		}
		
		if($this->input->post('add_part')){
			$this->inventory_model->add_part($id);
		}
		
		if($this->input->post('edit_part')){
			$this->inventory_model->edit_part($id);
		}
		
		if($this->input->post('add_defect')){
			$this->inventory_model->add_defect($id);
		}
		
		if($this->input->post('submit_intervals')){
			$this->inventory_model->update_intervals($id);
		}
		
		$data['loadjscss'] = '';
		
		
		$this->db->where('boutique_id',$this->uri->segment(6));
    	$this->db->where('gb',$this->uri->segment(7));
    	$this->db->where('product_id',$this->uri->segment(4));
    	$this->db->where('sold',0);
    	$this->db->where('fraud',1);
    	$this->db->where('type','bought');
    	$data['phones'] = $this->db->get('orders')->result();
				
		$data['boutique'] = $this->boutique_model->get_by_id($this->uri->segment(6));
		
		if($data['boutique']){
			$data['boutique_name'] = $data['boutique']->name;
		}else{
			$data['boutique_name'] = '?';
		}

		$data['yield'] = "products/inventory_fraud";
		$this->load->view('layout/application',$data);
		
	}
	
	function edit_inventory($device_id = false){
		
		$unique_id = $this->input->post('id');
		
		$this->db->where('unqiue_string',$unique_id);
    	$this->db->where('hide',0);
    	$this->db->group_by('unqiue_string');
		$data['parts'] = $this->db->get('parts')->result();
		
		$this->load->model('boutique_model');
		
		$this->db->where('active',1);
        $data['boutique_info'] = $this->db->get('boutiques')->result();
		$data['device'] = $device_id;
		
		$this->load->view('products/_edit_inventory',$data);
		
	}
	
	function transfer_part($device_id = false){
		
		$unique_id = $this->input->post('id');
		
		$this->db->where('unqiue_string',$unique_id);
    	$this->db->where('hide',0);
    	$this->db->group_by('unqiue_string');
		$data['parts'] = $this->db->get('parts')->result();
		
		$this->load->model('boutique_model');
		
		$this->db->where('active',1);
        $data['boutique_info'] = $this->db->get('boutiques')->result();
		$data['device'] = $device_id;
		
		$this->load->view('products/transfer_part',$data);
		
	}
	
	function transfer_part_amount($device_id = false){
		
		if($this->input->post('move_inventory')){
			$this->load->model('inventory_model');
			$this->inventory_model->move_inventory($device_id);
		}
		
		$unique_id = $this->input->post('id');
		$fromBoutiqueId = $this->input->post('from');
		
		$this->db->where('unqiue_string',$unique_id);
    	$this->db->where('hide',0);
    	$this->db->where('boutique_id',$fromBoutiqueId);
    	$this->db->group_by('unqiue_string');
		$inventoryFrom = $this->db->get('parts')->result();
		
		if($inventoryFrom){
			$data['inventory'] = $inventoryFrom[0]->inventory;
		}else{
			$data['inventory'] = 0;
		}
		
		$this->load->model('boutique_model');
		
		$this->db->where('active',1);
        $data['boutique_from'] = $this->db->get('boutiques')->result();
		$data['device'] = $device_id;
		
		$this->load->view('products/_transfer_amount',$data);
		
	}
	
	public function show($id = false)
	{
	
		$this->load->model('product_model');	
		
		if($this->input->post('submit_product')){
			$this->product_model->update_product($id);
		}elseif($this->input->post('add_color')){
			$this->product_model->add_color($id);
		}elseif($this->input->post('add_gb')){
			$this->product_model->add_gb($id);
		}elseif($this->input->post('add_condition')){
			$this->product_model->add_condition($id);
		}elseif($this->input->post('upload_image')){
			$this->product_model->upload_image_to_color($id);
		}
		
		$data['product'] = $this->product_model->get_product_by_id($id);
		
		if(!$data['product']){
			redirect('products');
		}
				
		$data['colors'] = $this->product_model->get_colors_to_product($id);
		$data['gbs'] = $this->product_model->get_gbs_to_product($id);
		$data['conditions'] = $this->product_model->get_conditions_to_product($id);
		
		$data['loadjscss'] = 'ckeditor';
		
		$data['yield'] = "products/show";
		$this->load->view('layout/application',$data);
	}
	
	public function create($id = false)
	{
	
		$this->load->model('product_model');	
		
		if($this->input->post('submit_product')){
			$this->product_model->create_product();
		}
		
		
		$data['categories'] = $this->product_model->get_categories();
		
		$data['loadjscss'] = 'ckeditor';
		
		$data['yield'] = "products/create";
		$this->load->view('layout/application',$data);
	}
	
	
	function delete_image($id,$product_id){
		$string = array(
			'image' => ''
		);
		$this->db->where('id',$id);
		$this->db->update('colors',$string);
		redirect('products/show/'.$product_id);
	}
	
	function set_default($type = false, $id, $product_id){
		
		if($type == 'color'){
			
			$string = array(
				'default' => 0
			);
			$this->db->where('product_id',$product_id);
			$this->db->update('colors',$string);
			
			// update current
			$string = array(
				'default' => 1
			);
			$this->db->where('id',$id);
			$this->db->update('colors',$string);
			
		}elseif($type == 'gb'){
			
			$string = array(
				'default' => 0
			);
			$this->db->where('product_id',$product_id);
			$this->db->update('gbs',$string);
			
			// update current
			$string = array(
				'default' => 1
			);
			$this->db->where('id',$id);
			$this->db->update('gbs',$string);
			
		}elseif($type == 'condition'){
			
			$string = array(
				'default' => 0
			);
			$this->db->where('product_id',$product_id);
			$this->db->update('conditions',$string);
			
			// update current
			$string = array(
				'default' => 1
			);
			$this->db->where('id',$id);
			$this->db->update('conditions',$string);
			
		}
		
		redirect('products/show/'.$product_id);
		
	}
	
	
	function cancel($id){
		$string = array(
			'active' => 0
		);
		$this->db->where('id',$id);
		$this->db->update('products',$string);
		
		redirect('products');
	}
	
	
	function delete_type($type = false, $id, $product_id){
		
		if($type == 'color'){

			// update current
			$this->db->where('id',$id);
			$this->db->delete('colors');
			
		}elseif($type == 'gb'){
			
			$this->db->where('id',$id);
			$this->db->delete('gbs');
			
		}elseif($type == 'condition'){
			
			$this->db->where('id',$id);
			$this->db->delete('conditions');
			
		}
		
		redirect('products/show/'.$product_id);
		
	}
	
	
	function update_inventory($id,$product_id = false){

		if($this->session->userdata('uid') == 1){
			
			$inventory = $this->input->post('inventory');
			
			$this->db->where('id',$id);
			$get_part_info = $this->db->get('parts')->result();
			
			if($get_part_info){
				$boutique_id = $get_part_info[0]->boutique_id;
			}else{
				$boutique_id = 0;
			}
			
			
			// count defect parts and minus
	        $this->db->where('part_id',$id);
	        $this->db->where('boutique_id',$boutique_id);
	        $defects = $this->db->get('defects')->num_rows();
	         	                    
	        $inventory = $inventory+$defects;
			
			$string = array(
				'inventory' => $inventory
			);
			$this->db->where('id',$id);
			$this->db->update('parts',$string);
			
			
		}
		
		redirect('products/inventory/parts/'.$product_id);
		
	}
        
        public function sort_product(){
            
            foreach ($_POST['item'] as $sort=>$id) {
                $this->db->where('id',$id)->update('products',array("prod_order"=>$sort));
            }
        }
        
         public function sort_part(){
            
            foreach ($_POST['item'] as $sort=>$id) {
                $this->db->where('id',$id)->update('parts',array("part_order"=>$sort));
            }
        }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */