<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Penilaian extends SistemNilai_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_nilai/Penilaian_model', 'penilaian_model');
        $this->load->model('sistem_nilai/ProgramStudi_model', 'program_studi_model');
        $this->load->model('sistem_nilai/AkademikMaster_model', 'master_model');
        $this->load->library(['form_validation', 'pagination', 'Nilai_excel']);
    }

    public function upload_nilai()
    {
        $selected_prodi = (int) $this->input->get('prodi', TRUE);
        $selected_tahun = (int) $this->input->get('tahun_akademik', TRUE);
        $selected_semester = $this->normalize_semester($this->input->get('semester', TRUE));
        $selected_angkatan = trim((string) $this->input->get('angkatan', TRUE));

        $this->render('penilaian/upload', [
            'title' => 'Upload Nilai - Sistem Nilai',
            'page_title' => 'Upload Nilai',
            'program_studi_options' => $this->program_studi_model->get_all(),
            'tahun_akademik_options' => $this->master_model->tahun_akademik(),
            'mata_kuliah_options' => $this->master_model->mata_kuliah(),
            'semester_options' => ['1' => 'Semester 1', '2' => 'Semester 2'],
            'selected_prodi' => $selected_prodi,
            'selected_tahun' => $selected_tahun,
            'selected_semester' => $selected_semester,
            'selected_angkatan' => $selected_angkatan,
            'angkatan_options' => $this->penilaian_model->angkatan_options()
        ]);
    }

    public function download_template()
    {
        $program_studi_id = (int) ($this->input->get('prodi', TRUE) ?: $this->input->get('program_studi_id', TRUE));
        $tahun_akademik_id = (int) ($this->input->get('tahun_akademik', TRUE) ?: $this->input->get('tahun_akademik_id', TRUE));
        $semester = $this->normalize_semester($this->input->get('semester', TRUE));
        $angkatan = trim((string) $this->input->get('angkatan', TRUE));

        if ($program_studi_id <= 0 || $tahun_akademik_id <= 0 || $semester === '' || $angkatan === '') {
            $this->session->set_flashdata('error', 'Pilih program studi, tahun akademik, semester, dan angkatan terlebih dahulu.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        $students = $this->penilaian_model->get_students_for_upload($program_studi_id, $tahun_akademik_id, $semester, $angkatan);
        $this->nilai_excel->download_template($students);
    }

    public function import_excel()
    {
        $this->require_post();

        $program_studi_id = (int) $this->input->post('program_studi_id', TRUE);
        $tahun_akademik_id = (int) $this->input->post('tahun_akademik_id', TRUE);
        $semester = trim((string) $this->input->post('semester', TRUE));
        $angkatan = trim((string) $this->input->post('angkatan', TRUE));
        $mata_kuliah_id = (int) $this->input->post('mata_kuliah_id', TRUE);

        if ($program_studi_id <= 0 || $tahun_akademik_id <= 0 || $semester === '' || $angkatan === '' || $mata_kuliah_id <= 0) {
            $this->session->set_flashdata('error', 'Semua filter harus dipilih sebelum upload nilai.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        if (empty($_FILES['file_excel']['name']) || $_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
            $this->session->set_flashdata('error', 'Pilih file Excel terlebih dahulu.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        $extension = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['xlsx', 'xls'], TRUE)) {
            $this->session->set_flashdata('error', 'File harus berformat .xlsx atau .xls.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        try {
            $result = $this->nilai_excel->read($_FILES['file_excel']['tmp_name']);
        } catch (Exception $exception) {
            $this->session->set_flashdata('error', 'File Excel tidak dapat dibaca.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        if ($result['error']) {
            $this->session->set_flashdata('error', $result['error']);
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        $students = $this->penilaian_model->get_students_for_upload($program_studi_id, $tahun_akademik_id, $semester, $angkatan);
        $student_map = [];
        foreach ($students as $student) {
            $student_map[strtoupper($student->nim)] = $student;
        }

        $penawaran = $this->penilaian_model->get_penawaran_by_filter($program_studi_id, $tahun_akademik_id, $semester, $mata_kuliah_id);
        if (!$penawaran) {
            $this->session->set_flashdata('error', 'Penawaran mata kuliah tidak ditemukan untuk kombinasi yang dipilih.');
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        $errors = [];
        $inserted = 0;
        $updated = 0;
        $now = date('Y-m-d H:i:s');

        foreach ($result['rows'] as $row_number => $row) {
            $nim = strtoupper(trim((string) $row['nim']));
            $nama = trim((string) $row['nama']);
            $nilai_angka = trim((string) $row['nilai_angka']);
            $nilai_huruf = trim((string) $row['nilai_huruf']);
            $bobot = trim((string) $row['bobot']);

            if ($nim === '' || $nama === '') {
                $errors[] = 'Baris ' . $row_number . ': NIM dan nama wajib diisi.';
                continue;
            }

            if (!isset($student_map[$nim])) {
                $errors[] = 'Baris ' . $row_number . ': NIM ' . $nim . ' tidak termasuk dalam filter yang dipilih.';
                continue;
            }

            if ($nilai_angka === '' || $nilai_huruf === '' || $bobot === '') {
                $errors[] = 'Baris ' . $row_number . ': nilai_angka, nilai_huruf, dan bobot wajib diisi.';
                continue;
            }

            $nilai_angka_float = (float) $nilai_angka;
            $bobot_float = (float) $bobot;
            if ($nilai_angka_float < 0 || $nilai_angka_float > 100 || $bobot_float < 0 || $bobot_float > 100) {
                $errors[] = 'Baris ' . $row_number . ': nilai_angka dan bobot harus berada dalam rentang 0 sampai 100.';
                continue;
            }

            $mahasiswa_id = (int) $student_map[$nim]->id;
            $existing = $this->penilaian_model->get_by_student_and_penawaran($mahasiswa_id, $penawaran->id);
            $payload = [
                'mahasiswa_id' => $mahasiswa_id,
                'penawaran_mk_id' => (int) $penawaran->id,
                'nilai_angka' => $nilai_angka_float,
                'nilai_huruf' => $nilai_huruf,
                'bobot' => $bobot_float,
                'updated_at' => $now
            ];

            if ($existing) {
                $this->penilaian_model->save($payload, $existing->id);
                $updated++;
            } else {
                $payload['created_at'] = $now;
                $this->penilaian_model->insert($payload);
                $inserted++;
            }
        }

        if ($errors) {
            $this->session->set_flashdata('error', 'Upload dibatalkan. Periksa data di bawah form.');
            $this->session->set_flashdata('import_errors', $errors);
            redirect('sistem-nilai/penilaian/upload-nilai');
        }

        $this->session->set_flashdata('success', 'Upload Nilai Berhasil');
        redirect('sistem-nilai/penilaian/daftar-nilai');
    }

    public function daftar_nilai()
    {
        $keyword = trim((string) $this->input->get('q', TRUE));
        $mata_kuliah_id = trim((string) $this->input->get('mata_kuliah', TRUE));
        $page = max(1, (int) $this->input->get('page', TRUE));
        $per_page = 10;
        $total_rows = $this->penilaian_model->count_all($keyword, $mata_kuliah_id);

        $config = [
            'base_url' => site_url('sistem-nilai/penilaian/daftar-nilai'),
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

        $this->render('penilaian/index', [
            'title' => 'Daftar Nilai - Sistem Nilai',
            'page_title' => 'Daftar Nilai',
            'nilai' => $this->penilaian_model->get_all($keyword, $mata_kuliah_id, $per_page, ($page - 1) * $per_page),
            'keyword' => $keyword,
            'selected_mata_kuliah' => $mata_kuliah_id,
            'mata_kuliah_options' => $this->master_model->mata_kuliah(),
            'pagination' => $this->pagination,
            'total_rows' => $total_rows,
            'current_page' => $page,
            'per_page' => $per_page
        ]);
    }

    public function edit($id)
    {
        $nilai = $this->get_or_404($id);
        $this->render('penilaian/form', [
            'title' => 'Ubah Nilai - Sistem Nilai',
            'page_title' => 'Ubah Nilai',
            'nilai' => $nilai,
            'mahasiswa' => $this->penilaian_model->get_mahasiswa_detail($nilai->mahasiswa_id),
            'penawaran' => $this->penilaian_model->get_penawaran_detail($nilai->penawaran_mk_id)
        ]);
    }

    public function update($id)
    {
        $this->require_post();
        $nilai = $this->get_or_404($id);

        $this->form_validation->set_rules('nilai_angka', 'Nilai Angka', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
        $this->form_validation->set_rules('nilai_huruf', 'Nilai Huruf', 'required|trim|max_length[2]');
        $this->form_validation->set_rules('bobot', 'Bobot', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]');

        if ($this->form_validation->run() === FALSE) {
            $this->render('penilaian/form', [
                'title' => 'Ubah Nilai - Sistem Nilai',
                'page_title' => 'Ubah Nilai',
                'nilai' => $nilai,
                'mahasiswa' => $this->penilaian_model->get_mahasiswa_detail($nilai->mahasiswa_id),
                'penawaran' => $this->penilaian_model->get_penawaran_detail($nilai->penawaran_mk_id)
            ]);
            return;
        }

        $this->penilaian_model->save([
            'nilai_angka' => (float) $this->input->post('nilai_angka', TRUE),
            'nilai_huruf' => strtoupper(trim((string) $this->input->post('nilai_huruf', TRUE))),
            'bobot' => (float) $this->input->post('bobot', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        ], $id);

        $this->session->set_flashdata('success', 'Data nilai berhasil diperbarui');
        redirect('sistem-nilai/penilaian/daftar-nilai');
    }

    public function delete($id)
    {
        $this->require_post();
        $this->get_or_404($id);
        $this->penilaian_model->delete($id);
        $this->session->set_flashdata('success', 'Data nilai berhasil dihapus');
        redirect('sistem-nilai/penilaian/daftar-nilai');
    }

    private function normalize_semester($semester)
    {
        $semester = trim((string) $semester);
        if ($semester === '') {
            return '';
        }

        $semester = strtolower($semester);
        if (in_array($semester, ['1', 'ganjil'], TRUE)) {
            return '1';
        }

        if (in_array($semester, ['2', 'genap'], TRUE)) {
            return '2';
        }

        return (string) (int) $semester;
    }

    private function get_or_404($id)
    {
        $nilai = $this->penilaian_model->get_by_id($id);
        if (!$nilai) {
            show_404();
        }

        return $nilai;
    }

    private function require_post()
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
        }
    }
}
