<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'hotel/manufacture/$1';
$route['manufacture'] = 'hotel/manufacture/$1';
$route['model'] = 'hotel/do_upload/$1';
$route['cars'] = 'hotel/cars/$1';
$route['details/(:any)'] = 'hotel/details/$1';
$route['remove/(:any)'] = 'hotel/remove/$1';
$route['upload/do_upload'] = 'hotel/do_upload/$1';



$route['404_override'] = 'notfound';
$route['translate_uri_dashes'] = FALSE;