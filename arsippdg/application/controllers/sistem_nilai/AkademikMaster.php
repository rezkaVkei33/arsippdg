<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/SistemNilai_Controller.php';

class AkademikMaster extends SistemNilai_Controller
{
    private $labels = ['tahun-akademik' => 'Tahun Akademik', 'mata-kuliah' => 'Mata Kuliah', 'penawaran-mata-kuliah' => 'Penawaran Mata Kuliah'];
    public function __construct() { parent::__construct(); $this->load->model('sistem_nilai/AkademikMaster_model', 'master_model'); $this->load->model('sistem_nilai/ProgramStudi_model', 'program_studi_model'); $this->load->library(['form_validation', 'pagination']); }
    public function tahun_akademik() { $this->listing('tahun-akademik'); }
    public function mata_kuliah() { $this->listing('mata-kuliah'); }
    public function penawaran_mata_kuliah() { $this->listing('penawaran-mata-kuliah'); }
    public function create($type) { $this->form_page($type, 'Tambah ' . $this->label($type)); }
    public function edit($type, $id) { $this->form_page($type, 'Ubah ' . $this->label($type), $this->find($type, $id)); }
    public function store($type) { $this->persist($type); }
    public function update($type, $id) { $this->persist($type, $id); }
    public function delete($type, $id) { $this->post_only(); $this->find($type, $id); $this->master_model->delete($type, $id); $this->session->set_flashdata('success', $this->label($type) . ' berhasil dihapus'); redirect($this->base($type)); }
    private function listing($type) {
        $q = trim((string) $this->input->get('q', TRUE));
        $selected_prodi = trim((string) $this->input->get('prodi', TRUE));
        $page = max(1, (int) $this->input->get('page', TRUE));
        $per_page = 10;
        $total_rows = $this->master_model->count_all($type, $q, $selected_prodi);

        $config = [
            'base_url' => site_url('sistem-nilai/master-data/' . $type),
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

        $this->render('master_akademik/index', [
            'title' => $this->label($type) . ' - Sistem Nilai',
            'type' => $type,
            'label' => $this->label($type),
            'items' => $this->master_model->get_all($type, $q, $selected_prodi, $per_page, ($page - 1) * $per_page),
            'keyword' => $q,
            'selected_prodi' => $selected_prodi,
            'program_studi_options' => $this->program_studi_model->get_all(),
            'pagination' => $this->pagination,
            'total_rows' => $total_rows,
            'current_page' => $page,
            'per_page' => $per_page
        ]);
    }
    private function form_page($type, $title, $item = NULL) { $this->render('master_akademik/form', ['title'=>$title.' - Sistem Nilai','type'=>$type,'label'=>$this->label($type),'item'=>$item,'mata_kuliah'=>$this->master_model->mata_kuliah(),'tahun_akademik'=>$this->master_model->tahun_akademik()]); }
    private function persist($type, $id = NULL) { $this->post_only(); $this->rules($type); if (!$this->form_validation->run()) { $this->form_page($type, ($id?'Ubah ':'Tambah ').$this->label($type), $id?$this->find($type,$id):NULL); return; } $data=$this->payload($type); $unique=$type==='tahun-akademik'?['tahun'=>$data['tahun'],'semester'=>$data['semester']]:($type==='mata-kuliah'?['kode_mk'=>$data['kode_mk']]:$data); if ($this->master_model->exists($type,$unique,$id)) { $this->session->set_flashdata('error', 'Data tersebut sudah terdaftar'); redirect($id?$this->base($type).'/ubah/'.$id:$this->base($type).'/tambah'); } $this->master_model->save($type,$data,$id); $this->session->set_flashdata('success',$this->label($type).' berhasil '.($id?'diperbarui':'ditambahkan')); redirect($this->base($type)); }
    private function rules($type) { if ($type==='tahun-akademik') { $this->form_validation->set_rules('tahun','Tahun','required|trim|max_length[9]'); $this->form_validation->set_rules('semester','Semester','required|in_list[Ganjil,Genap]'); $this->form_validation->set_rules('status','Status','required|in_list[Draft,Aktif,Selesai]'); } elseif ($type==='mata-kuliah') { $this->form_validation->set_rules('kode_mk','Kode Mata Kuliah','required|trim|max_length[30]'); $this->form_validation->set_rules('nama_mk','Nama Mata Kuliah','required|trim|max_length[200]'); $this->form_validation->set_rules('sks','SKS','required|integer|greater_than[0]'); $this->form_validation->set_rules('semester','Semester','required|integer|greater_than[0]'); $this->form_validation->set_rules('jenis','Jenis','required|in_list[Wajib,Pilihan]'); $this->form_validation->set_rules('status','Status','required|in_list[Aktif,Nonaktif]'); } else { $this->form_validation->set_rules('mata_kuliah_id','Mata Kuliah','required|integer'); $this->form_validation->set_rules('tahun_akademik_id','Tahun Akademik','required|integer'); } }
    private function payload($type) { if ($type==='tahun-akademik') return ['tahun'=>trim((string)$this->input->post('tahun',TRUE)),'semester'=>$this->input->post('semester',TRUE),'tanggal_mulai'=>$this->null('tanggal_mulai'),'tanggal_selesai'=>$this->null('tanggal_selesai'),'status'=>$this->input->post('status',TRUE)]; if ($type==='mata-kuliah') return ['kode_mk'=>strtoupper(trim((string)$this->input->post('kode_mk',TRUE))),'nama_mk'=>trim((string)$this->input->post('nama_mk',TRUE)),'sks'=>(int)$this->input->post('sks',TRUE),'semester'=>(int)$this->input->post('semester',TRUE),'jenis'=>$this->input->post('jenis',TRUE),'status'=>$this->input->post('status',TRUE)]; return ['mata_kuliah_id'=>(int)$this->input->post('mata_kuliah_id',TRUE),'tahun_akademik_id'=>(int)$this->input->post('tahun_akademik_id',TRUE)]; }
    private function null($key) { $v=trim((string)$this->input->post($key,TRUE)); return $v===''?NULL:$v; }
    private function label($type) { if (!isset($this->labels[$type])) show_404(); return $this->labels[$type]; }
    private function base($type) { return 'sistem-nilai/master-data/'.$type; }
    private function find($type,$id) { $i=$this->master_model->get($type,$id); if(!$i) show_404(); return $i; }
    private function post_only() { if (strtoupper($this->input->method())!=='POST') show_404(); }
}
