<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Daddy
 */
class Admin extends CI_Controller{
    //put your code here

    
    
    public function __construct() {
        parent::__construct();
        $user_account = $this->session->userdata('user_account');
        $this->load->model('common_model');
        $this->load->library('form_validation');
        $this->load->helper('security');
        

    }



    

   

    

    /* function for admin login  */

    public function index() {  

        $data['title'] = "Login To Admin Panel";

      
        $this->form_validation->set_rules('user_name', 'Username', 'required|trim');
        $this->form_validation->set_rules('user_password', 'Password', 'required|trim');
        if($this->form_validation->run() == TRUE)
        {
            $user_name=$this->input->post('user_name');
            $password=$this->input->post('password');
         $post=array('user_name'=>htmlentities($this->input->post('user_name')),
          'password'=>htmlentities($this->input->post('user_password'))
        );


            $url='http://localhost/example/';
        $ch = curl_init($url.'ws-get-login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response =curl_exec($ch);
        
        $decoded_response = json_decode($response, true);

        if($decoded_response['Response']['error_code']=='1')
        {
            $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';

            $this->session->set_userdata('msg', $msg);
            
            $this->load->view('backend/log-in/login', $data);
        }
        else
        {
            $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';

            $this->session->set_userdata('msg_success', $msg);
            $this->session->set_userdata('user_account', $decoded_response['Response']['user_details']);
            $user_account = $this->session->userdata('user_account');         
            $this->session->set_userdata('admin_user_name', $user_account['user_name']);             
            redirect(base_url().'backend/home');

        }
    }
else
{
    $this->load->view('backend/log-in/login', $data);
}

    }

    

    

   

    public function logout() {

        /* unseting the user session data. */
        $this->session->unset_userdata("user_account");
        redirect(base_url() . "backend/login");

    }

     
    public function getUserList()
    {



        $user_account = $this->session->userdata('user_account');

        if (empty($user_account)) {

           redirect(base_url() . "backend/login");  

        }

       
      
        $post=array('user_id'=>htmlentities($user_account[0]['user_id']),
       
      );


          $url='http://localhost/example/';
      $ch = curl_init($url.'ws-get-user-details');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      $response =curl_exec($ch);
      $decoded_response = json_decode($response, true);

      if($decoded_response['Response']['error_code']=='1')
        {
            $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';

            $this->session->set_userdata('msg', $msg);
            
            $this->load->view('backend/log-in/login', $data);
        }
        else
        {
            $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';

            $data['title'] = "User Details";
            $data['arr_admin_list']=$decoded_response['Response']['user_records'];
            $data['access_user']=$decoded_response['Response']['user_access'];
                     $this->load->view('backend/admin/list',$data);

        }
    }
        public function setUserDetails()
     {
        $user_account = $this->session->userdata('user_account');

        if (empty($user_account)) {

           redirect(base_url() . "backend/login");  

        }
        if(isset($_POST))
        {
            $this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
            $this->form_validation->set_rules('last_name','last_name','trim|required');
            $this->form_validation->set_rules('middel_name', 'middel_name', 'trim');
            $this->form_validation->set_rules('user_email', 'user_email', 'trim|required');
            $this->form_validation->set_rules('user_password','user_password','trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('user_type','User type','trim|required');
            if($this->form_validation->run()== TRUE)
            {
                $post=array('user_id'=>htmlentities($user_account[0]['user_id']),
                             'user_name'=>htmlentities($this->input->post('user_name')),
                             'first_name'=>htmlentities($this->input->post('first_name')),
                             'last_name'=>htmlentities($this->input->post('last_name')),
                             'middel_name'=>htmlentities($this->input->post('middel_name')),
                             'email_id'=>htmlentities($this->input->post('user_email')),
                             'password'=>htmlentities($this->input->post('user_password')),
                             'status'=>htmlentities($this->input->post('status')),
                             'user_type'=>htmlentities($this->input->post('user_type')),   
            );
                $url='http://localhost/example/';
                $ch = curl_init($url.'ws-set-user-details');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response =curl_exec($ch);
                $decoded_response = json_decode($response, true);


                if($decoded_response['Response']['error_code']=='1')
                {
                    $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';
        
                    $this->session->set_userdata('msg', $msg);
                    
                    redirect(base_url().'backend/home');
                }
                else
                {
                    $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';
                    $this->session->set_userdata('msg', $msg);
                    redirect(base_url().'backend/home');
        
                }

            }
        }
        $data['title'] = "User Details";
        $data['action']=base_url().'backend/user-details-add';
        $this->load->view('backend/admin/add',$data);
          
    }
    public function updateUserDetails($edit_id)
    {
        $user_account = $this->session->userdata('user_account');

        if (empty($user_account)) {

           redirect(base_url() . "backend/login");  

        }
        $url='http://localhost/example/';

    
        if(isset($_POST['user_name']))
        {
            
            $this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
            $this->form_validation->set_rules('last_name','last_name','trim|required');
            $this->form_validation->set_rules('middel_name', 'middel_name', 'trim');
            $this->form_validation->set_rules('user_email', 'user_email', 'trim|required');       
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('user_type','User type','trim|required');
            if($this->form_validation->run()== TRUE)
            {
                $post=array('user_id'=>htmlentities($user_account[0]['user_id']),
                            'user_name_id'=>htmlentities(base64_decode($edit_id)),
                             'user_name'=>htmlentities($this->input->post('user_name')),
                             'first_name'=>htmlentities($this->input->post('first_name')),
                             'last_name'=>htmlentities($this->input->post('last_name')),
                             'middel_name'=>htmlentities($this->input->post('middel_name')),
                             'email_id'=>htmlentities($this->input->post('user_email')),
                            
                             'status'=>htmlentities($this->input->post('status')),
                             'user_type'=>htmlentities($this->input->post('user_type')),   
            );
                
                $ch = curl_init($url.'ws-update-user-details');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response =curl_exec($ch);
                $decoded_response = json_decode($response, true);


                if($decoded_response['Response']['error_code']=='1')
                {
                    $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';
        
                    $this->session->set_userdata('msg', $msg);
                    
                    redirect(base_url().'backend/home');
                }
                else
                {
                    $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';
                    $this->session->set_userdata('msg', $msg);
                    redirect(base_url().'backend/home');
        
                }

            }
         
        }



        $post=array('user_id'=>htmlentities($user_account[0]['user_id']),
        'user_name_id'=>htmlentities(base64_decode($edit_id)),);
                $ch = curl_init($url.'ws-get-user-details-by-Id');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response =curl_exec($ch);
                $decoded_response = json_decode($response, true);
              
                if($decoded_response['Response']['error_code']=='1')
                {
                    $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';
        
                    $this->session->set_userdata('msg', $msg);
                    
                    redirect(base_url().'backend/home');
                }
                else
                {
                    $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';
                    $this->session->set_userdata('msg', $msg);
                    
                
        $data['title'] = "Edit User Details";
        $data['arr_admin_detail']=$decoded_response['Response']['user_records'][0];
        $data['action']=base_url().'backend/user-details-edit/'.$edit_id;
        $this->load->view('backend/admin/edit',$data);
                }

    }    

    public function getUserLogDetails()
    {
        $user_account = $this->session->userdata('user_account');

        if (empty($user_account)) {

           redirect(base_url() . "backend/login");  

        }
        $url='http://localhost/example/';
        $post=array('user_id'=>htmlentities($user_account[0]['user_id']),
        );
                $ch = curl_init($url.'ws-user-log-details');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response =curl_exec($ch);
                $decoded_response = json_decode($response, true);
              
                if($decoded_response['Response']['error_code']=='1')
                {
                    $msg = '<div class="alert alert-error"><strong>Sorry!</strong>'. $decoded_response['Response']['msg'].'</div>';
        
                    $this->session->set_userdata('msg', $msg);
                    
                    redirect(base_url().'backend/home');
                }
                else
                {
                    $msg = '<div class="alert alert-success">'. $decoded_response['Response']['msg'].'</div>';
                    $this->session->set_userdata('msg', $msg);
        $data['title'] = "User Details";
        $data['action']='';
        $data['arr_log_list']=$decoded_response['Response']['user_activity'];
        $this->load->view('backend/admin/user-log-list',$data);
                }

    }

    

   
    



}
