<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AkademikMaster_model extends CI_Model
{
    private $tables = [
        'tahun-akademik' => 'ak_tahun_akademik',
        'mata-kuliah' => 'ak_mata_kuliah',
        'penawaran-mata-kuliah' => 'ak_penawaran_mk'
    ];

    private function table($type) { return $this->tables[$type]; }

    public function get_all($type, $keyword = '')
    {
        if ($type === 'penawaran-mata-kuliah') {
            $this->db->select('ak_penawaran_mk.*, ak_mata_kuliah.kode_mk, ak_mata_kuliah.nama_mk, ak_tahun_akademik.tahun, ak_tahun_akademik.semester')
                ->from('ak_penawaran_mk')->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id')
                ->join('ak_tahun_akademik', 'ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id');
            if ($keyword !== '') $this->db->group_start()->like('ak_mata_kuliah.kode_mk', $keyword)->or_like('ak_mata_kuliah.nama_mk', $keyword)->or_like('ak_tahun_akademik.tahun', $keyword)->group_end();
            return $this->db->order_by('ak_tahun_akademik.tahun', 'DESC')->get()->result();
        }
        $this->db->from($this->table($type));
        if ($keyword !== '') $this->db->group_start()->like($type === 'tahun-akademik' ? 'tahun' : 'kode_mk', $keyword)->or_like($type === 'mata-kuliah' ? 'nama_mk' : 'semester', $keyword)->group_end();
        return $this->db->order_by('id', 'DESC')->get()->result();
    }
    public function get($type, $id) { return $this->db->where('id', (int) $id)->get($this->table($type))->row(); }
    public function save($type, array $data, $id = NULL) { return $id === NULL ? $this->db->insert($this->table($type), $data) : $this->db->where('id', (int) $id)->update($this->table($type), $data); }
    public function delete($type, $id) { return $this->db->where('id', (int) $id)->delete($this->table($type)); }
    public function exists($type, array $where, $except = NULL) { $this->db->where($where); if ($except) $this->db->where('id !=', (int) $except); return $this->db->count_all_results($this->table($type)) > 0; }
    public function mata_kuliah() { return $this->db->where('status', 'Aktif')->order_by('nama_mk')->get('ak_mata_kuliah')->result(); }
    public function tahun_akademik() { return $this->db->order_by('tahun', 'DESC')->get('ak_tahun_akademik')->result(); }
}
