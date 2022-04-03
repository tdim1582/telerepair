<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Garanti extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->global_model->check_if_logged_in();
		$this -> load -> model('garanti_model');
		
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */




	public function index()
	{
		$data['yield'] = "garanti/index";
		$data['GarantiData'] = $this->garanti_model->selectAllData('garanti');
		$this->load->view('layout/application',$data);
	}
	
	function create(){
		$garanti_uri_id	=	$this->uri->segment(3);
		$data['GarantiDataAll'] = $this->garanti_model->selectAllData('garanti',array('id'=>$garanti_uri_id));
		$this->form_validation->set_rules('name','Name','required');
		
		if($this->form_validation->run()==false){
			$data['yield'] = "garanti/create";
			$this->load->view('layout/application',$data);
		}else{
			$garanti_array 		= array(
				'name' 			=> $this->input->post('name'),
				'text' 			=> $this->input->post('garanti_text'),
				'status' 		=> 1,
			);
			if($garanti_uri_id){
				//update
				$garanti_update_id	=	$this->garanti_model->updateData('garanti',$garanti_array,array('id'=>$garanti_uri_id));
				if($garanti_update_id){
					redirect('garanti');
				}
			}else{
				//insert
				$garanti_last_id	=	$this->garanti_model->insertData('garanti',$garanti_array);
				if($garanti_last_id){
					redirect('garanti');
				}
			}
				
		}
	}

	public function delete_garanti()
	{
		$garanti_uri_id	=	$this->uri->segment(3);
		if($garanti_uri_id){
			$garanti_delete	=	$this->garanti_model->deleteData('garanti',array('id'=>$garanti_uri_id));
			if($garanti_delete){
				redirect('garanti');
			}
		}
	}
}

