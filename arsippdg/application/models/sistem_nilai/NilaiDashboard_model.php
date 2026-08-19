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
            'total_mata_kuliah' => (int) $this->db->count_all('ak_mata_kuliah'),
            'mahasiswa_belum_dinilai' => $this->count_mahasiswa_belum_dinilai()
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

    /** Count eligible students with no grade in any currently active academic year. */
    private function count_mahasiswa_belum_dinilai()
    {
        $row = $this->db
            ->select('COUNT(ak_mahasiswa.id) AS total')
            ->from('ak_mahasiswa')
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'inner')
            ->where('ak_mahasiswa.status', 'Aktif')
            ->where('ak_program_studi.status', 'Aktif')
            ->where("EXISTS (SELECT 1 FROM ak_tahun_akademik WHERE status = 'Aktif')", NULL, FALSE)
            ->where("NOT EXISTS (SELECT 1 FROM ak_nilai INNER JOIN ak_penawaran_mk ON ak_penawaran_mk.id = ak_nilai.penawaran_mk_id INNER JOIN ak_tahun_akademik ON ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id WHERE ak_nilai.mahasiswa_id = ak_mahasiswa.id AND ak_tahun_akademik.status = 'Aktif')", NULL, FALSE)
            ->get()
            ->row();

        return (int) ($row->total ?? 0);
    }
}
