<?php 
class SuratMasuk extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        require_login();
        $this->load->model('SuratMasuk_model', 'surat');
        $this->load->model('Catatan_model', 'catatan');
        $this->load->library(['pagination', 'session']);
        $this->load->helper(['url', 'form']);

    }

    public function index()
    {
        $keyword = $this->input->get('q');
        $bulan = $this->input->get('bulan');

        $config['base_url'] = site_url('suratmasuk');
        $config['per_page'] = 10;
        $config['total_rows'] = $this->surat->count_aktif($keyword, $bulan);

        $this->pagination->initialize($config);

        $data = [
            'title'       => 'Arsip PDG - Surat Masuk',
            'subtitle'    => 'Surat Masuk',
            'content'     => 'surat_masuk/index',
            'page_object' => $this->surat->get_aktif(
                                $config['per_page'],
                                $this->uri->segment(3),
                                $keyword,
                                $bulan
                            ),
            'keyword' => $keyword,
            'bulan'=> $bulan
        ];

        $this->load->view('surat_masuk/surat_masuk', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Arsip PDG - Tambah Surat Masuk',
            'subtitle' => 'Tambah Surat Masuk',
            'content' => 'surat_masuk/form'
        ];

        $this->load->view('surat_masuk/mod_surat_masuk', $data);
    }

    public function create()
    {
        if ($this->input->post()) {

            if (empty($_FILES['file_surat']['name'])) {
                $this->session->set_flashdata('error', 'File surat wajib diunggah');
                redirect('suratmasuk/add');
            }

            $this->load->library('google_drive_oauth');

            try {
                $upload = $this->google_drive_oauth->upload(
                    $_FILES['file_surat']['tmp_name'],
                    $_FILES['file_surat']['name'],
                    '1YzpWe7s6TFVT8o9F_idLj0VaEiCZpXZ3'
                );

                $data = [
                    'nomor_surat' => $this->input->post('nomor_surat'),
                    'asal_surat'  => $this->input->post('asal_surat'),
                    'tanggal_surat'=> $this->input->post('tanggal_surat'),
                    'perihal'     => $this->input->post('perihal'),
                    'ringkasan'   => $this->input->post('ringkasan'),
                    'drive_file_id'  => $upload['file_id'],
                    'drive_file_url' => $upload['file_url'],
                    'drive_mime_type'=> $upload['mime_type'] ?? mime_content_type($_FILES['file_surat']['tmp_name']) ?? 'application/octet-stream'
                ];

                $this->surat->insert($data);
                $this->session->set_flashdata('success','Surat masuk berhasil ditambahkan');
                redirect('suratmasuk');
            } catch (Exception $e) {
                $this->session->set_flashdata('error', 'Gagal mengunggah file: ' . $e->getMessage());
                redirect('suratmasuk/add');
            }
        }

        $this->load->view('surat_masuk/mod_surat_masuk', [
            'title' => 'Arsip PDG - Tambah Surat Masuk',
            'subtitle' => 'Tambah Surat Masuk',
            'content' => 'surat_masuk/form'
        ]);
    }

    public function detail($id)
    {
        $surat = $this->surat->get_by_id($id);

        if (!$surat) {
            show_404();
        }

        $catatan = $this->catatan->get_by_surat_masuk_id($id);

        $data = [
            'title'   => 'Arsip PDG - Detail Surat Masuk',
            'subtitle' => 'Detail Surat Masuk',
            'jenis_surat' => 'masuk',
            'surat'   => $surat,
            'catatan' => $catatan
        ];

        $this->load->view('surat_masuk/detail_surat', $data);
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
                'asal_surat'  => $this->input->post('asal_surat'),
                'tanggal_surat'=> $this->input->post('tanggal_surat'),
                'perihal'     => $this->input->post('perihal'),
                'ringkasan'   => $this->input->post('ringkasan')
            ];

            // Jika file baru diunggah
            if (!empty($_FILES['file_surat']['name'])) {
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
                    '1YzpWe7s6TFVT8o9F_idLj0VaEiCZpXZ3'
                );

                $data['drive_file_id'] = $upload['file_id'];
                $data['drive_file_url'] = $upload['file_url'];
                $data['drive_mime_type'] = $upload['mime_type'] ?? mime_content_type($_FILES['file_surat']['tmp_name']) ?? 'application/octet-stream';
            }

            $this->surat->update($id, $data);
            $this->session->set_flashdata('success','Surat masuk berhasil diperbarui');
            redirect('suratmasuk');
        }

        $data = [
            'title' => 'Arsip PDG - Ubah Surat Masuk',
            'subtitle' => 'Ubah Surat Masuk',
            'content' => 'surat_masuk/form',
            'surat' => $surat
        ];

        $this->load->view('surat_masuk/mod_surat_masuk', $data);
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
        $this->session->set_flashdata('success','Surat masuk dan file berhasil dihapus');
        redirect('suratmasuk');
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
                $existing_arsip = $this->arsip->get_by_sumber_id($surat->id, 'masuk');
                
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
                            'jenis_surat'       => 'masuk',
                            'sumber_id'         => $surat->id,
                            'nomor_surat'       => $surat->nomor_surat,
                            'pihak'             => $surat->asal_surat,
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
                        redirect('suratmasuk');
                    }
                }
            }

            $this->surat->update_status($id, $status);
            $this->session->set_flashdata('success','Status surat berhasil diubah');
            redirect('suratmasuk');
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
                ->or_like('asal_surat', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') = " . $this->db->escape($bulan));
        }

        $surats = $this->db->order_by('created_at', 'DESC')->get('surat_masuk')->result();

        if ($format === 'excel') {
            $this->export_excel($surats);
        } else {
            $this->export_pdf($surats);
        }
    }

    private function export_pdf($surats)
{
    $this->load->library('pdf_generator');

    $html = $this->load->view(
        'surat_masuk/pdf_laporan',
        ['surats' => $surats],
        true
    );

    // Gunakan landscape
    $filename = 'Laporan_Surat_Masuk_' . date('Y-m-d');
    $this->pdf_generator->generate_landscape($html, $filename, true);
    }

}