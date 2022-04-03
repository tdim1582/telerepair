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

		$data['title'] = 'Category';

		$data['yield'] = "category/index";
		$this->load->view('layout/application',$data);
    }
}
