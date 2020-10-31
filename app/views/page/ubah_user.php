    <div class="container mt-3">
        <div class="kotak">
            <?php
            Flasher::flash()
            ?>
        </div>
        <div class="jumbotron">
            <h1 class="display-5">Ubah Pegawai</h1>
            <hr class="my-4">
            <div class="col-lg-6">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto">Foto Pegawai</label>
                        <input type="file" class="form-control" id="foto" name="file">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama User</label>
                        <input required type="text" class="form-control" id="name" name="nama"
                            value="<?= $data['detail_user'][0]['nama_user'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Asal</label>
                        <input required type="text" class="form-control" id="alamat" name="alamat"
                            value="<?= $data['detail_user'][0]['alamat_asal'] ?>">
                    </div>
                    <div class="form-group">
                        <?php

                        $admin = '';
                        $pegawai = '';
                        if ($data['detail_user'][0]['jabatan'] == 1) {
                            $admin = "selected";
                        } else {
                            $pegawai = "selected";
                        }
                        ?>
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-control">
                            <option value="1" <?= $admin ?>>Admin</option>
                            <option value="2" <?= $pegawai ?>>Pegawai</option>
                        </select>
                    </div>
                    <input type="hidden" name="file_old" value="<?= $data['detail_user'][0]['foto_user']?>">
                    <button type="submit" class="btn btn-primary" value="SUBMIT" name="submit">Ubah Data</button>
                </form>
            </div>
        </div>
    </div>