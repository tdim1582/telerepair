<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistic extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->global_model->check_if_logged_in();
        $this->global_model->check_permission('statistic');
    }

	public function index()
	{

		$data['title'] = 'Statistik';

		if($this->input->get('from')){
			$start_period = strtotime($this->input->get('from').' 00:00:00');
			$end_period   = strtotime($this->input->get('to').' 23:59:59');

			$data['start_date'] = date("Y-m-d",strtotime($this->input->get('from').' 00:00:00'));
			$data['end_date'] = date("Y-m-d",strtotime($this->input->get('to').' 23:59:59'));

		}else{
			$start_period = strtotime("first day of this month");
			$end_period   = strtotime("today 23:59:59");

			$data['start_date'] = date("Y-m-d",strtotime("first day of this month"));
			$data['end_date'] = date("Y-m-d",strtotime("today 23:59:59"));

		}


		// get earnings month by month
		$data['january'] = $this->global_model->calculate_revenue_by_month('january',$this->input->get('boutique'));
		$data['february'] = $this->global_model->calculate_revenue_by_month('february',$this->input->get('boutique'));
		$data['march'] = $this->global_model->calculate_revenue_by_month('march',$this->input->get('boutique'));
		$data['april'] = $this->global_model->calculate_revenue_by_month('april',$this->input->get('boutique'));
		$data['may'] = $this->global_model->calculate_revenue_by_month('may',$this->input->get('boutique'));
		$data['june'] = $this->global_model->calculate_revenue_by_month('june',$this->input->get('boutique'));
		$data['july'] = $this->global_model->calculate_revenue_by_month('july',$this->input->get('boutique'));
		$data['august'] = $this->global_model->calculate_revenue_by_month('august',$this->input->get('boutique'));
		$data['september'] = $this->global_model->calculate_revenue_by_month('september',$this->input->get('boutique'));
		$data['october'] = $this->global_model->calculate_revenue_by_month('october',$this->input->get('boutique'));
		$data['november'] = $this->global_model->calculate_revenue_by_month('november',$this->input->get('boutique'));
		$data['december'] = $this->global_model->calculate_revenue_by_month('december',$this->input->get('boutique'));

		// get sale
		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['sale'] = 0;
			}else{
				$data['sale'] = $access[0]->price;
			}
		}else{
			$data['sale'] = 0;
		}

		//////////////////////////////////

		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$this->db->where('payment_type','cash');
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['cash_sold'] = 0;
			}else{
				$data['cash_sold'] = $access[0]->price;
			}
		}else{
			$data['cash_sold'] = 0;
		}

		//////////////////////////////////

		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$this->db->where('payment_type','card');
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['card_sold'] = 0;
			}else{
				$data['card_sold'] = $access[0]->price;
			}
		}else{
			$data['card_sold'] = 0;
		}

		//////////////////////////////////

		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$this->db->where('payment_type','mobilepay');
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['mobilepay_sold'] = 0;
			}else{
				$data['mobilepay_sold'] = $access[0]->price;
			}
		}else{
			$data['mobilepay_sold'] = 0;
		}


		// get buy
		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','bought');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['bought'] = 0;
			}else{
				$data['bought'] = $access[0]->price;
			}
		}else{
			$data['bought'] = 0;
		}


		// get access
		$this->db->select_sum('price');

		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		}

		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','access');
		$this->db->where('cancelled',0);
		$this->db->where('hidden',0);
		$access = $this->db->get('orders')->result();

		if($access){
			if($access[0]->price == false){
				$data['access'] = 0;
			}else{
				$data['access'] = $access[0]->price;
			}
		}else{
			$data['access'] = 0;
		}



		// get parts used
		$this->db->select_sum('parts.price');
		$this->db->from('parts');
		if($this->input->get('boutique')){
			if($this->input->get('boutique') != 'all'){
				$this->db->where('parts_used.boutique_id',$this->input->get('boutique'));
			}
		}else{
			$this->db->where('parts_used.boutique_id',$this->session->userdata('active_boutique'));
		}
		$this->db->where('parts_used.created_timestamp >=',$start_period);
		$this->db->where('parts_used.created_timestamp <=',$end_period);
		$this->db->join('parts_used', 'parts_used.part_id = parts.id');

		$access = $this->db->get()->result();

		if($access){
			if($access[0]->price == false){
				$data['parts'] = 0;
			}else{
				$data['parts'] = $access[0]->price;
			}
		}else{
			$data['parts'] = 0;
		}


		// result
		$data['result'] = ($data['access']+$data['sale'])-($data['parts']+$data['bought']);

		if($data['result'] < 0){
			$data['type'] = 'negative';
		}else{
			$data['type'] = 'positive';
		}

		$data['yield'] = "statistic/index";
		$this->load->view('layout/application',$data);
	}



	function hidden($boutique_id = false){
		$this->load->model('device_model');
		
		
		$start_date = $this->input->get('sdate');
		$end_date = $this->input->get('edate');
		
		
		$slet_data = $this->input->get('slet_data');
		$rank = $this->session->userdata('rank');

		$start_period = strtotime("$start_date 00:00:00");
		$end_period   = strtotime("$end_date 23:59:59");

		$this->db->where('id',$boutique_id);
		$data['boutique'] = $this->db->get('boutiques')->result();

		$this->db->where('boutique_id',$boutique_id);
	
		$this->db->where('type','sold');
		$this->db->where('hidden',1);
		
		if ($slet_data == 1 && $rank==10) {
		    $data['orders_bought'] = array();
		    $this->db->delete('orders');
		} else {
		    $this->db->where('created_timestamp >=',$start_period);
		    $this->db->where('created_timestamp <=',$end_period);
		    $data['orders_bought'] = $this->db->get('orders')->result();    
		}
		

		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('type','bought');
		$this->db->where('hidden',1);
		
		if ($slet_data == 1 && $rank==10) {
		    $data['orders_sold'] = array();
		    $this->db->delete('orders');
		} else {
		    $this->db->where('created_timestamp >=',$start_period);
		    $this->db->where('created_timestamp <=',$end_period);
	
		    $data['orders_sold'] = $this->db->get('orders')->result();    
		}
		


		$this->db->where('boutique_id',$boutique_id);
	
		$this->db->where('type','credit');
		$this->db->where('hidden',1);
		
		if ($slet_data == 1 && $rank==10) {
		    $data['orders_credit'] = array();
		    $this->db->delete('orders');
		} else {
		    $this->db->where('created_timestamp >=',$start_period);
		    $this->db->where('created_timestamp <=',$end_period);
		    $data['orders_credit'] = $this->db->get('orders')->result();    
		}

		$this->db->where('boutique_id',$boutique_id);
	
		$this->db->where('type','access');
		$this->db->where('hidden',1);
		
		if ($slet_data == 1 && $rank==10) {
		    $data['access'] = array();
		    $this->db->delete('orders');
		    
		    //53334, 65969
		    //53324, 65861
		    
		    $this->db->query('delete FROM order_item WHERE order_item.order_id NOT IN (SELECT id FROM orders)');
		    $this->db->query('delete FROM order_payments WHERE order_payments.order_id NOT IN (SELECT id FROM orders)');
		    $this->db->query(' delete FROM order_comment WHERE order_comment.order_id NOT IN (SELECT id FROM orders)');
		   
		} else {
		    $this->db->where('created_timestamp >=',$start_period);
		    $this->db->where('created_timestamp <=',$end_period);
		    $data['access'] = $this->db->get('orders')->result();    
		}	

		$data['yield'] = "statistic/day_hidden";
		$data['delete_link'] = '';
		
		if ($rank==10) {
		    $data['delete_link'] = '<a href="?sdate='.$start_date.'&edate='.$end_date.'&slet_data=1" style="opacity:0;" title="Slet data" class="slet_data btn btn-danger" onclick="return confirm(\'Er du sikker?\')" >Slet data</a>';
		}
		
		
		$this->load->view('layout/application',$data);
	}

	function interval($boutique_id = false){
		$this->load->model('device_model');
		$start_date = $this->input->get('sdate');
		$end_date = $this->input->get('edate');

		$start_period = strtotime("$start_date 00:00:00");
		$end_period   = strtotime("$end_date 23:59:59");

		$this->db->where('id',$boutique_id);
		$data['boutique'] = $this->db->get('boutiques')->result();

		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('hidden',0);
		$data['orders_bought'] = $this->db->get('orders')->result();


		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','bought');
		$this->db->where('hidden',0);
		$data['orders_sold'] = $this->db->get('orders')->result();


		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','credit');
		$this->db->where('hidden',0);
		$data['orders_credit'] = $this->db->get('orders')->result();


		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','access');
		$this->db->where('hidden',0);
		$data['access'] = $this->db->get('orders')->result();

		$data['yield'] = "statistic/day";
		$this->load->view('layout/application',$data);
	}


	function month_numbers(){

		$this->load->model('boutique_model');

		$data['yield'] = "statistic/month_numbers";
		$this->load->view('layout/application',$data);

	}

	function month_numbers_detailed($month,$boutique){

		$this->load->model('boutique_model');

		$boutique_id = $boutique;
		$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));

		$start_period = strtotime(date("01-$month-Y").' 00:00:00');
		$end_period   = strtotime(date("$days_in_month-$month-Y").' 23:59:59');

		$this->db->where('id',$boutique_id);
		$data['boutique'] = $this->db->get('boutiques')->result();

		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('id !=',0);
		$this->db->where('bought_from_order_id !=',0);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','sold');
		$this->db->where('hidden',0);
		$data['orders_bought'] = $this->db->get('orders')->result();


		$this->db->where('boutique_id',$boutique_id);
		$this->db->where('created_timestamp >=',$start_period);
		$this->db->where('created_timestamp <=',$end_period);
		$this->db->where('type','access');
		$this->db->where('hidden',0);
		$data['access'] = $this->db->get('orders')->result();

		$data['yield'] = "statistic/month_numbers_detailed";
		$this->load->view('layout/application',$data);

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
