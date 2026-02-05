<?php 
class Arsip extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        require_login();
        $this->load->model('Arsip_model', 'arsip');
        $this->load->library(['pagination', 'session']);
        $this->load->helper(['url', 'form']);
    }

    // Halaman Arsip Masuk
    public function masuk()
    {
        $keyword = $this->input->get('q');
        $bulan = $this->input->get('bulan');

        $config['base_url'] = site_url('arsip/masuk');
        $config['per_page'] = 10;
        
        // Custom query untuk arsip masuk
        $this->db->where('jenis_surat', 'masuk');
        
        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('pihak', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(tanggal_diarsipkan, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $config['total_rows'] = $this->db->count_all_results('arsip');

        $this->pagination->initialize($config);

        // Reset query dan ambil data
        $this->db->where('jenis_surat', 'masuk');
        
        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('pihak', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(tanggal_diarsipkan, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $page_object = $this->db
            ->order_by('tanggal_diarsipkan', 'DESC')
            ->get('arsip', $config['per_page'], $this->uri->segment(3))
            ->result();

        $data = [
            'title'       => 'Arsip PDG - Arsip Surat Masuk',
            'subtitle'    => 'Arsip Surat Masuk',
            'jenis'       => 'masuk',
            'page_object' => $page_object,
            'keyword'     => $keyword,
            'bulan'     => $bulan
        ];

        $this->load->view('arsip/arsip_masuk', $data);
    }

    // Halaman Arsip Keluar
    public function keluar()
    {
        $keyword = $this->input->get('q');
        $bulan = $this->input->get('bulan');

        $config['base_url'] = site_url('arsip/keluar');
        $config['per_page'] = 10;
        
        // Custom query untuk arsip keluar
        $this->db->where('jenis_surat', 'keluar');
        
        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('pihak', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(tanggal_diarsipkan, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $config['total_rows'] = $this->db->count_all_results('arsip');

        $this->pagination->initialize($config);

        // Reset query dan ambil data
        $this->db->where('jenis_surat', 'keluar');
        
        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('pihak', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(tanggal_diarsipkan, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $page_object = $this->db
            ->order_by('tanggal_diarsipkan', 'DESC')
            ->get('arsip', $config['per_page'], $this->uri->segment(3))
            ->result();

        $data = [
            'title'       => 'Arsip Surat Keluar',
            'subtitle'    => 'Arsip Surat Keluar',
            'jenis'       => 'keluar',
            'page_object' => $page_object,
            'keyword'     => $keyword,
            'bulan'     => $bulan
        ];

        $this->load->view('arsip/arsip_keluar', $data);
    }

    // Detail arsip
    public function detail($id)
    {
        $arsip = $this->arsip->get_by_id($id);

        if (!$arsip) {
            show_404();
        }

        $data = [
            'title'   => 'Arsip PDG - Detail Arsip',
            'subtitle' => 'Detail Arsip Surat',
            'arsip'   => $arsip
        ];

        // Gunakan view terpisah berdasarkan jenis surat
        if ($arsip->jenis_surat === 'masuk') {
            $this->load->view('arsip/detail_arsip_masuk', $data);
        } else {
            $this->load->view('arsip/detail_arsip_keluar', $data);
        }
    }

    // Hapus arsip dan file di Google Drive
    public function delete($id)
    {
        $arsip = $this->arsip->get_by_id($id);

        if (!$arsip) {
            show_404();
        }

        // Hapus file dari Google Drive
        if ($arsip->drive_file_id) {
            try {
                $this->load->library('google_drive_oauth');
                $this->google_drive_oauth->delete_file($arsip->drive_file_id);
            } catch (Exception $e) {
                $this->session->set_flashdata('warning', 'Arsip berhasil dihapus, namun file di Google Drive gagal dihapus: ' . $e->getMessage());
            }
        }

        $this->arsip->delete($id);
        $this->session->set_flashdata('success', 'Arsip dan file berhasil dihapus');
        
        // Redirect ke halaman arsip sesuai jenis
        if ($arsip->jenis_surat === 'masuk') {
            redirect('arsip/masuk');
        } else {
            redirect('arsip/keluar');
        }
    }

    // Kembalikan arsip ke status aktif pada surat
    public function kembalikan($id)
    {
        if ($this->input->method() !== 'post') {
            $this->session->set_flashdata('warning', 'Permintaan tidak valid.');
            redirect('arsip/masuk');
        }

        $arsip = $this->arsip->get_by_id($id);

        if (!$arsip) {
            $this->session->set_flashdata('warning', 'Data arsip tidak ditemukan.');
            redirect('arsip/masuk');
        }

        // Tentukan model berdasarkan jenis surat
        if ($arsip->jenis_surat === 'masuk') {
            $this->load->model('SuratMasuk_model', 'surat');
            $redirect_page = 'arsip/masuk';
        } else {
            $this->load->model('SuratKeluar_model', 'surat');
            $redirect_page = 'arsip/keluar';
        }

        // Cek surat sumber masih ada atau tidak
        $surat = $this->surat->get_by_id($arsip->sumber_id);

        if (!$surat) {
            $this->session->set_flashdata('warning',
                'Data surat dengan nomor ' . $arsip->nomor_surat . ' sudah tidak tersedia. '
                . 'Silakan unggah kembali surat tersebut melalui menu Surat. '
                . 'Setelah proses unggah ulang berhasil, arsip ini wajib dihapus '
                . 'untuk menjaga konsistensi data.'
            );
            redirect($redirect_page);
        }

        // Update status surat menjadi aktif
        $this->surat->update_status($arsip->sumber_id, 'aktif');

        $this->session->set_flashdata('success',
            'Status surat ' . $arsip->nomor_surat . ' berhasil dikembalikan ke aktif.'
        );

        redirect($redirect_page);
    }
}
