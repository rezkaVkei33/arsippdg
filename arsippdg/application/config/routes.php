<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ========== AUTH ROUTES ==========
$route['auth/login']          = 'auth/login';
$route['auth/do_login']       = 'auth/do_login';
$route['auth/logout']         = 'auth/logout';
$route['auth/(:any)']         = 'auth/$1';

// Shortcut routes
$route['login']               = 'auth/login';
$route['register']            = 'auth/register';
$route['logout']              = 'auth/logout';

// ========== DASHBOARD ROUTE ==========
$route['dashboard']           = 'dashboard/index';

// ========== SISTEM NILAI ROUTES ==========
$route['sistem-nilai']                                      = 'sistem_nilai/NilaiDashboard/index';
$route['sistem-nilai/master-data/program-studi']            = 'sistem_nilai/MasterData/program_studi';
$route['sistem-nilai/master-data/program-studi/tambah']     = 'sistem_nilai/MasterData/program_studi_create';
$route['sistem-nilai/master-data/program-studi/simpan']     = 'sistem_nilai/MasterData/program_studi_store';
$route['sistem-nilai/master-data/program-studi/ubah/(:num)'] = 'sistem_nilai/MasterData/program_studi_edit/$1';
$route['sistem-nilai/master-data/program-studi/perbarui/(:num)'] = 'sistem_nilai/MasterData/program_studi_update/$1';
$route['sistem-nilai/master-data/program-studi/hapus/(:num)'] = 'sistem_nilai/MasterData/program_studi_delete/$1';
$route['sistem-nilai/master-data/mahasiswa']                = 'sistem_nilai/Mahasiswa/index';
$route['sistem-nilai/master-data/mahasiswa/tambah']         = 'sistem_nilai/Mahasiswa/create';
$route['sistem-nilai/master-data/mahasiswa/simpan']         = 'sistem_nilai/Mahasiswa/store';
$route['sistem-nilai/master-data/mahasiswa/ubah/(:num)']    = 'sistem_nilai/Mahasiswa/edit/$1';
$route['sistem-nilai/master-data/mahasiswa/perbarui/(:num)'] = 'sistem_nilai/Mahasiswa/update/$1';
$route['sistem-nilai/master-data/mahasiswa/hapus/(:num)']   = 'sistem_nilai/Mahasiswa/delete/$1';
$route['sistem-nilai/master-data/mahasiswa/upload']         = 'sistem_nilai/Mahasiswa/upload';
$route['sistem-nilai/master-data/mahasiswa/template']       = 'sistem_nilai/Mahasiswa/download_template';
$route['sistem-nilai/master-data/mahasiswa/import']         = 'sistem_nilai/Mahasiswa/import_excel';
foreach (['tahun-akademik', 'mata-kuliah', 'penawaran-mata-kuliah'] as $master_route) {
    $route['sistem-nilai/master-data/' . $master_route] = 'sistem_nilai/AkademikMaster/' . str_replace('-', '_', $master_route);
    $route['sistem-nilai/master-data/' . $master_route . '/tambah'] = 'sistem_nilai/AkademikMaster/create/' . $master_route;
    $route['sistem-nilai/master-data/' . $master_route . '/simpan'] = 'sistem_nilai/AkademikMaster/store/' . $master_route;
    $route['sistem-nilai/master-data/' . $master_route . '/ubah/(:num)'] = 'sistem_nilai/AkademikMaster/edit/' . $master_route . '/$1';
    $route['sistem-nilai/master-data/' . $master_route . '/perbarui/(:num)'] = 'sistem_nilai/AkademikMaster/update/' . $master_route . '/$1';
    $route['sistem-nilai/master-data/' . $master_route . '/hapus/(:num)'] = 'sistem_nilai/AkademikMaster/delete/' . $master_route . '/$1';
}
$route['sistem-nilai/penilaian/upload-nilai']               = 'sistem_nilai/Penilaian/upload_nilai';
$route['sistem-nilai/penilaian/daftar-nilai']               = 'sistem_nilai/Penilaian/daftar_nilai';
$route['sistem-nilai/akademik/khs']                         = 'sistem_nilai/Akademik/khs';
$route['sistem-nilai/akademik/ips']                         = 'sistem_nilai/Akademik/ips';
$route['sistem-nilai/akademik/ipk']                         = 'sistem_nilai/Akademik/ipk';
$route['sistem-nilai/akademik/transkrip-nilai']             = 'sistem_nilai/Akademik/transkrip_nilai';
$route['sistem-nilai/laporan/rekap-mahasiswa']              = 'sistem_nilai/Laporan/rekap_mahasiswa';
$route['sistem-nilai/laporan/rekap-nilai']                  = 'sistem_nilai/Laporan/rekap_nilai';
$route['sistem-nilai/laporan/rekap-mata-kuliah']            = 'sistem_nilai/Laporan/rekap_mata_kuliah';
$route['sistem-nilai/pengaturan/grade']                     = 'sistem_nilai/Pengaturan/grade';

// ========== USER MANAGEMENT ROUTES ==========
$route['users']               = 'Users/index';
$route['users/create']        = 'Users/create';
$route['users/edit/(:num)']   = 'Users/edit/$1';
$route['users/delete/(:num)'] = 'Users/delete/$1';

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
