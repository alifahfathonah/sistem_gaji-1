<?php

/** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Bonus_lebaran extends CI_Model
{
    public function getAllData()
    {
        $this->datatables->select('b.id,b.tanggal, k.nama_karyawan, j.nama_jabatan, b.total_gaji_bonus');
        $this->datatables->from('bonus_lebaran b');
        $this->datatables->join('karyawan k', 'k.id_karyawan = b.id_karyawan', 'left');
        $this->datatables->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->datatables->join('jabatan j', 'j.id = k.id_jabatan', 'left');
        return $this->datatables->generate();
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('bonus_lebaran');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function getSlipGaji()
    {
        $this->db->select('b.id, b.tanggal, k.nama_karyawan, j.nama_jabatan, b.total_gaji_bonus');
        $this->db->from('bonus_lebaran b');
        $this->db->join('karyawan k', 'k.id_karyawan = b.id_karyawan', 'left');
        $this->db->join('golongan g', 'g.id = k.id_golongan', 'left');
        $this->db->join('jabatan j', 'j.id = k.id_jabatan', 'left');
        return $this->db->get()->result();
    }

    public function addData($data)
    {
        $this->db->insert('bonus_lebaran', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('bonus_lebaran ap', array('ap.id' => $id))->result();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('bonus_lebaran');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('bonus_lebaran', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('bonus_lebaran');
    }
}

/* End of file Bonus_kinerja.php */
