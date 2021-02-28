<?php

/** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_bulanan extends CI_Model
{
    public function getAllData()
    {
        $this->datatables->select('b.id, k.nama_karyawan, b.tanggal, tj.nama as nama_golongan, k.gaji_pokok, j.nama_jabatan, b.uang_transport,b.tunjangan_kinerja,b.tunjangan_jabatan,b.uang_extra_kurikuler,b.uang_lembur,b.bonus_lain, b.total_gaji,b.total_potongan,b.total_potongan, b.approve_yayasan');
        $this->datatables->from('gaji_bulanan b');
        $this->datatables->join('karyawan k', 'k.id_karyawan = b.id_karyawan', 'left');
        $this->datatables->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->datatables->join('jabatan j', 'j.id = k.id_jabatan', 'left');
        $this->datatables->join('tingkat_jabatan tj', 'tj.id = j.id_tingkat_jabatan', 'left');
        return $this->datatables->generate();
    }

    public function visualizeGajiBulananPerbulan()
    {
        $this->db->select('MONTH(tanggal) as bulan, sum(total_gaji) as tot_gaji');
        $this->db->from('gaji_bulanan');
        $this->db->group_by('MONTH(tanggal)');
        $this->db->where('YEAR(tanggal)', date('Y'));
        return $this->db->get()->result();
    }

    public function getDataGajiBulananByIdTingkatJabatan($tingkat_jabatan, $bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('tj.id as id_tj, sum(gb.total_gaji) as totalGaji, tj.nama,  MONTH(gb.tanggal) as bulan');
        $this->db->from('gaji_bulanan gb');
        $this->db->join('karyawan k', 'k.id_karyawan = gb.id_karyawan', 'left');
        $this->db->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->db->join('tingkat_jabatan tj', 'tj.id = g.id_tingkat_jabatan', 'left');
        $this->db->where('tj.nama', $tingkat_jabatan);
        $this->db->where('MONTH(gb.tanggal)', $bulan);
        $this->db->group_by('MONTH(gb.tanggal)');
        return $this->db->get()->result();
    }

    public function getDataGajiBulanan($tingkat_jabatan, $bulan)
    {
        $this->db->select('gb.id, k.id_tingkat_jabatan, MONTH(gb.tanggal) as bulan, tj.nama, sum(gb.total_gaji) as totalGaji');
        $this->db->from('gaji_bulanan gb');
        $this->db->join('karyawan k', 'k.id_karyawan = gb.id_karyawan', 'left');
        $this->db->join('tingkat_jabatan tj', 'tj.id = k.id_tingkat_jabatan', 'left');
        $this->db->where('MONTH(gb.tanggal)', $bulan);
        $this->db->where('tj.nama', $tingkat_jabatan);
        $this->db->group_by('MONTH(gb.tanggal)');

        return $this->db->get()->result();
    }


    public function getTotalGajiBulanan($total, $bulan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->select('sum(gb.total_gaji) as totalGaji, MONTH(gb.tanggal) as bulan');
        $this->db->from('gaji_bulanan gb');
        $this->db->join('karyawan k', 'k.id_karyawan = gb.id_karyawan', 'left');
        $this->db->where('tj.nama', $tingkat_jabatan);
        $this->db->where('MONTH(gb.tanggal)', $bulan);
        $this->db->group_by('MONTH(gb.tanggal)');
        return $this->db->get()->result();
    }

    public function getGajiBulanan()
    {
        $this->db->select('tj.id as id_tj, sum(gb.total_gaji) as totalGaji, tj.nama, MONTH(gb.tanggal) as bulan ');
        $this->db->from('gaji_bulanan gb');
        $this->db->join('karyawan k', 'k.id_karyawan = gb.id_karyawan', 'left');
        $this->db->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->db->join('tingkat_jabatan tj', 'tj.id = g.id_tingkat_jabatan', 'left');
        $this->db->group_by('MONTH(gb.tanggal)');
        return $this->db->get()->result();
    }

    public function addData($data)
    {
        $this->db->insert('gaji_bulanan', $data);
    }

    public function getGaji($id_golongan)
    {
        $this->db->select('g.jumlah_gaji_pokok, g.total_gaji');
        $this->db->from('karyawan k');
        $this->db->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->db->where('k.id_karyawan', $id_golongan);
        return $this->db->get()->result();
    }

    public function getGajiKar($id_kar)
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('id_karyawan', $id_kar);
        return $this->db->get()->result();
    }

    public function getGajiTambahan()
    {
        $this->db->select('*');
        $this->db->from('gaji_tambahan');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('gaji_bulanan ap', array('ap.id' => $id))->result();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('gaji_bulanan');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function getSlipGaji($id)
    {
        $this->db->select('b.id,b.tanggal, k.nama_karyawan, tj.nama as nama_golongan, g.jumlah_gaji_pokok, j.nama_jabatan, b.uang_transport, b.total_gaji,b.total_potongan');
        $this->db->from('gaji_bulanan b');
        $this->db->join('karyawan k', 'k.id_karyawan = b.id_karyawan', 'left');
        $this->db->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->db->join('jabatan j', 'j.id = g.id_jabatan', 'left');
        $this->db->join('tingkat_jabatan tj', 'tj.id = g.id_tingkat_jabatan', 'left');
        $this->db->where('b.id', $id);
        return $this->db->get()->result();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('gaji_bulanan', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('gaji_bulanan');
    }

    public function approve($id)
    {
        return $this->db->query('update gaji_bulanan set approve_yayasan = 1 where id ="' . $id . '"');
    }
}

/* End of file Gaji_bulanan.php */
