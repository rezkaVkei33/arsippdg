<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class MasterData extends SistemNilai_Controller
{
    public function program_studi() { $this->render_empty_page('Program Studi', 'Master Data', 'bi-diagram-3'); }
    public function mahasiswa() { $this->render_empty_page('Mahasiswa', 'Master Data', 'bi-people'); }
    public function tahun_akademik() { $this->render_empty_page('Tahun Akademik', 'Master Data', 'bi-calendar-range'); }
    public function mata_kuliah() { $this->render_empty_page('Mata Kuliah', 'Master Data', 'bi-book'); }
    public function penawaran_mata_kuliah() { $this->render_empty_page('Penawaran Mata Kuliah', 'Master Data', 'bi-journal-plus'); }
}
