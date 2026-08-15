<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramStudi_model extends CI_Model
{
    private $table = 'ak_program_studi';

    public function get_all($keyword = NULL)
    {
        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('kode_prodi', $keyword)
                ->or_like('nama_prodi', $keyword)
            ->group_end();
        }

        return $this->db
            ->order_by('nama_prodi', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function kode_exists($kode_prodi, $except_id = NULL)
    {
        $this->db->where('kode_prodi', $kode_prodi);

        if ($except_id !== NULL) {
            $this->db->where('id !=', (int) $except_id);
        }

        return $this->db->count_all_results($this->table) > 0;
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
