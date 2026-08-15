<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class NilaiDashboard extends SistemNilai_Controller
{
    public function index()
    {
        $this->render('dashboard', [
            'title' => 'Dashboard - Sistem Nilai'
        ]);
    }
}
