<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jadwal extends CI_Model
{
    public function jadwal_list()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('tb_jadwal')->result();
    }


    public function simpan_jadwal($tanggal, $kegiatan, $jam, $lokasi, $keterangan)
    {
        $data = [
            'tanggal' => $tanggal,
            'kegiatan' => $kegiatan,
            'jam' => $jam,
            'lokasi' => $lokasi,
            'keterangan' => $keterangan
        ];
        return $this->db->insert('tb_jadwal', $data);
    }


    public function get_jadwal_by_kode($id_jadwal)
    {
        return $this->db->get_where('tb_jadwal', ['id' => $id_jadwal])->row();
    }

    public function update_jadwal($id_jadwal, $tanggal, $kegiatan, $jam, $lokasi, $keterangan)
    {
        $data = [
            'tanggal' => $tanggal,
            'kegiatan' => $kegiatan,
            'jam' => $jam,
            'lokasi' => $lokasi,
            'keterangan' => $keterangan
        ];
        return $this->db->update('tb_jadwal', $data, ['id' => $id_jadwal]);
    }


    public function hapus_jadwal($id_jadwal)
    {
        return $this->db->delete('tb_jadwal', ['id' => $id_jadwal]);
    }
    public function search($query)
    {
        // Search for records based on the name or other fields
        $this->db->like('kegiatan', $query);
        $this->db->or_like('keterangan', $query);
        $this->db->or_like('lokasi', $query);
        $this->db->or_like('tanggal', $query);
        $this->db->or_like('jam', $query);
        $query = $this->db->get('tb_jadwal'); // Replace 'your_table_name' with the actual table name
        return $query->result();
    }




    public function artikel_list()
    {
        return $this->db->get('tb_artikel')->result();
    }

    public function simpan_artikel($data)
    {
        return $this->db->insert('tb_artikel', $data);
    }

    public function get_artikel_by_kode($id_artikel)
    {
        return $this->db->get_where('tb_artikel', ['id' => $id_artikel])->row();
    }

    public function update_artikel($id_artikel, $data)
    {
        return $this->db->update('tb_artikel', $data, ['id' => $id_artikel]);
    }

    public function hapus_artikel($id_artikel)
    {
        return $this->db->delete('tb_artikel', ['id' => $id_artikel]);
    }

    public function search2($query)
    {
        $this->db->like('judul', $query);
        $this->db->or_like('isi', $query);
        return $this->db->get('tb_artikel')->result();
    }
}
