    <div class="container mt-3">
        <div class="kotak">
            <?php
            Flasher::flash()
            ?>
        </div>
        <div class="jumbotron ">
            <h1 class="display-5">Data Pegawai</h1>
            <hr class="my-4">
            <a href="<?= BASEURL ?>/user/tambah_pegawai"><button class="btn btn-primary mb-3">Tambah
                    Data</button></a>
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama User</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aktivasi</th>
                            <th scope="col">Dibuat Tanggal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                        $i = 1;
                        foreach ($data['pegawai'] as $data) { ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['nama_user'] ?></td>
                            <td>
                                <?php if ($data['jabatan'] == 1) { ?>
                                Admin
                                <?php } else { ?>
                                Pegawai
                                <?php } ?>
                            </td>
                            <td><?= $data['alamat_asal'] ?></td>
                            <td>
                                <?php if ($data['active'] == 1) { ?>
                                <a href="<?= BASEURL ?>/user/non_aktif/<?= $data['id'] ?>"><button
                                        class="btn btn-info">Aktif</button></a>
                                <?php } else { ?>
                                <a href="<?= BASEURL ?>/user/aktif/<?= $data['id'] ?>"><button
                                        class="btn btn-secondary">Non-Aktif</button></a>
                                <?php } ?>
                            </td>
                            <td><?= $data['create_at'] ?></td>
                            <td> <a href="<?= BASEURL ?>/user/ubah_user/<?= $data['id'] ?>"><button
                                        class="btn btn-warning">Ubah</button></a>
                                <a href="<?= BASEURL ?>/user/hapus_user/<?= $data['id'] ?>"><button
                                        class="btn btn-danger">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>