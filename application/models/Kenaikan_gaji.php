<?php

/** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Kenaikan_gaji extends CI_Model
{
    public function getData()
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function getAllData()
    {
        $this->datatables->select('j.id, k.nama_karyawan, j.persentase, j.jumlah_kenaikan, j.total_gaji');
        $this->datatables->from('kenaikan_gaji j');
        $this->datatables->join('karyawan k', 'k.id_karyawan = j.id_karyawan', 'left');
        return $this->datatables->generate();
    }

    public function addData($data)
    {
        $this->db->insert('kenaikan_gaji', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function getSlipGaji()
    {
        $this->db->select('j.id, k.nama_karyawan, j.persentase, j.jumlah_kenaikan, j.total_gaji');
        $this->db->from('kenaikan_gaji j');
        $this->db->join('karyawan k', 'k.id_karyawan = j.id_karyawan', 'left');
        return $this->db->get()->result();
    }

    public function getByIdKaryawan($id_kar)
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->where('id_karyawan', $id_kar);
        return $this->db->get()->result();
    }

    public function getKenaikanGajiByIdKaryawan($id_kar)
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->where('id_karyawan', $id_kar);
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('kenaikan_gaji ap', array('ap.id' => $id))->result();
    }

    public function getIdKenaikanGajiByIdKaryawan($id_kar)
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->where('id_karyawan', $id_kar);
        return $this->db->get()->row();
    }

    public function getIdKaryawanByIdKenaikanGaji($id)
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('kenaikan_gaji');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('kenaikan_gaji', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kenaikan_gaji');
    }
}

/* End of file Kenaikan_gaji.php */
