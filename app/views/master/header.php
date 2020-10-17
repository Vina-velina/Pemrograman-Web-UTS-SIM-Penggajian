<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>UD SUMBER HASIL - <?= $data['title'] ?></title>
</head>

<body>
    <section id="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">SIM Penggajian</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" href="<?= BASEURL ?>">Home <span class="sr-only">(current)</span></a>
                        <?php if ($data['user'][0]['jabatan'] == "1") { ?>
                        <a class="nav-link " href="<?= BASEURL ?>/user/pegawai">Data Pegawai</a>
                        <a class="nav-link " href="<?= BASEURL ?>/user/data_gaji">Data Gaji</a>
                        <?php } else { ?>
                        <a class="nav-link " href="<?= BASEURL ?>/user/data_gaji_user">Detail Gaji</a>
                        <?php } ?>
                        <li class=" nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= ucfirst($data['user'][0]['nama_user']) ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarD ropdown">
                                <a class="dropdown-item"
                                    href="<?= BASEURL ?>/user/ganti_password/<?= $data['user'][0]['id'] ?>">Ganti
                                    Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= BASEURL ?>/user/logout">Logout</a>
                            </div>
                        </li>

                    </div>
                </div>
            </div>
        </nav>
    </section>

    <?php
    Flasher::flash()
    ?>