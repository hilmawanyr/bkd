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
$route['remove-rsc/(:any)'] = 'penelitian/remove_research/$1';
$route['edit/(:num)'] = 'penelitian/edit/$1';
$route['update-rsc'] = 'penelitian/update';

$route['pengabdian'] = 'pengabdian';
$route['dev-program/(:any)'] = 'pengabdian/get_devotion_program/$1';
$route['dev-param/(:any)'] = 'pengabdian/get_devotion_param/$1';
$route['dev-credit/(:any)/(:any)'] = 'pengabdian/set_devotion_credit/$1/$2';
$route['dev-temp-data'] = 'pengabdian/temporaryDevotion';
$route['load-dev-temp'] = 'pengabdian/load_devotion_temp_table';
$route['remove-temp-dev/(:num)'] = 'pengabdian/delete_temp_devotion/$1';
$route['add-dev'] = 'pengabdian/add_devotion';
$route['load-dev-list'] = 'pengabdian/load_list_page';
$route['dev-edit/(:num)'] = 'pengabdian/edit/$1';
$route['update-dev'] = 'pengabdian/update';
$route['remove-dev/(:num)'] = 'pengabdian/remove/$1';
$route['dev-by-year/(:any)'] = 'pengabdian/dev_on_year/$1';

$route['form'] = 'form';
$route['set-form-year'] = 'form/set_opt';
$route['print-form'] = 'form/print_out_form';

$route['laporan-pengajaran'] = 'pengajaran/report_pengajaran';
$route['pengajaran-claim-pertahun/(:any)'] = 'pengajaran/report_pengajaran/detail/$1';
$route['claim-pengajaran/(:any)'] = 'pengajaran/report_pengajaran/claim/$1';
$route['claim-flag/(:any)'] = 'pengajaran/report_pengajaran/flag/$1';
$route['attach-teach-evidence'] = 'pengajaran/report_pengajaran/attach_file';

$route['laporan-penelitian'] = 'penelitian/report_penelitian';
$route['penelitian-claim-pertahun/(:any)'] = 'penelitian/report_penelitian/detail/$1';
$route['attach-doc/(:any)/(:any)'] = 'penelitian/report_penelitian/attach_file/$1/$2';
$route['submit-doc/(:any)'] = 'penelitian/report_penelitian/submit_attachment/$1';
$route['remove-doc-link/(:any)/(:any)'] = 'penelitian/report_penelitian/remove_link/$1/$2';