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

    public function get_all($type, $keyword = '', $filter_value = NULL, $limit = NULL, $offset = 0)
    {
        $this->build_query($type, $keyword, $filter_value);

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        if ($type === 'penawaran-mata-kuliah') {
            return $this->db->order_by('ak_tahun_akademik.tahun', 'DESC')->order_by('ak_mata_kuliah.nama_mk', 'ASC')->get()->result();
        }

        return $this->db->order_by('id', 'DESC')->get()->result();
    }

    public function count_all($type, $keyword = '', $filter_value = NULL)
    {
        $this->build_query($type, $keyword, $filter_value);
        return (int) $this->db->count_all_results();
    }

    private function build_query($type, $keyword = '', $filter_value = NULL)
    {
        if ($type === 'penawaran-mata-kuliah') {
            $this->db->select('ak_penawaran_mk.*, ak_mata_kuliah.kode_mk, ak_mata_kuliah.nama_mk, ak_tahun_akademik.tahun, ak_tahun_akademik.semester')
                ->from('ak_penawaran_mk')
                ->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id', 'left')
                ->join('ak_tahun_akademik', 'ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id', 'left');

            if ($keyword !== '') {
                $this->db->group_start()->like('ak_mata_kuliah.kode_mk', $keyword)->or_like('ak_mata_kuliah.nama_mk', $keyword)->or_like('ak_tahun_akademik.tahun', $keyword)->group_end();
            }

            $this->db->where('ak_tahun_akademik.status', 'Aktif');

            if ($filter_value !== NULL && $filter_value !== '' && $filter_value !== 'all' && $this->db->field_exists('program_studi_id', 'ak_mata_kuliah')) {
                $this->db->where('ak_mata_kuliah.program_studi_id', (int) $filter_value);
            }
            return;
        }

        $this->db->from($this->table($type));

        if ($type === 'mata-kuliah') {
            if ($keyword !== '') {
                $this->db->group_start()->like('kode_mk', $keyword)->or_like('nama_mk', $keyword)->group_end();
            }

            if ($filter_value !== NULL && $filter_value !== '' && $filter_value !== 'all') {
                $this->db->where('semester', (int) $filter_value);
            }
            return;
        }

        if ($keyword !== '') {
            $this->db->group_start()->like('tahun', $keyword)->or_like('semester', $keyword)->group_end();
        }
    }

    public function get($type, $id) { if ($type === 'penawaran-mata-kuliah') { return $this->db->select('ak_penawaran_mk.*')->from('ak_penawaran_mk')->join('ak_tahun_akademik', 'ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id', 'inner')->where('ak_penawaran_mk.id', (int) $id)->where('ak_tahun_akademik.status', 'Aktif')->get()->row(); } return $this->db->where('id', (int) $id)->get($this->table($type))->row(); }
    public function save($type, array $data, $id = NULL) { return $id === NULL ? $this->db->insert($this->table($type), $data) : $this->db->where('id', (int) $id)->update($this->table($type), $data); }
    public function delete($type, $id) { return $this->db->where('id', (int) $id)->delete($this->table($type)); }
    public function exists($type, array $where, $except = NULL) { $this->db->where($where); if ($except) $this->db->where('id !=', (int) $except); return $this->db->count_all_results($this->table($type)) > 0; }
    public function mata_kuliah() { return $this->db->where('status', 'Aktif')->order_by('semester', 'ASC')->order_by('kode_mk', 'ASC')->get('ak_mata_kuliah')->result(); }
    public function mata_kuliah_semester_options() { return $this->db->select('semester')->from('ak_mata_kuliah')->where('semester IS NOT NULL')->group_by('semester')->order_by('semester', 'ASC')->get()->result(); }
    public function tahun_akademik() { return $this->db->where('status', 'Aktif')->order_by('tahun', 'DESC')->get('ak_tahun_akademik')->result(); }
}
