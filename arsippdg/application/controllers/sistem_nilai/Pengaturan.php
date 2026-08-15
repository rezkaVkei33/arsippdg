<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Pengaturan extends SistemNilai_Controller
{
    public function grade() { $this->render_empty_page('Grade', 'Pengaturan', 'bi-sliders'); }
}
