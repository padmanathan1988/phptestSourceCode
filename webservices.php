
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webservices extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('webservice_model');
        $this->load->model('common_model');
        $this->load->library('form_validation');
        $this->load->helper('security');
    }
 public function getloginUser()
 {
    $this->form_validation->set_rules('user_name', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');
    if($this->form_validation->run() == TRUE)
    {

        $user_name=$this->input->post('user_name');
        $password=$this->input->post('password');
        $condarr=array('user_name'=>$user_name,
                     'user_password'=>md5($password),
                    'user_status'=>'1');

       $user_details= $this->common_model->getRecords('mst_users','user_id,user_name,first_name,middle_name,last_name,user_email,user_type,user_status,user_create_date',$condarr);
    
       if(!empty($user_details))
     {
        $arr_to_return = array('error_code' => '0', 'msg' => 'Successfully','user_details'=>$user_details);
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
     } 
     else
     {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Invalid Username and Password');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);    
     }
    }
    else
      {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter Credential Details');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);  
      }
 }





    // get USer Details 
    public function getUerDetails()
    {
      $user_id =  $this->input->post('user_id');
      
      $this->form_validation->set_rules('user_id', 'user_id', 'required');

      if($this->form_validation->run() == TRUE)
      {
      $user_access=$this->getAccessToUser($user_id);
      
      if($user_access!='0')
      {
         $user_details=$this->common_model->getRecords('mst_users','user_id,user_name,first_name,middle_name,last_name,user_email,user_type,user_status,user_create_date');
         $arr_to_return = array('error_code' => '0', 'msg' => 'Success Full','user_records'=>$user_details,'user_access'=>$user_access);
         $response_arr = array('Response' => $arr_to_return);
         echo json_encode($response_arr);  
      }
      else
      {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Enter User Id is Invalid');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);  
      }
    }
    else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter The User Id','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
       
    }

    // check the user is exit and get the acces details 
    // 0 will not exit user and    1 is normal user only view and 2 is admin access all;
    public function getAccessToUser($user_id)
    {
          if($user_id!='')
          {
             $userExit= $this->common_model->getRecords('mst_users','user_type',array('user_id'=>$user_id,'user_status'=>'1'));
      
             if(!empty($userExit))
             {
                  return $userExit[0]['user_type'];
             }
          }
          else
          return 0;
    }

   public function SetUserDetails()
   {
    $this->load->library('form_validation');
  
    $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
       $this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
       $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
       $this->form_validation->set_rules('last_name','last_name','trim|required');
       $this->form_validation->set_rules('middel_name', 'middel_name', 'trim');
       $this->form_validation->set_rules('email_id', 'email_id', 'trim|required');
       $this->form_validation->set_rules('password','password','trim|required');
       
       $this->form_validation->set_rules('status', 'Status', 'trim|required');
       $this->form_validation->set_rules('user_type','User type','trim|required');
       if($this->form_validation->run()== TRUE)
      {
       $user_id=$this->input->post('user_id');
        $user_name=$this->input->post('user_name');
        $first_name=$this->input->post('first_name');
        $last_name=$this->input->post('last_name');
        $middel_name=$this->input->post('middel_name');
        $email_id=$this->input->post('email_id');
        $password=$this->input->post('password');
        $status=$this->input->post('status');
        $user_type=$this->input->post('user_type');
        $user_access=$this->getAccessToUser($user_id);
      if($user_access=='2')
      {  $insert_arr=array('user_name'=>$user_name,
                          'first_name'=>$first_name,
                           'last_name'=>$last_name,
                            'middle_name'=>$middel_name,
                           'user_email'=>$email_id,
                           'user_password'=>md5($password),
                           'user_status'=>$status,
                           'user_type'=>$user_type,

                        );

       $insert_id=$this->common_model->insertRow($insert_arr,'mst_users');
       $useractive= array('user_id_fk'=>$user_id,
       'user_activity_text'=>' Add New  User '.$user_name,
   'user_active_status'=>'1',
   );
$this->common_model->insertRow($useractive,'mst_user_activity'); 
       $arr_to_return = array('error_code' => '0', 'msg' => 'Success Fully Added');
       $response_arr = array('Response' => $arr_to_return);
       echo json_encode($response_arr); 
    }
    else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Access Deine');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
      }
      else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter User Details','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
   }
   public function getUserDetailsById()
   {
    $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
    $this->form_validation->set_rules('user_name_id', 'user_name_id', 'trim|required');
    if($this->form_validation->run()== TRUE)
      {
            $user_name_id=$this->input->post('user_name_id');
            $user_id=$this->input->post('user_id');
            $user_access=$this->getAccessToUser($user_id);
            if($user_access=='2')
      {  
        $user_details=$this->common_model->getRecords('mst_users','user_id,user_name,first_name,middle_name,last_name,user_email,user_type,user_status,user_create_date',array('user_id'=>$user_name_id));
        $useractive= array('user_id_fk'=>$user_id,
       'user_activity_text'=>' Get User Details '.$user_details[0]['user_name'],
   'user_active_status'=>'1' );
$this->common_model->insertRow($useractive,'mst_user_activity'); 
        
        $arr_to_return = array('error_code' => '0', 'msg' => 'Success Full','user_records'=>$user_details,'user_access'=>$user_access);
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr); 
  }
  else
  {
    $arr_to_return = array('error_code' => '1', 'msg' => 'Access Denie');
    $response_arr = array('Response' => $arr_to_return);
    echo json_encode($response_arr); 
  }
      }
      else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter User Details','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }

   }

   public function UpdateUserDetails()
   {
 
  
    $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
    $this->form_validation->set_rules('user_name_id', 'user_name_id', 'trim|required');
       $this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
       $this->form_validation->set_rules('first_name', 'first_name', 'trim|required');
       $this->form_validation->set_rules('last_name','last_name','trim|required');
       $this->form_validation->set_rules('middel_name', 'middel_name', 'trim|required');
       $this->form_validation->set_rules('email_id', 'email_id', 'trim|required'); 
       $this->form_validation->set_rules('status', 'Status', 'trim|required');
       $this->form_validation->set_rules('user_type','User type','trim|required');
       if($this->form_validation->run()== TRUE)
      {
       $user_id=$this->input->post('user_id');
        $user_name=$this->input->post('user_name');
        $first_name=$this->input->post('first_name');
        $last_name=$this->input->post('last_name');
        $middel_name=$this->input->post('middel_name');
        $email_id=$this->input->post('email_id');
        $password=$this->input->post('password');
        $status=$this->input->post('status');
        $user_type=$this->input->post('user_type');
        $user_access=$this->getAccessToUser($user_id);
      if($user_access=='2')
      {  $update_arr=array('user_name'=>$user_name,
                          'first_name'=>$first_name,
                           'last_name'=>$last_name,
                            'middle_name'=>$middel_name,
                           'user_email'=>$email_id,
                           'user_status'=>$status,
                           'user_type'=>$user_type,

                        );

                   $this->common_model->updateRow('mst_users',$update_arr,array('user_id'=>$user_id));
                   $useractive= array('user_id_fk'=>$user_id,
                   'user_activity_text'=>' Update the User '.$user_name,
               'user_active_status'=>'1',
               );
  $this->common_model->insertRow($useractive,'mst_user_activity');  
                   $arr_to_return = array('error_code' => '0', 'msg' => 'Success Fully Update');
                   $response_arr = array('Response' => $arr_to_return);
                   echo json_encode($response_arr); 
    }
    else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Access Deine');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
      }
      else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter User Details','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
   }
 public function deletUserDetails()
 {
    
    $this->form_validation->set_rules('user_name_id', 'user_name_id', 'trim|required');
    $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
    if($this->form_validation->run()== TRUE)
    {
        $user_access=$this->getAccessToUser($user_id);
        if($user_access=='2')
      { 
           $user_id=$this->input->post('user_id');
           $user_name_id=$this->input->post('user_name_id');
           $user_details=$this->common_model->getRecords('mst_users','user_name',array('user_id'=>$user_name_id));
           $this->common_model->deleteRow(array($user_name_id),'mst_users','user_id');


           $useractive= array('user_id_fk'=>$user_id,
                            'user_activity_text'=>' Delete the User '.$user_details[0]['user_name'],
                        'user_active_status'=>'1',
                        );
           $this->common_model->insertRow($useractive,'mst_user_activity');  
        $arr_to_return = array('error_code' => '0', 'msg' => 'User Deleted Sucssfully');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr); 
      }
      else
      {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Access Deine');
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);
      }
    }
    else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter User Id','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    }
 }

 public function getActivityUser()
 {
    $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
    if($this->form_validation->run()== TRUE)
    {
      $activity= $this->common_model->getUserActivity();
      $arr_to_return = array('error_code' => '0', 'msg' => 'User Log','user_activity'=>$activity);
      $response_arr = array('Response' => $arr_to_return);
      echo json_encode($response_arr);
    }
    else
    {
        $arr_to_return = array('error_code' => '1', 'msg' => 'Please Enter User Details','errors'=>validation_errors());
        $response_arr = array('Response' => $arr_to_return);
        echo json_encode($response_arr);   
    } 
 }



}
?>