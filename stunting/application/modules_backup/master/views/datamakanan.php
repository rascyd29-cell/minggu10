<!-- Tautkan Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <h5 class="card-header mb-0">Menu Makanan</h5>
            <h7>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dengan menggunakan sistem rekomendasi weighted product</h7>

            <div class="table-responsive text-nowrap">
                <a href="<?php echo site_url('master/create'); ?>">
                    <button id="addForm" type="button" class="btn btn-primary mt-4 mx-4" style="background-color: blue">+tambah data</button>
                </a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Paket</th>
                            <th>Waktu makan</th>
                            <th>Menu</th>
                            <th>aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-1">
                        <?php $no = 1; ?>
                        <?php foreach ($query as $index => $item): ?>
                            <tr>
                                <?php if ($index % 5 == 0): ?>
                                    <td rowspan="5">
                                        <?php echo $no++; ?></td>
                                <?php endif; ?>
                                <?php if ($index % 5 == 0): ?>
                                    <td rowspan="5">
                                        <?php echo $item->paket; ?></td>
                                <?php endif; ?>

                                <td><?php echo $item->waktu_makan; ?></td>
                                <td><?php echo $item->menu; ?></td>
                                <?php if ($index % 5 == 0): ?>
                                    <td rowspan="5">
                                        <form method="POST" action="<?php echo site_url('master/delete/' . $item->paket); ?>">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <a href="<?php echo site_url('/master/showadmin/' . $item->paket); ?>" class="btn btn-info btn-sm">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a class="btn btn-warning btn-sm" title="Edit" href="<?php echo site_url('master/edit/' . $item->paket); ?>">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            &nbsp;
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Anda Yakin Data akan di Hapus?')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>