<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT user_sub_menu3.*, user_menu3.menu FROM user_sub_menu3 JOIN user_menu3 ON user_sub_menu3.menu_id = user_menu3.id";
        return $this->db->query($query)->result_array();
    }


    public function showMenu($role_id)
    {
        $queryMenu = "SELECT user_menu3.id, menu FROM user_menu3 JOIN user_access_menu3 ON user_menu3.id = user_access_menu3.menu_id WHERE user_access_menu3.role_id =  $role_id ORDER BY user_access_menu3.menu_id ASC";
        return $this->db->query($queryMenu)->result_array();
    }

    public function showSubMenu($menuId)
    {
        $querySubMenu = "SELECT * FROM user_sub_menu3  WHERE menu_id = $menuId AND is_active = 1";
        return $this->db->query($querySubMenu)->result_array();
    }
    // User Menu
    public function getUserMenuAll()
    {
        return $this->db->get_where('user_menu3', ['id !=' => 1])->result_array();
    }
}
