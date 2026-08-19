<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akademik_model extends CI_Model
{
    public function get_riwayat_akademik($tahun_id = NULL, $semester = NULL)
    {
        $this->db
            ->select('ta.id, ta.tahun, ta.semester, COALESCE(SUM(mk.sks), 0) AS total_sks')
            ->from('ak_tahun_akademik ta')
            ->join('ak_penawaran_mk pm', 'pm.tahun_akademik_id = ta.id', 'left')
            ->join('ak_mata_kuliah mk', 'mk.id = pm.mata_kuliah_id', 'left')
            ->where('ta.status', 'Aktif')
            ->group_by('ta.id, ta.tahun, ta.semester')
            ->order_by('ta.tahun', 'DESC')
            ->order_by('ta.semester', 'ASC');

        if ($tahun_id !== NULL && $tahun_id !== '') {
            $this->db->where('ta.id', (int) $tahun_id);
        }

        if ($semester !== NULL && $semester !== '') {
            $this->db->where('ta.semester', (int) $semester);
        }

        return $this->db->get()->result();
    }

    public function get_tahun_akademik_by_id($id)
    {
        return $this->db->where('id', (int) $id)->where('status', 'Aktif')->get('ak_tahun_akademik')->row();
    }

    public function get_mahasiswa_by_tahun_semester($tahun_akademik_id, $semester = NULL, $program_studi_id = NULL, $limit = NULL, $offset = 0)
    {
        $this->db
            ->distinct()
            ->select('m.id, m.nim, m.nama, p.nama_prodi')
            ->from('ak_nilai n')
            ->join('ak_mahasiswa m', 'm.id = n.mahasiswa_id', 'left')
            ->join('ak_program_studi p', 'p.id = m.program_studi_id', 'left')
            ->join('ak_penawaran_mk pm', 'pm.id = n.penawaran_mk_id', 'left')
            ->join('ak_tahun_akademik ta', 'ta.id = pm.tahun_akademik_id', 'left')
            ->where('pm.tahun_akademik_id', (int) $tahun_akademik_id)
            ->where('ta.status', 'Aktif')
            ->order_by('m.nama', 'ASC');

        if ($semester !== NULL && $semester !== '' && $semester !== '0') {
            $this->db->where('ta.semester', $semester);
        }

        if ($program_studi_id !== NULL && $program_studi_id !== '' && $program_studi_id !== '0') {
            $this->db->where('m.program_studi_id', (int) $program_studi_id);
        }

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->get()->result();
    }

    public function count_mahasiswa_by_tahun_semester($tahun_akademik_id, $semester = NULL, $program_studi_id = NULL)
    {
        $this->db
            ->select('COUNT(DISTINCT m.id) AS total')
            ->from('ak_nilai n')
            ->join('ak_mahasiswa m', 'm.id = n.mahasiswa_id', 'left')
            ->join('ak_program_studi p', 'p.id = m.program_studi_id', 'left')
            ->join('ak_penawaran_mk pm', 'pm.id = n.penawaran_mk_id', 'left')
            ->join('ak_tahun_akademik ta', 'ta.id = pm.tahun_akademik_id', 'left')
            ->where('pm.tahun_akademik_id', (int) $tahun_akademik_id)
            ->where('ta.status', 'Aktif');

        if ($semester !== NULL && $semester !== '' && $semester !== '0') {
            $this->db->where('ta.semester', $semester);
        }

        if ($program_studi_id !== NULL && $program_studi_id !== '' && $program_studi_id !== '0') {
            $this->db->where('m.program_studi_id', (int) $program_studi_id);
        }

        $row = $this->db->get()->row();
        return (int) ($row->total ?? 0);
    }

    public function get_mahasiswa_detail($id)
    {
        return $this->db
            ->select('m.*, p.nama_prodi')
            ->from('ak_mahasiswa m')
            ->join('ak_program_studi p', 'p.id = m.program_studi_id', 'left')
            ->where('m.id', (int) $id)
            ->get()->row();
    }

    public function get_khs_by_mahasiswa($mahasiswa_id, $tahun_akademik_id, $semester = NULL)
    {
        $this->db
            ->select('mk.kode_mk, mk.nama_mk, mk.sks, n.nilai_huruf, n.bobot AS nilai_angka, (mk.sks * n.bobot) AS nilai_mutu, n.updated_at')
            ->from('ak_nilai n')
            ->join('ak_penawaran_mk pm', 'pm.id = n.penawaran_mk_id', 'left')
            ->join('ak_mata_kuliah mk', 'mk.id = pm.mata_kuliah_id', 'left')
            ->join('ak_tahun_akademik ta', 'ta.id = pm.tahun_akademik_id', 'left')
            ->where('n.mahasiswa_id', (int) $mahasiswa_id)
            ->where('pm.tahun_akademik_id', (int) $tahun_akademik_id)
            ->where('ta.status', 'Aktif')
            ->order_by('mk.kode_mk', 'ASC');

        if ($semester !== NULL && $semester !== '' && $semester !== '0') {
            $this->db->where('ta.semester', $semester);
        }

        return $this->db->get()->result();
    }

    public function get_khs_by_mahasiswa_all($mahasiswa_id)
    {
        $this->db
            ->select('mk.kode_mk, mk.nama_mk, mk.sks, n.nilai_huruf, n.bobot AS nilai_angka, (mk.sks * n.bobot) AS nilai_mutu, ta.tahun, ta.semester, pm.tahun_akademik_id')
            ->from('ak_nilai n')
            ->join('ak_penawaran_mk pm', 'pm.id = n.penawaran_mk_id', 'left')
            ->join('ak_mata_kuliah mk', 'mk.id = pm.mata_kuliah_id', 'left')
            ->join('ak_tahun_akademik ta', 'ta.id = pm.tahun_akademik_id', 'left')
            ->where('n.mahasiswa_id', (int) $mahasiswa_id)
            ->where('ta.status', 'Aktif')
            ->order_by('ta.tahun', 'ASC')
            ->order_by('ta.semester', 'ASC')
            ->order_by('mk.kode_mk', 'ASC');

        return $this->db->get()->result();
    }

    public function get_latest_khs_update($mahasiswa_id, $tahun_akademik_id)
    {
        return $this->db
            ->select('MAX(n.updated_at) AS updated_at')
            ->from('ak_nilai n')
            ->join('ak_penawaran_mk pm', 'pm.id = n.penawaran_mk_id', 'left')
            ->join('ak_tahun_akademik ta', 'ta.id = pm.tahun_akademik_id', 'inner')
            ->where('n.mahasiswa_id', (int) $mahasiswa_id)
            ->where('pm.tahun_akademik_id', (int) $tahun_akademik_id)
            ->where('ta.status', 'Aktif')
            ->get()->row();
    }
}
