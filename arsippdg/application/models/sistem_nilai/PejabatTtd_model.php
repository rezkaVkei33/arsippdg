<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PejabatTtd_model extends CI_Model
{
    private $table = 'ak_pejabat_ttd';

    public function get_all($keyword = NULL, $limit = NULL, $offset = 0)
    {
        $this->db->from($this->table);

        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('nama_pejabat', $keyword)
                ->or_like('nomor_induk', $keyword)
                ->or_like('jabatan', $keyword)
            ->group_end();
        }

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->order_by('jabatan', 'ASC')->get()->result();
    }

    public function count_all($keyword = NULL)
    {
        $this->db->from($this->table);

        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('nama_pejabat', $keyword)
                ->or_like('nomor_induk', $keyword)
                ->or_like('jabatan', $keyword)
            ->group_end();
        }

        return (int) $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function get_active()
    {
        return $this->db
            ->where('status', 1)
            ->order_by('jabatan', 'ASC')
            ->get($this->table)
            ->result();
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

    public function toggle_status($id)
    {
        $current = $this->db->select('status')->where('id', (int) $id)->get($this->table)->row();
        if (!$current) {
            return FALSE;
        }

        $new_status = $current->status === 1 ? 0 : 1;
        return $this->db->where('id', (int) $id)->update($this->table, ['status' => $new_status]);
    }
}
