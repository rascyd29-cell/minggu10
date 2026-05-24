<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card mb-4 shadow">
                    <div>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>Perhitungan Rekomendasi Makanan dengan Metode Weighted Product</h5>
                        </div>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold py-0 mb-0"><span class="text-muted fw-light"></span>#Kebutuhan Kalori</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="basic-default-fullname">BMR balita</label><br>
                                <h3><span class="badge bg-label-primary me-3"><?php echo isset($nilaibmr) ? $nilaibmr : '-'; ?></span></h3>

                                <label class="form-label fw-bold" for="basic-default-fullname">Total Kebutuhan kalori balita</label>
                                <h3><span class="badge bg-label-warning me-3"><?php echo isset($tdee) ? $tdee : '-'; ?></span></h3>

                                <label class="form-label fw-bold" for="basic-default-fullname">Distribusi kalori per waktu makan</label>
                                <div class="table-responsive text-nowrap me-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>makan pagi</th>
                                                <th>selingan pagi</th>
                                                <th>makan siang</th>
                                                <th>selingan sore</th>
                                                <th>makan malam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo isset($nilaiWaktu[0]) ? $nilaiWaktu[0] : '-'; ?></td>
                                                <td><?php echo isset($nilaiWaktu[1]) ? $nilaiWaktu[1] : '-'; ?></td>
                                                <td><?php echo isset($nilaiWaktu[2]) ? $nilaiWaktu[2] : '-'; ?></td>
                                                <td><?php echo isset($nilaiWaktu[3]) ? $nilaiWaktu[3] : '-'; ?></td>
                                                <td><?php echo isset($nilaiWaktu[4]) ? $nilaiWaktu[4] : '-'; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <hr>
                                <h5 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>#Persentase isi piring balita 2-5 tahun</h5>
                                <h6>pada persentase isi piring dalam menyusun menu untuk balita 2-5 yaitu makanan pokok sebanyak 35%, lauk 35%, sayur 15% dan buah 15%</h6>

                                <!-- Small table -->
                                <div class="card">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr class="">
                                                    <th>Jadwal Makan</th>
                                                    <th>Makanan Pokok (kkal)</th>
                                                    <th>Lauk (kkal)</th>
                                                    <th>Sayur (kkal)</th>
                                                    <th>Buah(kkal)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td><i class="fab tf-icons bx bx-check fa-lg text-danger me-3"></i><strong>Makan Pagi</strong></td>
                                                    <td><?php echo isset($nilaiisipiring[0]) ? $nilaiisipiring[0] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[1]) ? $nilaiisipiring[1] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[2]) ? $nilaiisipiring[2] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[3]) ? $nilaiisipiring[3] : '-'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fab tf-icons bx bx-check fa-lg text-danger me-3"></i><strong>Makan Siang</strong></td>
                                                    <td><?php echo isset($nilaiisipiring[4]) ? $nilaiisipiring[4] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[5]) ? $nilaiisipiring[5] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[6]) ? $nilaiisipiring[6] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[7]) ? $nilaiisipiring[7] : '-'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="fab tf-icons bx bx-check fa-lg text-danger me-3"></i><strong>Makan Malam</strong></td>
                                                    <td><?php echo isset($nilaiisipiring[8]) ? $nilaiisipiring[8] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[9]) ? $nilaiisipiring[9] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[10]) ? $nilaiisipiring[10] : '-'; ?></td>
                                                    <td><?php echo isset($nilaiisipiring[11]) ? $nilaiisipiring[11] : '-'; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--/ Small table -->



                                <div>
                                    </br>
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>#TABEL ALTERNATIF</h5>
                                    </div>
                                    <div class="table-responsive text-nowrap mx-5 mb-5">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Paket</th>
                                                    <th>Total Protein</th>
                                                    <th>Total Karbohidrat</th>
                                                    <th>Total Lemak</th>
                                                    <th>TotaL Energi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-1">
                                                <?php
                                                $no = 1;
                                                for ($i = 0; $i < count($query); $i++) {
                                                    echo '<tr>';
                                                    echo '<td>' . $no++ . '</td>';
                                                    echo '<td>' . $query[$i]->paket . '</td>'; // Mengakses properti 'paket'
                                                    echo '<td>' . $JumlahTotal_Protein[$i] . '</td>';
                                                    echo '<td>' . $JumlahTotal_Karbo[$i] . '</td>';
                                                    echo '<td>' . $JumlahTotal_Lemak[$i] . '</td>';
                                                    echo '<td>' . $JumlahTotal_Energi[$i] . '</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div>
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold py-0 mb-0"><span class="text-muted fw-light"></span>#TABEL KRITERIA</h5>
                                        </div>
                                        <div class="table-responsive text-nowrap mx-5 mb-5">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Kriteria</th>
                                                        <th>Kode</th>
                                                        <th>Bobot</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-1">
                                                    <?php
                                                    foreach ($kriteria as $item) {
                                                        echo '<tr>';
                                                        echo '<td>' . $item['kriteria'] . '</td>';
                                                        echo '<td>' . $item['kode'] . '</td>';
                                                        echo '<td>' . $item['bobot'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold py-1 mb-0"># TABEL BOBOT KEPENTINGAN</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap mb-4">
                                                <table class="table table-striped">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>C1</th>
                                                            <th>C2</th>
                                                            <th>C3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo isset($bobotKriteria['C1']) ? $bobotKriteria['C1'] : 'N/A'; ?></td>
                                                            <td><?php echo isset($bobotKriteria['C2']) ? $bobotKriteria['C2'] : 'N/A'; ?></td>
                                                            <td><?php echo isset($bobotKriteria['C3']) ? $bobotKriteria['C3'] : 'N/A'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-3">
                                                <p class="fw-bold">Total Bobot:
                                                    <span class="text-primary">
                                                        <?php
                                                        $totalBobot2 = (int) $totalBobot;
                                                        echo isset($totalBobot2) ? $totalBobot2 : 'N/A'; ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    <div>
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>#PERBANDINGAN ALTERNATIF DAN KRITERIA</h5>
                                        </div>
                                        <div class="table-responsive text-nowrap mx-5 mb-5">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Paket</th>
                                                        <th>C1</th>
                                                        <th>C2</th>
                                                        <th>C3</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-1">
                                                    <?php
                                                    $no = 1;
                                                    for ($i = 0; $i < count($query); $i++) {
                                                        echo '<tr>';
                                                        echo '<td>' . $no++ . '</td>';
                                                        echo '<td>' . $query[$i]->paket . '</td>';
                                                        echo '<td>' . $JumlahTotal_Protein[$i] . '</td>';
                                                        echo '<td>' . $JumlahTotal_Karbo[$i] . '</td>';
                                                        echo '<td>' . $JumlahTotal_Lemak[$i] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold py-1 mb-0">
                                                <span class="text-muted fw-light"></span>#VEKTOR S
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Paket</th>
                                                            <th>Nilai Vektor S</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-1">
                                                        <?php
                                                        $no = 1;
                                                        for ($i = 0; $i < count($query); $i++) {
                                                            echo '<tr>';
                                                            echo '<td>' . $no++ . '</td>';
                                                            echo '<td>' . $query[$i]->paket . '</td>';
                                                            echo '<td>' . $hasil[$i] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                <p class="fw-bold">Total Bobot:
                                                    <span class="text-primary">
                                                        <?php echo isset($totalVektorS) ? $totalVektorS : 'N/A'; ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                    <div>
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>#VEKTOR V</h5>
                                        </div>
                                        <div class="table-responsive text-nowrap mx-5 mb-5">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Paket</th>
                                                        <th>Nilai vektor V</th>
                                                        <th>RANK</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-1">
                                                    <?php
                                                    $no = 1;
                                                    $count = count($hasilPengurutan);
                                                    for ($i = 0; $i < $count; $i++) {
                                                        echo '<tr>';
                                                        echo  '<td>' . $hasilPengurutan[$i]['label'] . '</td>';
                                                        echo '<td>' . $hasilPengurutan[$i]['value'] . '</td>';
                                                        echo '<td>' . $no++ . '</td>';
                                                        echo '</tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <div>
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold py-1 mb-0"><span class="text-muted fw-light"></span>#TABEL MENU YANG DIREKOMENDASIKAN</h5>
                                            </div>

                                            <div class="table-responsive text-nowrap mx-5 mb-5">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Paket</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-1">
                                                        <?php
                                                        $no = 1;
                                                        $count = count($hasilPengurutan);
                                                        for ($i = 0; $i < $count; $i++) {
                                                            echo '<tr>';
                                                            echo '<td>' . $no++ . '</td>';
                                                            echo '<td>' . $hasilPengurutan[$i]['label'] . '</td>';
                                                            echo '<td> <a href="' . site_url('/data/show/' . $hasilPengurutan[$i]['label']) . '"class="btn btn-outline-info" style="text-decoration: none; padding: 2px 6px; font-size: 6px;"> <center> <i class="bx bx-show"></center></i></td>';
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>