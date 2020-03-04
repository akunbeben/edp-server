<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complaints extends CI_Model {

    public function get($id = null)
    {
        $this->db->select('complaint.id, complaint.id_complaint, complaint.tanggal, toko.nama_toko, toko.kode_toko, complaint.keluhan, complaint.catatan, complaint.status');
        $this->db->from('complaint');
        $this->db->join('toko', 'complaint.toko = toko.id');
        if ($id !== null) {
            $this->db->where('complaint.id', $id);
        }
        $this->db->where('complaint.aktif', 0);
        $this->db->where('status', 0);
        $this->db->order_by('complaint.tanggal ASC');
        return $this->db->get();
    }

    public function getIdComplaint($id = null)
    {
        $this->db->from('complaint');
        if ($id !== null) {
            $this->db->where('complaint.id', $id);
        }
        $this->db->where('complaint.aktif', 0);
        $this->db->where('status', 0);
        return $this->db->get();
    }

    public function save($complaint)
    {
        $this->db->insert('complaint', $complaint);
        return $this->db->affected_rows();
    }
}