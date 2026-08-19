<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NilaiDashboard_model extends CI_Model
{
    /** Return counts for the main dashboard cards. */
    public function get_summary()
    {
        return (object) [
            'total_mahasiswa' => (int) $this->db->count_all('ak_mahasiswa'),
            'total_program_studi' => (int) $this->db->count_all('ak_program_studi'),
            'total_mata_kuliah' => (int) $this->db->count_all('ak_mata_kuliah')
        ];
    }

    /** Include programs with no students so the distribution is complete. */
    public function get_mahasiswa_per_prodi()
    {
        return $this->db
            ->select('ak_program_studi.kode_prodi, ak_program_studi.nama_prodi, COUNT(ak_mahasiswa.id) AS total_mahasiswa')
            ->from('ak_program_studi')
            ->join('ak_mahasiswa', 'ak_mahasiswa.program_studi_id = ak_program_studi.id', 'left')
            ->group_by('ak_program_studi.id, ak_program_studi.kode_prodi, ak_program_studi.nama_prodi')
            ->order_by('ak_program_studi.nama_prodi', 'ASC')
            ->get()
            ->result();
    }

    public function get_tahun_akademik_aktif()
    {
        return $this->db
            ->where('status', 'Aktif')
            ->order_by('tahun', 'DESC')
            ->order_by('semester', 'ASC')
            ->get('ak_tahun_akademik')
            ->result();
    }
}
