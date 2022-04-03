<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sold extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
        $this->global_model->check_permission('sold_devices_overview');
    }
	public function index()
	{
		$this->load->library('pagination');
		$per_page = 50;
		
		if($this->uri->segment(3)){
			$offset = $this->uri->segment(3);
		}else{
			$offset = 0;
		}
		
		$data['title'] = 'Solgte enheder';
		
		if($this->input->post('sold_device')){
			$this->load->model('device_model');
			$this->device_model->create_order('sold');
		}
		
		$this->load->model('product_model');
		$data['products'] = $this->product_model->get_products();
		$data['gbs_list'] = $this->product_model->get_gbs();
		
		
		$this->db->order_by('id','desc');
		$this->db->where('cancelled',0);
		if($this->input->get('from_date')){
			$this->db->where('created_timestamp >=',strtotime($this->input->get('from_date')));
		}
		if($this->input->get('to_date')){
			$this->db->where('created_timestamp <=',strtotime($this->input->get('to_date')));
		}
	  	$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	  	$this->db->where('type','sold');
	  	$this->db->where('hidden',0);
	  	$total_orders = $this->db->get('orders')->num_rows();
		
		//$this->db->limit($per_page,$offset);
		$this->db->order_by('id','desc');
		$this->db->where('cancelled',0);
		if($this->input->get('from_date')){
			$this->db->where('created_timestamp >=',strtotime($this->input->get('from_date')));
		}
		if($this->input->get('to_date')){
			$this->db->where('created_timestamp <=',strtotime($this->input->get('to_date')));
		}
	  	$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	  	$this->db->where('type','sold');
	  	$this->db->limit($per_page,$offset);
	  	$this->db->where('hidden',0);
	  	$data['orders'] = $this->db->get('orders')->result();
		
		
		$config['base_url'] = site_url('sold/index');
		$config['total_rows'] = $total_orders;
		$config['per_page'] = $per_page; 
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<div class="pagi">';
		$config['full_tag_close'] = '</div>';
		
		$this->pagination->initialize($config); 
		
		$data['rank_permissions'] = $this->global_model->get_rank_permissions();
		
		$data['yield'] = "sold/index";
		$this->load->view('layout/application',$data);
	}
	
	
//	function insurance(){
//		
//		$this->db->order_by('id','desc');
//		$this->db->where('insurance',1);
//		$data['orders'] = $this->db->get('orders')->result();
//		
//		$data['yield'] = "sold/insurance";
//		$this->load->view('layout/application',$data);
//		
//	}
	
	
	public function editDevice()
	{
	
		$id = $this->input->post('id');
		
		if($this->input->post('edit_device')){
			$this->load->model('device_model');
			$this->device_model->edit_order('sold',$this->input->post('id'));
		}
		
		$this->load->model('product_model');
		$this->load->model('order_model');
		$data['products'] = $this->product_model->get_products();
		$data['gbs_list'] = $this->product_model->get_gbs();
		
		$data['order'] = $this->order_model->get_order_by_id($id,'sold');
		
		$this->load->view('sold/_edit',$data);
	}
	
	
	function getInfo(){
		
		$rank_permissions = $this->global_model->get_rank_permissions();
		
		$this->load->model('order_model');
		
		$id = $this->input->post('order_id');
		$alreadyTested = $this->input->post('alreadyTested');
		
		if (strpos($rank_permissions,'all') !== false && $alreadyTested == 1) {
		
			$string = array(
				'already_tested' => 1
			);
			$this->db->where('id',$id);
			$this->db->update('orders',$string);
			
		}
		
		$info = $this->order_model->get_order_by_id($id,'bought');
		
		$this->db->where('order_id',$id);
		$test_info = $this->db->get('tests')->result();
		
		if(!$test_info && $info->already_tested == 0){
			// not tested
			if (strpos($rank_permissions,'all') !== false) {
				$admin = true;
			}else{
				$admin = false;
			}
			
			$info = array(
				'tested' => false,
				'admin' => $admin
			);
			
			$this->output->set_content_type('application/json')->set_output(json_encode($info));
		}else{
			$this->output->set_content_type('application/json')->set_output(json_encode($info));
		}
		
	}
	
	
	function getExchangeInfo(){
				
		$this->load->model('order_model');
		
		$id = $this->input->post('id');

		$info = $this->order_model->get_order_by_id($id,'bought');
		
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	
	function cancel(){
		
		$id = $this->input->post('line_id');
		$reason = $this->input->post('reason');

		
		$this->load->model('order_model');
		$data['order_info'] = $this->order_model->get_order_by_id($id);
		
		if($data['order_info']){
			
			// get sold phone and remove sold id
			$this->db->where('id',$data['order_info']->bought_from_order_id);
			$bought_order = $this->db->get('orders')->result();
			
			if($bought_order){
				$string = array(
					'sold' => 0
				);
				$this->db->where('id',$bought_order[0]->id);
				$this->db->update('orders',$string);
			}
			
			$string = array(
				'cancelled' => 1
			);
			$this->db->where('id',$id);
			$this->db->update('orders',$string);
			
			$prevOrderID = $data['order_info']->id;
			// create creditnote
			unset($data['order_info']->id);
			
			$string = $data['order_info'];
			$this->db->insert('orders',$string);
			
			$credit_id = $this->db->insert_id();
			
			$string = array(
				'created_timestamp' => time(),
				'type' => 'credit',
				'imei' => '',
				'cancelled' => 0,
				'part' => '',
				'bought_from_order_id' => 0,
				'credit_reason' => $reason,
				'uid' => $this->session->userdata('uid'),
				'creditlineConnectedID' => $prevOrderID
			);
			$this->db->where('id',$credit_id);
			$this->db->update('orders',$string);
			
			// update inventory
			
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
			$this->db->where('product_id',$data['order_info']->product_id);
			$this->db->where('gb',$data['order_info']->gb);
			$inventory = $this->db->get('inventory')->result();
			
			if($inventory){
				$new_inventory = $inventory[0]->inventory+1;
				$string = array(
					'inventory' => $new_inventory
				);
				$this->db->where('id',$inventory[0]->id);
				$this->db->update('inventory',$string);
			}
			
		}
		
		if($this->input->get('redirect')){
			$this->session->set_flashdata('success','Salget blev krediteret med succes');
			redirect($this->input->get('redirect'));
		}else{
			redirect('sold');
		}
		
	}
	
	
	function calculatePrice(){
		
		$order_id = $this->input->post('order_id');
		$condition = $this->input->post('condition');
		
		$this->load->model('device_model');
		$price = $this->device_model->calculatePriceSold($order_id,$condition);
		echo $price;
		
	}
	
	
	
	function credit(){
		
		$data['title'] = 'Krediterede salg';
		
		//$this->db->limit($per_page,$offset);
		$this->db->order_by('id','desc');
	  	$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	  	$this->db->where('type','credit');
	  	$data['orders'] = $this->db->get('orders')->result();
		

		$data['yield'] = "sold/credit";
		$this->load->view('layout/application',$data);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */