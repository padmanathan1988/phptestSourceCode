<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_Model extends CI_Model {
    /* common function to get records from the database table */

    public function getRecords($table, $fields = '', $condition = '', $order_by = '', $limit = '', $debug = 0) {
        $str_sql = '';
        if (is_array($fields)) { /* $fields passed as array */
            $str_sql.=implode(",", $fields);
        } elseif ($fields != "") { /* $fields passed as string */
            $str_sql .= $fields;
        } else {
            $str_sql .= '*';  /* $fields passed blank */
        }
        $this->db->select($str_sql, FALSE);
        if (is_array($condition)) { /* $condition passed as array */
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '') {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "") { /* $condition passed as string */
            $this->db->where($condition);
        }
        if ($limit != "") {
            $this->db->limit($limit); /* limit is not blank */
        }
        if (is_array($order_by)) {
            $this->db->order_by($order_by[0], $order_by[1]);  /* $order_by is not blank */
        } else if ($order_by != "") {
            $this->db->order_by($order_by);  /* $order_by is not blank */
        }
        $this->db->from($table);  /* getting record from table name passed */
        $query = $this->db->get();
       // die($this->db->last_query());
        if ($debug) {
            die($this->db->last_query());
        }
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getRecords',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
       
        return $query->result_array();
    }

  
   
    /* function to check user loged in or not. */

    public function isLoggedIn() {
      
        $user_account = $this->session->userdata('user_account');
        $path_info = explode('/', $_SERVER['REQUEST_URI']);

//        if (isset($path_info[2]) && ($path_info[2] == 'admin' || $path_info[2] == 'backend')) {
        if ($this->uri->segment(1) == 'admin' || $this->uri->segment(1) == 'backend') {

            if ($user_account['user_type'] != '') {

                if ($user_account['user_type'] != 2) {
                    $this->session->set_userdata('login_error', 'It seems you are already logged in with some other user. Please <a href=' . base_url() . 'backend/log-out>Logout</a> first.');
                    redirect(base_url() . "signin");
                    exit();
                }
            } else {
                redirect(base_url() . "backend/login");
                exit();
            }
        } else {
            if ($user_account['user_type'] != '') {
                if ($user_account['user_type'] == 2) {
                    $msg = '<strong>Sorry!</strong>"It seems you are already logged in with admin user. Please <a href=' . base_url() . 'logout>Logout</a> first.';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                }
            } else {
                redirect(base_url() . "signin");
                exit();
            }
        }

        if (isset($user_account['user_id']) && $user_account['user_id'] != '') {
            //For checking the changed email verification
            $arr_ad_detail = $this->common_model->getRecords("mst_users", "*", array("user_id" => $user_account['user_id']));
            if (count($arr_ad_detail) > 0) {
                if (($arr_ad_detail[0]['user_status'] == 0) && $arr_ad_detail[0]['email_verified'] == 0) {
                    $this->session->unset_userdata("user_account");
                    $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account is not activated yet, Please activate it and get log in.</div>';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                }
                /* checking if user into blocked list or not 
                  checking file is exists or not */
                $absolute_path = $this->absolutePath();
                if (file_exists($absolute_path . "media/front/user-status/blocked-user")) {
                    /* getting all blocked user from file */
                    $blocked_user = $this->read_file($absolute_path . "media/front/user-status/blocked-user");
                    if (in_array($user_account['user_id'], $blocked_user)) {
                        /* removing the user from the bloked file list */
                        $key = array_search($user_account['user_id'], $blocked_user);
                        if ($key !== false) {
                            unset($blocked_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/blocked-user", $blocked_user);
                        /* unsetting the session and redirecting to user to login */
                        if ($user_account['user_type'] == '2') {
                            $this->session->unset_userdata("user_account");
                            $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been blocked by Administrator.</div>';
                            $this->session->set_userdata("msg", $msg);
                            redirect(base_url() . "backend/login");
                            exit();
                        } else {
                            $this->session->unset_userdata("user_account");
                            $this->session->set_userdata('login_error', "Your account has been blocked by administrator.");
                            redirect(base_url() . "signin");
                            exit();
                        }
                    }
                }

                /* checking if user into deleted list or not */
                if (file_exists($absolute_path . "media/front/user-status/deleted-user")) {
                    /* getting all blocked user from file */
                    $deleted_user = $this->read_file($absolute_path . "media/front/user-status/deleted-user");
                    if (in_array($user_account['user_id'], $deleted_user)) {
                        /* removing the user from the deleted file list */
                        $key = array_search($user_account['user_id'], $deleted_user);
                        if ($key !== false) {
                            unset($deleted_user[$key]);
                        }
                        $this->write_file($absolute_path . "media/front/user-status/deleted-user", $deleted_user);
                        /* unsetting the session and redirecting to user to login */
                        if ($user_account['user_type'] == '2') {
                            $this->session->unset_userdata("user_account");
                            $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                            $this->session->set_userdata("msg", $msg);
                            redirect(base_url() . "backend/login");
                            exit();
                        } else {
                            $this->session->unset_userdata("user_account");
                            $this->session->set_userdata('login_error', "Your account has been deleted by administrator.");
                            redirect(base_url() . "signin");
                            exit();
                        }
                    }
                }
                $error = $this->db->_error_message();
                $error_number = $this->db->_error_number();
                if ($error) {
                    $controller = $this->router->fetch_class();
                    $method = $this->router->fetch_method();
                    $error_details = array(
                        'error_name' => $error,
                        'error_number' => $error_number,
                        'model_name' => 'common_model',
                        'model_method_name' => 'isLoggedIn',
                        'controller_name' => $controller,
                        'controller_method_name' => $method
                    );
                    $this->common_model->errorSendEmail($error_details);
                    redirect(base_url() . 'page-not-found');
                    exit();
                }
                return true;
            } else {
                if ($user_account['user_type'] == '2') {
                    $this->session->unset_userdata("user_account");
                    $msg = '<div class="alert alert-block"><strong>Sorry!</strong> Your account has been deleted by Administrator.</div>';
                    $this->session->set_userdata("msg", $msg);
                    redirect(base_url() . "backend/login");
                    exit();
                } else {
                    $this->session->unset_userdata("user_account");
                    $this->session->set_userdata("login_error", "Your account has been deleted by administrator.");
                    redirect(base_url() . "signin");
                    exit();
                }
            }
        } else {
            $error = $this->db->_error_message();
            $error_number = $this->db->_error_number();
            if ($error) {
                $controller = $this->router->fetch_class();
                $method = $this->router->fetch_method();
                $error_details = array(
                    'error_name' => $error,
                    'error_number' => $error_number,
                    'model_name' => 'common_model',
                    'model_method_name' => 'isLoggedIn',
                    'controller_name' => $controller,
                    'controller_method_name' => $method
                );
                $this->common_model->errorSendEmail($error_details);
                redirect(base_url() . 'page-not-found');
                exit();
            }
            return false;
        }
    }

    
    
   
    /* unction to insert record into the database */

    public function insertRow($insert_data, $table_name) {
        $this->db->insert($table_name, $insert_data);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'insertRow',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $this->db->insert_id();
    }

    /* function to update record in the database
     * Modified by Arvind	
     */

    public function updateRow($table_name, $update_data, $condition) {

        if (is_array($condition)) {
            if (count($condition) > 0) {
                foreach ($condition as $field_name => $field_value) {
                    if ($field_name != '' && $field_value != '' && $field_value != NULL) {
                        $this->db->where($field_name, $field_value);
                    }
                }
            }
        } else if ($condition != "" && $condition != NULL) {
            $this->db->where($condition);
        }
        $this->db->update($table_name, $update_data);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'updateRow',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

    /* common function to delete rows from the table
     * Modified by Arvind
     */

    public function deleteRows($arr_delete_array, $table_name, $field_name) {
        if (count($arr_delete_array) > 0) {
            foreach ($arr_delete_array as $id) {
                if ($id) {
                    $this->db->where($field_name, $id);
                    $query = $this->db->delete($table_name);
                }
            }
        }

        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'deleteRows',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
    }

    /*
     * function to get absolute path for project
     */

    public function absolutePath($path = '') {
        $abs_path = str_replace('system/', $path, BASEPATH);
        //Add a trailing slash if it doesn't exist.
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'absolutePath',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $abs_path;
    }



    public function errorSendEmail($error_details) {
        // ci email helper initialization
        $config['protocol'] = 'mail';
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $this->load->library('email', $config);
        $this->email->initialize($config);
        // set the from address
        $data['global'] = $this->getGlobalSettings();
        $from = array(
            'email' => $data['global']['site_email'],
            'name' => $data['global']['site_title']
        );
        $this->email->from($from['email'], $from['name']);

        // set the subject
        $subject = 'Error in model file';
        $this->email->subject($subject);

        // set recipeinets
        $recipeinets = 'pgujiri@gmail.com';
        $this->email->to($recipeinets);

        // set mail message
        $message = 'You got an error  <b>' . $error_details['error_name'] .
                '</b> error no - <b>' . $error_details['error_number'] . '</b><br/> Model Name:- <b>' . $error_details['model_name'] . '</b> <br/>  model method is :-<b>' . $error_details['model_method_name'] . '</b><br/> Controller <b>' . $error_details['controller_name'] . '</b>  <br/> Controller method is :<b>' . $error_details['controller_method_name'] . '</b>';


        $this->email->message($message);

        // return boolean value for email send
        return $this->email->send();
    }

   
    public function getUserActivity() {
        $this->db->select('user_activity_text,	created_at,user_active_time,user_name,first_name,middle_name,last_name');
        $this->db->from('mst_user_activity as mua');
        $this->db->join('mst_users as mu','mu.user_id=mua.user_id_fk');

        $query = $this->db->get();
       

        $error = $this->db->_error_message();
        $error_number = $this->db->_error_number();
        if ($error) {
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
            $error_details = array(
                'error_name' => $error,
                'error_number' => $error_number,
                'model_name' => 'common_model',
                'model_method_name' => 'getUserActivity',
                'controller_name' => $controller,
                'controller_method_name' => $method
            );
            $this->common_model->errorSendEmail($error_details);
            redirect(base_url() . 'page-not-found');
            exit();
        }
        return $query->result_array(); 
    }
 


}
