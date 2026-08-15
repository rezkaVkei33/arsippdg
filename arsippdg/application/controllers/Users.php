<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        require_master_akun();
        $this->load->model('Auth_model', 'auth_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('users/index', [
            'title' => 'Akun Master - Manajemen Pengguna',
            'users' => $this->auth_model->get_all()
        ]);
    }

    public function create()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[arsip_surat,sistem_nilai,master_akun]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/form', ['title' => 'Tambah Pengguna', 'user' => NULL]);
            return;
        }

        $this->auth_model->insert([
            'username' => trim($this->input->post('username', TRUE)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role' => $this->input->post('role', TRUE)
        ]);

        $this->session->set_flashdata('success', 'Pengguna baru berhasil dibuat');
        redirect('users');
    }

    public function edit($id)
    {
        $user = $this->auth_model->get_user_by_id($id);
        if (!$user) {
            show_404();
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[arsip_surat,sistem_nilai,master_akun]');
        $this->form_validation->set_rules('password', 'Password', 'min_length[8]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/form', ['title' => 'Ubah Pengguna', 'user' => $user]);
            return;
        }

        $username = trim($this->input->post('username', TRUE));
        $existing = $this->auth_model->get_user_by_username($username);
        if ($existing && (int) $existing->id !== (int) $id) {
            $this->session->set_flashdata('error', 'Username sudah digunakan');
            redirect('users/edit/' . $id);
        }

        if ((int) $this->session->userdata('user_id') === (int) $id && $this->input->post('role', TRUE) !== 'master_akun') {
            $this->session->set_flashdata('error', 'Akun Master yang sedang digunakan tidak boleh diubah rolenya');
            redirect('users/edit/' . $id);
        }

        $data = [
            'username' => $username,
            'role' => $this->input->post('role', TRUE)
        ];
        if ($this->input->post('password') !== '') {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $this->auth_model->update($id, $data);

        // Keep the currently logged-in user's session in sync.
        if ((int) $this->session->userdata('user_id') === (int) $id) {
            $this->session->set_userdata(['username' => $data['username'], 'role' => $data['role']]);
        }

        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui');
        redirect('users');
    }

    public function delete($id)
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
        }

        if ((int) $this->session->userdata('user_id') === (int) $id) {
            $this->session->set_flashdata('error', 'Akun yang sedang digunakan tidak dapat dihapus');
            redirect('users');
        }

        $user = $this->auth_model->get_user_by_id($id);
        if (!$user) {
            show_404();
        }

        $this->auth_model->delete($id);
        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        redirect('users');
    }
}
