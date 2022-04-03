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

		if($this->input->post('create')){
			$this->load->model('receipt_model');
			$this->receipt_model->create();
		}

		$this->db->select('receipt.*,products.name as product_name')->join('products','products.id = receipt.product_id','left');
		$this->db->where('receipt.boutique_id',$this->session->userdata('active_boutique'));
		$this->db->order_by('receipt.created_timestamp','desc');
		$data['receipts'] = $this->db->get('receipt')->result();
		$this->load->model('product_model');
		$data['products'] = $this->product_model->get_products();
		$data['yield'] = "receipt/index";
		$this->load->view('layout/application',$data);
	}


	function print_($id){
		$this->db->select('receipt.*,products.name as product_name')->join('products','products.id = receipt.product_id','left');
		$this->db->where('receipt.id',$id);
		$data['receipt'] = $this->db->get('receipt')->result();

		if(!$data['receipt']){
			redirect('');
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
