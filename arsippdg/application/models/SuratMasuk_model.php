<?php 
class SuratMasuk_model extends CI_Model {

    protected $table = 'surat_masuk';

    public function get_aktif($limit, $offset, $keyword=null, $bulan=null)
    {
        $this->db->where('status','aktif');

        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('asal_surat', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') = " . $this->db->escape($bulan));
        }

        return $this->db
            ->order_by('created_at','DESC')
            ->get($this->table, $limit, $offset)
            ->result();
    }

    public function count_aktif($keyword=null, $bulan=null)
    {
        $this->db->where('status','aktif');

        if ($keyword) {
            $this->db->group_start()
                ->like('nomor_surat', $keyword)
                ->or_like('asal_surat', $keyword)
                ->or_like('perihal', $keyword)
            ->group_end();
        }

        if ($bulan) {
            $this->db->where("DATE_FORMAT(created_at, '%Y-%m') = " . $this->db->escape($bulan));
        }

        return $this->db->count_all_results($this->table);
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function update_status($id, $status)
    {
        return $this->db->where('id', $id)->update($this->table, ['status' => $status]);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}