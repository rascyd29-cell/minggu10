<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_jadwal');
        $this->load->model('DataMakanan_model');
        $this->load->model('Selingan_model');
        $this->load->model('Sub_menu_model');
    }

    public function dashboard()
    {
        // Query utama dengan join untuk data balita dan orang tua
        $this->db->select('data_pengukuran.*, tb_balita.nama as nama_balita, tb_balita.jenis_kelamin as gender2, tb_balita.tanggal_lahir as lahir, tb_balita.alamat as alamat2, tb_balita.id_ortu as ortu, user.name as nama_ortu');
        $this->db->from('data_pengukuran');
        $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');
        $datas['data'] = $this->db->order_by('id', 'DESC')->get()->result();

        // Mengambil 5 data terbaru dari history sensor secara descending
        $datas['data2_'] = $this->db->select('*')
            ->from('historysesnor_timbangan')
            ->order_by('id', 'DESC')
            ->limit(5)
            ->get()
            ->result();

        $datas['jumlah_orang_tua'] = $this->db->where('role_id', 2)->count_all_results('user');
        $datas['jumlah_balita'] = $this->db->count_all_results('tb_balita');
        $datas['title'] = 'Dashboard';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->template->load('template1', 'master/dashboard', $datas);
    }


    public function index()
    {
        $data['title'] = 'Data Master';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_master', $data);
            $this->load->view('templates/footer');
        } else {
            // Ambil data dari form
            $email = $this->input->post('email');
            $desa = $this->input->post('desa');
            $kecamatan = $this->input->post('kecamatan');
            $kabupaten = $this->input->post('kabupaten');
            $provinsi = $this->input->post('provinsi');
            $name = $this->input->post('name');

            // Update data user di database
            $this->db->set('name', $name);
            $this->db->set('desa', $desa);
            $this->db->set('kecamatan', $kecamatan);
            $this->db->set('kabupaten', $kabupaten);
            $this->db->set('provinsi', $provinsi);
            $this->db->where('email', $email);
            $this->db->update('user');

            // Set pesan berhasil dan redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Informasi berhasil diperbarui!</div>');
            redirect('master');
        }
    }




    public function jadwal()
    {
        $data['title'] = "Jadwal";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_jadwal');
        $this->load->view('templates/footer');
    }
    public function data_jadwal()
    {
        $data = $this->M_jadwal->jadwal_list();
        echo json_encode($data);
    }

    public function get_jadwal()
    {
        $id_jadwal = $this->input->get('id');
        $data = $this->M_jadwal->get_jadwal_by_kode($id_jadwal);
        echo json_encode($data);
    }

    public function simpan_jadwal()
    {
        $tanggal = $this->input->post('tanggal');
        $kegiatan = $this->input->post('kegiatan');
        $jam = $this->input->post('jam');
        $lokasi = $this->input->post('lokasi');
        $keterangan = $this->input->post('keterangan');

        $data = $this->M_jadwal->simpan_jadwal($tanggal, $kegiatan, $jam, $lokasi, $keterangan);
        echo json_encode(['success' => $data]);
    }

    public function update_jadwal()
    {
        $id_jadwal = $this->input->post('edit_id');
        $tanggal = $this->input->post('edit_tanggal');
        $kegiatan = $this->input->post('edit_kegiatan');
        $jam = $this->input->post('edit_jam');
        $lokasi = $this->input->post('edit_lokasi');
        $keterangan = $this->input->post('edit_keterangan');

        $data = $this->M_jadwal->update_jadwal($id_jadwal, $tanggal, $kegiatan, $jam, $lokasi, $keterangan);
        echo json_encode(['success' => $data]);
    }


    public function hapus_jadwal()
    {
        $id_jadwal = $this->input->post('id');
        $data = $this->M_jadwal->hapus_jadwal($id_jadwal);
        echo json_encode(['success' => $data]);
    }

    public function search()
    {
        $query = $this->input->get('query'); // Get the search query from the AJAX request

        // Call the model method to fetch search results
        $data['results'] = $this->M_jadwal->search($query);

        // Load the search results view and return HTML for table rows
        if (!empty($data['results'])) {
            $no = 1; // Initialize counter
            foreach ($data['results'] as $result) {
                echo '<tr>
                <td>' . $no++ . '</td> <!-- Incrementing number -->
                <td>' . htmlspecialchars($result->tanggal) . '</td>
                <td>' . htmlspecialchars($result->kegiatan) . '</td>
                <td>' . htmlspecialchars($result->jam) . '</td>
                <td>' . htmlspecialchars($result->lokasi) . '</td>
                <td>' . htmlspecialchars($result->keterangan) . '</td>
                <td>
                    <button class="btn btn-warning btn-sm edit" data-id="' . $result->id . '">Edit</button>
                    <button class="btn btn-danger btn-sm delete" data-id="' . $result->id . '">Delete</button>
                </td>
              </tr>';
            }
        } else {
            echo '<tr><td colspan="4">No results found.</td></tr>'; // Provide feedback if no results are found
        }
    }






    public function artikel()
    {
        $data['title'] = "Artikel";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_artikel');
        $this->load->view('templates/footer');
    }

    public function data_artikel()
    {
        $data = $this->M_jadwal->artikel_list();
        echo json_encode($data);
    }

    public function get_artikel()
    {
        $id_artikel = $this->input->get('id');
        $data = $this->M_jadwal->get_artikel_by_kode($id_artikel);
        echo json_encode($data);
    }

    public function simpan_artikel()
    {
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $response = array('status' => 'error', 'message' => $this->upload->display_errors());
        } else {
            $file_data = $this->upload->data();
            $data = array(
                'judul' => $this->input->post('judul'),
                'isi' => $this->input->post('isi'),
                'gambar' => $file_data['file_name'],
                'timestamp' => date('Y-m-d H:i:s')
            );

            $this->db->insert('tb_artikel', $data);
            $response = array('status' => 'success', 'message' => 'Artikel berhasil diupload');
        }

        echo json_encode($response);
    }

    public function update_artikel()
    {
        $id_artikel = $this->input->post('edit_id');
        $data = array(
            'judul' => $this->input->post('edit_judul'),
            'isi' => $this->input->post('edit_isi')
        );

        // Periksa jika gambar diunggah
        if (!empty($_FILES['edit_gambar']['name'])) {
            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('edit_gambar')) {
                $file_data = $this->upload->data();
                $data['gambar'] = $file_data['file_name'];
            }
        }

        $result = $this->M_jadwal->update_artikel($id_artikel, $data);
        echo json_encode(['success' => $result]);
    }

    public function hapus_artikel()
    {
        $id_artikel = $this->input->post('id');
        $result = $this->M_jadwal->hapus_artikel($id_artikel);
        echo json_encode(['success' => $result]);
    }

    public function search2()
    {
        $query = $this->input->get('query');
        $data['results'] = $this->M_jadwal->search2($query);

        if (!empty($data['results'])) {
            $no = 1;
            foreach ($data['results'] as $result) {
                // Convert isi to an array of words
                $words = explode(' ', $result->isi);
                // Limit to the first 10 words
                $limited_words = array_slice($words, 0, 10);
                // Join the words back into a string
                $isi_preview = implode(' ', $limited_words);
                // Add ellipsis if there are more words
                if (count($words) > 10) {
                    $isi_preview .= '...';
                }

                echo '<tr>
                    <td>' . $no++ . '</td>
                    <td><img src="' . base_url('assets/uploads/' . $result->gambar) . '" width="100"></td>
                    <td>' . htmlspecialchars($result->judul) . '</td>
                    <td>' . htmlspecialchars($isi_preview) . '</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit" data-id="' . $result->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $result->id . '">Hapus</button>
                    </td>
                  </tr>';
            }
        } else {
            echo '<tr><td colspan="5">No results found.</td></tr>';
        }
    }
    public function menu_makan()
    {
        $query = $this->DataMakanan_model->get_all();
        $datas['title'] = 'Menu Makanan';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->template->load('template1', 'master/datamakanan', ['query' => $query]);
    }

    public function create()
    {
        $datas['title'] = 'Menu Makanan';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->template->load('template1', 'master/formInput', $datas);
    }

    public function store()
    {
        $paket = $this->input->post('paket');
        $waktumakan_pagi = $this->input->post('waktumakan_pagi');
        $menu_pagi = $this->input->post('menu_pagi');
        $mp_pagi = $this->input->post('mp_pagi');
        $j_makananPokok = $this->input->post('j_mp');
        $proteinmp_pagi = $this->input->post('proteinmp_pagi');
        $karbomp_pagi = $this->input->post('karbomp_pagi');
        $lemakmp_pagi = $this->input->post('lemakmp_pagi');
        $energimp_pagi = $this->input->post('energimp_pagi');
        $lauk_pagi = $this->input->post('lauk_pagi');
        $j_lauk = $this->input->post('j_lauk');
        $proteinlauk_pagi = $this->input->post('proteinlauk_pagi');
        $karbolauk_pagi = $this->input->post('karbolauk_pagi');
        $lemaklauk_pagi = $this->input->post('lemaklauk_pagi');
        $energilauk_pagi = $this->input->post('energilauk_pagi');
        $sayur_pagi = $this->input->post('syr_pagi');
        $j_sayur = $this->input->post('j_sayur');
        $proteinsyr_pagi = $this->input->post('proteinsyr_pagi');
        $karbosyr_pagi = $this->input->post('karbosyr_pagi');
        $lemaksyr_pagi = $this->input->post('lemaksyr_pagi');
        $energisyr_pagi = $this->input->post('energisyr_pagi');
        $buah_pagi = $this->input->post('buah_pagi');
        $j_buah = $this->input->post('j_buah');
        $proteinbuah_pagi = $this->input->post('proteinbuah_pagi');
        $karbobuah_pagi = $this->input->post('karbobuah_pagi');
        $lemakbuah_pagi = $this->input->post('lemakbuah_pagi');
        $energibuah_pagi = $this->input->post('energibuah_pagi');
        $waktumakan_siang = $this->input->post('waktumakan_siang');
        $menu_siang = $this->input->post('menu_siang');
        $mp_siang = $this->input->post('mp_siang');
        $proteinmp_siang = $this->input->post('proteinmp_siang');
        $karbomp_siang = $this->input->post('karbomp_siang');
        $lemakmp_siang = $this->input->post('lemakmp_siang');
        $energimp_siang = $this->input->post('energimp_siang');
        $lauk_siang = $this->input->post('lauk_siang');
        $proteinlauk_siang = $this->input->post('proteinlauk_siang');
        $karbolauk_siang = $this->input->post('karbolauk_siang');
        $lemaklauk_siang = $this->input->post('lemaklauk_siang');
        $energilauk_siang = $this->input->post('energilauk_siang');
        $sayur_siang = $this->input->post('syr_siang');
        $proteinsyr_siang = $this->input->post('proteinsyr_siang');
        $karbosyr_siang = $this->input->post('karbosyr_siang');
        $lemaksyr_siang = $this->input->post('lemaksyr_siang');
        $energisyr_siang = $this->input->post('energisyr_siang');
        $buah_siang = $this->input->post('buah_siang');
        $proteinbuah_siang = $this->input->post('proteinbuah_siang');
        $karbobuah_siang = $this->input->post('karbobuah_siang');
        $lemakbuah_siang = $this->input->post('lemakbuah_siang');
        $energibuah_siang = $this->input->post('energibuah_siang');
        $waktumakan_malam = $this->input->post('waktumakan_malam');
        $menu_malam = $this->input->post('menu_malam');
        $mp_malam = $this->input->post('mp_malam');
        $proteinmp_malam = $this->input->post('proteinmp_malam');
        $karbomp_malam = $this->input->post('karbomp_malam');
        $lemakmp_malam = $this->input->post('lemakmp_malam');
        $energimp_malam = $this->input->post('energimp_malam');
        $lauk_malam = $this->input->post('lauk_malam');
        $proteinlauk_malam = $this->input->post('proteinlauk_malam');
        $karbolauk_malam = $this->input->post('karbolauk_malam');
        $lemaklauk_malam = $this->input->post('lemaklauk_malam');
        $energilauk_malam = $this->input->post('energilauk_malam');
        $sayur_malam = $this->input->post('syr_malam');
        $proteinsyr_malam = $this->input->post('proteinsyr_malam');
        $karbosyr_malam = $this->input->post('karbosyr_malam');
        $lemaksyr_malam = $this->input->post('lemaksyr_malam');
        $energisyr_malam = $this->input->post('energisyr_malam');
        $buah_malam = $this->input->post('buah_malam');
        $proteinbuah_malam = $this->input->post('proteinbuah_malam');
        $karbobuah_malam = $this->input->post('karbobuah_malam');
        $lemakbuah_malam = $this->input->post('lemakbuah_malam');
        $energibuah_malam = $this->input->post('energibuah_malam');
        $waktumakan_SPagi = $this->input->post('waktumakan_SPagi');
        $menuselingan_pagi = $this->input->post('menuselingan_pagi');
        $proteinsp_pagi = $this->input->post('proteinselingan_pagi');
        $karbosp_pagi = $this->input->post('karboselingan_pagi');
        $lemaksp_pagi = $this->input->post('lemakselingan_pagi');
        $energisp_pagi = $this->input->post('energiselingan_pagi');
        $waktumakan_Ssore = $this->input->post('waktumkn_Ssore');
        $menuselingan_sore = $this->input->post('menuselingan_sore');
        $proteinss_sore = $this->input->post('proteinselingan_sore');
        $karboss_sore = $this->input->post('karboselingan_sore');
        $lemakss_sore = $this->input->post('lemakselingan_sore');
        $energiss_sore = $this->input->post('energiselingan_sore');

        //================INPUT DATA MAKANAN================//
        $dataMakanan = $this->DataMakanan_model->insert([
            'paket' => $paket,
            'waktu_makan' => $waktumakan_pagi,
            'menu' => $menu_pagi
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $mp_pagi,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_pagi,
            'karbohidrat' => $karbomp_pagi,
            'lemak' => $lemakmp_pagi,
            'energi' => $energimp_pagi,
            'Data_makanan_idData_makanan' => $dataMakanan['idData_makanan'] // Gunakan array
        ]);



        $this->Sub_menu_model->insert([
            'nama_makanan' => $lauk_pagi,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_pagi,
            'karbohidrat' => $karbolauk_pagi,
            'lemak' => $lemaklauk_pagi,
            'energi' => $energilauk_pagi,
            'Data_makanan_idData_makanan' => $dataMakanan['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $sayur_pagi,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_pagi,
            'karbohidrat' => $karbosyr_pagi,
            'lemak' => $lemaksyr_pagi,
            'energi' => $energisyr_pagi,
            'Data_makanan_idData_makanan' => $dataMakanan['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $buah_pagi,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_pagi,
            'karbohidrat' => $karbobuah_pagi,
            'lemak' => $lemakbuah_pagi,
            'energi' => $energibuah_pagi,
            'Data_makanan_idData_makanan' => $dataMakanan['idData_makanan']
        ]);

        //================INPUT DATA MAKANAN================//
        $dataMakanan_siang = $this->DataMakanan_model->insert([
            'paket' => $paket,
            'waktu_makan' => $waktumakan_siang,
            'menu' => $menu_siang
        ]);

        //================INPUT SUBMENU================//
        $this->Sub_menu_model->insert([
            'nama_makanan' => $mp_siang,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_siang,
            'karbohidrat' => $karbomp_siang,
            'lemak' => $lemakmp_siang,
            'energi' => $energimp_siang,
            'Data_makanan_idData_makanan' => $dataMakanan_siang['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $lauk_siang,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_siang,
            'karbohidrat' => $karbolauk_siang,
            'lemak' => $lemaklauk_siang,
            'energi' => $energilauk_siang,
            'Data_makanan_idData_makanan' => $dataMakanan_siang['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $sayur_siang,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_siang,
            'karbohidrat' => $karbosyr_siang,
            'lemak' => $lemaksyr_siang,
            'energi' => $energisyr_siang,
            'Data_makanan_idData_makanan' => $dataMakanan_siang['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $buah_siang,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_siang,
            'karbohidrat' => $karbobuah_siang,
            'lemak' => $lemakbuah_siang,
            'energi' => $energibuah_siang,
            'Data_makanan_idData_makanan' => $dataMakanan_siang['idData_makanan']
        ]);

        //================INPUT DATA MAKANAN================//
        $dataMakanan_malam = $this->DataMakanan_model->insert([
            'paket' => $paket,
            'waktu_makan' => $waktumakan_malam,
            'menu' => $menu_malam
        ]);

        //================INPUT SUBMENU================//
        $this->Sub_menu_model->insert([
            'nama_makanan' => $mp_malam,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_malam,
            'karbohidrat' => $karbomp_malam,
            'lemak' => $lemakmp_malam,
            'energi' => $energimp_malam,
            'Data_makanan_idData_makanan' => $dataMakanan_malam['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $lauk_malam,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_malam,
            'karbohidrat' => $karbolauk_malam,
            'lemak' => $lemaklauk_malam,
            'energi' => $energilauk_malam,
            'Data_makanan_idData_makanan' => $dataMakanan_malam['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $sayur_malam,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_malam,
            'karbohidrat' => $karbosyr_malam,
            'lemak' => $lemaksyr_malam,
            'energi' => $energisyr_malam,
            'Data_makanan_idData_makanan' => $dataMakanan_malam['idData_makanan']
        ]);

        $this->Sub_menu_model->insert([
            'nama_makanan' => $buah_malam,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_malam,
            'karbohidrat' => $karbobuah_malam,
            'lemak' => $lemakbuah_malam,
            'energi' => $energibuah_malam,
            'Data_makanan_idData_makanan' => $dataMakanan_malam['idData_makanan']
        ]);

        //================INPUT SELINGAN================//
        $dataSelingan_pagi = $this->DataMakanan_model->insert([
            'paket' => $paket,
            'waktu_makan' => $waktumakan_SPagi,
            'menu' => $menuselingan_pagi
        ]);

        $this->Selingan_model->insert([
            'nama_selingan' => $menuselingan_pagi,
            'protein' => $proteinsp_pagi,
            'karbohidrat' => $karbosp_pagi,
            'lemak' => $lemaksp_pagi,
            'energi' => $energisp_pagi,
            'Data_makanan_idData_makanan' => $dataSelingan_pagi['idData_makanan']
        ]);

        $dataSelingan_sore = $this->DataMakanan_model->insert([
            'paket' => $paket,
            'waktu_makan' => $waktumakan_Ssore,
            'menu' => $menuselingan_sore
        ]);

        $this->Selingan_model->insert([
            'nama_selingan' => $menuselingan_sore,
            'protein' => $proteinss_sore,
            'karbohidrat' => $karboss_sore,
            'lemak' => $lemakss_sore,
            'energi' => $energiss_sore,
            'Data_makanan_idData_makanan' => $dataSelingan_sore['idData_makanan']
        ]);

        $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
        redirect('master/menu_makan');
    }

    public function edit($id)
    {
        // Load database library
        $this->load->database();

        // Query untuk mendapatkan data makanan berdasarkan paket
        $this->db->select('*');
        $this->db->from('data_makanan');
        $this->db->like('paket', $id);
        $query = $this->db->get();
        $dataMakanan = $query->result();

        // Ambil semua idData_makanan dari hasil query dataMakanan
        $idDataMakananArray = array_column($dataMakanan, 'idData_makanan');

        // Query join data_makanan dan sub_menu
        $this->db->select('data_makanan.*, sub_menu.*');
        $this->db->from('data_makanan');
        $this->db->join('sub_menu', 'sub_menu.Data_makanan_idData_makanan = data_makanan.idData_makanan');
        $this->db->where_in('data_makanan.idData_makanan', $idDataMakananArray);
        $query = $this->db->get();
        $subMenu = $query->result();

        // Query join data_makanan dan selingan
        $this->db->select('data_makanan.*, selingan.*');
        $this->db->from('data_makanan');
        $this->db->join('selingan', 'selingan.Data_makanan_idData_makanan = data_makanan.idData_makanan');
        $this->db->where_in('data_makanan.idData_makanan', $idDataMakananArray);
        $query = $this->db->get();
        $selingan = $query->result();

        // Load view



        $datas['title'] = 'Menu Makanan';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->load->view('master/formEdit', compact('dataMakanan', 'subMenu', 'selingan', 'idDataMakananArray'));
    }

    public function update($idmakan_pagi, $idmakan_siang, $idmakan_malam, $idmakan_selinganPG, $idmakan_selinganSR)
    {
        // Load models
        $this->load->model('DataMakanan_model', 'data_makanan');
        $this->load->model('sub_menu_model', 'sub_menu');
        $this->load->model('Selingan_model', 'selingan');

        // Proses data dari request
        $paket = $this->input->post('paket');
        $waktumakan_pagi = $this->input->post('waktumakan_pagi');
        $menu_pagi = $this->input->post('menu_pagi');
        $mp_pagi = $this->input->post('mp_pagi');
        $j_makananPokok = $this->input->post('j_mp');
        $proteinmp_pagi = $this->input->post('proteinmp_pagi');
        $karbomp_pagi = $this->input->post('karbomp_pagi');
        $lemakmp_pagi = $this->input->post('lemakmp_pagi');
        $energimp_pagi = $this->input->post('energimp_pagi');
        $lauk_pagi = $this->input->post('lauk_pagi');
        $j_lauk = $this->input->post('j_lauk');
        $proteinlauk_pagi = $this->input->post('proteinlauk_pagi');
        $karbolauk_pagi = $this->input->post('karbolauk_pagi');
        $lemaklauk_pagi = $this->input->post('lemaklauk_pagi');
        $energilauk_pagi = $this->input->post('energilauk_pagi');
        $sayur_pagi = $this->input->post('syr_pagi');
        $j_sayur = $this->input->post('j_sayur');
        $proteinsyr_pagi = $this->input->post('proteinsyr_pagi');
        $karbosyr_pagi = $this->input->post('karbosyr_pagi');
        $lemaksyr_pagi = $this->input->post('lemaksyr_pagi');
        $energisyr_pagi = $this->input->post('energisyr_pagi');
        $buah_pagi = $this->input->post('buah_pagi');
        $j_buah = $this->input->post('j_buah');
        $proteinbuah_pagi = $this->input->post('proteinbuah_pagi');
        $karbobuah_pagi = $this->input->post('karbobuah_pagi');
        $lemakbuah_pagi = $this->input->post('lemakbuah_pagi');
        $energibuah_pagi = $this->input->post('energibuah_pagi');
        $waktumakan_siang = $this->input->post('waktumakan_siang');
        $menu_siang = $this->input->post('menu_siang');
        $mp_siang = $this->input->post('mp_siang');
        $proteinmp_siang = $this->input->post('proteinmp_siang');
        $karbomp_siang = $this->input->post('karbomp_siang');
        $lemakmp_siang = $this->input->post('lemakmp_siang');
        $energimp_siang = $this->input->post('energimp_siang');
        $lauk_siang = $this->input->post('lauk_siang');
        $proteinlauk_siang = $this->input->post('proteinlauk_siang');
        $karbolauk_siang = $this->input->post('karbolauk_siang');
        $lemaklauk_siang = $this->input->post('lemaklauk_siang');
        $energilauk_siang = $this->input->post('energilauk_siang');
        $sayur_siang = $this->input->post('syr_siang');
        $proteinsyr_siang = $this->input->post('proteinsyr_siang');
        $karbosyr_siang = $this->input->post('karbosyr_siang');
        $lemaksyr_siang = $this->input->post('lemaksyr_siang');
        $energisyr_siang = $this->input->post('energisyr_siang');
        $buah_siang = $this->input->post('buah_siang');
        $proteinbuah_siang = $this->input->post('proteinbuah_siang');
        $karbobuah_siang = $this->input->post('karbobuah_siang');
        $lemakbuah_siang = $this->input->post('lemakbuah_siang');
        $energibuah_siang = $this->input->post('energibuah_siang');
        $waktumakan_malam = $this->input->post('waktumakan_malam');
        $menu_malam = $this->input->post('menu_malam');
        $mp_malam = $this->input->post('mp_malam');
        $proteinmp_malam = $this->input->post('proteinmp_malam');
        $karbomp_malam = $this->input->post('karbomp_malam');
        $lemakmp_malam = $this->input->post('lemakmp_malam');
        $energimp_malam = $this->input->post('energimp_malam');
        $lauk_malam = $this->input->post('lauk_malam');
        $proteinlauk_malam = $this->input->post('proteinlauk_malam');
        $karbolauk_malam = $this->input->post('karbolauk_malam');
        $lemaklauk_malam = $this->input->post('lemaklauk_malam');
        $energilauk_malam = $this->input->post('energilauk_malam');
        $sayur_malam = $this->input->post('syr_malam');
        $proteinsyr_malam = $this->input->post('proteinsyr_malam');
        $karbosyr_malam = $this->input->post('karbosyr_malam');
        $lemaksyr_malam = $this->input->post('lemaksyr_malam');
        $energisyr_malam = $this->input->post('energisyr_malam');
        $buah_malam = $this->input->post('buah_malam');
        $proteinbuah_malam = $this->input->post('proteinbuah_malam');
        $karbobuah_malam = $this->input->post('karbobuah_malam');
        $lemakbuah_malam = $this->input->post('lemakbuah_malam');
        $energibuah_malam = $this->input->post('energibuah_malam');
        $waktumakan_SPagi = $this->input->post('waktumakan_SPagi');
        $menuselingan_pagi = $this->input->post('menuselingan_pagi');
        $proteinsp_pagi = $this->input->post('proteinselingan_pagi');
        $karbosp_pagi = $this->input->post('karboselingan_pagi');
        $lemaksp_pagi = $this->input->post('lemakselingan_pagi');
        $energisp_pagi = $this->input->post('energiselingan_pagi');
        $waktumakan_Ssore = $this->input->post('waktumkn_Ssore');
        $menuselingan_sore = $this->input->post('menuselingan_sore');
        $proteinss_sore = $this->input->post('proteinselingan_sore');
        $karboss_sore = $this->input->post('karboselingan_sore');
        $lemakss_sore = $this->input->post('lemakselingan_sore');
        $energiss_sore = $this->input->post('energiselingan_sore');

        // Update Data Makanan Pagi
        $this->data_makanan->update($idmakan_pagi, [
            'paket' => $paket,
            'waktu_makan' => $waktumakan_pagi,
            'menu' => $menu_pagi,
        ]);

        $idsub_pagi = $this->sub_menu->get_by_data_makanan_id($idmakan_pagi);
        $this->sub_menu->update($idsub_pagi[0]->id, [
            'nama_makanan' => $mp_pagi,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_pagi,
            'karbohidrat' => $karbomp_pagi,
            'lemak' => $lemakmp_pagi,
            'energi' => $energimp_pagi
        ]);

        $this->sub_menu->update($idsub_pagi[1]->id, [
            'nama_makanan' => $lauk_pagi,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_pagi,
            'karbohidrat' => $karbolauk_pagi,
            'lemak' => $lemaklauk_pagi,
            'energi' => $energilauk_pagi
        ]);

        $this->sub_menu->update($idsub_pagi[2]->id, [
            'nama_makanan' => $sayur_pagi,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_pagi,
            'karbohidrat' => $karbosyr_pagi,
            'lemak' => $lemaksyr_pagi,
            'energi' => $energisyr_pagi
        ]);

        $this->sub_menu->update($idsub_pagi[3]->id, [
            'nama_makanan' => $buah_pagi,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_pagi,
            'karbohidrat' => $karbobuah_pagi,
            'lemak' => $lemakbuah_pagi,
            'energi' => $energibuah_pagi
        ]);

        // Update Data Makanan Siang
        $this->data_makanan->update($idmakan_siang, [
            'paket' => $paket,
            'waktu_makan' => $waktumakan_siang,
            'menu' => $menu_siang,
        ]);

        $idsub_siang = $this->sub_menu->get_by_data_makanan_id($idmakan_siang);
        $this->sub_menu->update($idsub_siang[0]->id, [
            'nama_makanan' => $mp_siang,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_siang,
            'karbohidrat' => $karbomp_siang,
            'lemak' => $lemakmp_siang,
            'energi' => $energimp_siang
        ]);

        $this->sub_menu->update($idsub_siang[1]->id, [
            'nama_makanan' => $lauk_siang,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_siang,
            'karbohidrat' => $karbolauk_siang,
            'lemak' => $lemaklauk_siang,
            'energi' => $energilauk_siang
        ]);

        $this->sub_menu->update($idsub_siang[2]->id, [
            'nama_makanan' => $sayur_siang,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_siang,
            'karbohidrat' => $karbosyr_siang,
            'lemak' => $lemaksyr_siang,
            'energi' => $energisyr_siang
        ]);

        $this->sub_menu->update($idsub_siang[3]->id, [
            'nama_makanan' => $buah_siang,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_siang,
            'karbohidrat' => $karbobuah_siang,
            'lemak' => $lemakbuah_siang,
            'energi' => $energibuah_siang
        ]);

        // Update Data Makanan Malam
        $this->data_makanan->update($idmakan_malam, [
            'paket' => $paket,
            'waktu_makan' => $waktumakan_malam,
            'menu' => $menu_malam,
        ]);

        $idsub_malam = $this->sub_menu->get_by_data_makanan_id($idmakan_malam);
        $this->sub_menu->update($idsub_malam[0]->id, [
            'nama_makanan' => $mp_malam,
            'jenis_makanan' => $j_makananPokok,
            'protein' => $proteinmp_malam,
            'karbohidrat' => $karbomp_malam,
            'lemak' => $lemakmp_malam,
            'energi' => $energimp_malam
        ]);

        $this->sub_menu->update($idsub_malam[1]->id, [
            'nama_makanan' => $lauk_malam,
            'jenis_makanan' => $j_lauk,
            'protein' => $proteinlauk_malam,
            'karbohidrat' => $karbolauk_malam,
            'lemak' => $lemaklauk_malam,
            'energi' => $energilauk_malam
        ]);

        $this->sub_menu->update($idsub_malam[2]->id, [
            'nama_makanan' => $sayur_malam,
            'jenis_makanan' => $j_sayur,
            'protein' => $proteinsyr_malam,
            'karbohidrat' => $karbosyr_malam,
            'lemak' => $lemaksyr_malam,
            'energi' => $energisyr_malam
        ]);

        $this->sub_menu->update($idsub_malam[3]->id, [
            'nama_makanan' => $buah_malam,
            'jenis_makanan' => $j_buah,
            'protein' => $proteinbuah_malam,
            'karbohidrat' => $karbobuah_malam,
            'lemak' => $lemakbuah_malam,
            'energi' => $energibuah_malam
        ]);

        // Update Selingan Pagi
        $idselinagan_PG = $this->selingan->get_by_data_makanan_id($idmakan_selinganPG);
        $this->selingan->update($idselinagan_PG->id, [
            'nama_selingan' => $menuselingan_pagi,
            'protein' => $proteinsp_pagi,
            'karbohidrat' => $karbosp_pagi,
            'lemak' => $lemaksp_pagi,
            'energi' => $energisp_pagi
        ]);

        $this->data_makanan->update($idselinagan_PG->Data_makanan_idData_makanan, [
            'menu' => $menuselingan_pagi
        ]);

        // Update Selingan Sore
        $idselinagan_SR = $this->selingan->get_by_data_makanan_id($idmakan_selinganSR);
        $this->selingan->update($idselinagan_SR->id, [
            'nama_selingan' => $menuselingan_sore,
            'protein' => $proteinss_sore,
            'karbohidrat' => $karboss_sore,
            'lemak' => $lemakss_sore,
            'energi' => $energiss_sore
        ]);

        $this->data_makanan->update($idselinagan_SR->Data_makanan_idData_makanan, [
            'menu' => $menuselingan_sore
        ]);

        // Redirect to datamakananadmin
        redirect('master/menu_makan');
    }

    public function showadmin($paket)
    {
        // Load database library
        $this->load->database();

        // Query join data_makanan dan sub_menu
        $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, sub_menu.nama_makanan, sub_menu.jenis_makanan, sub_menu.protein, sub_menu.karbohidrat, sub_menu.lemak, sub_menu.energi');
        $this->db->from('data_makanan');
        $this->db->join('sub_menu', 'sub_menu.Data_makanan_idData_makanan = data_makanan.idData_makanan');
        $this->db->like('data_makanan.paket', $paket);
        $joindata = $this->db->get()->result();

        // Query join data_makanan dan selingan
        $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, selingan.protein, selingan.karbohidrat, selingan.lemak, selingan.energi');
        $this->db->from('data_makanan');
        $this->db->join('selingan', 'selingan.Data_makanan_idData_makanan = data_makanan.idData_makanan');
        $this->db->where('data_makanan.paket', $paket);
        $this->db->group_start(); // Memulai grup kondisi
        $this->db->where('data_makanan.waktu_makan', 'selingan pagi');
        $this->db->or_where('data_makanan.waktu_makan', 'selingan sore');
        $this->db->group_end(); // Mengakhiri grup kondisi
        $dataSelingan = $this->db->get()->result();



        $datas['title'] = 'Menu Makanan';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->load->view('master/submenuadmin', compact('joindata', 'paket', 'dataSelingan'));
    }

    public function delete($paket)
    {
        // Get data makanan based on paket
        $dataMakanan = $this->DataMakanan_model->get_by_paket($paket);

        if ($dataMakanan) {
            $dataMakananIds = array_column($dataMakanan, 'idData_makanan');

            // Delete related records in sub_menu and selingan tables
            foreach ($dataMakananIds as $id) {
                $this->Sub_menu_model->delete_by_data_makanan_id($id);
                $this->Selingan_model->delete_by_data_makanan_id($id);
                $this->DataMakanan_model->delete($id);
            }

            // Set success message
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        } else {
            // Set error message if no data found
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
        }

        // Redirect to datamakananadmin
        redirect('master/menu_makan');
    }
}
