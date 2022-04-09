<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
        // $this->global_model->check_permission('statistic');
    }

	public function index()
	{

        $data['title'] = 'Categories';
        
        $this->load->model('category_model');	
		
		if($this->input->post('submit_category')){
			$this->category_model->create_category();
		}
		
		$data['categories'] = $this->category_model->get_category();
		
		$data['loadjscss'] = '';
		
		$data['yield'] = "category/index";
		$this->load->view('layout/application',$data);
	}
	
	function delete($id){
		
		$this->db->where('id',$id);
		$this->db->delete('categories');
		
		redirect('category');
	}

	public function edit()
	{
		
		$id = $this->input->post('id');
		
		$this->load->model('category_model');	
		
		if($this->input->post('submit_category')){
			$this->category_model->edit($id);
		}
		
		$data['categories'] = $this->category_model->get_category_by_id($id);
		
		$data['loadjscss'] = '';
		
		$this->load->view('category/_edit',$data);
	}

}
