<?php
class Arsip_model extends CI_Model {

    protected $table = 'arsip';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_all($limit = null, $offset = 0, $keyword = null, $bulan = null)
    {
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

        $query = $this->db->order_by('tanggal_diarsipkan', 'DESC');

        if ($limit) {
            return $query->get($this->table, $limit, $offset)->result();
        }

        return $query->get($this->table)->result();
    }

    public function count_all($keyword = null, $bulan = null)
    {
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

        return $this->db->count_all_results($this->table);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_by_sumber_id($sumber_id, $jenis_surat)
    {
        return $this->db->where('sumber_id', $sumber_id)
                        ->where('jenis_surat', $jenis_surat)
                        ->get($this->table)
                        ->row();
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
