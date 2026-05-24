<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Excel_File.xls");
?>
<div class="table-responsive">
    <table id="datatable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>
                    <center>Identitas Balita</center>
                </th>
                <th>
                    <center>Pengukuran</center>
                </th>
                <th>
                    <center>Z-Score</center>
                </th>
                <th>
                    <center>Kesimpulan</center>
                </th>
            </tr>
        </thead>
        <tbody id="show_data">
            <?php
            $no = 1;
            foreach ($data as $u) {
                $birth_date = new DateTime($u->lahir);
                $measurement_date = new DateTime($u->date_create);
                $age_interval = $measurement_date->diff($birth_date);
                $age_years = $age_interval->y;
                $age_months = $age_interval->m;
                $result_age_monts = ($age_years * 12) + $age_months;
                $age_display = $age_years . ' tahun, ' . $age_months . ' bulan';
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><b>Nama: <?php echo $u->nama_balita ?></b> <br />
                        Jenis Kelamin: <?php echo $u->gender2 ?> <br />
                        Tanggal Lahir: <?php echo $u->lahir ?> <br />
                        Orang Tua: <?php echo $u->nama_ortu ?> <br />
                        Alamat: <?php echo $u->alamat2 ?> <br />
                    </td>
                    <td>Tanggal pengukuran: <?php echo $u->date_create ?><br />
                        Usia: <?php echo $age_display ?><br />
                        Faktor Aktivitas: <?php echo $u->aktivitas ?><br />
                        Faktor Stress: <?php echo $u->stress ?><br />

                        Berat: <?php echo $u->mass ?> Kg <br />
                        Tinggi: <?php echo $u->height ?> cm <br />
                        Lingkar Kepala: <?php echo $u->head ?> cm<br />
                    </td>

                    <td>

                        <?php

                        $bbu = $this->db->select('*')->from('bbu')->where('umur', $result_age_monts)->where('nb', $u->gender2)->get()->result();



                        if (!empty($bbu)) {

                            $bbu_med = $bbu[0]->Med;

                            $bbu_min = $bbu[0]->min;

                            $bbu_max = $bbu[0]->max;

                            $zbbu = 0;

                            $kesimpulan_zbbu = '';

                            if ($u->mass == $bbu_med) {

                                $zbbu = 0;
                            } else if ($u->mass <= $bbu_med) {

                                $zbbu = number_format((float)((($u->mass - $bbu_med) / ($bbu_med - $bbu_min))), 2, '.', '');
                            } else if ($u->mass >= $bbu_med) {

                                $zbbu = number_format((float)((($u->mass - $bbu_med) / ($bbu_med - $bbu_max))), 2, '.', '');
                            } else {
                                $zbbu = 0;
                            }

                            if ($u->mass > $bbu_max) {

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

                            echo "1. BB/U = $zbbu <b> ($kesimpulan_zbbu) </b> <br/>";



                            $pbu_tbu = $this->db->select('*')->from('pbu_tbu')->where('umur', $result_age_monts)->where('nb', $u->gender2)->get()->result();

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

                            if ($u->height == $pbu_tbu_med) {

                                $zpbu_tbu = 0;
                            } else if ($u->height <= $pbu_tbu_med) {

                                $zpbu_tbu = number_format((float)((($u->height - $pbu_tbu_med) / ($pbu_tbu_med - $pbu_tbu_min))), 2, '.', '');
                            } else if ($u->height >= $pbu_tbu_med) {

                                $zpbu_tbu = number_format((float)((($u->height - $pbu_tbu_med) / ($pbu_tbu_med - $pbu_tbu_max))), 2, '.', '');
                            } else {
                                $zpbu_tbu = 0;
                            }

                            if ($u->height > $pbu_tbu_max) {

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

                            echo "2. PB/U dan TB/U = $zpbu_tbu <b> ($kesimpulan_pbu_tbu) </b> <br/>";



                            $bulan = 0;

                            if ($result_age_monts >= 24) {

                                $bulan = 2;
                            } else {

                                $bulan = 0;
                            }

                            $bbpb_bbtb = $this->db->select('*')->from('bbpb_bbtb')->where('umur', $bulan)->where('tinggi', $u->height)->where('nb', $u->gender2)->get()->result();

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

                            if ($u->mass == $bbpb_bbtb_med) {

                                $zbbpb_bbtb = 0;
                            } else if ($u->mass <= $bbpb_bbtb_med) {
                                if (($bbpb_bbtb_med - $bbpb_bbtb_min) != 0) {
                                    $zbbpb_bbtb = number_format((float)((($u->mass - $bbpb_bbtb_med) / ($bbpb_bbtb_med - $bbpb_bbtb_min))), 2, '.', '');
                                } else {
                                    $zbbpb_bbtb = 0;
                                }
                            } else if ($u->mass >= $bbpb_bbtb_med) {
                                if (($bbpb_bbtb_med - $bbpb_bbtb_min) != 0) {
                                    $zbbpb_bbtb = number_format((float)((($u->mass - $bbpb_bbtb_med) / ($bbpb_bbtb_med - $bbpb_bbtb_max))), 2, '.', '');
                                } else {
                                    $zbbpb_bbtb = 0;
                                }
                            } else {
                                $zbbpb_bbtb = 0;
                            }


                            if ($u->mass > $bbpb_bbtb_max) {

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

                            echo "3. BB/PB dan BB/TB = $zbbpb_bbtb <b> ($kesimpulan_bbpb_bbtbu) </b><br/>";



                            $tinggi = $u->height / 100;

                            $imtu = $this->db->select('*')->from('imtu')->where('umur', $result_age_monts)->where('nb', $u->gender2)->get()->result();

                            if ($tinggi != 0) {
                                $imt = $u->mass / pow($tinggi, 2);  // Jika $tinggi tidak 0, lakukan pembagian
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

                            echo "4. IMT/U = $zimtu <b> ($kesimpulan_imtu) </b> <br/>";



                            $headu = $this->db->select('*')->from('headu')->where('umur', $result_age_monts)->where('nb', $u->gender2)->get()->result();

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

                            if ($u->head == $headu_med) {

                                $zheadu = 0;
                            } else if ($u->head <= $headu_med) {

                                $zheadu = number_format((float)((($u->head - $headu_med) / ($headu_med - $headu_min))), 2, '.', '');
                            } else if ($u->head >= $headu_med) {

                                $zheadu = number_format((float)((($u->head - $headu_med) / ($headu_med - $headu_max))), 2, '.', '');
                            } else {
                                $zheadu = 0;
                            }

                            if ($u->head > $headu_max) {

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

                            echo "5. LK/U =  $zheadu <b> ($kesimpulan_zheadu) </b><br/>";
                        } else {

                            echo "<b> Error: Max 5 tahun </b>";
                        }

                        ?>

                    </td>
                    <td>
                        <?php
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
                        echo "1. Berat Badan = <b> $kesimpulan_zbbu </b> Atau <b> $kesimpulan_imtu </b><br/>";
                        echo "2. Tinggi Badan = <b> $kesimpulan_pbu_tbu </b><br/>";
                        echo "3. Nutrisi = <b> $kesimpulan_bbpb_bbtbu </b> Atau <b> $kesimpulan_imtu </b><br/>";

                        // =====================INPUTAN UNTUK REKOMENDASI MAKANAN=========================== //
                        $umur = (float) $result_age_monts / 12;
                        $jeniskelamin = $u->gender2;
                        $beratbadan = $u->mass;
                        $aktivitas = $u->aktivitas;
                        $stress = $u->stress;
                        $komponen_input = [$umur, $jeniskelamin, $beratbadan, $aktivitas, $stress];

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

                        echo "4. BMR = <b> $nilaibmr kkal/hari</b><br/>";
                        echo "5. Total Kebutuhan Kalori = <b> $tdee kkal/hari</b><br/>";
                        ?>


                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    Keterangan: <br />
    1. BB/U = Berat Badan / umur <br />
    2. PB/U dan TB/U = Panjang Badan / Umur dan Tinggi Badan / umur <br />
    3. BB/PB dan BB/TB = Berat Badan / Panjang Badan dan Berat Badan / Tinggi Badan <br />
    4. IMT/U = Index Masa Tubuh / Umur <br />
    5. LK/U = Lingkar Kepala / Umur <br />
</div>
</div>
</div>



<!-- Include Bootstrap Datepicker library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('#changeStatusBtn').click(function() {
            $.ajax({
                url: '<?php echo base_url("data/changeStatus"); ?>',
                type: 'GET',
                success: function(response) {
                    // Berhasil mengubah status
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Terjadi kesalahan saat mengubah status
                    console.error(error);
                }
            });
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'csv'
            ]
        });
    });
</script>