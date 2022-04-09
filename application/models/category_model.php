<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_category()
    {
        $this->db->order_by('id');
        $query = $this->db->get('categories');
        return $query->result();
	}
	
	function get_category_by_id($id = false)
    {
    	$this->db->where('id',$id);
        $query = $this->db->get('categories')->result();
        if($query){
	        return $query[0];
        }else{
	        return false;
        }
    }

    function create_category(){

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Navn', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

		if ($this->form_validation->run() == TRUE)
		{

	        $name = $this->input->post('name');
			$parent = $this->input->post('parent');

	        $string = array(
	        	'name'   => $name,
	        	'parent' => $parent ? $parent : 0
	        );
	        $this->db->insert('categories',$string);

	       	$id = $this->db->insert_id();

	       	$this->global_model->log_action('category_created',$id);

	        redirect('category?parent='.$parent);

	    }

	}

	function edit($id){

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Navn', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

		if ($this->form_validation->run() == TRUE)
		{
			$name = $this->input->post('name');
			$parent = $this->input->post('parent');
			
			$string = array(
	        	'name'   => $name,
	        	'parent' => $parent?$parent:0,
			);
			
			$this->db->where('id',$id);
	        $this->db->update('categories',$string);
			
		}

		$this->global_model->log_action('category_updated',$id);

	    redirect('category');
	}
}

// end of model file
