<?php

class Rest extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_jadwal');
        $this->load->library('form_validation');
        //is_logged_in();
    }

    function index()
    {
        $tolak = json_encode("access denied");
        echo $tolak;
    }

    public function history($device, $id = NULL)
    {
        // Pemetaan nama device ke nama tabel
        $tables = [
            'topi' => 'historysesnor_topi',
            'timbangan' => 'historysesnor_timbangan'
        ];

        if (!isset($tables[$device])) {
            echo json_encode(['message' => 'Tabel tidak valid']);
            return;
        }
        $table = $tables[$device]; // Ambil nama tabel berdasarkan parameter
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getHistoryById($table, $id);
                } else {
                    $this->getAllHistory($table);
                }
                break;
            case 'POST':
                $this->createHistory($table);
                break;
            case 'PUT':
                $this->updateHistory($table, $id);
                break;
            case 'DELETE':
                $this->deleteHistory($table, $id);
                break;
            default:
                echo json_encode(['message' => 'Metode tidak diizinkan']);
                break;
        }
    }

    private function getAllHistory($table)
    {
        $query = $this->db->get($table)->result();
        echo json_encode($query);
    }

    private function getHistoryById($table, $id)
    {
        $query = $this->db->get_where($table, ['id' => $id])->row();
        if ($query) {
            echo json_encode($query);
        } else {
            echo json_encode(['message' => 'Data tidak ditemukan']);
        }
    }

    private function createHistory($table)
    {
        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        // Jika tidak ada data dari JSON, coba ambil dari $_POST atau $_GET
        if (!$data) {
            $data = $_POST ? $_POST : $_GET;
        }

        if ($this->db->insert($table, $data)) {
            echo json_encode(['message' => 'Data berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Gagal menambahkan data']);
        }
    }


    private function updateHistory($table, $id = NULL)
    {
        // Ambil ID dari query string jika tidak diberikan di parameter
        if (!$id) {
            $id = $_GET['id'] ?? NULL;
        }

        if (!$id) {
            echo json_encode(['message' => 'ID tidak ditemukan']);
            return;
        }

        // Ambil data dari JSON body, $_POST, atau $_GET
        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, true);

        if (!$data) {
            $data = $_POST ?: $_GET;
        }

        if (empty($data)) {
            echo json_encode(['message' => 'Data kosong, tidak ada yang diperbarui']);
            return;
        }

        $this->db->where('id', $id);
        if ($this->db->update($table, $data)) {
            echo json_encode(['message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Gagal memperbarui data']);
        }
    }



    private function deleteHistory($table, $id = NULL)
    {
        // Ambil ID dari query string jika tidak diberikan di parameter
        if (!$id) {
            $id = $_GET['id'] ?? NULL;
        }

        if (!$id) {
            echo json_encode(['message' => 'ID tidak ditemukan']);
            return;
        }

        // Periksa apakah data dengan ID tersebut ada
        $this->db->where('id', $id);
        $query = $this->db->get($table);

        if ($query->num_rows() == 0) {
            echo json_encode(['message' => 'Data tidak ditemukan']);
            return;
        }

        // Lakukan proses delete
        $this->db->where('id', $id);
        if ($this->db->delete($table)) {
            echo json_encode(['message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'Gagal menghapus data']);
        }
    }

















    function bacajason()
    {
        $data = $this->db->select('*')->from('status')->limit(1)->order_by('id', 'DESC')->get()->result();
        $response = array("Data" => array());
        foreach ($data as $r) {
            $temp = array(
                "status" => $r->status
            );

            array_push($response["Data"], $temp);
        }
        $data = json_encode($response);
        echo "$data";
    }

    public function kirimdatasensor()
    {
        $isi = array(
            'height'     => $_GET['tinggi'],
            'head'     => $_GET['kepala']
        );
        $this->db->insert('historysesnor_topi', $isi);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo "gagal";
        } else {
            echo "sukses";
        }
    }

    public function kirimdatasensor2()
    {
        $isi = array(
            'mass'     => $_GET['mass']
        );
        $this->db->insert('historysesnor_timbangan', $isi);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo "gagal";
        } else {
            echo "sukses";
        }
    }


    function jason_data_balita($balita_id = null)
    {
        $this->db->select(
            'data_pengukuran.*, 
        tb_balita.nama as nama_balita, 
        tb_balita.jenis_kelamin as gender2, 
        tb_balita.tanggal_lahir as lahir, 
        tb_balita.alamat as alamat2, 
        tb_balita.id_ortu as ortu, 
        user.name as nama_ortu,
        user.email as email_ortu',
        ); // Mengambil nama orang tua

        $this->db->from('data_pengukuran');
        $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left'); // Join dengan tabel user


        // Jika $balita_id diberikan, tambahkan kondisi where
        if ($balita_id !== null) {
            $this->db->where('data_pengukuran.name', $balita_id); // Filter by balita_id
        }

        // Mengambil data
        $datas = $this->db->order_by('id', 'DESC')->get()->result();

        $response = array("Data" => array());

        foreach ($datas as $r) {
            $birth_date = new DateTime($r->lahir);
            $measurement_date = new DateTime($r->date_create);
            $age_interval = $measurement_date->diff($birth_date);
            $age_years = $age_interval->y;
            $age_months = $age_interval->m;
            $result_age_monts = ($age_years * 12) + $age_months;
            $age_display = $age_years . ' tahun, ' . $age_months . ' bulan';



            $bbu = $this->db->select('*')->from('bbu')->where('umur', $result_age_monts)->where('nb', $r->gender2)->get()->result();

            if (!empty($bbu)) {

                $bbu_med = $bbu[0]->Med;

                $bbu_min = $bbu[0]->min;

                $bbu_max = $bbu[0]->max;

                $zbbu = 0;

                $kesimpulan_zbbu = '';

                if ($r->mass == $bbu_med) {

                    $zbbu = 0;
                } else if ($r->mass <= $bbu_med) {

                    $zbbu = number_format((float)((($r->mass - $bbu_med) / ($bbu_med - $bbu_min))), 2, '.', '');
                } else if ($r->mass >= $bbu_med) {

                    $zbbu = number_format((float)((($r->mass - $bbu_med) / ($bbu_med - $bbu_max))), 2, '.', '');
                } else {
                    $zbbu = 0;
                }

                if ($r->mass > $bbu_max) {

                    $kesimpulan_zbbu = 'Risiko Berat Badan';

                    $zbbu = $zbbu * -1;
                } else if ($zbbu >= 1) {

                    $kesimpulan_zbbu = 'Risiko Berat Badan';
                } else if ($zbbu <= -3) {

                    $kesimpulan_zbbu = 'Sangat kekurangan berat badan';
                } else if ($zbbu >= -3 && $zbbu <= -2) {

                    $kesimpulan_zbbu = 'Berat badan kurang';
                } else if ($zbbu >= -2 && $zbbu <= 1) {

                    $kesimpulan_zbbu = 'Normal';
                }

                //echo "1. BB/U = $zbbu <b> ($kesimpulan_zbbu) </b> <br/> <br/>";



                $pbu_tbu = $this->db->select('*')->from('pbu_tbu')->where('umur', $result_age_monts)->where('nb', $r->gender2)->get()->result();

                if (!empty($pbu_tbu)) {
                    $pbu_tbu_med = $pbu_tbu[0]->Med;

                    $pbu_tbu_min = $pbu_tbu[0]->min;

                    $pbu_tbu_max = $pbu_tbu[0]->max;
                } else {
                    $pbu_tbu_med = 0;

                    $pbu_tbu_min = 0;

                    $pbu_tbu_max = 0;
                }

                $zpbu_tbu = 0;

                $kesimpulan_pbu_tbu = '';

                if ($r->height == $pbu_tbu_med) {

                    $zpbu_tbu = 0;
                } else if ($r->height <= $pbu_tbu_med) {

                    $zpbu_tbu = number_format((float)((($r->height - $pbu_tbu_med) / ($pbu_tbu_med - $pbu_tbu_min))), 2, '.', '');
                } else if ($r->height >= $pbu_tbu_med) {

                    $zpbu_tbu = number_format((float)((($r->height - $pbu_tbu_med) / ($pbu_tbu_med - $pbu_tbu_max))), 2, '.', '');
                } else {
                    $zpbu_tbu = 0;
                }

                if ($r->height > $pbu_tbu_max) {

                    $kesimpulan_pbu_tbu = 'Terlalu Tinggi';

                    $zpbu_tbu = $zpbu_tbu * -1;
                } else if ($zpbu_tbu >= 3) {

                    $kesimpulan_pbu_tbu = 'Terlalu Tinggi';
                } else if ($zpbu_tbu <= -3) {

                    $kesimpulan_pbu_tbu = 'Indikasi Stunting';
                } else if ($zpbu_tbu >= -3 && $zpbu_tbu <= -2) {

                    $kesimpulan_pbu_tbu = 'Stunting';
                } else if ($zpbu_tbu >= -2 && $zpbu_tbu <= 3) {

                    $kesimpulan_pbu_tbu = 'Normal';
                }

                //echo "2. PB/U dan TB/U = $zpbu_tbu <b> ($kesimpulan_pbu_tbu) </b> <br/> <br/>";



                $bulan = 0;

                if ($result_age_monts >= 24) {

                    $bulan = 2;
                } else {

                    $bulan = 0;
                }

                $bbpb_bbtb = $this->db->select('*')->from('bbpb_bbtb')->where('umur', $bulan)->where('tinggi', $r->height)->where('nb', $r->gender2)->get()->result();

                if (!empty($bbpb_bbtb)) {
                    $bbpb_bbtb_med = $bbpb_bbtb[0]->Med;

                    $bbpb_bbtb_min = $bbpb_bbtb[0]->min;

                    $bbpb_bbtb_max = $bbpb_bbtb[0]->max;
                } else {
                    $bbpb_bbtb_med = 0;

                    $bbpb_bbtb_min = 0;

                    $bbpb_bbtb_max = 0;
                }

                $zbbpb_bbtb = 0;

                $kesimpulan_bbpb_bbtbu = '';

                if ($r->mass == $bbpb_bbtb_med) {

                    $zbbpb_bbtb = 0;
                } else if ($r->mass <= $bbpb_bbtb_med) {
                    if (($bbpb_bbtb_med - $bbpb_bbtb_min) != 0) {
                        $zbbpb_bbtb = number_format((float)((($r->mass - $bbpb_bbtb_med) / ($bbpb_bbtb_med - $bbpb_bbtb_min))), 2, '.', '');
                    } else {
                        $zbbpb_bbtb = 0;
                    }
                } else if ($r->mass >= $bbpb_bbtb_med) {
                    if (($bbpb_bbtb_med - $bbpb_bbtb_min) != 0) {
                        $zbbpb_bbtb = number_format((float)((($r->mass - $bbpb_bbtb_med) / ($bbpb_bbtb_med - $bbpb_bbtb_max))), 2, '.', '');
                    } else {
                        $zbbpb_bbtb = 0;
                    }
                } else {
                    $zbbpb_bbtb = 0;
                }


                if ($r->mass > $bbpb_bbtb_max) {

                    $kesimpulan_bbpb_bbtbu = 'Kegemukan';

                    $zbbpb_bbtb = $zbbpb_bbtb * -1;
                }

                if ($zbbpb_bbtb >= 1 && $zbbpb_bbtb <= 2) {

                    $kesimpulan_bbpb_bbtbu = 'Risiko Kelebihan Berat Badan';
                } else if ($zbbpb_bbtb >= 3) {

                    $kesimpulan_bbpb_bbtbu = 'Obesitas';
                } else if ($zbbpb_bbtb <= -3) {

                    $kesimpulan_bbpb_bbtbu = 'Sangat Kurus';
                } else if ($zbbpb_bbtb >= -3 && $zbbpb_bbtb <= -2) {

                    $kesimpulan_bbpb_bbtbu = 'Kurus';
                } else if ($zbbpb_bbtb >= -2 && $zbbpb_bbtb <= 1) {

                    $kesimpulan_bbpb_bbtbu = 'Normal';
                }

                //echo "3. BB/PB dan BB/TB = $zbbpb_bbtb <b> ($kesimpulan_bbpb_bbtbu) </b><br/><br/>";



                $tinggi = $r->height / 100;

                $imtu = $this->db->select('*')->from('imtu')->where('umur', $result_age_monts)->where('nb', $r->gender2)->get()->result();

                if ($tinggi != 0) {
                    $imt = $r->mass / pow($tinggi, 2);  // Jika $tinggi tidak 0, lakukan pembagian
                } else {
                    $imt = 0;  // Jika $tinggi = 0, atur nilai menjadi 0 untuk menghindari Division by Zero
                }

                if (!empty($imtu)) {
                    $imtu_med = $imtu[0]->Med;

                    $imtu_min = $imtu[0]->min;

                    $imtu_max = $imtu[0]->max;
                } else {
                    $imtu_med = 0;

                    $imtu_min = 0;

                    $imtu_max = 0;
                }

                $zimtu = 0;

                $kesimpulan_imtu = '';

                if ($imt == $imtu_med) {

                    $zimtu = 0;
                } else if ($imt <= $imtu_med) {

                    $zimtu = number_format((float)((($imt - $imtu_med) / ($imtu_med - $imtu_min))), 2, '.', '');
                } else if ($imt >= $imtu_med) {

                    $zimtu = number_format((float)((($imt - $imtu_med) / ($imtu_med - $imtu_max))), 2, '.', '');
                } else {
                    $zimtu = 0;
                }

                if ($imt > $imtu_max) {

                    $kesimpulan_imtu = 'Kegemukan';

                    $zimtu = $zimtu * -1;
                }

                if ($zimtu >= 1 && $zimtu <= 2) {

                    $kesimpulan_imtu = 'Risiko Kelebihan Berat Badan';
                }

                if ($zimtu >= 3) {

                    $kesimpulan_imtu = 'Obesitas';
                } else if ($zimtu <= -3) {

                    $kesimpulan_imtu = 'Sangat Kurus';
                } else if ($zimtu >= -3 && $zimtu <= -2) {

                    $kesimpulan_imtu = 'Kurus';
                } else if ($zimtu >= -2 && $zimtu <= 1) {

                    $kesimpulan_imtu = 'Normal';
                }

                //echo "4. IMT/U = $zimtu <b> ($kesimpulan_imtu) </b> <br/><br/>";



                $headu = $this->db->select('*')->from('headu')->where('umur', $result_age_monts)->where('nb', $r->gender2)->get()->result();

                if (!empty($headu)) {
                    $headu_med = $headu[0]->Med;

                    $headu_min = $headu[0]->min;

                    $headu_max = $headu[0]->max;
                } else {
                    $headu_med = 0;

                    $headu_min = 0;

                    $headu_max = 0;
                }

                $zheadu = 0;

                $kesimpulan_zheadu = '';

                if ($r->head == $headu_med) {

                    $zheadu = 0;
                } else if ($r->head <= $headu_med) {

                    $zheadu = number_format((float)((($r->head - $headu_med) / ($headu_med - $headu_min))), 2, '.', '');
                } else if ($r->head >= $headu_med) {

                    $zheadu = number_format((float)((($r->head - $headu_med) / ($headu_med - $headu_max))), 2, '.', '');
                } else {
                    $zheadu = 0;
                }

                if ($r->head > $headu_max) {

                    $kesimpulan_zheadu = 'Risiko Berat Badan';

                    $zheadu = $zheadu * -1;
                } else if ($zheadu >= 1) {

                    $kesimpulan_zheadu = 'Risiko Berat Badan';
                } else if ($zheadu <= -3) {

                    $kesimpulan_zheadu = 'Sangat kekurangan berat badan';
                } else if ($zheadu >= -3 && $zheadu <= -2) {

                    $kesimpulan_zheadu = 'Berat badan kurang';
                } else if ($zheadu >= -2 && $zheadu <= 1) {

                    $kesimpulan_zheadu = 'Normal';
                }

                //echo "5. LK/U =  $zheadu <b> ($kesimpulan_zheadu) </b><br/><br/>";
            } else {

                //echo "<b> Error: Max 5 tahun </b>";
            }


            if (!empty($kesimpulan_zbbu)) {
                $kesimpulan_zbbu = $kesimpulan_zbbu;
            } else {
                $kesimpulan_zbbu = "Error";
            }
            if (!empty($kesimpulan_imtu)) {
                $kesimpulan_imtu = $kesimpulan_imtu;
            } else {
                $kesimpulan_imtu = "Error";
            }
            if (!empty($kesimpulan_pbu_tbu)) {
                $kesimpulan_pbu_tbu = $kesimpulan_pbu_tbu;
            } else {
                $kesimpulan_pbu_tbu = "Error";
            }
            if (!empty($kesimpulan_bbpb_bbtbu)) {
                $kesimpulan_bbpb_bbtbu = $kesimpulan_bbpb_bbtbu;
            } else {
                $kesimpulan_bbpb_bbtbu = "Error";
            }
            if (!empty($kesimpulan_imtu)) {
                $kesimpulan_imtu = $kesimpulan_imtu;
            } else {
                $kesimpulan_imtu = "Error";
            }


            $temp = array(

                "email" => $r->email_ortu,
                "balita_id" => $r->name,
                "nama" => $r->nama_balita,
                "jenis_kelamin" => $r->gender2,
                "tanggal_lahir" => $r->lahir,
                "orang_tua" => $r->nama_ortu,
                "id_ortu" => $r->ortu,
                "alamat" => $r->alamat2,
                "tanggal_pengukuran" => $r->date_create,
                "umur" => $age_display,
                "berat_badan" => $r->mass,
                "tinggi_badan" => $r->height,
                "lingkar_kepala" => $r->head,
                "BB/U" => $zbbu,
                "kesimpulan_zbbu" => $kesimpulan_zbbu,
                "PB/U_dan_TB/U" => $zpbu_tbu,
                "kesimpulan_pbu_tbu" => $kesimpulan_pbu_tbu,
                "BB/PB_dan_BB/TB" => $zbbpb_bbtb,
                "kesimpulan_bbpb_bbtbu" => $kesimpulan_bbpb_bbtbu,
                "IMT/U" => $zimtu,
                "kesimpulan_imtu" => $kesimpulan_imtu,
                "LK/U" => $zheadu,
                "kesimpulan_zheadu" => $kesimpulan_zheadu,

                "Kesimpulan_Berat_Badan1" => $kesimpulan_zbbu,
                "Kesimpulan_Berat_Badan2" => $kesimpulan_imtu,

                "Kesimpulan_Tinggi_Badan" => $kesimpulan_pbu_tbu,


                "Kesimpulan_Nutrisi1" => $kesimpulan_bbpb_bbtbu,
                "Kesimpulan_Nutrisi2" => $kesimpulan_imtu

            );

            array_push($response["Data"], $temp);
        }
        $data = json_encode($response);
        echo "$data";
    }


    public function data_jadwal()
    {
        $data = $this->M_jadwal->jadwal_list();
        echo json_encode($data);
    }

    public function data_artikel()
    {
        $data = $this->M_jadwal->artikel_list();

        // Pastikan hanya JSON yang di-echo
        header('Content-Type: application/json');
        echo json_encode($data);
    }



    public function login()
    {
        // Memeriksa apakah request adalah POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Query untuk memeriksa email
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('email', $email);
            $user_result = $this->db->get();

            if ($user_result->num_rows() > 0) {
                $user = $user_result->row_array();

                // Memverifikasi password
                if (password_verify($password, $user['password'])) {
                    if ($user['role_id'] == 2) {
                        // Jika role_id = 2, ambil data balita dan data pengukuran untuk ortu ini
                        $this->db->select('tb_balita.*, user.name as nama_ortu, user.email as email_ortu, COUNT(data_pengukuran.id) as jumlah_pengukuran');
                        $this->db->from('tb_balita');
                        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');
                        $this->db->join('data_pengukuran', 'data_pengukuran.name = tb_balita.id', 'left');
                        $this->db->where('user.role_id', 2);
                        $this->db->where('user.id', $user['id']); // Filter dengan ID orang tua yang login
                        $this->db->group_by('tb_balita.id'); // Grupkan berdasarkan balita ID

                        $balita_data = $this->db->get()->result();

                        $response_data = array();
                        foreach ($balita_data as $r) {
                            $temp = array(
                                "email" => $r->email_ortu,
                                "id_ortu" => $r->id_ortu,
                                "nama_ortu" => $r->nama_ortu,
                                "nama_balita" => $r->nama,
                                "id_balita" => $r->id,
                                "jumlah_balita" => count($balita_data),
                                "jumlah_pengukuran" => $r->jumlah_pengukuran
                            );
                            array_push($response_data, $temp);
                        }

                        // Respons JSON jika login sebagai orang tua dengan data balita
                        $response = array(
                            'status' => 'success',
                            'message' => 'Login successful',
                            'Data' => $response_data
                        );
                    } else {
                        // Respons jika role_id bukan 2
                        $response = array(
                            'status' => 'error',
                            'message' => 'Email tidak ditemukan'
                        );
                    }
                } else {
                    // Respons jika password salah
                    $response = array(
                        'status' => 'error',
                        'message' => 'Password salah'
                    );
                }
            } else {
                // Respons jika email tidak ditemukan
                $response = array(
                    'status' => 'error',
                    'message' => 'Email tidak ditemukan'
                );
            }
            echo json_encode($response);
        } else {
            // Respons jika request bukan POST
            echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        }
    }
}
