<?php
class DataMakanan_model extends CI_Model
{

    protected $table = 'data_makanan';
    protected $primary_key = 'idData_makanan';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
    }

    // Method to get a record by its primary key
    public function get($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->get($this->table)->row();
    }

    // Method to get all records
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return [
            'idData_makanan' => $this->db->insert_id(), // Kembalikan ID
            'data_inserted' => $data // Tambahkan data yang dimasukkan (opsional)
        ];
    }




    // Method to get records by a specific field
    public function get_by($field, $value)
    {
        $this->db->where($field, $value);
        return $this->db->get($this->table)->result();
    }

    // Method to get records by multiple conditions
    public function get_many_by($conditions = array())
    {
        $this->db->where($conditions);
        return $this->db->get($this->table)->result();
    }

    // Method to count all records
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    // Method to count records by a specific field
    public function count_by($field, $value)
    {
        $this->db->where($field, $value);
        return $this->db->count_all_results($this->table);
    }

    // Method to count records by multiple conditions
    public function count_many_by($conditions = array())
    {
        $this->db->where($conditions);
        return $this->db->count_all_results($this->table);
    }

    public function getDistinctPaket()
    {
        $this->db->distinct();
        $this->db->select('paket');
        $query = $this->db->get('data_makanan');
        return $query->result();
    }
    public function getDistinctPaket2()
    {
        $this->db->distinct();
        $this->db->select('paket');
        $query = $this->db->get('data_makanan');
        return $query->result_array(); // Menggunakan result_array()
    }


    public function get_by_paket($paket)
    {
        $this->db->where('paket', $paket);
        return $this->db->get('data_makanan')->result_array();
    }

    public function delete($id)
    {
        $this->db->where('idData_makanan', $id);
        $this->db->delete('data_makanan');
    }

    public function update($id, $data)
    {
        $this->db->where('idData_makanan', $id);
        $this->db->update('Data_makanan', $data);
    }

    public function get_by_data_makanan_id($id)
    {
        $this->db->where('Data_makanan_idData_makanan', $id);
        return $this->db->get('Data_makanan')->row();
    }
}
