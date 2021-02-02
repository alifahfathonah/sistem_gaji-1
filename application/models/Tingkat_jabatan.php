<?php

/** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Tingkat_jabatan extends CI_Model
{
    public function getData()
    {
        $this->db->select('*');
        $this->db->from('tingkat_jabatan');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function getAllData()
    {
        $this->datatables->select('id, nama, create_date');
        $this->datatables->from('tingkat_jabatan');
        return $this->datatables->generate();
    }

    public function addData($data)
    {
        $this->db->insert('tingkat_jabatan', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('tingkat_jabatan ap', array('ap.id' => $id))->result();
    }
    public function getIdtingkatJabByGolongan($id_jab)
    {
        $this->db->select('*');
        $this->db->from('golongan');
        $this->db->where('id', $id_jab);
        return $this->db->get()->result();
    }
    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('tingkat_jabatan');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }


    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tingkat_jabatan', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tingkat_jabatan');
    }
}

/* End of file Tingkat_jabatan.php */
