<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class NilaiDashboard extends SistemNilai_Controller
{
    public function index()
    {
        $this->load->model('sistem_nilai/NilaiDashboard_model', 'dashboard_model');

        $this->render('dashboard', [
            'title' => 'Dashboard - Sistem Nilai',
            'summary' => $this->dashboard_model->get_summary(),
            'mahasiswa_per_prodi' => $this->dashboard_model->get_mahasiswa_per_prodi(),
            'tahun_akademik_aktif' => $this->dashboard_model->get_tahun_akademik_aktif()
        ]);
    }
}
