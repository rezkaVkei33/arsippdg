<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ========== AUTH ROUTES ==========
$route['auth/login']          = 'auth/login';
$route['auth/do_login']       = 'auth/do_login';
$route['auth/register']       = 'auth/register';
$route['auth/do_register']    = 'auth/do_register';
$route['auth/logout']         = 'auth/logout';
$route['auth/(:any)']         = 'auth/$1';

// Shortcut routes
$route['login']               = 'auth/login';
$route['register']            = 'auth/register';
$route['logout']              = 'auth/logout';

// ========== DASHBOARD ROUTE ==========
$route['dashboard']           = 'dashboard/index';

// ========== SURAT MASUK ROUTES ==========
// route surat masuk 
$route['suratmasuk']                 = 'SuratMasuk/index';
$route['suratmasuk/add']             = 'SuratMasuk/add';
$route['suratmasuk/create']          = 'SuratMasuk/create';
$route['suratmasuk/detail/(:num)']   = 'SuratMasuk/detail/$1';
$route['suratmasuk/update/(:num)']   = 'SuratMasuk/update/$1';
$route['suratmasuk/delete/(:num)']   = 'SuratMasuk/delete/$1';
$route['suratmasuk/change_status/(:num)'] = 'SuratMasuk/change_status/$1';
$route['suratmasuk/export']          = 'SuratMasuk/export';

// route surat keluar
$route['suratkeluar']                 = 'SuratKeluar/index';
$route['suratkeluar/add']             = 'SuratKeluar/add';
$route['suratkeluar/create']          = 'SuratKeluar/create';
$route['suratkeluar/detail/(:num)']   = 'SuratKeluar/detail/$1';
$route['suratkeluar/update/(:num)']   = 'SuratKeluar/update/$1';
$route['suratkeluar/delete/(:num)']   = 'SuratKeluar/delete/$1';
$route['suratkeluar/change_status/(:num)'] = 'SuratKeluar/change_status/$1';
$route['suratkeluar/export']          = 'SuratKeluar/export';

// route arsip
$route['arsip/masuk']                = 'Arsip/masuk';
$route['arsip/keluar']               = 'Arsip/keluar';
$route['arsip/detail/(:num)']        = 'Arsip/detail/$1';
$route['arsip/delete/(:num)']        = 'Arsip/delete/$1';

// route catatan 
$route['catatan']              = 'Catatan/index';
$route['catatan/hapus/(:num)'] = 'Catatan/delete/$1';

// route google 
$route['google/login']    = 'google/login';
$route['google/callback'] = 'google/callback';



