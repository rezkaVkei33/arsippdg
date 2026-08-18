<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_model extends CI_Model
{
    private $table = 'ak_grade';

    public function get_all($keyword = NULL, $limit = NULL, $offset = 0)
    {
        $this->db->from($this->table);

        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('kode', $keyword)
                ->or_like('keterangan', $keyword)
            ->group_end();
        }

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->order_by('nilai_min', 'DESC')->get()->result();
    }

    public function count_all($keyword = NULL)
    {
        $this->db->from($this->table);

        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('kode', $keyword)
                ->or_like('keterangan', $keyword)
            ->group_end();
        }

        return (int) $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function get_by_kode($kode)
    {
        $kode = strtoupper(trim((string) $kode));
        if ($kode === '') {
            return NULL;
        }

        return $this->db
            ->where('kode', $kode)
            ->get($this->table)
            ->row();
    }

    public function get_bobot_by_kode($kode)
    {
        $grade = $this->get_by_kode($kode);
        if (!$grade) {
            return NULL;
        }

        return (float) $grade->bobot;
    }

    public function kode_exists($kode, $except_id = NULL)
    {
        $this->db->where('kode', $kode);
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
