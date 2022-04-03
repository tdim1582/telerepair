<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_statistics extends CI_Controller {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
        $this->global_model->check_permission('statistic');
    }

    public function index()
    {
        $data['title'] = 'Salgstal';

        if($this->input->get('from')){
            $start_period = strtotime($this->input->get('from').' 00:00:00');
            $end_period   = strtotime($this->input->get('to').' 23:59:59');

            $data['start_date'] = date("Y-m-d",strtotime($this->input->get('from').' 00:00:00'));
            $data['end_date'] = date("Y-m-d",strtotime($this->input->get('to').' 23:59:59'));

        } else{
            $start_period = strtotime("first day of this month");
            $end_period   = strtotime("today 23:59:59");

            $data['start_date'] = date("Y-m-d",strtotime("first day of this month"));
            $data['end_date'] = date("Y-m-d",strtotime("today 23:59:59"));
        }

        //test user data statistics

        if ( $this->input->get('month_filter') ) {
            $data['choosen_month'] = strtolower($this->input->get('month_filter'));
        } else {
            $data['choosen_month'] = strtolower(date("F", strtotime("now")));
        }

        //Debug data
        $data['greg'] = $this -> global_model -> calculate_sale_by_user(48, 'february',$this->input->get('boutique'));
        $data['greg_dynamic'] = $this -> global_model -> calculate_sale_by_user(48, $data['choosen_month'], $this->input->get('boutique'));
        //Debug data end
            
        $data['all_sales'] = $this -> global_model -> get_sales_all_users();
        
        foreach ($data['all_sales'] as $users):
            $data['user_names'][] = $users['name'];
            $data['user_sales'][] = $this -> global_model -> calculate_sale_by_user($users['id'], $data['choosen_month'], $this->input->get('boutique'));
        endforeach;
        
        $data['yield'] = "sales_statistics/index";
        $this->load->view('layout/application',$data);
    }
}
