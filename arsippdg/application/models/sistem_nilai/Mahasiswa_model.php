<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    private $table = 'ak_mahasiswa';

    public function get_all($keyword = NULL, $program_studi_id = NULL, $limit = NULL, $offset = 0)
    {
        $this->db
            ->select('ak_mahasiswa.*, ak_program_studi.kode_prodi, ak_program_studi.nama_prodi')
            ->from($this->table)
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left');

        $this->apply_filters($keyword, $program_studi_id);

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->order_by('ak_mahasiswa.nama', 'ASC')->get()->result();
    }

    public function count_all($keyword = NULL, $program_studi_id = NULL)
    {
        $this->db
            ->from($this->table)
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left');

        $this->apply_filters($keyword, $program_studi_id);

        return (int) $this->db->count_all_results();
    }

    private function apply_filters($keyword = NULL, $program_studi_id = NULL)
    {
        if ($keyword !== NULL && $keyword !== '') {
            $this->db->group_start()
                ->like('ak_mahasiswa.nim', $keyword)
                ->or_like('ak_mahasiswa.nama', $keyword)
                ->or_like('ak_program_studi.nama_prodi', $keyword)
            ->group_end();
        }

        if ($program_studi_id !== NULL && $program_studi_id !== '' && $program_studi_id !== 'all') {
            $this->db->where('ak_mahasiswa.program_studi_id', (int) $program_studi_id);
        }
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function nim_exists($nim, $except_id = NULL)
    {
        $this->db->where('nim', $nim);
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
        $this->db->trans_start();

        $this->db->where('mahasiswa_id', (int) $id)->delete('ak_nilai');
        $this->db->where('id', (int) $id)->delete($this->table);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
