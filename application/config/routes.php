<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login_controller';
$route['404_override'] = 'login_controller';
$route['translate_uri_dashes'] = FALSE;

//RUTA: LOGIN
$route['acreditando'] = 'login_controller/validandoCuenta';
$route['salir'] = 'login_controller/salir';



//RUTA: REPORTES
$route['main'] = 'main_controller';
$route['getResumen'] = 'main_controller/getResumen';

$route['inweb'] = 'main_controller/inweb';
$route['getInweb'] = 'main_controller/getInweb';
$route['reset_sku'] = 'main_controller/reset_sku';

$route['BuscarSolicitud'] = 'main_controller/BuscarSolicitud';

$route['Info_Cuenta/(:any)'] = 'main_controller/getInfoCuenta/$1';
$route['Load_factura/(:any)/(:any)'] = 'main_controller/Load_factura/$1/$2';
$route['save_log_factura/(:any)/(:any)/(:any)'] = 'main_controller/save_log_factura/$1/$2/$3';

