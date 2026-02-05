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
        // Jika sudah login, redirect ke dashboard
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

        $username = $this->input->post('username');
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

        // Set session
        $session_data = [
            'logged_in'  => TRUE,
            'user_id'    => $user->id,
            'username'   => $user->username
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

    // Halaman Register
    public function register()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data = [
            'title'    => 'Register - Arsip Surat PDG',
            'subtitle' => 'Buat Akun Baru'
        ];

        $this->load->view('auth/register', $data);
    }

    // Process Register
    public function do_register()
    {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        }

        // Prepare data
        $data = [
            'username'  => $this->input->post('username'),
            'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        // Insert user
        if ($this->auth_model->insert($data)) {
            $this->session->set_flashdata('success', 'Akun berhasil dibuat! Silakan login.');
            log_message('info', 'User ' . $data['username'] . ' berhasil melakukan registrasi');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat akun. Silakan coba lagi.');
            redirect('auth/register');
        }
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
