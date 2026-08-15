<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Laporan extends SistemNilai_Controller
{
    public function rekap_mahasiswa() { $this->render_empty_page('Rekap Mahasiswa', 'Laporan', 'bi-people-fill'); }
    public function rekap_nilai() { $this->render_empty_page('Rekap Nilai', 'Laporan', 'bi-file-bar-graph'); }
    public function rekap_mata_kuliah() { $this->render_empty_page('Rekap Mata Kuliah', 'Laporan', 'bi-journals'); }
}
