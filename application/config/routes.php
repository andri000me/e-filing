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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['admin/page/dashboard'] = 'admin/dashboard';
$route['user/page/dashboard'] = 'user/dashboard';

// Config
$route['admin/page/config'] = 'admin/config';
$route['admin/page/config/upd_stat'] = 'admin/config/upd_stat';
$route['admin/page/config/insert'] = 'admin/config/insert';
$route['admin/page/config/update'] = 'admin/config/update';
$route['admin/page/config/delete/(:num)'] = 'admin/config/delete/$1';
$route['admin/page/config/get/(:num)'] = 'admin/config/get_data/$1';

// Jenis Dokumen
$route['admin/page/jenis-dokumen'] = 'admin/jenis_dokumen';
$route['admin/page/jenis-dokumen/insert'] = 'admin/jenis_dokumen/insert';
$route['admin/page/jenis-dokumen/update'] = 'admin/jenis_dokumen/update';
$route['admin/page/jenis-dokumen/delete/(:num)'] = 'admin/jenis_dokumen/delete/$1';
$route['admin/page/jenis-dokumen/get/(:num)'] = 'admin/jenis_dokumen/get_data/$1';

// Kategori Dokumen
$route['admin/page/kategori-dokumen'] = 'admin/kategori_dokumen';
$route['admin/page/kategori-dokumen/insert'] = 'admin/kategori_dokumen/insert';
$route['admin/page/kategori-dokumen/update'] = 'admin/kategori_dokumen/update';
$route['admin/page/kategori-dokumen/delete/(:num)'] = 'admin/kategori_dokumen/delete/$1';
$route['admin/page/kategori-dokumen/get/(:num)'] = 'admin/kategori_dokumen/get_data/$1';

// Unit Tujuan
$route['admin/page/unit-tujuan'] = 'admin/unit_tujuan';
$route['admin/page/unit-tujuan/list'] = 'admin/unit_tujuan/list_unit';
$route['admin/page/unit-tujuan/insert'] = 'admin/unit_tujuan/insert';
$route['admin/page/unit-tujuan/update'] = 'admin/unit_tujuan/update';
$route['admin/page/unit-tujuan/delete/(:num)'] = 'admin/unit_tujuan/delete/$1';
$route['admin/page/unit-tujuan/get/(:num)'] = 'admin/unit_tujuan/get_data/$1';

// Jabatan
$route['admin/page/jabatan'] = 'admin/jabatan';
$route['admin/page/jabatan/insert'] = 'admin/jabatan/insert';
$route['admin/page/jabatan/update'] = 'admin/jabatan/update';
$route['admin/page/jabatan/delete/(:num)'] = 'admin/jabatan/delete/$1';
$route['admin/page/jabatan/get/(:num)'] = 'admin/jabatan/get_data/$1';

// Pegawai
$route['admin/page/pegawai'] = 'admin/pegawai';
$route['admin/page/pegawai/insert'] = 'admin/pegawai/insert';
$route['admin/page/pegawai/update'] = 'admin/pegawai/update';
$route['admin/page/pegawai/delete/(:num)'] = 'admin/pegawai/delete/$1';
$route['admin/page/pegawai/get/(:num)'] = 'admin/pegawai/get_data/$1';

// Dokumen Keluar
$route['user/page/dokumen-keluar'] = 'user/dokumen_keluar';
$route['user/page/dokumen-keluar/list'] = 'user/dokumen_keluar/get_list';
$route['user/page/dokumen-keluar/insert'] = 'user/dokumen_keluar/insert';
$route['user/page/dokumen-keluar/update'] = 'user/dokumen_keluar/update';
$route['user/page/dokumen-keluar/delete/(:num)'] = 'user/dokumen_keluar/delete/$1';
$route['user/page/dokumen-keluar/get/(:num)'] = 'user/dokumen_keluar/get_data/$1';

// Dokumen Masuk
$route['user/page/dokumen-masuk'] = 'user/dokumen_masuk';
$route['user/page/dokumen-masuk/list'] = 'user/dokumen_masuk/get_list';
$route['user/page/dokumen-masuk/insert'] = 'user/dokumen_masuk/insert';
$route['user/page/dokumen-masuk/update'] = 'user/dokumen_masuk/update';
$route['user/page/dokumen-masuk/delete/(:num)'] = 'user/dokumen_masuk/delete/$1';
$route['user/page/dokumen-masuk/get/(:num)'] = 'user/dokumen_masuk/get_data/$1';

// Laporan Dokumen Keluar
$route['user/page/laporan-dokumen-keluar'] = 'user/laporan_dok_keluar';
