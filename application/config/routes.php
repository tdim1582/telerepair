<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['choose_boutique'] = "authenticate/choose_boutique";

$route['sold/(:num)'] = "sold/index/$1";
$route['bought/(:num)'] = "bought/index/$1";

$route['access/extra/(:num)'] = "access/index/$1";

$route['products/inventory/devices/(:num)/fraud/(:num)/(:num)'] = "products/inventory_fraud/$1/$2/$3/$4";
$route['products/inventory/(:any)/(:num)/defects/(:num)/(:num)'] = "products/inventory_defects/$1/$2/$3/$4";
$route['products/inventory/(:any)/(:num)'] = "products/inventory/$1/$2";

$route['transfer/(:num)'] = "transfer/index/$1";

$route['logout'] = "authenticate/logout";
$route['login'] = "authenticate/login";
$route['forgotpassword'] = "authenticate/forgotpassword";
$route['resetpassword'] = "authenticate/resetpassword";


$route['default_controller'] = "dashboard";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
