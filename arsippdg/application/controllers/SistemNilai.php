<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SistemNilai extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        require_role('sistem_nilai');
    }

    public function index()
    {
        $this->load->view('sistem_nilai/index', [
            'title' => 'Sistem Nilai - Dashboard'
        ]);
    }
}
