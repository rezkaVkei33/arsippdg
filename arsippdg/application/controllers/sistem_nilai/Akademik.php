<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/SistemNilai_Controller.php';

class Akademik extends SistemNilai_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sistem_nilai/Akademik_model', 'akademik_model');
        $this->load->model('sistem_nilai/ProgramStudi_model', 'program_studi_model');
        $this->load->library('pagination');
    }

    public function khs()
    {
        $tahun_id = $this->input->get('tahun_id', TRUE);
        $semester = $this->input->get('semester', TRUE);

        $data = [
            'title' => 'Kartu Hasil Studi (KHS) - Sistem Nilai',
            'page_title' => 'Riwayat Akademik',
            'riwayat' => $this->akademik_model->get_riwayat_akademik($tahun_id, $semester),
            'selected_tahun_id' => $tahun_id,
            'selected_semester' => $semester,
            'tahun_akademik_options' => $this->db->order_by('tahun', 'DESC')->get('ak_tahun_akademik')->result(),
            'semester_options' => ['Ganjil' => 'Ganjil', 'Genap' => 'Genap']
        ];

        $this->render('akademik/khs_index', $data);
    }

    public function riwayat_mahasiswa()
    {
        $tahun_akademik_id = (int) $this->input->get('tahun_id', TRUE);
        $semester = $this->input->get('semester', TRUE);
        $selected_prodi = trim((string) $this->input->get('prodi', TRUE));
        $page = max(1, (int) $this->input->get('page', TRUE));
        $per_page = 10;

        if ($tahun_akademik_id <= 0) {
            redirect('sistem-nilai/akademik/khs');
        }

        $tahun = $this->akademik_model->get_tahun_akademik_by_id($tahun_akademik_id);
        $total_rows = $this->akademik_model->count_mahasiswa_by_tahun_semester($tahun_akademik_id, $semester, $selected_prodi);

        $config = [
            'base_url' => site_url('sistem-nilai/akademik/riwayat-mahasiswa') . '?tahun_id=' . (int) $tahun_akademik_id . '&semester=' . urlencode((string) $semester),
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
        $mahasiswa = $this->akademik_model->get_mahasiswa_by_tahun_semester($tahun_akademik_id, $semester, $selected_prodi, $per_page, $offset);

        $this->render('akademik/mahasiswa_list', [
            'title' => 'Daftar Mahasiswa - KHS',
            'page_title' => 'Daftar Mahasiswa',
            'tahun_akademik' => $tahun,
            'semester' => $semester,
            'selected_prodi' => $selected_prodi,
            'program_studi_options' => $this->program_studi_model->get_all(),
            'mahasiswa' => $mahasiswa,
            'pagination' => $this->pagination,
            'total_rows' => $total_rows,
            'current_page' => $page,
            'per_page' => $per_page,
        ]);
    }

    public function khs_mahasiswa($mahasiswa_id, $tahun_akademik_id)
    {
        $mahasiswa = $this->akademik_model->get_mahasiswa_detail($mahasiswa_id);
        if (!$mahasiswa) {
            show_404();
        }

        $tahun = $this->akademik_model->get_tahun_akademik_by_id($tahun_akademik_id);
        $khs_rows = $this->akademik_model->get_khs_by_mahasiswa($mahasiswa_id, $tahun_akademik_id, $tahun ? $tahun->semester : NULL);

        $total_sks = 0;
        $total_nilai_mutu = 0;
        foreach ($khs_rows as $row) {
            $total_sks += (float) $row->sks;
            $total_nilai_mutu += (float) $row->nilai_mutu;
        }

        $ip = $total_sks > 0 ? $total_nilai_mutu / $total_sks : 0;

        $this->render('akademik/khs_detail', [
            'title' => 'KHS Mahasiswa - Sistem Nilai',
            'page_title' => 'KHS Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'tahun_akademik' => $tahun,
            'khs' => $khs_rows,
            'total_sks' => $total_sks,
            'total_nilai_mutu' => $total_nilai_mutu,
            'ip' => $ip,
            'export_url' => site_url('sistem-nilai/akademik/export-khs/' . (int) $mahasiswa_id . '/' . (int) $tahun_akademik_id),
        ]);
    }

    public function export_khs($mahasiswa_id, $tahun_akademik_id)
    {
        $this->load->library('pdf_generator');

        $mahasiswa = $this->akademik_model->get_mahasiswa_detail($mahasiswa_id);
        if (!$mahasiswa) {
            show_404();
        }

        $tahun = $this->akademik_model->get_tahun_akademik_by_id($tahun_akademik_id);
        if (!$tahun) {
            show_404();
        }

        $khs_rows = $this->akademik_model->get_khs_by_mahasiswa($mahasiswa_id, $tahun_akademik_id, $tahun->semester);

        $total_sks = 0;
        $total_nilai_mutu = 0;
        foreach ($khs_rows as $row) {
            $total_sks += (float) $row->sks;
            $total_nilai_mutu += (float) $row->nilai_mutu;
        }
        $ip = $total_sks > 0 ? $total_nilai_mutu / $total_sks : 0;

        $updated = $this->akademik_model->get_latest_khs_update($mahasiswa_id, $tahun_akademik_id);
        $tanggal_update = !empty($updated->updated_at) ? date('d F Y', strtotime($updated->updated_at)) : date('d F Y');

        $html = $this->load->view('akademik/pdf_khs', [
            'mahasiswa' => $mahasiswa,
            'tahun_akademik' => $tahun,
            'khs' => $khs_rows,
            'total_sks' => $total_sks,
            'total_nilai_mutu' => $total_nilai_mutu,
            'ip' => $ip,
            'tanggal_update' => $tanggal_update,
        ], TRUE);

        $this->pdf_generator->generate($html, 'KHS_' . $mahasiswa->nim, true);
    }

    public function ips() { $this->render_empty_page('Indeks Prestasi Semester (IPS)', 'Akademik', 'bi-graph-up-arrow'); }
    public function ipk() { $this->render_empty_page('Indeks Prestasi Kumulatif (IPK)', 'Akademik', 'bi-bar-chart-line'); }
    public function transkrip_nilai() { $this->render_empty_page('Transkrip Nilai', 'Akademik', 'bi-file-earmark-richtext'); }
}
