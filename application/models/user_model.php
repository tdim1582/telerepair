<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

  var $title   = '';
  var $content = '';
  var $date    = '';

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
    
  function login()
  {
    
    $email = $this->input->post('email');
    $password = $this->input->post('password');
          
    $this->db->where('active',1);
    $this->db->where('email',$email);
    $this->db->where('password',sha1($password));
    $sql = $this->db->get('users_kasse')->result();
    
    //Test if user login with e-mail works, if not test with personal ID.
    if (!$sql)
    {
      $this->db->where('active',1);
      $this->db->where('personal_id',$email);
      $this->db->where('password',sha1($password));
      $sql = $this->db->get('users_kasse')->result();
    }
    
    if($sql){
        
        if($sql[0]->boutiques){
            $explode_boutiques = explode(",",$sql[0]->boutiques);
            
            $count_boutiques = count($explode_boutiques);
            
            if($count_boutiques == 1){
                $active_boutique = $sql[0]->boutiques;
            }else{
                $active_boutique = $explode_boutiques[0];
            }
            
        }else{
            $active_boutique = 0;
        }
        
        $string = array(
        'last_login' => time()
        );
        $this->db->where('id',$sql[0]->id);
        $this->db->update('users_kasse',$string);
        
        $newdata = array(
            'uid'  => $sql[0]->id,
            'rank' => $sql[0]->rank,
            'personal_id'     => $personal_id,
            'logged_in' => TRUE
        );

        $this->session->set_userdata($newdata);
                
        redirect('choose_boutique');
        
    }else{
      redirect('login');
  }
    
  }
  
  function choose_boutique($me){
      
      $boutique_id = $this->input->post('id');
      
      $my_boutiques = explode(",",$me[0]->boutiques);
      
      if(in_array($boutique_id,$my_boutiques)){

          $newdata = array(
              'active_boutique' => $boutique_id
          );

          $this->session->set_userdata($newdata);
          
          $this->global_model->log_action('login',$me[0]->id);
          
          redirect('');
          
      }else{

          redirect('choose_boutique');
      }
      
  }
  
  function create_user(){
    
    $name            = $this->input->post('name');
    $email           = $this->input->post('email');
    $personal_id     = $this->input->post('personal_id');
    //$password        = $this->input->post('password');
    $password        = $this->randomPassword();
    $rank            = $this->input->post('rank');
    
    $boutiques     = $this->input->post('boutiques');
    
    $boutiques_list = false;
    foreach($boutiques as $boutique){
        if($boutiques_list){
            $boutiques_list = $boutiques_list.', '.$boutique;
        }else{
            $boutiques_list = $boutique;
        }
    }

    $raport_email_boutiques = $this->input->post('raport_email_boutiques');
    
    $raport_email_boutiques_list = false;
    foreach($raport_email_boutiques as $raport_email_boutique){
        if($raport_email_boutiques_list){
            $raport_email_boutiques_list = $raport_email_boutiques_list.', '.$boutique;
        }else{
            $raport_email_boutiques_list = $raport_email_boutique;
        }
    }
    
    $string = array(
        'name' => $name,
        'email' => $email,
        'personal_id' => $personal_id,
        'boutiques' => $boutiques_list,
        'password' => sha1($password),
        'last_login' => 0,
        'active' => 1,
        'created_timestamp' => time(),
        'rank'              => $rank,
        'raport_email_boutiques' => $raport_email_boutiques_list
    );
    $this->db->insert('users_kasse',$string);
    
    $id = $this->db->insert_id();
    
    $this->global_model->log_action('user_created',$id);
    
    //$this->global_model->log_action('created_new_admin',$id);
    
    redirect('users');
      
  }
  
  function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 25; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
  
  
  function update(){
    
    $name            = $this->input->post('name');
    $email           = $this->input->post('email');
    $personal_id     = $this->input->post('personal_id');
    $password        = $this->input->post('password');
    $rank            = $this->input->post('rank');
    
    $uid             = $this->input->post('uid');
    
    $boutiques       = $this->input->post('boutiques');
    
    $boutiques_list  = false;
    foreach($boutiques as $boutique){
        if($boutiques_list){
            $boutiques_list = $boutiques_list.', '.$boutique;
        }else{
            $boutiques_list = $boutique;
        }
    }

    $raport_email_boutiques = $this->input->post('raport_email_boutiques');
    
    $raport_email_boutiques_list = false;
    foreach($raport_email_boutiques as $raport_email_boutique){
        if($raport_email_boutiques_list){
            $raport_email_boutiques_list = $raport_email_boutiques_list.', '.$raport_email_boutique;
        }else{
            $raport_email_boutiques_list = $raport_email_boutique;
        }
    }
    
    if($password){
        $string = array(
            'name'              => $name,
            'email'             => $email,
            'personal_id'       => $personal_id,
            'password'          => sha1($password),
            'boutiques'         => $boutiques_list,
            'rank'              => $rank,
            'raport_email_boutiques' => $raport_email_boutiques_list
        );
    }else{
        $string = array(
            'name'              => $name,
            'email'             => $email,
            'personal_id'       => $personal_id,
            'boutiques'         => $boutiques_list,
            'rank'              => $rank,
            'raport_email_boutiques' => $raport_email_boutiques_list
        );
    }
    
    
    $this->db->where('id',$uid);
    $this->db->update('users_kasse',$string);
    
    $id = $this->db->insert_id();
    
    $this->global_model->log_action('user_updated',$uid);
    
    //$this->global_model->log_action('created_new_admin',$id);
    
    redirect('users');
    
}
  
  
  function create_permission(){
      
      $name            = $this->input->post('name');
      $permissions     = $this->input->post('permissions');
              
      $permission_list = false;
      foreach($permissions as $permission){
          if($permission_list){
              $permission_list = $permission_list.', '.$permission;
          }else{
              $permission_list = $permission;
          }
      }
      
      $string = array(
          'name' => $name,
          'permission' => $permission_list,
          'created_timestamp' => time(),
      );
      $this->db->insert('ranks',$string);
      
      $id = $this->db->insert_id();
      
      $this->global_model->log_action('permission_created',$id);
      
      redirect('users/permissions');
      
  }
  
  
  function update_permission(){
      
      $id              = $this->input->post('id');
      $name            = $this->input->post('name');
      $permissions     = $this->input->post('permissions');
      
      $permission_list = false;
      foreach($permissions as $permission){
          if($permission_list){
              $permission_list = $permission_list.', '.$permission;
          }else{
              $permission_list = $permission;
          }
      }

      
      $string = array(
          'name' => $name,
          'permission' => $permission_list
      );
      $this->db->where('id',$id);
      $this->db->update('ranks',$string);
              
      $this->global_model->log_action('permission_updated',$id);
      
      redirect('users/permissions');
      
  }
  
  
  function get_users(){
      
      $this->db->where('active',1);
      $this->db->order_by('id','desc');
      $users = $this->db->get('users_kasse')->result();
      return $users;
      
  }
  
  function get_user_by_id($id = false){
      
      $this->db->order_by('id','desc');
      $this->db->where('active',1);
      $this->db->where('id',$id);
      $users = $this->db->get('users_kasse')->result();
      return $users;
      
  }
  
  function get_ranks(){
      
      $this->db->order_by('name','asc');
      $this->db->where('active',1);
      $ranks = $this->db->get('ranks')->result();
      return $ranks;
      
  }
    
    
  function get_rank_by_id($id){
      
      $this->db->order_by('name','asc');
      $this->db->where('active',1);
      $this->db->where('id',$id);
      $ranks = $this->db->get('ranks')->result();
      return $ranks;
      
  }
      
  public function forgot_password($email)
  {
    $this->db->from('users_kasse'); 
    $this->db->where('email', $email); 
    $query=$this->db->get();
    return $query->row_array();
  }
  
  public function resetlink()
  {
    $email = $this->input->post('email');
    //echo $email;
    
    $result = $this->forgot_password($email);
    
    if($result)
    {
      //echo " mail findes.";
      $passwordplain  = rand(999999999,9999999999);
      //echo "\nPassword plain = ".$passwordplain;
      $newpass['password'] = sha1($passwordplain);
      //echo "\nPassword hashed = " . $newpass['password'];
      
      
      //Reset password
      
      $this->db->where('email', $email);
      $this->db->update('users_kasse', $newpass);
      
      //Send mail
      
      $mail_message  = 'Kære '.$result['name'].',' . "\r\n";
      $mail_message .= 'Tak fordi du har nulstillet din adgangskode' . "\r\n\n";
      $mail_message .= 'Klik på linket for at ændre din adgangskode: ' . base_url('resetpassword?token=') . $newpass['password'] . "\r\n\n";
      $mail_message .= 'Venlig hilsen' . "\r\n";
      $mail_message .= 'Telerepair admin robotten.' . "\r\n";
      
      $this->load->library('email');

      $this->email->from('info@telerepair.dk', 'Telerepair Admin');
      $this->email->to($email);
      
      $this->email->subject('Password nulstilling');
      $this->email->message($mail_message);

      $this->email->send();
      
      $this->session->set_flashdata('message', 'Mail sendt med nulstillingslink.');
      redirect('login');
      
    }
    else
    {
      $this->session->set_flashdata('message', 'Mail findes ikke, prøv igen.');
      redirect('forgotpassword');
    }
  }
  
  public function check_token($token)
  {
    $this->db->from('users_kasse'); 
    $this->db->where('password', $token);
    $query=$this->db->get();
    return $query->row_array();
  }
  
  public function change_password()
  {
    $password['password'] = sha1($this->input->post('password'));
    $token = $this->input->get('token');
        
    $this->db->where('password',$token);
    $this->db->update('users_kasse',$password);
    
    
    //echo "Password: " . $password['password'] . " - token = " . $token;
    
    $this->session->set_flashdata('message', 'Adgangskode ændret.');
    
    redirect('login');
  }

}

// end of model file
