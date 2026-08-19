<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class MasterData extends SistemNilai_Controller
{
    private $jenjang = ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
    private $status = ['Aktif', 'Nonaktif'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_nilai/ProgramStudi_model', 'program_studi_model');
        $this->load->library('form_validation');
    }

    public function program_studi()
    {
        $keyword = trim((string) $this->input->get('q', TRUE));

        $this->render('program_studi/index', [
            'title' => 'Program Studi - Sistem Nilai',
            'program_studi' => $this->program_studi_model->get_all($keyword),
            'keyword' => $keyword
        ]);
    }

    public function program_studi_create()
    {
        $this->render_program_studi_form('Tambah Program Studi');
    }

    public function program_studi_store()
    {
        $this->require_post();
        $this->set_program_studi_rules(TRUE);

        if ($this->form_validation->run() === FALSE) {
            $this->render_program_studi_form('Tambah Program Studi');
            return;
        }

        $this->program_studi_model->insert($this->program_studi_payload());
        $this->session->set_flashdata('success', 'Program studi berhasil ditambahkan');
        redirect('sistem-nilai/master-data/program-studi');
    }

    public function program_studi_edit($id)
    {
        $program_studi = $this->get_program_studi_or_404($id);
        $this->render_program_studi_form('Ubah Program Studi', $program_studi);
    }

    public function program_studi_update($id)
    {
        $this->require_post();
        $program_studi = $this->get_program_studi_or_404($id);
        $this->set_program_studi_rules(FALSE);

        if ($this->form_validation->run() === FALSE) {
            $this->render_program_studi_form('Ubah Program Studi', $program_studi);
            return;
        }

        $kode_prodi = strtoupper(trim($this->input->post('kode_prodi', TRUE)));
        if ($this->program_studi_model->kode_exists($kode_prodi, $id)) {
            $this->session->set_flashdata('error', 'Kode program studi sudah digunakan');
            redirect('sistem-nilai/master-data/program-studi/ubah/' . $id);
        }

        $this->program_studi_model->update($id, $this->program_studi_payload());
        $this->session->set_flashdata('success', 'Program studi berhasil diperbarui');
        redirect('sistem-nilai/master-data/program-studi');
    }

    public function program_studi_delete($id)
    {
        $this->require_post();
        $this->get_program_studi_or_404($id);
        $this->program_studi_model->delete($id);
        $this->session->set_flashdata('success', 'Program studi berhasil dihapus');
        redirect('sistem-nilai/master-data/program-studi');
    }

    public function program_studi_toggle_status($id)
    {
        $this->require_post();
        $program_studi = $this->get_program_studi_or_404($id);
        $status = $program_studi->status === 'Aktif' ? 'Nonaktif' : 'Aktif';

        $this->program_studi_model->update($id, ['status' => $status]);
        $this->session->set_flashdata('success', 'Program studi berhasil ' . strtolower($status) . '.');
        redirect('sistem-nilai/master-data/program-studi');
    }

    public function tahun_akademik() { $this->render_empty_page('Tahun Akademik', 'Master Data', 'bi-calendar-range'); }
    public function mata_kuliah() { $this->render_empty_page('Mata Kuliah', 'Master Data', 'bi-book'); }
    public function penawaran_mata_kuliah() { $this->render_empty_page('Penawaran Mata Kuliah', 'Master Data', 'bi-journal-plus'); }

    private function set_program_studi_rules($is_create)
    {
        $kode_rule = 'required|trim|max_length[20]';
        if ($is_create) {
            $kode_rule .= '|is_unique[ak_program_studi.kode_prodi]';
        }

        $this->form_validation->set_rules('kode_prodi', 'Kode Program Studi', $kode_rule);
        $this->form_validation->set_rules('nama_prodi', 'Nama Program Studi', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('jenjang', 'Jenjang', 'required|in_list[' . implode(',', $this->jenjang) . ']');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[' . implode(',', $this->status) . ']');
    }

    private function program_studi_payload()
    {
        return [
            'kode_prodi' => strtoupper(trim($this->input->post('kode_prodi', TRUE))),
            'nama_prodi' => trim($this->input->post('nama_prodi', TRUE)),
            'jenjang' => $this->input->post('jenjang', TRUE),
            'status' => $this->input->post('status', TRUE)
        ];
    }

    private function render_program_studi_form($title, $program_studi = NULL)
    {
        $this->render('program_studi/form', [
            'title' => $title . ' - Sistem Nilai',
            'page_title' => $title,
            'program_studi' => $program_studi,
            'jenjang_options' => $this->jenjang,
            'status_options' => $this->status
        ]);
    }

    private function get_program_studi_or_404($id)
    {
        $program_studi = $this->program_studi_model->get_by_id($id);
        if (!$program_studi) {
            show_404();
        }

        return $program_studi;
    }

}
