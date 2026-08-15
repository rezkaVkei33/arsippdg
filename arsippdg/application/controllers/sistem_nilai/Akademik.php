<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Akademik extends SistemNilai_Controller
{
    public function khs() { $this->render_empty_page('Kartu Hasil Studi (KHS)', 'Akademik', 'bi-file-earmark-text'); }
    public function ips() { $this->render_empty_page('Indeks Prestasi Semester (IPS)', 'Akademik', 'bi-graph-up-arrow'); }
    public function ipk() { $this->render_empty_page('Indeks Prestasi Kumulatif (IPK)', 'Akademik', 'bi-bar-chart-line'); }
    public function transkrip_nilai() { $this->render_empty_page('Transkrip Nilai', 'Akademik', 'bi-file-earmark-richtext'); }
}
