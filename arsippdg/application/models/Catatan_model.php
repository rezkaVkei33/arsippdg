<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan_model extends CI_Model
{
    protected $table = 'catatan';

    public function get_all($jenis = null)
    {
        if ($jenis) {
            $this->db->where('jenis_surat', $jenis);
        }

        return $this->db
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_surat($jenis, $surat_id)
    {
        return $this->db
            ->where('jenis_surat', $jenis)
            ->where('surat_id', $surat_id)
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_surat_masuk_id($id)
    {
        return $this->db
            ->where('jenis_surat', 'masuk')
            ->where('surat_id', $id)
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_surat_keluar_id($id)
    {
        return $this->db
            ->where('jenis_surat', 'keluar')
            ->where('surat_id', $id)
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }
}
