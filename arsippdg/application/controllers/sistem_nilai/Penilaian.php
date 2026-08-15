<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Penilaian extends SistemNilai_Controller
{
    public function upload_nilai() { $this->render_empty_page('Upload Nilai', 'Penilaian', 'bi-cloud-arrow-up'); }
    public function daftar_nilai() { $this->render_empty_page('Daftar Nilai', 'Penilaian', 'bi-clipboard-data'); }
}
