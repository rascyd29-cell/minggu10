<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col">
                <div class="card mb-4 shadow">
                    <div class="me-3 px-5 mt-5 mb-5">
                        <div>
                            <h3>Tabel Menu Makanan</h3>
                            <p>Berdasarkan paket menu yang direkomendasikan di atas, maka disarankan memberikan makanan lengkap dalam satu piring sebanyak 3x dalam sehari, dengan berat yang sudah direkomendasikan berikut ini:</p>
                        </div>

                        <div class="table-responsive text-nowrap px-5 mt-2">
                            <table class="table table-striped mb-5">
                                <thead>
                                    <tr>
                                        <th scope="col">Paket</th>
                                        <th scope="col">Waktu Makan</th>
                                        <th scope="col">Nama Makanan</th>
                                        <th scope="col">Jenis Makanan</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Protein</th>
                                        <th scope="col">Karbohidrat</th>
                                        <th scope="col">Lemak</th>
                                        <th scope="col">Energi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($joindata as $index => $item): ?>
                                        <?php if ($index % 4 == 0): ?>
                                            <tr>
                                                <td rowspan="4"><?= $item->paket ?></td>
                                                <td rowspan="4"><?= $item->waktu_makan ?></td>
                                                <td><?= $item->nama_makanan ?></td>
                                                <td><?= $item->jenis_makanan ?></td>
                                                <td>100</td>
                                                <td><?= $item->protein ?></td>
                                                <td><?= $item->karbohidrat ?></td>
                                                <td><?= $item->lemak ?></td>
                                                <td><?= $item->energi ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td><?= $item->nama_makanan ?></td>
                                                <td><?= $item->jenis_makanan ?></td>
                                                <td>100</td>
                                                <td><?= $item->protein ?></td>
                                                <td><?= $item->karbohidrat ?></td>
                                                <td><?= $item->lemak ?></td>
                                                <td><?= $item->energi ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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
                                    <?php foreach ($dataSelingan as $index => $item): ?>

                                        <?php if ($index % 4 == 0): ?>
                                            <tr>
                                                <td rowspan="4"><?= $item->paket ?></td>
                                                <td><?= $item->waktu_makan ?></td>
                                                <td><?= $item->menu ?></td>
                                                <td>100</td>
                                                <td><?= $item->protein ?></td>
                                                <td><?= $item->karbohidrat ?></td>
                                                <td><?= $item->lemak ?></td>
                                                <td><?= $item->energi ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td><?= $item->waktu_makan ?></td>
                                                <td><?= $item->menu ?></td>
                                                <td>100</td>
                                                <td><?= $item->protein ?></td>
                                                <td><?= $item->karbohidrat ?></td>
                                                <td><?= $item->lemak ?></td>
                                                <td><?= $item->energi ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>