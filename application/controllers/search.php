<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
    }
	
	public function index()
	{
		
		$this->load->model('boutique_model');
		
		$search = $this->input->post('search');
		
		// search for orders
		if($search){
			$this->db->like('name',$search);
			$this->db->or_like('address',$search);
			$this->db->or_like('number',$search);
			$this->db->or_like('imei',$search);
			$this->db->or_like('id',$search);
			$this->db->limit(100);
			$this->db->where('type !=','cancelled');
			$this->db->order_by('id','desc');
			$data['orders'] = $this->db->get('orders')->result();
		}else{
			$data['orders'] = false;
		}
				
		$data['yield'] = "search/index";
		$this->load->view('layout/application',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */