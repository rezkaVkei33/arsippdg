<?php 
class SuratKeluar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        require_login();
        $this->load->model('SuratKeluar_model', 'surat');
        $this->load->model('Catatan_model', 'catatan');
        $this->load->library(['pagination', 'session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $keyword = $this->input->get('q');
        $bulan = $this->input->get('bulan');

        $config['base_url'] = site_url('suratkeluar');
        $config['per_page'] = 10;
        $config['total_rows'] = $this->surat->count_aktif($keyword, $bulan);

        $this->pagination->initialize($config);

        $data = [
            'title'       => 'Arsip PDG - Surat Keluar',
            'subtitle'    => 'Surat Keluar',
            'content'     => 'surat_keluar/index',
            'page_object' => $this->surat->get_aktif(
                                $config['per_page'],
                                $this->uri->segment(3),
                                $keyword,
                                $bulan
                            ),
            'keyword' => $keyword,
            'bulan'=> $bulan
        ];

        $this->load->view('surat_keluar/surat_keluar', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Arsip PDG - Tambah Surat Keluar',
            'subtitle' => 'Tambah Surat Keluar',
            'content' => 'surat_keluar/form'
        ];

        $this->load->view('surat_keluar/mod_surat_keluar', $data);
    }

    public function create()
    {
        if ($this->input->post()) {

            if (empty($_FILES['file_surat']['name'])) {
                $this->session->set_flashdata('error', 'File surat wajib diunggah');
                redirect('suratkeluar/add');
            }

            $nomor_surat = $this->input->post('nomor_surat');
            
            // Cek apakah nomor surat sudah ada
            $existing = $this->db->where('nomor_surat', $nomor_surat)->get('surat_keluar')->row();
            if ($existing) {
                $this->session->set_flashdata('error', 'Nomor surat sudah terdaftar di sistem');
                redirect('suratkeluar/add');
            }

            try {
                $this->load->library('google_drive_oauth');

                $upload = $this->google_drive_oauth->upload(
                    $_FILES['file_surat']['tmp_name'],
                    $_FILES['file_surat']['name'],
                    '137p2ijPz797gTp-wjDoqx3S2LeF3WqvP'
                );
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Gagal upload ke Google Drive: ' . $e->getMessage());
                redirect('suratkeluar/add');
            }

            $data = [
                'nomor_surat' => $nomor_surat,
                'pihak'       => $this->input->post('pihak'),
                'tanggal_surat'=> $this->input->post('tanggal_surat'),
                'perihal'     => $this->input->post('perihal'),
                'ringkasan'   => $this->input->post('ringkasan'),
                'drive_file_id'  => $upload['file_id'],
                'drive_file_url' => $upload['file_url'],
                'drive_mime_type'=> $upload['mime_type'] ?? mime_content_type($_FILES['file_surat']['tmp_name']) ?? 'application/octet-stream',
                'status'      => 'aktif'
            ];

            $this->surat->insert($data);
            $this->session->set_flashdata('success','Surat keluar berhasil ditambahkan');
            redirect('suratkeluar');
        }

        $this->load->view('surat_keluar/mod_surat_keluar', [
            'title' => 'Arsip PDG - Tambah Surat Keluar',
            'subtitle' => 'Tambah Surat Keluar',
            'content' => 'surat_keluar/form'
        ]);
    }

    public function update($id)
    {
        $surat = $this->surat->get_by_id($id);

        if (!$surat) {
            show_404();
        }

        if ($this->input->post()) {
            $data = [
                'nomor_surat' => $this->input->post('nomor_surat'),
                'pihak'       => $this->input->post('pihak'),
                'tanggal_surat'=> $this->input->post('tanggal_surat'),
                'perihal'     => $this->input->post('perihal'),
                'ringkasan'   => $this->input->post('ringkasan')
            ];

            // Jika file baru diunggah
            if (!empty($_FILES['file_surat']['name'])) {
                try {
                    $this->load->library('google_drive_oauth');

                    // Hapus file lama jika ada
                    if (!empty($surat->drive_file_id)) {
                        try {
                            $this->google_drive_oauth->delete_file($surat->drive_file_id);
                        } catch (Exception $e) {
                            log_message('error', 'Gagal menghapus file lama: ' . $e->getMessage());
                        }
                    }

                    $upload = $this->google_drive_oauth->upload(
                        $_FILES['file_surat']['tmp_name'],
                        $_FILES['file_surat']['name'],
                        '137p2ijPz797gTp-wjDoqx3S2LeF3WqvP'
                    );
                } catch (Exception $e) {
                    $this->session->set_flashdata('error', 'Gagal upload ke Google Drive: ' . $e->getMessage());
                    redirect('suratkeluar/update/' . $id);
                }

                $data['drive_file_id'] = $upload['file_id'];
                $data['drive_file_url'] = $upload['file_url'];
                $data['drive_mime_type'] = $upload['mime_type'] ?? mime_content_type($_FILES['file_surat']['tmp_name']) ?? 'application/octet-stream';
            }

            $this->surat->update($id, $data);
            $this->session->set_flashdata('success','Surat keluar berhasil diperbarui');
            redirect('suratkeluar');
        }

        $data = [
            'title' => 'Ubah Surat Keluar',
            'subtitle' => 'Ubah Surat Keluar',
            'content' => 'surat_keluar/form',
            'surat' => $surat
        ];

        $this->load->view('surat_keluar/mod_surat_keluar', $data);
    }

    public function detail($id)
    {
        $surat = $this->surat->get_by_id($id);

        if (!$surat) {
            show_404();
        }

        $catatan = $this->catatan->get_by_surat_keluar_id($id);

        $data = [
            'title' => 'Arsip PDG - Detail Surat Keluar',
            'subtitle' => 'Detail Surat Keluar',
            'jenis_surat' => 'keluar',
            'surat' => $surat,
            'catatan' => $catatan ?? null
        ];

        $this->load->view('surat_masuk/detail_surat', $data);
    }

    public function delete($id)
    {
        $surat = $this->surat->get_by_id($id);

        if (!$surat) {
            show_404();
        }

        // Hapus file dari Google Drive jika ada
        if ($surat->drive_file_id) {
            try {
                $this->load->library('google_drive_oauth');
                $this->google_drive_oauth->delete_file($surat->drive_file_id);
            } catch (Exception $e) {
                $this->session->set_flashdata('warning', 'Surat berhasil dihapus, namun file di Google Drive gagal dihapus: ' . $e->getMessage());
            }
        }

        $this->surat->delete($id);
        $this->session->set_flashdata('success','Surat keluar dan file berhasil dihapus');
        redirect('suratkeluar');
    }

    public function change_status($id)
    {
        $surat = $this->surat->get_by_id($id);

        if (!$surat) {
            show_404();
        }

        if ($this->input->post()) {
            $status = $this->input->post('status');

            // Jika status diubah menjadi diarsipkan
            if ($status === 'diarsipkan' && $surat->status !== 'diarsipkan') {
                $this->load->model('Arsip_model', 'arsip');
                $this->load->library('google_drive_oauth');

                // Cek apakah sudah ada di arsip
                $existing_arsip = $this->arsip->get_by_sumber_id($surat->id, 'keluar');
                
                if (!$existing_arsip) {
                    // Copy file ke folder arsip
                    $archive_folder_id = '1SwvN2ePWPRF8Yezy_KWr6lkQsIxaSLrk';
                    
                    try {
                        $copy_result = $this->google_drive_oauth->copy_file(
                            $surat->drive_file_id,
                            $surat->nomor_surat . '.pdf',
                            $archive_folder_id
                        );

                        // Duplikat ke arsip dengan file ID yang baru
                        $arsip_data = [
                            'jenis_surat'       => 'keluar',
                            'sumber_id'         => $surat->id,
                            'nomor_surat'       => $surat->nomor_surat,
                            'pihak'             => $surat->pihak,
                            'tanggal_surat'     => $surat->tanggal_surat,
                            'perihal'           => $surat->perihal,
                            'ringkasan'         => $surat->ringkasan,
                            'drive_file_id'     => $copy_result['file_id'],
                            'drive_file_url'    => $copy_result['file_url'],
                            'drive_mime_type'   => $copy_result['mime_type'] ?? 'application/pdf',
                            'tanggal_diarsipkan' => date('Y-m-d H:i:s')
                        ];

                        $this->arsip->insert($arsip_data);
                    } catch (Exception $e) {
                        $this->session->set_flashdata('error', 'Gagal copy file ke arsip: ' . $e->getMessage());
                        redirect('suratkeluar');
                    }
                }
            }

            $this->surat->update_status($id, $status);
            $this->session->set_flashdata('success','Status surat berhasil diubah');
            redirect('suratkeluar');
        }
    }

    public function export($format = 'pdf')
    {
        $keyword = $this->input->get('q');
        $bulan = $this->input->get('bulan');

        // Get all aktif data
        $surats = $this->db->where('status', 'aktif');
        
        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('pihak', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $surats = $this->db->order_by('created_at', 'DESC')->get('surat_keluar')->result();

        if ($format === 'excel') {
            $this->export_excel($surats);
        } else {
            $this->export_pdf($surats);
        }
    }

    private function export_pdf($surats)
    {
        $this->load->library('pdf_generator');

        $data = [
            'surats'    => $surats,
            'logo_path' => realpath(FCPATH . 'assets/img/LogoPoltek.png')
        ];

        $html = $this->load->view(
            'surat_keluar/pdf_laporan',
            $data,
            true
        );

        $filename = 'Laporan_Surat_Keluar_' . date('Y-m-d_H-i-s');

        $this->pdf_generator->generate_landscape($html, $filename, true);
    }
}
