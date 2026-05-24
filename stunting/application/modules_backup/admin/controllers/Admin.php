<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'user');
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Admin_model');
    }
    function data_data()
    {
        $data = $this->Admin_model->data_list();
        echo json_encode($data);
    }

    function get_data()
    {
        $id = $this->input->get('id');
        $data = $this->Admin_model->get_data_by_kode($id);
        echo json_encode($data);
    }

    public function index()
    {
        $datas['title'] = 'Dashboard';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->template->load('template1', 'admin/index', $datas);
        //$this->load->view('templates/footer'); // gak usah di pakai
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->user->getUserData();

        $data['role'] = $this->admin->getUserRoleAll();

        $this->form_validation->set_rules('role', 'Role Name', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $role_name = $this->input->post('role');
            $data = [
                'role' => $role_name
            ];
            $user_role = $this->db->get_where('user_role', ['role' => $role_name]);

            if ($user_role->num_rows() < 1) {
                $this->db->insert('user_role', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Role Added!</div>');
                redirect('admin/role');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This role is exist!</div>');
                redirect('admin/role');
            }
        }
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->user->getUserData();


        $data['role'] = $this->admin->getUserRoleById($role_id);;

        $data['menu'] = $this->menu->getUserMenuAll();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer', $data);
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu3', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu3', $data);
        } else {
            $this->db->delete('user_access_menu3', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Access Changed! </div>');
    }

    public function editrole($role_id)
    {
        $data['title'] = 'Edit Role';
        $data['user'] = $this->user->getUserData();
        $data['role'] = $this->admin->getUserRoleById($role_id);;

        $this->form_validation->set_rules('role', 'Role Name', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-role', $data);
            $this->load->view('templates/footer');
        } else {
            $role_name = $this->input->post('role');
            $user_role = $this->db->get_where('user_role', ['role' => $role_name]);
            if ($user_role->num_rows() < 1) {
                $this->db->set('role', $role_name);
                $this->db->where('id', $role_id);
                $this->db->update('user_role');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit Role Success!</div>');
                redirect('admin/role/');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This role name is exist or same!</div>');
                redirect('admin/editrole/' . $role_id);
            }
        }
    }

    public function deleterole($role_id)
    {
        $role = $this->admin->getUserRoleById($role_id);

        $this->db->delete('user_role', ['id' => $role_id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $role['role'] . ' role is deleted!</div>');
        redirect('admin/role');
    }



    public function menu()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu3')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/menu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu3', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('admin/menu');
        }
    }


    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu3')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() ==  false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu3', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('admin/submenu');
        }
    }

    public function editmenu($menu_id)
    {
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get_where('user_menu3', ['id' => $menu_id])->row_array();

        $this->form_validation->set_rules('menu', 'Menu Name', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-menu', $data);
            $this->load->view('templates/footer');
        } else {
            $menu_name = $this->input->post('menu');
            $getMenu = $this->db->get_where('user_menu3', ['menu' => $menu_name]);

            if ($getMenu->num_rows() < 1) {
                $this->db->set('menu', $menu_name);
                $this->db->where('id', $menu_id);
                $this->db->update('user_menu3');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit Menu Success!</div>');
                redirect('admin/menu');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This Menu name is exist or same!</div>');
                redirect('admin/editmenu/' . $menu_id);
            }
        }
    }

    public function deletemenu($menu_id)
    {
        $menu = $this->db->get_where('user_menu3', ['id' => $menu_id])->row_array();

        $this->db->delete('user_menu3', ['id' => $menu_id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $menu['menu'] . ' menu is deleted!</div>');
        redirect('admin/menu');
    }

    public function editsub($submenu_id)
    {
        $data['title'] = 'Edit Submenu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu3')->result_array();
        $data['submenu'] = $this->db->get_where('user_sub_menu3', ['id' => $submenu_id])->row_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit-submenu', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $submenu_name = $this->input->post('title');
            $data_sub = [
                'title' => $submenu_name,
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->set($data_sub);
            $this->db->where('id', $submenu_id);
            $this->db->update('user_sub_menu3');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit Submenu Success!</div>');
            redirect('admin/submenu');
        }
    }
    public function deletesub($submenu_id)
    {
        $submenu = $this->db->get_where('user_sub_menu3', ['id' => $submenu_id])->row_array();

        $this->db->delete('user_sub_menu3', ['id' => $submenu_id]);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $submenu['title'] . ' Submenu is deleted!</div>');
        redirect('admin/submenu');
    }


    function buatakun()
    {
        $data['data'] = $this->db->select('*')->from('user')->get()->result();
        $data['title'] = 'Buat Akun';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        //$this->load->view('admin/list', $data);
        $this->template->load('template1', 'admin/list', $data);
        //$this->load->view('templates/footer'); // tidak pakai
    }


    function add()
    {
        $this->load->helper('string');
        $isi = array(

            'name'     => $this->input->post('name'),
            'email'    => $this->input->post('email'),
            'image' => 'default.jpg',
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id'     => $this->input->post('role_id'),
            'is_active'     => $this->input->post('is_active'),
            'date_created'     => time()

        );


        $this->db->insert('user', $isi);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun Berhasil dibuat!</div>');
        redirect('admin/buatakun');
    }


    function edit()
    {
        if (isset($_POST['submit'])) {
            $data = array(

                'name'     => $this->input->post('name'),
                'email'    => $this->input->post('email'),
                'role_id'     => $this->input->post('role_id'),
                'is_active'     => $this->input->post('is_active')

            );

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->dispay_errors();
                }
            }

            $id   = $this->input->post('id');
            $this->db->where('id', $id); //difilter berdasarkan id
            $this->db->update('user', $data); //eksekusi update
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun Berhasil diubah!</div>');
            redirect('admin/buatakun');
        } else {
            $id           = $this->uri->segment(3);
            $datas['data'] = $this->db->get_where('user', array('email' => $id))->row_array();
            $datas['data2'] = $this->db->select('*')->from('user')->where('id', $this->uri->segment(3))->limit(1)->order_by('id', 'DESC')->get()->result(); //Untuk mengambil data dari database webinar


            $datas['title'] = 'Buat Akun';
            $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

            $this->load->view('templates/header', $datas);
            $this->load->view('templates/sidebar', $datas);
            $this->load->view('templates/topbar', $datas);
            $this->template->load('template1', 'admin/edit2', $datas);
        }
    }

    function hapus()
    {
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            // proses delete data
            $this->db->where('id', $id);
            $this->db->delete('user');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun Berhasil Dihapus!</div>');
        redirect('admin/buatakun');
    }
}
