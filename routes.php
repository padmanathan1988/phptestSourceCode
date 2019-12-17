<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */



/* admin login, dashboard and forgot password */
$route['default_controller'] = "admin/index";
$route['backend'] = "admin/index";
$route['backend/login'] = "admin/index";
$route['backend/index'] = "admin/index";
$route['backend/home'] = "admin/getUserList";
$route['backend/log-out'] = "admin/logout";
$route['backend/user-details-add']="admin/setUserDetails";
$route['backend/user-details-edit/(:any)']="admin/updateUserDetails/$1";
$route['backend/delete-user-details']="admin/deleteUserDetails";
$route['backend/user-log']="admin/getUserLogDetails";




$route['ws-get-login']="webservices/getloginUser";
$route['ws-get-user-details']="webservices/getUerDetails";
$route['ws-set-user-details']="webservices/SetUserDetails";
$route['ws-get-user-details-by-Id']="webservices/getUserDetailsById";
$route['ws-update-user-details']="webservices/UpdateUserDetails";
$route['ws-delete-user-details']="webservices/deletUserDetails";
$route['ws-user-log-details']="webservices/getActivityUser";










