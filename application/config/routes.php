<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth'] = 'auth';
$route['login'] = 'auth/attemp_login';
$route['logout'] = 'auth/logout';

$route['pengajaran'] = 'pengajaran';
$route['review-pengajaran'] = 'pengajaran/load_page';
$route['daftar-pengajaran'] = 'pengajaran/daftar_pengajaran';
$route['pengajaran-pertahun/(:num)'] = 'pengajaran/detail/$1';
$route['ubah-pengajaran/(:num)'] = 'pengajaran/edit/$1';
$route['update-pengajaran/(:num)'] = 'pengajaran/update/$1';
$route['hapus-pengajaran/(:num)'] = 'pengajaran/remove/$1';

$route['penelitian'] = 'penelitian';
$route['tambah-penelitian'] = 'penelitian/add';
$route['program-penelitian/(:any)'] = 'penelitian/program_activity/$1';
$route['parameter-penelitian/(:any)'] = 'penelitian/program_params/$1';
$route['sks-penelitian/(:any)/(:any)'] = 'penelitian/set_sks/$1/$2';
$route['set-duration-category/(:any)'] = 'penelitian/duration_category/$1';
$route['temp-rsc-table'] = 'penelitian/loadTable';
$route['temp-research'] = 'penelitian/temporaryResearch';
$route['rm-temp-row/(:num)'] = 'penelitian/deleteList/$1';
$route['rsc-detail/(:num)/(:any)'] = 'penelitian/load_detail/$1/$2';
$route['attach-doc/(:num)/(:any)'] = 'penelitian/attach_file/$1/$2';
$route['submit-doc/(:any)'] = 'penelitian/submit_attachment/$1';
$route['remove-doc-link/(:any)/(:any)'] = 'penelitian/remove_link/$1/$2';
$route['remove-rsc/(:any)'] = 'penelitian/remove_research/$1';
$route['edit/(:num)'] = 'penelitian/edit/$1';
$route['update-rsc'] = 'penelitian/update';