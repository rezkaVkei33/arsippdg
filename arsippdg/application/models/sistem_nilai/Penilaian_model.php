<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian_model extends CI_Model
{
    private $table = 'ak_nilai';

    public function get_all($keyword = '', $mata_kuliah_id = NULL, $limit = NULL, $offset = 0)
    {
        $this->db
            ->select('ak_nilai.*, ak_mahasiswa.nim, ak_mahasiswa.nama, ak_program_studi.nama_prodi, ak_mata_kuliah.kode_mk, ak_mata_kuliah.nama_mk, ak_tahun_akademik.tahun, ak_tahun_akademik.semester')
            ->from($this->table)
            ->join('ak_mahasiswa', 'ak_mahasiswa.id = ak_nilai.mahasiswa_id', 'left')
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left')
            ->join('ak_penawaran_mk', 'ak_penawaran_mk.id = ak_nilai.penawaran_mk_id', 'left')
            ->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id', 'left')
            ->join('ak_tahun_akademik', 'ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id', 'left');

        if ($keyword !== '') {
            $this->db->group_start()
                ->like('ak_mahasiswa.nim', $keyword)
                ->or_like('ak_mahasiswa.nama', $keyword)
                ->or_like('ak_mata_kuliah.nama_mk', $keyword)
                ->or_like('ak_program_studi.nama_prodi', $keyword)
            ->group_end();
        }

        if ($mata_kuliah_id !== NULL && $mata_kuliah_id !== '' && $mata_kuliah_id !== 'all') {
            $this->db->where('ak_penawaran_mk.mata_kuliah_id', (int) $mata_kuliah_id);
        }

        if ($limit !== NULL) {
            $this->db->limit((int) $limit, (int) $offset);
        }

        return $this->db->order_by('ak_nilai.id', 'DESC')->get()->result();
    }

    public function count_all($keyword = '', $mata_kuliah_id = NULL)
    {
        $this->db
            ->from($this->table)
            ->join('ak_mahasiswa', 'ak_mahasiswa.id = ak_nilai.mahasiswa_id', 'left')
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left')
            ->join('ak_penawaran_mk', 'ak_penawaran_mk.id = ak_nilai.penawaran_mk_id', 'left')
            ->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id', 'left');

        if ($keyword !== '') {
            $this->db->group_start()
                ->like('ak_mahasiswa.nim', $keyword)
                ->or_like('ak_mahasiswa.nama', $keyword)
                ->or_like('ak_mata_kuliah.nama_mk', $keyword)
                ->or_like('ak_program_studi.nama_prodi', $keyword)
            ->group_end();
        }

        if ($mata_kuliah_id !== NULL && $mata_kuliah_id !== '' && $mata_kuliah_id !== 'all') {
            $this->db->where('ak_penawaran_mk.mata_kuliah_id', (int) $mata_kuliah_id);
        }

        return (int) $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', (int) $id)->get($this->table)->row();
    }

    public function insert(array $data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function save(array $data, $id = NULL)
    {
        if ($id === NULL) {
            return $this->db->insert($this->table, $data);
        }

        return $this->db->where('id', (int) $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', (int) $id)->delete($this->table);
    }

    public function get_students_for_upload($program_studi_id, $tahun_akademik_id, $semester, $angkatan)
    {
        return $this->db
            ->select('ak_mahasiswa.id, ak_mahasiswa.nim, ak_mahasiswa.nama, ak_mahasiswa.angkatan, ak_program_studi.nama_prodi')
            ->from('ak_mahasiswa')
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left')
            ->where('ak_mahasiswa.program_studi_id', (int) $program_studi_id)
            ->where('ak_mahasiswa.angkatan', (string) $angkatan)
            ->order_by('ak_mahasiswa.nama', 'ASC')
            ->get()
            ->result();
    }

    public function get_penawaran_by_filter($program_studi_id, $tahun_akademik_id, $semester, $mata_kuliah_id = NULL)
    {
        $this->db
            ->select('ak_penawaran_mk.*')
            ->from('ak_penawaran_mk')
            ->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id', 'left')
            ->where('ak_penawaran_mk.tahun_akademik_id', (int) $tahun_akademik_id)
            ->where('ak_mata_kuliah.program_studi_id', (int) $program_studi_id)
            ->where('ak_mata_kuliah.semester', (int) $semester === 1 ? 1 : 2);

        if ($mata_kuliah_id !== NULL && $mata_kuliah_id !== '') {
            $this->db->where('ak_penawaran_mk.mata_kuliah_id', (int) $mata_kuliah_id);
        }

        return $this->db->order_by('ak_penawaran_mk.id', 'DESC')->get()->row();
    }

    public function get_by_student_and_penawaran($mahasiswa_id, $penawaran_mk_id)
    {
        return $this->db
            ->where('mahasiswa_id', (int) $mahasiswa_id)
            ->where('penawaran_mk_id', (int) $penawaran_mk_id)
            ->get($this->table)
            ->row();
    }

    public function angkatan_options()
    {
        return $this->db->select('angkatan')->from('ak_mahasiswa')->where('angkatan IS NOT NULL')->group_by('angkatan')->order_by('angkatan', 'DESC')->get()->result();
    }

    public function get_mahasiswa_detail($id)
    {
        return $this->db
            ->select('ak_mahasiswa.*, ak_program_studi.nama_prodi')
            ->from('ak_mahasiswa')
            ->join('ak_program_studi', 'ak_program_studi.id = ak_mahasiswa.program_studi_id', 'left')
            ->where('ak_mahasiswa.id', (int) $id)
            ->get()->row();
    }

    public function get_penawaran_detail($id)
    {
        return $this->db
            ->select('ak_penawaran_mk.*, ak_mata_kuliah.kode_mk, ak_mata_kuliah.nama_mk, ak_tahun_akademik.tahun, ak_tahun_akademik.semester')
            ->from('ak_penawaran_mk')
            ->join('ak_mata_kuliah', 'ak_mata_kuliah.id = ak_penawaran_mk.mata_kuliah_id', 'left')
            ->join('ak_tahun_akademik', 'ak_tahun_akademik.id = ak_penawaran_mk.tahun_akademik_id', 'left')
            ->where('ak_penawaran_mk.id', (int) $id)
            ->get()->row();
    }
}
