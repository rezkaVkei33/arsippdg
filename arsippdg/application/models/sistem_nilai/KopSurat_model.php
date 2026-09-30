<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KopSurat_model extends CI_Model
{
    private $table = 'ak_kop_surat';

    /** Return the newest row; the controller enforces that only one row exists. */
    public function get_single()
    {
        return $this->db->order_by('id', 'DESC')->limit(1)->get($this->table)->row();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function get_active()
    {
        return $this->db->where('status', 1)->order_by('id', 'DESC')->limit(1)->get($this->table)->row();
    }

    public function insert(array $data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, array $data)
    {
        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete($this->table);
    }
}
