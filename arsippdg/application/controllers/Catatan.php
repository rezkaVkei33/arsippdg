<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require_login();
        $this->load->model('Catatan_model', 'catatan');
        $this->load->library(['pagination', 'session']);
        $this->load->helper('url');
    }

    public function index()
    {
        $jenis = $this->input->get('jenis');

        $config['base_url']   = site_url('catatan');
        $config['per_page']   = 10;
        $config['total_rows'] = count(
            $this->catatan->get_all($jenis)
        );

        $this->pagination->initialize($config);

        $data = [
            'title'       => 'Arsip PDG - Catatan',
            'subtitle'    => 'Catatan',
            'content'     => 'catatan/index',
            'page_object' => array_slice(
                $this->catatan->get_all($jenis),
                $this->uri->segment(3),
                $config['per_page']
            ),
            'jenis' => $jenis
        ];

        $this->load->view('layout', $data);
    }

    public function delete($id)
    {
        $this->catatan->delete($id);
        $this->session->set_flashdata('success', 'Catatan berhasil dihapus');
        redirect('catatan');
    }
}
