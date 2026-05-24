<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        // Ambil data user dari session berdasarkan email
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Validasi form untuk update profil (nama)
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        // Validasi form untuk perubahan password
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'trim|min_length[6]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            // Load view jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('akun/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi berhasil, update data
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // Proses upload gambar profil
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
                    echo $this->upload->display_errors();
                }
            }

            // Update nama pengguna
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            // Proses perubahan password
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if ($current_password) {
                // Cek apakah password saat ini benar
                if (!password_verify($current_password, $data['user']['password'])) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password saat ini salah!</div>');
                    redirect('akun');
                } else {
                    // Cek apakah password baru sama dengan password lama
                    if (password_verify($new_password, $data['user']['password'])) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama!</div>');
                        redirect('akun');
                    } else {
                        // Hash password baru dan update di database
                        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                        $this->db->set('password', $password_hash);
                        $this->db->where('email', $email);
                        $this->db->update('user');

                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password berhasil diubah!</div>');
                        redirect('akun');
                    }
                }
            }

            // Pesan sukses jika profil berhasil diperbarui
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profil Anda berhasil diperbarui!</div>');
            redirect('akun');
        }
    }
}
