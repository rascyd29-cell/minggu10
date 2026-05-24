<?php

class Laporan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('DataMakanan_model');
        $this->load->model('Sub_menu_model');
        is_logged_in();
    }


    public function index()
    {
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // Pastikan data user ditemukan
        if ($datas['user']) {
            $id_ortu = $datas['user']['id']; // Mengambil ID orang tua dari user yang login

            // Query data dengan join antara data_pengukuran, tb_balita, dan user berdasarkan ID orang tua
            $this->db->select('data_pengukuran.*, 
                           tb_balita.nama as nama_balita, 
                           tb_balita.jenis_kelamin as gender2, 
                           tb_balita.tanggal_lahir as lahir, 
                           tb_balita.alamat as alamat2, 
                           tb_balita.id_ortu as ortu, 
                           user.name as nama_ortu'); // Mengambil nama orang tua
            $this->db->from('data_pengukuran');
            $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
            $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');

            // Filter data berdasarkan ID orang tua
            $this->db->where('tb_balita.id_ortu', $id_ortu);

            // Mengambil data dan urutkan
            $datas['data'] = $this->db->order_by('data_pengukuran.id', 'DESC')->get()->result();
        } else {
            $datas['data'] = []; // Jika user tidak ditemukan, tampilkan data kosong atau pesan error
            echo "<b>Data user tidak ditemukan atau belum login.</b><br/>";
        }


        $datas['title'] = 'Hasil';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $datas);
        $this->load->view('templates/sidebar', $datas);
        $this->load->view('templates/topbar', $datas);
        $this->template->load('template1', 'laporan/index', $datas);
    }

    public function rekomendasi($id)
    {
        // Join data
        $this->db->select('data_pengukuran.*, 
        tb_balita.nama as nama_balita, 
        tb_balita.jenis_kelamin as gender2, 
        tb_balita.tanggal_lahir as lahir, 
        tb_balita.alamat as alamat2, 
        tb_balita.id_ortu as ortu, 
        user.name as nama_ortu');
        $this->db->from('data_pengukuran');
        $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');
        $this->db->where('data_pengukuran.id', $id); // Filter berdasarkan $id
        $datas['data'] = $this->db->order_by('id', 'DESC')->get()->result();

        // =====================INPUTAN USER=========================== //
        foreach ($datas['data'] as $u) {
            $birth_date = new DateTime($u->lahir);
            $measurement_date = new DateTime($u->date_create);
            $age_interval = $measurement_date->diff($birth_date);
            $age_years = $age_interval->y;
            $age_months = $age_interval->m;
            $result_age_monts = ($age_years * 12) + $age_months;


            $umur = (float) $result_age_monts / 12;
            $jeniskelamin = $u->gender2;
            $beratbadan = $u->mass;
            $aktivitas = $u->aktivitas;
            $stress = $u->stress;
        }

        $komponen_input = [$umur, $jeniskelamin, $beratbadan, $aktivitas, $stress];

        // =====================INPUTAN USER=========================== //

        $nilaibmr = 0;
        $nilaiaktivitas = 0;
        $nilaistress = 0;
        $nilaiisipiring = 0;
        // ================MENGHITUNG BMR BALITA=======================
        switch ($umur) {
            case ($umur >= 0 && $umur <= 3):
                // Kategori umur 0-3
                if ($jeniskelamin == 'Laki-laki') {
                    $nilaibmr = 60.9 * $beratbadan - 54;
                }
                if ($jeniskelamin == 'Perempuan') {
                    $nilaibmr = 61.0 * $beratbadan - 51;
                }

                break;

            case ($umur > 3 && $umur <= 10):
                // Kategori umur 3-10
                if ($jeniskelamin == 'Laki-laki') {
                    $nilaibmr = 22.7 * $beratbadan + 495;
                }
                if ($jeniskelamin == 'Perempuan') {
                    $nilaibmr = 22.5 * $beratbadan + 499;
                }
                break;
            default:
                break;
        }

        //===============LOGIKA AKTIVITAS=============================
        switch ($aktivitas) {
            case 'bedrest':
                $nilaiaktivitas = 1.0;
                break;
            case 'gerakterbatas':
                $nilaiaktivitas = 1.2;
                break;
            case 'bisajalan':
                $nilaiaktivitas = 1.5;
                break;
            case 'normal':
                $nilaiaktivitas = 1.7;
                break;
            default:
                $nilaiaktivitas = 1.0;
                break;
        }

        //================LOGIKA FAKTOR STRESS======================
        switch ($stress) {
            case 'tidakada':
                $nilaistress = 1;
                break;
            case 'operasi':
                $nilaistress = (1 + 1.2) / 2;
                break;
            case 'trauma':
                $nilaistress = (1.2 + 1.6) / 2;
                break;
            case 'infeksi':
                $nilaistress = (1.2 + 1.6) / 2;
                break;
            case 'peradangan':
                $nilaistress = (1.05 + 1.25) / 2;
                break;
            case 'patahtulang':
                $nilaistress = (1.1 + 1.3) / 2;
                break;
            case 'infeksi':
                $nilaistress = (1.3 + 1.5) / 2;
                break;
            case 'sepsis':
                $nilaistress = (1.2 + 1.5) / 2;
                break;
            case 'cederakepala':
                $nilaistress = 1.3;
                break;
            case 'kanker':
                $nilaistress = (1.1 + 1.45) / 2;
                break;
            default:
                $nilaistress = 1.0;
                break;
        }

        //===================PERHITUNGAN TOTAL KALORI================//
        $tdee = $nilaibmr * $nilaiaktivitas * $nilaistress;

        $makanPagi = 25 / 100 * $tdee;
        $selinganPagi = 10 / 100 * $tdee;
        $makanSiang = 30 / 100 * $tdee;
        $selinganSore = 10 / 100 * $tdee;
        $makanMalam = 25 / 100 * $tdee;

        $nilaiWaktu = [$makanPagi, $selinganPagi, $makanSiang, $selinganSore, $makanMalam];

        //========LOGIKA RUMUS PERSENTASE ISI PIRINGKU 2-5 TAHUN======//
        //pagi
        $makananPokok = $makanPagi * 35 / 100;
        $lauk         = $makanPagi * 35 / 100;
        $sayur        = $makanPagi * 15 / 100;
        $buah         = $makanPagi * 15 / 100;
        //siang
        $makananPokokS = $makanSiang * 35 / 100;
        $laukS         = $makanSiang * 35 / 100;
        $sayurS        = $makanSiang * 15 / 100;
        $buahS         = $makanSiang * 15 / 100;
        //malam
        $makananPokokM = $makanMalam * 35 / 100;
        $laukM         = $makanMalam * 35 / 100;
        $sayurM        = $makanMalam * 15 / 100;
        $buahM         = $makanMalam * 15 / 100;

        $nilaiisipiring = [$makananPokok, $lauk, $sayur, $buah, $makananPokokS, $laukS, $sayurS, $buahS, $makananPokokM, $laukM, $sayurM, $buahM];

        // NILAI PRESENTASE DIKIRIM KE FUNGSI SHOW UNTUK MENAMPILKAN DETAIL //
        $this->session->set_userdata('makananPokok_pagi', $makananPokok);
        $this->session->set_userdata('lauk_pagi', $lauk);
        $this->session->set_userdata('sayur_pagi', $sayur);
        $this->session->set_userdata('buah_pagi', $buah);

        $this->session->set_userdata('makananPokok_siang', $makananPokokS);
        $this->session->set_userdata('lauk_siang', $laukS);
        $this->session->set_userdata('sayur_siang', $sayurS);
        $this->session->set_userdata('buah_siang', $buahS);

        $this->session->set_userdata('makananPokok_malam', $makananPokokM);
        $this->session->set_userdata('lauk_malam', $laukM);
        $this->session->set_userdata('sayur_malam', $sayurM);
        $this->session->set_userdata('buah_malam', $buahM);

        $this->session->set_userdata('selingan_pagi', $selinganPagi);
        $this->session->set_userdata('selingan_sore', $selinganSore);
        // NILAI PRESENTASE DIKIRIM KE FUNGSI SHOW UNTUK MENAMPILKAN DETAIL //

        //======== MENAMPILKAN PAKET MAKANAN YANG TERSEDIA =====//
        $query = $this->DataMakanan_model->getDistinctPaket();

        //========PERHITUNGAN TABEL ALTERNATIF(TOTAL PROTEIN, TOTAL KARBO, TOTAL LEMAK DAN TOTAL ENERGI)=====//

        //==================QUERY MENGAMBIL SEMUA PAKET MAKANAN=================//
        $paketList = $this->DataMakanan_model->getDistinctPaket();

        $allJoinData = [];
        foreach ($paketList as $paket) {
            // Asumsikan $paket adalah objek stdClass dengan properti 'paket'
            $joindata = $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, sub_menu.nama_makanan, sub_menu.jenis_makanan, sub_menu.protein, sub_menu.karbohidrat, sub_menu.lemak, sub_menu.energi')
                ->from('data_makanan')
                ->join('sub_menu', 'sub_menu.Data_makanan_idData_makanan = data_makanan.idData_makanan')
                ->where('data_makanan.paket', $paket->paket) // Mengakses properti 'paket'
                ->get()->result();

            $allJoinData[$paket->paket] = $joindata; // Menggunakan properti 'paket' sebagai key
        }

        //die(print_r($allJoinData));
        //==================QUERY MENGAMBIL SEMUA PAKET MAKANAN=================//

        //=============MENGAMBIL NILAI ENERGI=========//
        $simpan = [];
        $subArray = [];
        $counter = 0;
        foreach ($allJoinData as $key => $values) {
            foreach ($values as $value) {
                $subArray[] = $value->energi;
                $counter++;

                if ($counter == 12) {
                    $simpan[] = $subArray;
                    $subArray = []; // Reset sub-array
                    $counter = 0; // Reset counter
                }
            }
        }

        //=============MENGAMBIL NILAI BERAT=========//
        // Simpan merupakan variabel dari energi
        $Berat = [];
        foreach ($simpan as $key => $value) {
            $Berat[$key] = [
                ($makananPokok / $value[0]) * 100,
                ($lauk /  $value[1]) * 100,
                ($sayur /  $value[2]) * 100,
                ($buah /  $value[3]) * 100,

                ($makananPokokS /  $value[4]) * 100,
                ($laukS /  $value[5]) * 100,
                ($sayurS /  $value[6]) * 100,
                ($buahS / $value[7]) * 100,

                ($makananPokokM /  $value[8]) * 100,
                ($laukM /  $value[9]) * 100,
                ($sayurM /  $value[10]) * 100,
                ($buahM /  $value[11]) * 100,
            ];
        }

        //==========MENGAMBIL NILAI PROTEIN==============//
        $nilai = [];
        $isi_array = [];
        $counterr = 0;

        foreach ($allJoinData as $key => $dt) {
            foreach ($dt as $dta) {
                $isi_array[] = $dta->protein;
                $counterr++;

                if ($counterr == 12) {
                    $nilai[] = $isi_array;
                    $isi_array = [];
                    $counterr = 0;
                }
            }
        }

        //============RUMUS MENCARI NILAI PROTEIN=========//
        $Protein = [];
        foreach ($Berat as $key => $values) {
            foreach ($values as $index => $value) {
                $Protein[$key][] = ($value / 100) * $nilai[$key][$index];
            }
        }

        //===================TOTAL PROTIN====================//
        $totalProtein = [];
        foreach ($Protein as $key => $value) {
            $totalProtein[$key] = array_sum($value);
        }

        // ==============================================================================================//
        //**************** MENCARI TOTAL KARBO ***********************//
        // ==============================================================================================//

        //==========MENGAMBIL NILAI kARBOHIDRAT==============//
        $karbo = [];
        $isi_array = [];
        $counterr = 0;

        foreach ($allJoinData as $key => $dt) {
            foreach ($dt as $dta) {
                $isi_array[] = $dta->karbohidrat;
                $counterr++;

                if ($counterr == 12) {
                    $karbo[] = $isi_array;
                    $isi_array = [];
                    $counterr = 0;
                }
            }
        }

        //============RUMUS MENCARI NILAI PROTEIN=========//
        $Karbohidrat = [];
        foreach ($Berat as $key => $values) {
            foreach ($values as $index => $value) {
                $Karbohidrat[$key][] = ($value / 100) * $karbo[$key][$index];
            }
        }

        //===================TOTAL PROTIN====================//
        $totalKarbohidrat = [];
        foreach ($Karbohidrat as $key => $value) {
            $totalKarbohidrat[$key] = array_sum($value);
        }

        // ==============================================================================================//
        //**************** MENCARI TOTAL LEMAK ***********************//
        // ==============================================================================================//

        //==========MENGAMBIL NILAI LEMAK==============//
        $lemak = [];
        $isi_array = [];
        $counterr = 0;

        foreach ($allJoinData as $key => $dt) {
            foreach ($dt as $dta) {
                $isi_array[] = $dta->lemak;
                $counterr++;

                if ($counterr == 12) {
                    $lemak[] = $isi_array;
                    $isi_array = [];
                    $counterr = 0;
                }
            }
        }

        //============RUMUS MENCARI NILAI PROTEIN=========//
        $Lemak = [];
        foreach ($Berat as $key => $values) {
            foreach ($values as $index => $value) {
                $Lemak[$key][] = ($value / 100) * $lemak[$key][$index];
            }
        }

        //===================TOTAL PROTIN====================//
        $totalLemak = [];
        foreach ($Lemak as $key => $value) {
            $totalLemak[$key] = array_sum($value);
        }

        // ==============================================================================================//
        //**************** MENCARI TOTAL ENERGI ***********************//
        // ==============================================================================================//

        //==========MENGAMBIL NILAI ENERGI==============//
        $energi = [];
        $isi_array = [];
        $counterr = 0;

        foreach ($allJoinData as $key => $dt) {
            foreach ($dt as $dta) {
                $isi_array[] = $dta->energi;
                $counterr++;

                if ($counterr == 12) {
                    $energi[] = $isi_array;
                    $isi_array = [];
                    $counterr = 0;
                }
            }
        }

        //============RUMUS MENCARI NILAI PROTEIN=========//
        $Energi = [];
        foreach ($Berat as $key => $values) {
            foreach ($values as $index => $value) {
                $Energi[$key][] = ($value / 100) * $energi[$key][$index];
            }
        }

        //===================TOTAL PROTEIN====================//
        $totalEnergi = [];
        foreach ($Energi as $key => $value) {
            $totalEnergi[$key] = array_sum($value);
        }

        // ==============================================================================================//
        //**************** MENGHITUNG TOTAL SELINGAN ***********************//
        // ==============================================================================================//

        //===================QUERY JOIN DATAMAKANAN => SELINGAN====================//
        $allSelingan = [];
        foreach ($paketList as $paket) {
            // Asumsikan $paket adalah objek stdClass dengan properti 'paket'
            $joindata = $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, selingan.nama_selingan, selingan.protein, selingan.karbohidrat, selingan.lemak, selingan.energi')
                ->from('data_makanan')
                ->join('selingan', 'selingan.Data_makanan_idData_makanan = data_makanan.idData_makanan')
                ->where('data_makanan.paket', $paket->paket) // Mengakses properti 'paket'
                ->get()->result();

            $allSelingan[$paket->paket] = $joindata; // Menggunakan properti 'paket' sebagai key
        }
        //===================QUERY JOIN DATAMAKANAN => SELINGAN====================//

        //===================RUMUS MENGHITUNG BERAT SELINGAN====================//
        $beratSelingan = [];
        foreach ($allSelingan as $key => $values) {
            foreach ($values as $value) {
                $waktuMakan = $value->waktu_makan;
                if ($waktuMakan == 'selingan pagi') {
                    $beratSelingan[$key][] = ($selinganPagi / $value->energi) * 100;
                } else {
                    $beratSelingan[$key][] = ($selinganSore / $value->energi) * 100;
                }
            }
        }

        //===================MENGAMBIL NILAI PROTEIN====================//
        $protein_selingan = [];
        foreach ($allSelingan as $paket => $items) {
            foreach ($items as $item) {
                if (!isset($protein_selingan[$paket])) {
                    $protein_selingan[$paket] = [];
                }
                $protein_selingan[$paket][] = $item->protein;
            }
        }

        //===================RUMUS MENGHITUNG PROTEIN SELINGAN====================//
        $ProteinSelingan = [];
        foreach ($beratSelingan as $key => $values) {
            foreach ($values as $index => $berat) {
                if (isset($protein_selingan[$key][$index])) {
                    $ProteinSelingan[$key][] = ($berat / 100) * $protein_selingan[$key][$index];
                }
            }
        }

        //===================MENJUMLAHKAN PROTEIN PERPAKET====================//
        $totalSelingan_Protein = [];
        foreach ($ProteinSelingan as $key => $values) {
            $totalSelingan_Protein[$key] = array_sum($values);
        }

        //===================MENJUMLAHKAN TOTMAKANAN + TOTSELINGAN====================//
        $JumlahTotal_Protein = [];
        $indexSelingan = array_values($totalSelingan_Protein); //Merubah index array ke numeric
        for ($i = 0; $i < count($indexSelingan); $i++) {
            $JumlahTotal_Protein[$i] = $totalProtein[$i] + $indexSelingan[$i];
        }

        // ==============================================================================================//
        //**************** MENGHITUNG TOTAL JUMLAH KARBOHIDRAT  ***********************//
        // ==============================================================================================//

        //===================MENGAMBIL NILAI KARBOHIDRAT====================//
        $karbo_selingan = [];
        foreach ($allSelingan as $paket => $items) {
            foreach ($items as $item) {
                if (!isset($karbo_selingan[$paket])) {
                    $karbo_selingan[$paket] = [];
                }
                $karbo_selingan[$paket][] = $item->karbohidrat;
            }
        }

        //===================RUMUS MENGHITUNG KARBO SELINGAN====================//
        $KarboSelingan = [];
        foreach ($beratSelingan as $key => $values) {
            foreach ($values as $index => $berat) {
                if (isset($karbo_selingan[$key][$index])) {
                    $KarboSelingan[$key][] = ($berat / 100) * $karbo_selingan[$key][$index];
                }
            }
        }

        //===================MENJUMLAHKAN KARBO PERPAKET====================//
        $totalSelingan_Karbo = [];
        foreach ($KarboSelingan as $key => $values) {
            $totalSelingan_Karbo[$key] = array_sum($values);
        }

        //===================MENJUMLAHKAN TOTMAKANAN + TOTSELINGAN====================//
        $JumlahTotal_Karbo = [];
        $indexSelingan = array_values($totalSelingan_Karbo); //Merubah index array ke numeric
        for ($i = 0; $i < count($indexSelingan); $i++) {
            $JumlahTotal_Karbo[$i] = $totalKarbohidrat[$i] + $indexSelingan[$i];
        }

        // ==============================================================================================//
        //**************** MENGHITUNG TOTAL JUMLAH LEMAK  ***********************//
        // ==============================================================================================//

        //===================MENGAMBIL NILAI LEMAK====================//
        $lemak_selingan = [];
        foreach ($allSelingan as $paket => $items) {
            foreach ($items as $item) {
                if (!isset($lemak_selingan[$paket])) {
                    $lemak_selingan[$paket] = [];
                }
                $lemak_selingan[$paket][] = $item->lemak;
            }
        }

        //===================RUMUS MENGHITUNG LEMAK SELINGAN====================//
        $LemakSelingan = [];
        foreach ($beratSelingan as $key => $values) {
            foreach ($values as $index => $berat) {
                if (isset($lemak_selingan[$key][$index])) {
                    $LemakSelingan[$key][] = ($berat / 100) * $lemak_selingan[$key][$index];
                }
            }
        }

        //===================MENJUMLAHKAN KARBO PERPAKET====================//
        $totalSelingan_Lemak = [];
        foreach ($LemakSelingan as $key => $values) {
            $totalSelingan_Lemak[$key] = array_sum($values);
        }

        //===================MENJUMLAHKAN TOTMAKANAN + TOTSELINGAN====================//
        $JumlahTotal_Lemak = [];
        $indexSelingan = array_values($totalSelingan_Lemak); //Merubah index array ke numeric
        for ($i = 0; $i < count($indexSelingan); $i++) {
            $JumlahTotal_Lemak[$i] = $totalLemak[$i] + $indexSelingan[$i];
        }

        // ==============================================================================================//
        //**************** MENGHITUNG TOTAL JUMLAH ENERGI  ***********************//
        // ==============================================================================================//

        //===================MENGAMBIL NILAI LEMAK====================//
        $energi_selingan = [];
        foreach ($allSelingan as $paket => $items) {
            foreach ($items as $item) {
                if (!isset($energi_selingan[$paket])) {
                    $energi_selingan[$paket] = [];
                }
                $energi_selingan[$paket][] = $item->energi;
            }
        }

        //===================RUMUS MENGHITUNG LEMAK SELINGAN====================//
        $EnergiSelingan = [];
        foreach ($beratSelingan as $key => $values) {
            foreach ($values as $index => $berat) {
                if (isset($energi_selingan[$key][$index])) {
                    $EnergiSelingan[$key][] = ($berat / 100) * $energi_selingan[$key][$index];
                }
            }
        }

        //===================MENJUMLAHKAN KARBO PERPAKET====================//
        $totalSelingan_Energi = [];
        foreach ($EnergiSelingan as $key => $values) {
            $totalSelingan_Energi[$key] = array_sum($values);
        }

        //===================MENJUMLAHKAN TOTMAKANAN + TOTSELINGAN====================//
        $JumlahTotal_Energi = [];
        $indexSelingan = array_values($totalSelingan_Energi); //Merubah index array ke numeric
        for ($i = 0; $i < count($indexSelingan); $i++) {
            $JumlahTotal_Energi[$i] = $totalEnergi[$i] + $indexSelingan[$i];
        }

        //===============LOGIKA BOBOT KRITERIA=======================================//
        // Data kriteria
        $kriteria = [
            ['kriteria' => 'protein', 'kode' => 'C1', 'bobot' => 0.6],
            ['kriteria' => 'karbohidrat', 'kode' => 'C2', 'bobot' => 0.25],
            ['kriteria' => 'lemak', 'kode' => 'C3', 'bobot' => 0.25],
        ];
        // Menghitung total bobot
        $totalBobot = array_sum(array_column($kriteria, 'bobot'));

        // Membuat fungsi untuk menghitung bobot kepentingan berdasarkan kode kriteria
        // Data kriteria
        $kriteria = [
            ['kriteria' => 'protein', 'kode' => 'C1', 'bobot' => 0.6],
            ['kriteria' => 'karbohidrat', 'kode' => 'C2', 'bobot' => 0.25],
            ['kriteria' => 'lemak', 'kode' => 'C3', 'bobot' => 0.25],
        ];

        // Menghitung total bobot
        $totalBobot = array_sum(array_column($kriteria, 'bobot'));

        // Pilih salah satu metode di bawah ini untuk menghitung bobot kriteria

        // Metode 1: Menggunakan foreach
        $bobotKriteria = [];
        foreach ($kriteria as $item) {
            $bobotKriteria[$item['kode']] = $item['bobot'] / $totalBobot;
        }

        // Atau Metode 2: Menggunakan array_map()
        $bobotKriteria = array_combine(
            array_column($kriteria, 'kode'),
            array_map(function ($item) use ($totalBobot) {
                return $item['bobot'] / $totalBobot;
            }, $kriteria)
        );

        // Menghitung vektor S
        $hasil = [];
        for ($i = 0; $i < count($query); $i++) {
            $nilaiC1 = $JumlahTotal_Protein[$i];
            $nilaiC2 = $JumlahTotal_Karbo[$i];
            $nilaiC3 = $JumlahTotal_Lemak[$i];

            $bobotC1 = $bobotKriteria['C1'];
            $bobotC2 = $bobotKriteria['C2'];
            $bobotC3 = $bobotKriteria['C3'];

            $hasil[$i] = pow($nilaiC1, $bobotC1) * pow($nilaiC2, $bobotC2) * pow($nilaiC3, $bobotC3);
        }
        // Total semua vektor S
        $totalVektorS = array_sum($hasil);

        // Menghitung vektor V
        $vektorV = [];
        for ($i = 0; $i < count($hasil); $i++) {
            $vektorV[$i] = $hasil[$i] / $totalVektorS;
        }

        // Melabeli nilai dengan ABC
        $pengurutan = [];
        $labels = $this->DataMakanan_model->getDistinctPaket2();
        for ($i = 0; $i < count($vektorV); $i++) {
            $pengurutan[$i] = ['label' => $labels[$i]['paket'], 'value' => $vektorV[$i]];
        }

        // Mengurutkan vektor V secara menurun
        usort($pengurutan, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });

        // Menyimpan hasil pengurutan ke dalam variabel
        $hasilPengurutan = $pengurutan;


        // Load view dengan data yang diperlukan
        $data['nilaibmr'] = $nilaibmr;
        $data['tdee'] = $tdee;
        $data['nilaiWaktu'] = $nilaiWaktu;
        $data['komponen_input'] = $komponen_input;
        $data['nilaiisipiring'] = $nilaiisipiring;
        $data['query'] = $query;
        $data['JumlahTotal_Protein'] = $JumlahTotal_Protein;
        $data['JumlahTotal_Karbo'] = $JumlahTotal_Karbo;
        $data['JumlahTotal_Lemak'] = $JumlahTotal_Lemak;
        $data['JumlahTotal_Energi'] = $JumlahTotal_Energi;
        $data['kriteria'] = $kriteria;
        $data['totalBobot'] = $totalBobot;
        $data['bobotKriteria'] = $bobotKriteria;
        $data['hasil'] = $hasil;
        $data['totalVektorS'] = $totalVektorS;
        $data['vektorV'] = $vektorV;
        $data['hasilPengurutan'] = $hasilPengurutan;

        $data['title'] = 'Hasil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->template->load('template1', 'laporan/spk', $data);
    }

    public function show($paket)
    {
        // Query join datamakanan dan submenu
        $joindata = $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, sub_menu.nama_makanan, sub_menu.jenis_makanan, sub_menu.protein, sub_menu.karbohidrat, sub_menu.lemak, sub_menu.energi')
            ->from('data_makanan')
            ->join('sub_menu', 'sub_menu.Data_makanan_idData_makanan = data_makanan.idData_makanan')
            ->where('data_makanan.paket', $paket)
            ->get()->result();

        // Ambil nilai-nilai dari session untuk makan pagi
        $makananPokok_pagi = $this->session->userdata('makananPokok_pagi');
        $lauk_pagi = $this->session->userdata('lauk_pagi');
        $sayur_pagi = $this->session->userdata('sayur_pagi');
        $buah_pagi = $this->session->userdata('buah_pagi');

        // Ambil nilai-nilai dari session untuk makan siang
        $makananPokok_siang = $this->session->userdata('makananPokok_siang');
        $lauk_siang = $this->session->userdata('lauk_siang');
        $sayur_siang = $this->session->userdata('sayur_siang');
        $buah_siang = $this->session->userdata('buah_siang');

        // Ambil nilai-nilai dari session untuk makan malam
        $makananPokok_malam = $this->session->userdata('makananPokok_malam');
        $lauk_malam = $this->session->userdata('lauk_malam');
        $sayur_malam = $this->session->userdata('sayur_malam');
        $buah_malam = $this->session->userdata('buah_malam');

        $Berat = [
            ($makananPokok_pagi / $joindata[0]->energi) * 100,
            ($lauk_pagi / $joindata[1]->energi) * 100,
            ($sayur_pagi / $joindata[2]->energi) * 100,
            ($buah_pagi / $joindata[3]->energi) * 100,

            ($makananPokok_siang / $joindata[4]->energi) * 100,
            ($lauk_siang / $joindata[5]->energi) * 100,
            ($sayur_siang / $joindata[6]->energi) * 100,
            ($buah_siang / $joindata[7]->energi) * 100,

            ($makananPokok_malam / $joindata[8]->energi) * 100,
            ($lauk_malam / $joindata[9]->energi) * 100,
            ($sayur_malam / $joindata[10]->energi) * 100,
            ($buah_malam / $joindata[11]->energi) * 100,
        ];

        $Protein = [
            ($Berat[0] / 100) * $joindata[0]->protein,
            ($Berat[1] / 100) * $joindata[1]->protein,
            ($Berat[2] / 100) * $joindata[2]->protein,
            ($Berat[3] / 100) * $joindata[3]->protein,
            ($Berat[4] / 100) * $joindata[4]->protein,
            ($Berat[5] / 100) * $joindata[5]->protein,
            ($Berat[6] / 100) * $joindata[6]->protein,
            ($Berat[7] / 100) * $joindata[7]->protein,
            ($Berat[8] / 100) * $joindata[8]->protein,
            ($Berat[9] / 100) * $joindata[9]->protein,
            ($Berat[10] / 100) * $joindata[10]->protein,
            ($Berat[11] / 100) * $joindata[11]->protein,
        ];

        $Karbo = [
            ($Berat[0] / 100) * $joindata[0]->karbohidrat,
            ($Berat[1] / 100) * $joindata[1]->karbohidrat,
            ($Berat[2] / 100) * $joindata[2]->karbohidrat,
            ($Berat[3] / 100) * $joindata[3]->karbohidrat,
            ($Berat[4] / 100) * $joindata[4]->karbohidrat,
            ($Berat[5] / 100) * $joindata[5]->karbohidrat,
            ($Berat[6] / 100) * $joindata[6]->karbohidrat,
            ($Berat[7] / 100) * $joindata[7]->karbohidrat,
            ($Berat[8] / 100) * $joindata[8]->karbohidrat,
            ($Berat[9] / 100) * $joindata[9]->karbohidrat,
            ($Berat[10] / 100) * $joindata[10]->karbohidrat,
            ($Berat[11] / 100) * $joindata[11]->karbohidrat,
        ];

        $Lemak = [
            ($Berat[0] / 100) * $joindata[0]->lemak,
            ($Berat[1] / 100) * $joindata[1]->lemak,
            ($Berat[2] / 100) * $joindata[2]->lemak,
            ($Berat[3] / 100) * $joindata[3]->lemak,
            ($Berat[4] / 100) * $joindata[4]->lemak,
            ($Berat[5] / 100) * $joindata[5]->lemak,
            ($Berat[6] / 100) * $joindata[6]->lemak,
            ($Berat[7] / 100) * $joindata[7]->lemak,
            ($Berat[8] / 100) * $joindata[8]->lemak,
            ($Berat[9] / 100) * $joindata[9]->lemak,
            ($Berat[10] / 100) * $joindata[10]->lemak,
            ($Berat[11] / 100) * $joindata[11]->lemak,
        ];

        $Energi = [
            ($Berat[0] / 100) * $joindata[0]->energi,
            ($Berat[1] / 100) * $joindata[1]->energi,
            ($Berat[2] / 100) * $joindata[2]->energi,
            ($Berat[3] / 100) * $joindata[3]->energi,
            ($Berat[4] / 100) * $joindata[4]->energi,
            ($Berat[5] / 100) * $joindata[5]->energi,
            ($Berat[6] / 100) * $joindata[6]->energi,
            ($Berat[7] / 100) * $joindata[7]->energi,
            ($Berat[8] / 100) * $joindata[8]->energi,
            ($Berat[9] / 100) * $joindata[9]->energi,
            ($Berat[10] / 100) * $joindata[10]->energi,
            ($Berat[11] / 100) * $joindata[11]->energi,
        ];

        // Query join datamakanan dan selingan
        $this->db->select('data_makanan.paket, data_makanan.waktu_makan, data_makanan.menu, selingan.protein, selingan.karbohidrat, selingan.lemak, selingan.energi');
        $this->db->from('data_makanan');
        $this->db->join('selingan', 'selingan.Data_makanan_idData_makanan = data_makanan.idData_makanan');
        $this->db->where('data_makanan.paket', $paket);
        $this->db->where_in('data_makanan.waktu_makan', ['selingan pagi', 'selingan sore']);
        $dataSelingan = $this->db->get()->result();

        // Mengambil session selingan
        $selinganPagi = $this->session->userdata('selingan_pagi');
        $selinganSore = $this->session->userdata('selingan_sore');

        // Menghitung berat selingan
        $BeratSelingan = [];
        foreach ($dataSelingan as $key => $value) {
            if ($value->waktu_makan == 'selingan pagi') {
                $BeratSelingan[$key] = ($selinganPagi / $value->energi) * 100;
            } else {
                $BeratSelingan[$key] = ($selinganSore / $value->energi) * 100;
            }
        }

        $ProteinSelingan = [];
        $KarbohidratSelingan = [];
        $LemakSelingan = [];
        $EnergiSelingan = [];

        foreach ($dataSelingan as $key => $value) {
            $ProteinSelingan[$key] = ($BeratSelingan[$key] / 100) * $value->protein;
            $KarbohidratSelingan[$key] = ($BeratSelingan[$key] / 100) * $value->karbohidrat;
            $LemakSelingan[$key] = ($BeratSelingan[$key] / 100) * $value->lemak;
            $EnergiSelingan[$key] = ($BeratSelingan[$key] / 100) * $value->energi;
        }


        // Load the view with the necessary data
        $data['title'] = 'Hasil';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);

        $this->load->view('submenu', compact('joindata', 'Berat', 'Protein', 'Karbo', 'Lemak', 'Energi', 'dataSelingan', 'BeratSelingan', 'ProteinSelingan', 'KarbohidratSelingan', 'LemakSelingan', 'EnergiSelingan'));
    }

    public function search_name()
    {
        $query = $this->input->post('query');
        $this->db->like('nama', $query); // Mencari di kolom 'name'
        $result = $this->db->get('tb_balita')->result();

        $output = '';
        foreach ($result as $user) {
            $output .= '<div class="suggestion-item" data-id="' . htmlspecialchars($user->id) . '" style="padding: 10px; cursor: pointer;">' . htmlspecialchars($user->nama) . '</div>';
        }

        echo $output; // Kembalikan hasil sebagai HTML
    }


    public function export_pdf($id)
    {
        // Query untuk mendapatkan data berdasarkan ID
        $this->db->select('data_pengukuran.*, 
                       tb_balita.nama as nama_balita, 
                       tb_balita.jenis_kelamin as gender2, 
                       tb_balita.tanggal_lahir as lahir, 
                       tb_balita.alamat as alamat2, 
                       tb_balita.id_ortu as ortu, 
                       user.name as nama_ortu');
        $this->db->from('data_pengukuran');
        $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');
        $this->db->where('data_pengukuran.id', $id);


        // Ambil data yang diinginkan
        $data['pengukuran'] = $this->db->get()->row(); // Mengambil satu baris data
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Melakukan join antara data_pengukuran, tb_balita, dan user untuk mendapatkan nama balita dan nama orang tua
        $this->db->select('data_pengukuran.*, 
                       tb_balita.nama as nama_balita, 
                       tb_balita.jenis_kelamin as gender2, 
                       tb_balita.tanggal_lahir as lahir, 
                       tb_balita.alamat as alamat2, 
                       tb_balita.id_ortu as ortu, 
                       user.name as nama_ortu'); // Mengambil nama orang tua

        $this->db->from('data_pengukuran');
        $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
        $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left'); // Join dengan tabel user

        // Mengambil data
        $data['data'] = $this->db->order_by('id', 'DESC')->get()->result();



        if (!$data['pengukuran']) {
            show_404(); // Jika data tidak ditemukan, tampilkan halaman 404
        }

        // Load library PDF
        $this->load->library('pdf');

        // Load view untuk tampilan PDF, kirimkan data ke view
        $html = $this->load->view('laporan/pdf_template', $data, true);

        // Konfigurasi TCPDF
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('Nama Author');
        $this->pdf->SetTitle('Laporan Data Pengukuran');
        $this->pdf->SetSubject('Laporan Pengukuran Balita');

        // Menambahkan halaman
        $this->pdf->AddPage();

        // Tulis konten HTML ke PDF
        $this->pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF untuk download
        $this->pdf->Output('data_pengukuran_' . $id . '.pdf', 'I'); // 'I' untuk menampilkan di browser
    }






    function download_excel()
    {
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // Pastikan data user ditemukan
        if ($datas['user']) {
            $id_ortu = $datas['user']['id']; // Mengambil ID orang tua dari user yang login

            // Query data dengan join antara data_pengukuran, tb_balita, dan user berdasarkan ID orang tua
            $this->db->select('data_pengukuran.*, 
                           tb_balita.nama as nama_balita, 
                           tb_balita.jenis_kelamin as gender2, 
                           tb_balita.tanggal_lahir as lahir, 
                           tb_balita.alamat as alamat2, 
                           tb_balita.id_ortu as ortu, 
                           user.name as nama_ortu'); // Mengambil nama orang tua
            $this->db->from('data_pengukuran');
            $this->db->join('tb_balita', 'tb_balita.id = data_pengukuran.name', 'left');
            $this->db->join('user', 'user.id = tb_balita.id_ortu', 'left');

            // Filter data berdasarkan ID orang tua
            $this->db->where('tb_balita.id_ortu', $id_ortu);

            // Mengambil data dan urutkan
            $datas['data'] = $this->db->order_by('data_pengukuran.id', 'DESC')->get()->result();
        } else {
            $datas['data'] = []; // Jika user tidak ditemukan, tampilkan data kosong atau pesan error
            echo "<b>Data user tidak ditemukan atau belum login.</b><br/>";
        }


        $datas['title'] = 'Hasil';
        $datas['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('laporan/download_excel', $datas);
    }
}
