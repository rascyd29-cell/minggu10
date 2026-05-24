<?php
class Sub_menu_model extends CI_Model
{

    protected $table = 'sub_menu';
    protected $primary_key = 'id';
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

    // Method to insert a new record
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }



    // Method to delete a record
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
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

    public function delete_by_data_makanan_id($id)
    {
        $this->db->where('Data_makanan_idData_makanan', $id);
        $this->db->delete('sub_menu');
    }

    public function get_by_data_makanan_id($id)
    {
        $this->db->where('Data_makanan_idData_makanan', $id);
        return $this->db->get('sub_menu')->result();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('sub_menu', $data);
    }
}
