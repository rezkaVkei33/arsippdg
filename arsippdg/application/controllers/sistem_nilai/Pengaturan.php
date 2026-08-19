<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Pengaturan extends SistemNilai_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_nilai/PejabatTtd_model', 'pejabat_ttd_model');
        $this->load->model('sistem_nilai/Grade_model', 'grade_model');
        $this->load->library(['form_validation', 'pagination', 'upload']);
    }

    public function grade()
    {
        $keyword = trim((string) $this->input->get('q', TRUE));
        $page = max(1, (int) $this->input->get('page', TRUE));
        $per_page = 10;
        $total_rows = $this->grade_model->count_all($keyword);

        $config = [
            'base_url' => site_url('sistem-nilai/pengaturan/grade'),
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'use_page_numbers' => TRUE,
            'page_query_string' => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination pagination-sm justify-content-center mb-0">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Awal',
            'last_link' => 'Akhir',
            'next_link' => '›',
            'prev_link' => '‹',
            'num_tag_open' => '<li class="page-item"><span class="page-link">',
            'num_tag_close' => '</span></li>',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>',
            'next_tag_open' => '<li class="page-item"><span class="page-link">',
            'next_tag_close' => '</span></li>',
            'prev_tag_open' => '<li class="page-item"><span class="page-link">',
            'prev_tag_close' => '</span></li>',
            'first_tag_open' => '<li class="page-item"><span class="page-link">',
            'first_tag_close' => '</span></li>',
            'last_tag_open' => '<li class="page-item"><span class="page-link">',
            'last_tag_close' => '</span></li>'
        ];
        $this->pagination->initialize($config);

        $offset = ($page - 1) * $per_page;

        $this->render('pengaturan/grade_index', [
            'title' => 'Grade - Pengaturan Sistem Nilai',
            'page_title' => 'Grade',
            'grades' => $this->grade_model->get_all($keyword, $per_page, $offset),
            'keyword' => $keyword,
            'pagination' => $this->pagination,
            'total_rows' => $total_rows,
            'current_page' => $page,
            'per_page' => $per_page
        ]);
    }

    public function tambah_grade()
    {
        $this->render_grade_form('Tambah Grade');
    }

    public function simpan_grade()
    {
        $this->require_post();

        if (!$this->validate_grade_form()) {
            $this->render_grade_form('Tambah Grade');
            return;
        }

        $data = [
            'kode' => strtoupper(trim((string) $this->input->post('kode', TRUE))),
            'nilai_min' => (float) $this->input->post('nilai_min', TRUE),
            'nilai_max' => (float) $this->input->post('nilai_max', TRUE),
            'bobot' => (float) $this->input->post('bobot', TRUE),
            'keterangan' => trim((string) $this->input->post('keterangan', TRUE)),
        ];

        $this->grade_model->insert($data);
        $this->session->set_flashdata('success', 'Data grade berhasil ditambahkan');
        redirect('sistem-nilai/pengaturan/grade');
    }

    public function ubah_grade($id)
    {
        $grade = $this->grade_model->get_by_id($id);
        if (!$grade) {
            show_404();
        }

        $this->render_grade_form('Ubah Grade', $grade);
    }

    public function update_grade($id)
    {
        $this->require_post();
        $grade = $this->grade_model->get_by_id($id);
        if (!$grade) {
            show_404();
        }

        if (!$this->validate_grade_form(FALSE)) {
            $this->render_grade_form('Ubah Grade', $grade);
            return;
        }

        $data = [
            'kode' => strtoupper(trim((string) $this->input->post('kode', TRUE))),
            'nilai_min' => (float) $this->input->post('nilai_min', TRUE),
            'nilai_max' => (float) $this->input->post('nilai_max', TRUE),
            'bobot' => (float) $this->input->post('bobot', TRUE),
            'keterangan' => trim((string) $this->input->post('keterangan', TRUE)),
        ];

        $this->grade_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data grade berhasil diperbarui');
        redirect('sistem-nilai/pengaturan/grade');
    }

    public function hapus_grade($id)
    {
        $this->require_post();
        $grade = $this->grade_model->get_by_id($id);
        if (!$grade) {
            show_404();
        }

        $this->grade_model->delete($id);
        $this->session->set_flashdata('success', 'Data grade berhasil dihapus');
        redirect('sistem-nilai/pengaturan/grade');
    }

    private function validate_grade_form($require_kode = TRUE)
    {
        $this->form_validation->set_rules('kode', 'Kode Grade', 'required|max_length[10]|alpha_upper');
        $this->form_validation->set_rules('nilai_min', 'Nilai Minimum', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('nilai_max', 'Nilai Maximum', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'max_length[100]');

        if (!$this->form_validation->run()) {
            return FALSE;
        }

        $kode = strtoupper(trim((string) $this->input->post('kode', TRUE)));
        $id = $this->input->post('id', TRUE);
        if ($this->grade_model->kode_exists($kode, $id)) {
            $this->form_validation->set_message('alpha_upper', 'Kode grade sudah digunakan');
            return FALSE;
        }

        return TRUE;
    }

    private function render_grade_form($title, $grade = NULL)
    {
        $grade_id = $grade->id ?? NULL;
        $kode = $grade->kode ?? '';
        $nilai_min = $grade->nilai_min ?? '';
        $nilai_max = $grade->nilai_max ?? '';
        $bobot = $grade->bobot ?? '';
        $keterangan = $grade->keterangan ?? '';

        $this->render('pengaturan/grade_form', [
            'title' => $title . ' - Pengaturan Sistem Nilai',
            'page_title' => $title,
            'grade_id' => $grade_id,
            'kode' => $kode,
            'nilai_min' => $nilai_min,
            'nilai_max' => $nilai_max,
            'bobot' => $bobot,
            'keterangan' => $keterangan,
        ]);
    }

    public function tanda_tangan()
    {
        $keyword = trim((string) $this->input->get('q', TRUE));
        $page = max(1, (int) $this->input->get('page', TRUE));
        $per_page = 10;
        $total_rows = $this->pejabat_ttd_model->count_all($keyword);

        $config = [
            'base_url' => site_url('sistem-nilai/pengaturan/tanda-tangan'),
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'use_page_numbers' => TRUE,
            'page_query_string' => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination pagination-sm justify-content-center mb-0">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Awal',
            'last_link' => 'Akhir',
            'next_link' => '›',
            'prev_link' => '‹',
            'num_tag_open' => '<li class="page-item"><span class="page-link">',
            'num_tag_close' => '</span></li>',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>',
            'next_tag_open' => '<li class="page-item"><span class="page-link">',
            'next_tag_close' => '</span></li>',
            'prev_tag_open' => '<li class="page-item"><span class="page-link">',
            'prev_tag_close' => '</span></li>',
            'first_tag_open' => '<li class="page-item"><span class="page-link">',
            'first_tag_close' => '</span></li>',
            'last_tag_open' => '<li class="page-item"><span class="page-link">',
            'last_tag_close' => '</span></li>'
        ];
        $this->pagination->initialize($config);

        $offset = ($page - 1) * $per_page;

        $this->render('pengaturan/tanda_tangan_index', [
            'title' => 'Tanda Tangan - Pengaturan Sistem Nilai',
            'page_title' => 'Tanda Tangan Pejabat',
            'pejabat' => $this->pejabat_ttd_model->get_all($keyword, $per_page, $offset),
            'keyword' => $keyword,
            'pagination' => $this->pagination,
            'total_rows' => $total_rows,
            'current_page' => $page,
            'per_page' => $per_page
        ]);
    }

    public function tambah_ttd()
    {
        $this->render_ttd_form('Tambah Tanda Tangan');
    }

    public function simpan_ttd()
    {
        $this->require_post();

        if (!$this->validate_ttd_form()) {
            $this->render_ttd_form('Tambah Tanda Tangan');
            return;
        }

        $data = [
            'nama_pejabat' => trim((string) $this->input->post('nama_pejabat', TRUE)),
            'nomor_induk' => trim((string) $this->input->post('nomor_induk', TRUE)),
            'jabatan' => trim((string) $this->input->post('jabatan', TRUE)),
            'tanggal_ttd' => $this->input->post('tanggal_ttd', TRUE),
            'status' => (int) $this->input->post('status', TRUE),
        ];

        $ttd_upload = $this->handle_file_upload('ttd_file', 'ttd');
        if ($ttd_upload === FALSE) {
            $this->session->set_flashdata('error', 'Gagal upload file tanda tangan');
            redirect('sistem-nilai/pengaturan/tanda-tangan/tambah');
            return;
        }
        $data['ttd_path'] = $ttd_upload;

        $cap_upload = $this->handle_file_upload('cap_file', 'cap');
        if ($cap_upload !== FALSE && $cap_upload !== '') {
            $data['cap_path'] = $cap_upload;
        }

        $this->pejabat_ttd_model->insert($data);
        $this->session->set_flashdata('success', 'Data tanda tangan berhasil ditambahkan');
        redirect('sistem-nilai/pengaturan/tanda-tangan');
    }

    public function ubah_ttd($id)
    {
        $pejabat = $this->pejabat_ttd_model->get_by_id($id);
        if (!$pejabat) {
            show_404();
        }

        $this->render_ttd_form('Ubah Tanda Tangan', $pejabat);
    }

    public function update_ttd($id)
    {
        $this->require_post();
        $pejabat = $this->pejabat_ttd_model->get_by_id($id);
        if (!$pejabat) {
            show_404();
        }

        if (!$this->validate_ttd_form(FALSE)) {
            $this->render_ttd_form('Ubah Tanda Tangan', $pejabat);
            return;
        }

        $data = [
            'nama_pejabat' => trim((string) $this->input->post('nama_pejabat', TRUE)),
            'nomor_induk' => trim((string) $this->input->post('nomor_induk', TRUE)),
            'jabatan' => trim((string) $this->input->post('jabatan', TRUE)),
            'tanggal_ttd' => $this->input->post('tanggal_ttd', TRUE),
            'status' => (int) $this->input->post('status', TRUE),
        ];

        $ttd_upload = $this->handle_file_upload('ttd_file', 'ttd');
        if ($ttd_upload === FALSE && !empty($_FILES['ttd_file']['name'])) {
            $this->session->set_flashdata('error', 'Gagal upload file tanda tangan');
            redirect('sistem-nilai/pengaturan/tanda-tangan/ubah/' . $id);
            return;
        }
        if ($ttd_upload !== FALSE && $ttd_upload !== '') {
            @unlink(FCPATH . 'assets/' . $pejabat->ttd_path);
            $data['ttd_path'] = $ttd_upload;
        }

        $cap_upload = $this->handle_file_upload('cap_file', 'cap');
        if ($cap_upload !== FALSE && $cap_upload !== '') {
            if (!empty($pejabat->cap_path)) {
                @unlink(FCPATH . 'assets/' . $pejabat->cap_path);
            }
            $data['cap_path'] = $cap_upload;
        }

        $this->pejabat_ttd_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data tanda tangan berhasil diperbarui');
        redirect('sistem-nilai/pengaturan/tanda-tangan');
    }

    public function hapus_ttd($id)
    {
        $this->require_post();
        $pejabat = $this->pejabat_ttd_model->get_by_id($id);
        if (!$pejabat) {
            show_404();
        }

        if (!empty($pejabat->ttd_path)) {
            @unlink(FCPATH . 'assets/' . $pejabat->ttd_path);
        }
        if (!empty($pejabat->cap_path)) {
            @unlink(FCPATH . 'assets/' . $pejabat->cap_path);
        }

        $this->pejabat_ttd_model->delete($id);
        $this->session->set_flashdata('success', 'Data tanda tangan berhasil dihapus');
        redirect('sistem-nilai/pengaturan/tanda-tangan');
    }

    public function toggle_ttd_status($id)
    {
        $this->require_post();
        $pejabat = $this->pejabat_ttd_model->get_by_id($id);
        if (!$pejabat) {
            show_404();
        }

        $this->pejabat_ttd_model->toggle_status($id);
        $this->session->set_flashdata('success', 'Status tanda tangan berhasil diubah');
        redirect('sistem-nilai/pengaturan/tanda-tangan');
    }

    private function validate_ttd_form($require_ttd = TRUE)
    {
        $this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'required|max_length[150]');
        $this->form_validation->set_rules('nomor_induk', 'Nomor Induk', 'max_length[50]');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|max_length[100]');
        $this->form_validation->set_rules('tanggal_ttd', 'Tanggal Tanda Tangan', 'required|callback_valid_ttd_date');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[0,1]');

        if ($require_ttd && empty($_FILES['ttd_file']['name'])) {
            $this->form_validation->set_message('required', 'File tanda tangan wajib diunggah');
            return FALSE;
        }

        return $this->form_validation->run();
    }

    /** Validate the YYYY-MM-DD value emitted by the HTML date input. */
    public function valid_ttd_date($date)
    {
        $parsed = DateTime::createFromFormat('Y-m-d', (string) $date);
        $is_valid = $parsed && $parsed->format('Y-m-d') === $date;

        if (!$is_valid) {
            $this->form_validation->set_message('valid_ttd_date', 'Format {field} tidak valid.');
        }

        return $is_valid;
    }

    private function handle_file_upload($input_name, $folder)
    {
        if (empty($_FILES[$input_name]['name'])) {
            return '';
        }

        $config = [
            'upload_path' => FCPATH . 'assets/' . $folder,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => 5120,
            'file_name' => 'ttd_' . time() . '_' . random_string('alnum', 8),
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($input_name)) {
            $this->form_validation->set_message('required', $this->upload->display_errors('', ''));
            return FALSE;
        }

        $uploaded = $this->upload->data();
        return $folder . '/' . $uploaded['file_name'];
    }

    private function render_ttd_form($title, $pejabat = NULL)
    {
        $pejabat_id = $pejabat->id ?? NULL;
        $nama_pejabat = $pejabat->nama_pejabat ?? '';
        $nomor_induk = $pejabat->nomor_induk ?? '';
        $jabatan = $pejabat->jabatan ?? '';
        $tanggal_ttd = $pejabat->tanggal_ttd ?? '';
        $ttd_path = $pejabat->ttd_path ?? '';
        $cap_path = $pejabat->cap_path ?? '';
        $status = $pejabat->status ?? 1;

        $this->render('pengaturan/tanda_tangan_form', [
            'title' => $title . ' - Pengaturan Sistem Nilai',
            'page_title' => $title,
            'pejabat_id' => $pejabat_id,
            'nama_pejabat' => $nama_pejabat,
            'nomor_induk' => $nomor_induk,
            'jabatan' => $jabatan,
            'tanggal_ttd' => $tanggal_ttd,
            'ttd_path' => $ttd_path,
            'cap_path' => $cap_path,
            'status' => $status,
        ]);
    }

}
