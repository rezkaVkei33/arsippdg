<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		require_login();
		$this->load->model('Auth_model', 'auth_model');
	}

	public function index()
	{
		$user_id = $this->session->userdata('user_id');
		
		$data = [
            'title' => 'Arsip PDG - Dashboard',
            'content' => 'dashboard/index',
            'last_login' => $this->auth_model->get_user_login_history($user_id, 5),
            'surat_masuk' => 10,
            'surat_keluar' => 5,
            'arsip_masuk' => 20,
            'arsip_keluar' => 12
        ];

		$this->load->view('base', $data);
	}
}
