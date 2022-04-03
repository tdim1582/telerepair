<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
    }
    
	public function show($id = false)
	{
		
		$this->load->model('order_model');
		$this->load->model('device_model');
		
		if($this->input->post('comment')){
			$this->order_model->create_comment($id);
		}
		
		if($this->input->post('create_fraud')){
			$this->device_model->create_fraud(current_url());
		}
		
		if($this->input->post('create_defect')){
			$this->device_model->create_defect(current_url());
		}
		
		$info = $this->order_model->get_order_by_id($id,'bought',false,true);
		
		if(!$info){
			redirect('bought');
		}
		
		$data['order'] = $info;
		$data['yield'] = "orders/show";
		$this->load->view('layout/application',$data);
		
	}
	
	function delete($id,$comment_id){
		
		$string = array(
			'active' => 0
		);
		$this->db->where('id',$comment_id);
		$this->db->update('comments',$string);
		
		redirect('orders/show/'.$id.'#intern_comments');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */