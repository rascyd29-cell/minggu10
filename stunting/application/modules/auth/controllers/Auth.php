<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('akun');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Sistem Pendeteksi Dini Stunting';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasinya success
            $this->_login();
        }
    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1 || $user['role_id'] == 3) {
                        redirect('master/dashboard');
                    } else {
                        redirect('laporan/');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Salah!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email ini belum diaktifkan!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar!</div>');
            redirect('auth');
        }
    }


    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('akun');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password tidak cocok!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Sistem Pendeteksi Dini Stunting';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $this->load->helper('string');
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);

            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat! Akun Anda telah dibuat. Periksa email anda untuk mengaktifkan akun!</div>');

            redirect('auth');
        }
    }


    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'stunting.app.shield@gmail.com',
            'smtp_pass' => 'ewlp ckve lofc ooaz',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];


        $this->email->initialize($config);

        $this->email->from('portablemyfarm@gmail.com', 'Sistem Pendeteksi Dini Stunting');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
    $this->email->subject('Verifikasi Akun Anda - Deteksi Dini Stunting');

    $email_body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 20px auto;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            .header {
                background-color: #8B80F9;
                color: white;
                padding: 20px;
                text-align: center;
            }
            .content {
                padding: 20px;
                line-height: 1.6;
            }
            .content p {
                margin: 0 0 10px;
            }
            .cta-button {
		display: inline-block;
    		background-color: #8B80F9; 
    		color: white !important;
    		text-decoration: none;
    		padding: 10px 20px;
    		border-radius: 5px;
    		font-weight: bold;
    		margin-top: 20px;
    		text-align: center;
    		border: none;
	    }            
	.cta-button:hover {
                background-color: #6D62D3;
            }
            .footer {
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #aaa;
                border-top: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Verifikasi Akun Anda</h1>
            </div>
            <div class="content">
                <p>Halo,</p>
                <p>Terima kasih telah mendaftar di platform <strong>Deteksi Dini Stunting</strong>. Untuk mulai menggunakan akun Anda, harap verifikasi email Anda dengan mengklik tombol di bawah ini:</p>
                <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="cta-button">Verifikasi Akun</a>
                <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
                <p>Terima kasih,</p>
                <p>Tim Deteksi Dini Stunting</p>
            </div>
            <div class="footer">
                <p>&copy; ' . date("Y") . ' Deteksi Dini Stunting. Semua hak dilindungi.</p>
            </div>
        </div>
    </body>
    </html>
    ';

    $this->email->message($email_body);
}
else if ($type == 'forgot') {
    $this->email->subject('Reset Password Anda - Deteksi Dini Stunting');

    $email_body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 600px;
                margin: 20px auto;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            .header {
                background-color: #8B80F9; /* Warna ungu */
                color: white;
                padding: 20px;
                text-align: center;
            }
            .content {
                padding: 20px;
                line-height: 1.6;
            }
            .content p {
                margin: 0 0 10px;
            }
            .cta-button {
                display: inline-block;
                background-color: #8B80F9; /* Warna ungu */
                color: white !important;
                text-decoration: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-weight: bold;
                margin-top: 20px;
                text-align: center;
                border: none;
            }
            .cta-button:hover {
                background-color: #6D62D3; /* Warna hover lebih gelap */
            }
            .footer {
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #aaa;
                border-top: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Reset Password Anda</h1>
            </div>
            <div class="content">
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mereset kata sandi akun Anda di <strong>Deteksi Dini Stunting</strong>. Jika Anda tidak meminta ini, abaikan email ini.</p>
                <p>Untuk mengatur ulang kata sandi Anda, klik tombol di bawah ini:</p>
                <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" class="cta-button">Reset Password</a>
                <p>Jika tombol tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:</p>
                <p><a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '</a></p>
                <p>Terima kasih,</p>
                <p>Tim Deteksi Dini Stunting</p>
            </div>
            <div class="footer">
                <p>&copy; ' . date("Y") . ' Deteksi Dini Stunting. Semua hak dilindungi.</p>
            </div>
        </div>
    </body>
    </html>
    ';

    $this->email->message($email_body);
}

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' Telah diaktifkan! Silakan masuk!</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Token kedaluwarsa!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Token salah!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Email salah!</div>');
            redirect('auth');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah keluar!</div>');
        redirect('auth');
    }


    public function blocked()
    {
        $this->load->view('auth/blocked');
    }


    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silakan periksa email Anda untuk mengatur ulang Password Anda!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar atau diaktifkan!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }


    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyetel ulang Password! Token salah.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyetel ulang Password! Email salah.</div>');
            redirect('auth');
        }
    }


    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->db->delete('user_token', ['email' => $email]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kata sandi telah diubah! Silakan masuk.</div>');
            redirect('auth');
        }
    }
}
