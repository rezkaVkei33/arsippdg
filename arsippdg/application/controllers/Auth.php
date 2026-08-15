<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth_model');
        $this->load->library('form_validation');
    }

    // Halaman Login
    public function login()
    {
        // Jika sudah login, redirect ke dashboard sesuai role.
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data = [
            'title'    => 'Login - Arsip Surat PDG',
            'subtitle' => 'Masuk ke Sistem'
        ];

        $this->load->view('auth/login', $data);
    }

    // Process Login
    public function do_login()
    {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        }

        $username = trim($this->input->post('username', TRUE));
        $password = $this->input->post('password');

        // Cek user
        $user = $this->auth_model->get_user_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth/login');
        }

        // Verifikasi password
        if (!password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('auth/login');
        }

        if (!in_array($user->role, ['arsip_surat', 'sistem_nilai', 'master_akun'], TRUE)) {
            log_message('error', 'User ' . $username . ' memiliki role tidak valid');
            $this->session->set_flashdata('error', 'Role akun tidak valid. Hubungi administrator');
            redirect('auth/login');
        }

        // Set session. Kolom role wajib ada pada tabel users.
        $this->session->sess_regenerate(TRUE);
        $session_data = [
            'logged_in'  => TRUE,
            'user_id'    => $user->id,
            'username'   => $user->username,
            'role'       => $user->role
        ];

        $this->session->set_userdata($session_data);

        // Record login activity
        $ip_address = $this->input->ip_address();
        $this->auth_model->record_login($user->id, $ip_address);

        // Log activity
        log_message('info', 'User ' . $username . ' berhasil login dari IP: ' . $ip_address);

        $this->session->set_flashdata('success', 'Selamat datang, ' . $username);
        redirect('dashboard');
    }

    // Logout
    public function logout()
    {
        $username = $this->session->userdata('username');
        
        log_message('info', 'User ' . $username . ' melakukan logout');
        
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda telah logout');
        redirect('auth/login');
    }
}
