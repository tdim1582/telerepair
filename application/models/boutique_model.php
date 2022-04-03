<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// use \PHPMailer\PHPMailer\PHPMailer;
// use \PHPMailer\PHPMailer\SMTP;
// use \PHPMailer\PHPMailer\Exception;


class Boutique_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get(){
    	$this->db->order_by('id','desc');
    	$this->db->where('active',1);
	    $b = $this->db->get('boutiques')->result();
	    return $b;
    }


    function get_by_id($id){
    	$this->db->order_by('id','desc');
    	$this->db->where('id',$id);
    	$this->db->where('active',1);
	    $b = $this->db->get('boutiques')->result();
	    if($b){
	    	return $b[0];
	    }else{
			return false;
	    }
    }


    function get_name_by_id($id){
    	$this->db->order_by('id','desc');
    	$this->db->where('id',$id);
    	$this->db->where('active',1);
	    $b = $this->db->get('boutiques')->result();
	    if($b){
	    	return $b[0]->name;
	    }else{
			return false;
	    }
    }


	function create(){

	    $name            = $this->input->post('name');
	    $address         = $this->input->post('address');
	    $initial         = $this->input->post('initial');

	    $tlcvremail      = $this->input->post('tlcvremail');

      $smtp_username      = $this->input->post('smtp_username');
      $smtp_password      = $this->input->post('smtp_password');
      $smtp_host      = $this->input->post('smtp_host');
      $smtp_port      = $this->input->post('smtp_port');

	    $string = array(
			'name' => $name,
			'initial' => $initial,
			'address' => $address,
			'active' => 1,
			'rank' => '',
			'tlcvremail' => $tlcvremail,
			'created_timestamp' => time(),
      'smtp_username' => $smtp_username,
      'smtp_password' => $smtp_password,
      'smtp_host' => $smtp_host,
      'smtp_port' => $smtp_port
		);
		$this->db->insert('boutiques',$string);

		$id = $this->db->insert_id();


		$get_gbs = $this->db->get('gbs')->result();

		foreach($get_gbs as $gbinfo){

			$this->db->where('name',$gbinfo->name);
			$this->db->where('boutique_id',$id);
			$this->db->where('product_id',$gbinfo->product_id);
			$check_exist = $this->db->get('gbs')->result();

			if(!$check_exist){

			$string = array(
	        	'name'              => $gbinfo->name,
	        	'price' => '0.00',
	        	'default' => 0,
	        	'new_price' => '0.00',
	        	'used_price' => '0.00',
	        	'product_id'        => $gbinfo->product_id,
	        	'boutique_id'       => $id,
	        	'created_timestamp' => time()
	        );
	        $this->db->insert('gbs',$string);

	        }

		}

		$this->db->group_by('unqiue_string');
		$this->db->where('unqiue_string !=','');
		$this->db->where('hide',0);
		$parts = $this->db->get('parts')->result();

		foreach($parts as $part){

			$string = array(
				'name' => $part->name,
				'inventory' => 0,
				'price' => $part->price,
				'product_id' => $part->product_id,
				'created_timestamp' => time(),
				'boutique_id' => $id,
				'hide' => $part->hide,
				'unqiue_string' => $part->unqiue_string,
				'part_of_inventory' => $part->part_of_inventory,
				'part_order' => 0
			);
			$this->db->insert('parts',$string);

		}

		$this->global_model->log_action('boutique_created',$id);

		redirect('boutiques');

    }


    function edit($id){

	    $name            = $this->input->post('name');
	    $address         = $this->input->post('address');
	    $initial         = $this->input->post('initial');

	    $tlcvremail      = $this->input->post('tlcvremail');

      $smtp_username      = $this->input->post('smtp_username');
      $smtp_password      = $this->input->post('smtp_password');
      $smtp_host      = $this->input->post('smtp_host');
      $smtp_port      = $this->input->post('smtp_port');

	    $string = array(
  			'name' => $name,
  			'initial' => $initial,
  			'address' => $address,
  			'tlcvremail' => $tlcvremail,
        'smtp_username' => $smtp_username,
        'smtp_password' => $smtp_password,
        'smtp_host' => $smtp_host,
        'smtp_port' => $smtp_port
  		);
  		$this->db->where('id',$id);
  		$this->db->update('boutiques',$string);

  		$this->global_model->log_action('boutique_update',$id);

  		redirect('boutiques');

    }

    function create_counting(){

	    $date               = $this->input->post('date');

	    $dankort      		= $this->input->post('dankort');
	    $danskeecmcvi      	= $this->input->post('danskeecmcvi');
	    $udlexmxvijcb      	= $this->input->post('udlexmxvijcb');
	    $gebyr		      	= $this->input->post('gebyr');

	    $halvore      		= $this->input->post('halvore');
	    $enkr      			= $this->input->post('enkr');
	    $tokr      			= $this->input->post('tokr');
	    $femkr      		= $this->input->post('femkr');
	    $tikr      			= $this->input->post('tikr');
	    $tyvekr      		= $this->input->post('tyvekr');
	    $halvtredskr      	= $this->input->post('halvtredskr');
	    $hundkr     		= $this->input->post('hundkr');
	    $tohundkr      		= $this->input->post('tohundkr');
	    $femhundkr      	= $this->input->post('femhundkr');
	    $tusindkr      		= $this->input->post('tusindkr');

		$raport_emails		= $this->input->post('raport_emails');

	    $to_bank            = $this->input->post('to_bank');

	    $to_bank 			= str_replace(",", ".", $to_bank);

	    $dankort 		= str_replace(",", ".", $dankort);
	    $danskeecmcvi 	= str_replace(",", ".", $danskeecmcvi);
	    $udlexmxvijcb 	= str_replace(",", ".", $udlexmxvijcb);
	    $gebyr 			= str_replace(",", ".", $gebyr);

	    $array = array(
	    	'cardInfo' => array(
	    		'dankort' => $dankort,
	    		'danskeecmcvi' => $danskeecmcvi,
	    		'udlexmxvijcb' => $udlexmxvijcb,
	    		'gebyr' => $gebyr
	    	),
	    	'cashInfo' => array(
	    		'halvore' => $halvore,
	    		'enkr' => $enkr,
	    		'tokr' => $tokr,
	    		'femkr' => $femkr,
	    		'tikr' => $tikr,
	    		'tyvekr' => $tyvekr,
	    		'halvtredskr' => $halvtredskr,
	    		'hundkr' => $hundkr,
	    		'tohundkr' => $tohundkr,
	    		'femhundkr' => $femhundkr,
	    		'tusindkr' => $tusindkr
	    	)
	    );

	    $info = json_encode($array);

	    if($date){

		    $start = strtotime($date.' 00:00:00');
			$end = strtotime($date.' 23:59:59');

			$created_timestamp = strtotime($date);

	    }else{
		    $start = strtotime(date("Y-m-d").' 00:00:00');
		    $end = strtotime(date("Y-m-d").' 23:59:59');

			$created_timestamp = time();

	    }

	    // CALCULATE ULTIMO

	    /*$this->db->where('created_timestamp <',time());
	    $this->db->limit(1);
	    $kasseafstemning = $this->db-get('kasseafstemning')->result();

	    print_r($kasseafstemning);
	    exit;
	    */
	    /*$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	    $this->db->where('uid',$this->session->userdata('uid'));
	    $this->db->where('created_timestamp >= ',$start);
	    $this->db->where('created_timestamp <= ',$end);
	    $counting = $this->db->get('kasseafstemning')->result();

	    if($counting){

		    $string = array(
		    	'info' => $info,
		    	'to_bank' => $to_bank
		    );
		    $this->db->where('id',$counting[0]->id);
		    $this->db->update('kasseafstemning',$string);

		    $id = $counting[0]->id;

	    }*/


	    // get last counting
	    $this->db->order_by('id','desc');
	    $this->db->limit(1);
	    $this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	    $last_boutique_id = $this->db->get('kasseafstemning')->result();

	    if($last_boutique_id){
		    $unique_id = $last_boutique_id[0]->unique_id+1;
	    }else{
		    $unique_id = 1;
	    }

	    $string = array(
	    	'info' => $info,
	    	'boutique_id' => $this->session->userdata('active_boutique'),
	    	'uid' => $this->session->userdata('uid'),
	    	'created_timestamp' => time(),
	    	'webshop' => 0,
	    	'ultimo' => '0.00',
	    	'to_bank' => $to_bank,
	    	'unique_id' => $unique_id
	    );
	    $this->db->insert('kasseafstemning',$string);

	    $id = $this->db->insert_id();

	    $this->global_model->log_action('counting_created',$id);

		$this->db->where('id',$id);
		$this->db->where('boutique_id',$this->session->userdata('active_boutique'));
		$data['counting'] = $this->db->get('kasseafstemning')->result();
		$data['user'] = $this->db->get('users_kasse')->result();
		$data['start'] = strtotime(date("Y-m-d",$data['counting'][0]->created_timestamp).' 00:00:00');
		$data['end'] = strtotime(date("Y-m-d",$data['counting'][0]->created_timestamp).' 23:59:59');
		
		$this->db->where('id',$this->session->userdata('active_boutique'));
		$data['boutique'] = $this->db->get('boutiques')->result();
		
		$date['id'] = $id;
		$data['card'] = $this->global_model->calculate_sale_by_payment_type('card',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['cash'] = $this->global_model->calculate_sale_by_payment_type('cash',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['mobilepay'] = $this->global_model->calculate_sale_by_payment_type('mobilepay',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['invoice'] = $this->global_model->calculate_sale_by_payment_type('invoice',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['loan'] = $this->global_model->calculate_sale_by_payment_type('loan',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['webshop'] = $this->global_model->calculate_sale_by_payment_type('webshop',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['nettalk'] = $this->global_model->calculate_sale_by_payment_type('nettalk',date("Y-m-d",$data['counting'][0]->created_timestamp));
		$data['totalRevenue'] = $data['card']+$data['cash']+$data['mobilepay']+$data['loan']+$data['nettalk']+$data['webshop'];
		$data['phoneSale'] = $this->global_model->calculate_sale_by_payment_typeRevenue(date("Y-m-d",$data['counting'][0]->created_timestamp),'sold');
		$data['access'] = $this->global_model->calculate_sale_by_payment_typeRevenue(date("Y-m-d",$data['counting'][0]->created_timestamp),'access');
		$data['float'] = 'left';
		$data['email'] = true;
		// user
		$this->db->where('id',$data['counting'][0]->uid);
		$data['user'] = $this->db->get('users_kasse')->result();
		
		$message = $this->load->view('status/generate', $data, true);

		require_once FCPATH . 'vendor/autoload.php';

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($message);
		$mpdf->Output('assets/pdf/raport_'.$id.'.pdf');



		if ($raport_emails && $raport_emails != '') {
			$raport_emails = explode(',', $raport_emails);
			// $from = "afstemning@telerepair.dk";
			// $fromName = 'Telerepair'; 
			// $subject = "Daily report";

			// $file = 'assets/pdf/raport_'.$id.'.pdf';
			// $file_name = basename($file);

			// $semi_rand = md5(time());  
			// $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  

			// $headers = "From: $fromName"." <".$from.">"; 
			// $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
		
			// $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
			// "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 

			// if(!empty($file) > 0){ 
			// 	if(is_file($file)){ 
			// 		$message .= "--{$mime_boundary}\n"; 
			// 		$fp =    @fopen($file,"rb"); 
			// 		$data =  @fread($fp,filesize($file)); 
			 
			// 		@fclose($fp); 
			// 		$data = chunk_split(base64_encode($data)); 
			// 		$message .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .  
			// 		"Content-Description: " . $file_name . "\n" . 
			// 		"Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . filesize($file) . ";\n" .  
			// 		"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
			// 	} 
			// } 
			// $message .= "--{$mime_boundary}--"; 

			// foreach ($raport_emails as $raport_email) {

			// 	if(!mail($raport_email, $subject, $message, $headers)) {
			// 		mail($raport_email, $subject, $message, $headers);
			// 	}
			// }
	
			// use \PHPMailer\PHPMailer\PHPMailer;
			// use \PHPMailer\PHPMailer\SMTP;
			// use \PHPMailer\PHPMailer\Exception;
			require_once 'vendor/autoload.php';

			$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
			try {
				// Settings
				
				// $mail->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'afstemning@telerepair.dk';                     //SMTP username
				$mail->Password   = 'Telernew2020.';                               //SMTP password
				$mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;           
				
				$mail->setFrom('afstemning@telerepair.dk', 'Telerepair');

				foreach ($raport_emails as $raport_email) {
					$mail->addAddress($raport_email);
				}
				$mail->addAttachment('assets/pdf/raport_'.$id.'.pdf'); 
				// Content
				$mail->isHTML(true);                       // Set email format to HTML
				$mail->Subject = 'Daily report';
				$mail->Body    = $message;
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				$mail->send();
				echo 'Message has been sent';
			} catch (\PHPMailer\PHPMailer\Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}

	    redirect('status/generate/'.$id);

    }


    function edit_counting(){

	    $dankort      		= $this->input->post('dankort');
	    $danskeecmcvi      	= $this->input->post('danskeecmcvi');
	    $udlexmxvijcb      	= $this->input->post('udlexmxvijcb');
	    $gebyr		      	= $this->input->post('gebyr');

	    $halvore      		= $this->input->post('halvore');
	    $enkr      			= $this->input->post('enkr');
	    $tokr      			= $this->input->post('tokr');
	    $femkr      		= $this->input->post('femkr');
	    $tikr      			= $this->input->post('tikr');
	    $tyvekr      		= $this->input->post('tyvekr');
	    $halvtredskr      	= $this->input->post('halvtredskr');
	    $hundkr     		= $this->input->post('hundkr');
	    $tohundkr      		= $this->input->post('tohundkr');
	    $femhundkr      	= $this->input->post('femhundkr');
	    $tusindkr      		= $this->input->post('tusindkr');

	    $to_bank            = $this->input->post('to_bank');


	    $dankort 		= str_replace(",", ".", $dankort);
	    $danskeecmcvi 	= str_replace(",", ".", $danskeecmcvi);
	    $udlexmxvijcb 	= str_replace(",", ".", $udlexmxvijcb);
	    $gebyr 			= str_replace(",", ".", $gebyr);

	    $id                 = $this->input->post('id');

	    $array = array(
	    	'cardInfo' => array(
	    		'dankort' => $dankort,
	    		'danskeecmcvi' => $danskeecmcvi,
	    		'udlexmxvijcb' => $udlexmxvijcb,
	    		'gebyr' => $gebyr
	    	),
	    	'cashInfo' => array(
	    		'halvore' => $halvore,
	    		'enkr' => $enkr,
	    		'tokr' => $tokr,
	    		'femkr' => $femkr,
	    		'tikr' => $tikr,
	    		'tyvekr' => $tyvekr,
	    		'halvtredskr' => $halvtredskr,
	    		'hundkr' => $hundkr,
	    		'tohundkr' => $tohundkr,
	    		'femhundkr' => $femhundkr,
	    		'tusindkr' => $tusindkr
	    	)
	    );

	    $info = json_encode($array);

	    $string = array(
	    	'info' => $info,
	    	'to_bank' => $to_bank
	    );
	    $this->db->where('id',$id);
	    $this->db->update('kasseafstemning',$string);

	    $this->global_model->log_action('counting_updated',$id);

	    redirect('status/generate/'.$id);

    }


    function create_phone_counting(){

	    $boutique_info = $this->get_by_id($this->session->userdata('active_boutique'));

	    $this->db->where('id',$this->session->userdata('uid'));
	    $userinfo  = $this->db->get('users_kasse')->result();

	    if($userinfo){
		    $username = $userinfo[0]->name;
	    }else{
		    $username = '?';
	    }

	    $mail_info = '';

	    $on_inventory_list = array();
	    $not_on_inventory_list = array();

	    $this->load->model('inventory_model');

	    $checked = $this->input->post('on_inventory');

	    $phones = $this->inventory_model->get_phones_in_boutique($this->session->userdata('active_boutique'));

	    foreach($phones as $phone){

	    	if(in_array($phone->id,$checked)){
	    		$on_inventory_list[$phone->id] = array(
	    			'imei' => $phone->imei,
	    			'name' => $phone->product.', '.$phone->gb.'GB, '.$phone->color,
	    			'id' => $phone->id
	    		);
	    	}else{
		    	$not_on_inventory_list[$phone->id] = array(
	    			'imei' => $phone->imei,
	    			'name' => $phone->product.', '.$phone->gb.'GB, '.$phone->color,
	    			'id' => $phone->id
	    		);

	    		$mail_info = $mail_info.'#'.$phone->id.'<br />';

	    	}

	    }

	    $on_inventory_list = json_encode($on_inventory_list);
	    $not_on_inventory_list = json_encode($not_on_inventory_list);

	    // get last counting
	    $this->db->order_by('id','desc');
	    $this->db->limit(1);
	    $this->db->where('boutique_id',$this->session->userdata('active_boutique'));
	    $last_boutique_id = $this->db->get('telefonafstemning')->result();

	    if($last_boutique_id){
		    $unique_id = $last_boutique_id[0]->unique_id+1;
	    }else{
		    $unique_id = 1;
	    }

	    $string = array(
	    	'info' => $on_inventory_list,
	    	'missing_phones' => $not_on_inventory_list,
	    	'created_timestamp' => time(),
	    	'uid' => $this->session->userdata('uid'),
	    	'boutique_id' => $this->session->userdata('active_boutique'),
	    	'unique_id' => $unique_id,
	    	'date' => date("Y-m-d")
	    );
	    $this->db->insert('telefonafstemning',$string);

	    $insert_id = $this->db->insert_id();

	    if($mail_info){

			$subject = 'Lagerafstemning stemmer ikke '.$boutique_info->name.'';
			$message = '#'.$unique_id.' - '.$boutique_info->name.' lagerafstemning - '.date("d/m/Y H:i").' - '.$username.'<br />
Følgende enheder er ikke på lager ved dagens afstemning af: "'.$username.'"<br />
'.$mail_info.'';

			$this->load->library('email');

			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			$this->email->from('no-reply@2ndbest.dk', '2ndbest');
			$this->email->to('simon@vato.dk, rh@brugteiphones.dk, jw@brugteiphones.dk, nf@brugteiphones.dk');

			$this->email->subject($subject);
			$this->email->message($message);

			$this->email->send();


		}

		$this->global_model->log_action('phone_counting_created',$insert_id,false);

	    redirect('status/phone/'.$insert_id);

    }

}

// end of model file
