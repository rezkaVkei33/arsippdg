<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Mahasiswa extends SistemNilai_Controller
{
    private $jenis_kelamin = ['L', 'P'];
    private $status = ['Aktif', 'Cuti', 'Lulus', 'Nonaktif', 'Drop Out'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_nilai/Mahasiswa_model', 'mahasiswa_model');
        $this->load->model('sistem_nilai/ProgramStudi_model', 'program_studi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $keyword = trim((string) $this->input->get('q', TRUE));
        $this->render('mahasiswa/index', [
            'title' => 'Mahasiswa - Sistem Nilai',
            'mahasiswa' => $this->mahasiswa_model->get_all($keyword),
            'keyword' => $keyword
        ]);
    }

    public function create()
    {
        $this->render_form('Tambah Mahasiswa');
    }

    public function store()
    {
        $this->require_post();
        $this->set_rules(TRUE);
        if ($this->form_validation->run() === FALSE) {
            $this->render_form('Tambah Mahasiswa');
            return;
        }

        $this->mahasiswa_model->insert($this->payload());
        $this->session->set_flashdata('success', 'Data mahasiswa berhasil ditambahkan');
        redirect('sistem-nilai/master-data/mahasiswa');
    }

    public function edit($id)
    {
        $this->render_form('Ubah Mahasiswa', $this->get_or_404($id));
    }

    public function update($id)
    {
        $this->require_post();
        $mahasiswa = $this->get_or_404($id);
        $this->set_rules(FALSE);
        if ($this->form_validation->run() === FALSE) {
            $this->render_form('Ubah Mahasiswa', $mahasiswa);
            return;
        }

        $nim = trim((string) $this->input->post('nim', TRUE));
        if ($this->mahasiswa_model->nim_exists($nim, $id)) {
            $this->session->set_flashdata('error', 'NIM sudah digunakan');
            redirect('sistem-nilai/master-data/mahasiswa/ubah/' . $id);
        }

        $this->mahasiswa_model->update($id, $this->payload());
        $this->session->set_flashdata('success', 'Data mahasiswa berhasil diperbarui');
        redirect('sistem-nilai/master-data/mahasiswa');
    }

    public function delete($id)
    {
        $this->require_post();
        $this->get_or_404($id);
        $this->mahasiswa_model->delete($id);
        $this->session->set_flashdata('success', 'Data mahasiswa berhasil dihapus');
        redirect('sistem-nilai/master-data/mahasiswa');
    }

    /** UI only; importing Excel will be implemented separately. */
    public function upload()
    {
        $this->render('mahasiswa/upload', ['title' => 'Upload Mahasiswa - Sistem Nilai']);
    }

    private function set_rules($is_create)
    {
        $nim_rule = 'required|trim|max_length[30]';
        if ($is_create) {
            $nim_rule .= '|is_unique[ak_mahasiswa.nim]';
        }

        $this->form_validation->set_rules('nim', 'NIM', $nim_rule);
        $this->form_validation->set_rules('nama', 'Nama Mahasiswa', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'in_list[' . implode(',', $this->jenis_kelamin) . ']');
        $this->form_validation->set_rules('program_studi_id', 'Program Studi', 'integer');
        $this->form_validation->set_rules('angkatan', 'Angkatan', 'regex_match[/^[0-9]{4}$/]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[' . implode(',', $this->status) . ']');
    }

    private function payload()
    {
        return [
            'nim' => trim((string) $this->input->post('nim', TRUE)),
            'nama' => trim((string) $this->input->post('nama', TRUE)),
            'jenis_kelamin' => $this->nullable_post('jenis_kelamin'),
            'program_studi_id' => $this->nullable_post('program_studi_id', TRUE),
            'angkatan' => $this->nullable_post('angkatan'),
            'status' => $this->input->post('status', TRUE)
        ];
    }

    private function nullable_post($field, $integer = FALSE)
    {
        $value = trim((string) $this->input->post($field, TRUE));
        return $value === '' ? NULL : ($integer ? (int) $value : $value);
    }

    private function render_form($title, $mahasiswa = NULL)
    {
        $this->render('mahasiswa/form', [
            'title' => $title . ' - Sistem Nilai',
            'page_title' => $title,
            'mahasiswa' => $mahasiswa,
            'program_studi_options' => $this->program_studi_model->get_all(),
            'jenis_kelamin_options' => $this->jenis_kelamin,
            'status_options' => $this->status
        ]);
    }

    private function get_or_404($id)
    {
        $mahasiswa = $this->mahasiswa_model->get_by_id($id);
        if (!$mahasiswa) {
            show_404();
        }

        return $mahasiswa;
    }

    private function require_post()
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
        }
    }
}
