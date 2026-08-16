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

        if ($tahun_akademik_id <= 0) {
            redirect('sistem-nilai/akademik/khs');
        }

        $tahun = $this->akademik_model->get_tahun_akademik_by_id($tahun_akademik_id);

        $this->render('akademik/mahasiswa_list', [
            'title' => 'Daftar Mahasiswa - KHS',
            'page_title' => 'Daftar Mahasiswa',
            'tahun_akademik' => $tahun,
            'semester' => $semester,
            'mahasiswa' => $this->akademik_model->get_mahasiswa_by_tahun_semester($tahun_akademik_id, $semester),
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
        ]);
    }

    public function ips() { $this->render_empty_page('Indeks Prestasi Semester (IPS)', 'Akademik', 'bi-graph-up-arrow'); }
    public function ipk() { $this->render_empty_page('Indeks Prestasi Kumulatif (IPK)', 'Akademik', 'bi-bar-chart-line'); }
    public function transkrip_nilai() { $this->render_empty_page('Transkrip Nilai', 'Akademik', 'bi-file-earmark-richtext'); }
}
