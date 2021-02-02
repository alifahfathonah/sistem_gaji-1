<?php

/** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Golongan extends CI_Model
{
    public function getAllData()
    {
        $this->datatables->select('g.id, g.level, tj.nama as nama_golongan, j.nama_jabatan, g.jumlah_gaji_pokok, g.t_jalan_jalan, g.t_kesehatan, g.t_pelatihan, g.t_cuti_tahunan, g.t_study_banding, g.t_umroh, g.kenaikan_gaji_20_persen, g.total_gaji, g.create_date');
        $this->datatables->from('golongan g');
        $this->datatables->join('jabatan j', 'j.id = g.id_jabatan', 'left');
        $this->datatables->join('tingkat_jabatan tj', 'tj.id = g.id_tingkat_jabatan', 'left');
        return $this->datatables->generate();
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('golongan');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function getDataGolongan()
    {
        $this->db->select('g.id, tj.nama as nama_golongan, g.level');
        $this->db->from('golongan g');
        $this->db->join('tingkat_jabatan tj', 'tj.id = g.id_tingkat_jabatan', 'left');
        $this->db->order_by('g.id', 'desc');
        return $this->db->get()->result();
    }

    public function addData($data)
    {
        $this->db->insert('golongan', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('golongan ap', array('ap.id' => $id))->result();
    }

    public function getGajiByGolongan($id)
    {
        $this->db->select('jumlah_gaji_pokok, total_gaji');
        $this->db->from('golongan');
        $this->db->where('id', $id);
        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('*');
        $this->db->from('golongan');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('golongan', $data);
        return $this->db->affected_rows();
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('golongan');
    }
}

/* End of file ModelName.php */
