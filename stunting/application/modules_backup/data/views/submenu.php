<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card mb-4 shadow">
                    <div class="me-3 px-5 mt-5 mb-5">
                        <div>
                            <h3>Tabel Sub Menu</h3>
                            <h6>dengan Metode Weighted Product</h6>
                            <p>Berdasarkan paket menu yang direkomendasikan di atas, maka disarankan memberikan makanan lengkap dalam satu piring sebanyak 3x dalam sehari, dengan berat yang sudah direkomendasikan berikut ini:</p>
                        </div>

                        <div class="table-responsive text-nowrap mt-2">
                            <table class="table table-striped mb-5">
                                <thead>
                                    <tr>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Waktu Makan</th>
                                        <th scope="col">Nama Makanan</th>
                                        <th scope="col">Jenis Makanan</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Protein</th>
                                        <th scope="col">karbo</th>
                                        <th scope="col">Lemak</th>
                                        <th scope="col">Energi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($joindata as $item) {
                                        if ($index % 4 == 0) {
                                            echo '<tr>';
                                            echo '<td rowspan="4">' . $item->paket . '</td>';
                                            echo '<td rowspan="4">' . $item->waktu_makan . '</td>';
                                            echo '<td>' . $item->nama_makanan . '</td>';
                                            echo '<td>' . $item->jenis_makanan . '</td>';
                                            echo '<td>' . number_format($Berat[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Protein[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Karbo[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Lemak[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Energi[$index], 2, '.', '') . '</td>';
                                            echo '</tr>';
                                        } else {
                                            echo '<tr>';
                                            echo '<td>' . $item->nama_makanan . '</td>';
                                            echo '<td>' . $item->jenis_makanan . '</td>';
                                            echo '<td>' . number_format($Berat[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Protein[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Karbo[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Lemak[$index], 2, '.', '') . '</td>';
                                            echo '<td>' . number_format($Energi[$index], 2, '.', '') . '</td>';
                                            echo '</tr>';
                                        }
                                        $index++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow">
                    <div class="me-3 px-5 mt-5">
                        <div>
                            <h3>Tabel Selingan</h3>
                            <p>Berdasarkan paket menu yang direkomendasikan di atas, maka disarankan memberikan makanan selingan berikut ini:</p>
                        </div>
                        <div class="table-responsive text-nowrap px-5 mt-2">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Waktu Makan</th>
                                        <th scope="col">Nama Selingan</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Protein</th>
                                        <th scope="col">Karbohidrat</th>
                                        <th scope="col">Lemak</th>
                                        <th scope="col">Energi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($dataSelingan as $item) {
                                        echo '<tr>';
                                        if ($index == 0) {
                                            echo '<td rowspan="2">' . $item->paket . '</td>';
                                        }
                                        echo '<td>' . $item->waktu_makan . '</td>';
                                        echo '<td>' . $item->menu . '</td>';
                                        echo '<td>' . number_format($BeratSelingan[$index], 2, '.', '') . '</td>';
                                        echo '<td>' . number_format($ProteinSelingan[$index], 2, '.', '') . '</td>';
                                        echo '<td>' . number_format($KarbohidratSelingan[$index], 2, '.', '') . '</td>';
                                        echo '<td>' . number_format($LemakSelingan[$index], 2, '.', '') . '</td>';
                                        echo '<td>' . number_format($EnergiSelingan[$index], 2, '.', '') . '</td>';
                                        echo '</tr>';
                                        $index++;
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