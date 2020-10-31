<?php
class User extends Controller
{
    public function index()
    {
        if (isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user/home');
            exit;
        } else {
            // Ini adalah data yang akan dikirim ke halaman
            $data['title'] = "Login User";
            if (isset($_POST['submit'])) {
                if ($this->model('User_model')->cekEmailUser($_POST['email']) > 0) {
                    $user = $this->model('User_model')->getUserWhereEmail($_POST['email']);
                    if (password_verify($_POST['passwd'], $user[0]['password'])) {
                        $_SESSION['login'] = true;
                        $username = $this->model('User_model')->getUser($_POST['email']);
                        $_SESSION['username'] = $username['id'];
                        $_SESSION['active'] = $username['active'];
                        header('Location:' . BASEURL . '/user/home');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Ditemukan, Password Anda Salah !', 'danger');
                        header('Location:' . BASEURL . '/user');
                        exit;
                    }
                } else {
                    Flasher::setflash('Gagal', 'Ditemukan, Email Anda Salah', 'danger');
                    header('Location:' . BASEURL . '/user');
                    exit;
                }
            } else {
                // Menyusun website
                $this->view('master/header_login', $data);
                $this->view('page/index', $data);
                $this->view('master/footer', $data);
            }
        }
    }
    public function data_gaji_user()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 2) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                $data['gaji'] = $this->model('User_model')->getAllGajiWhere($session[0]['id']);
                $data['title'] = "Data Pegawai";
                $this->view('master/header', $data);
                $this->view('page/data_gaji_user', $data);
                $this->view('master/footer', $data);
            }
        }
    }
    public function home()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                $data['title'] = "Dashboard";
                $this->view('master/header', $data);
                $this->view('page/home', $data);
                $this->view('master/footer', $data);
            }
        }
    }
    public function pegawai()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                $data['pegawai'] = $this->model('User_model')->getAllUser();
                $data['title'] = "Data Pegawai";
                $this->view('master/header', $data);
                $this->view('page/pegawai', $data);
                $this->view('master/footer', $data);
            }
        }
    }
    public function tambah_pegawai()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $data['title'] = "Tambah Pegawai";
                if (isset($_POST['submit'])) {
                    if ($this->model('User_model')->cekEmailUser($_POST['email']) > 0) {
                        echo "Email Sudah Digunakan";
                    } else {
                        if ($_POST['passwd'] != $_POST['konf-passwd']) {
                            echo "Password Tidak Sesuai";
                        } else {
                            $new_pass = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
                            if ($_FILES['file']['error'] == 0) {
                                // Settingan
                                $eks_foto_boleh = array('png', 'jpg');
                                $nama_foto = $_FILES['file']['name'];
                                $foto = explode('.', $nama_foto);
                                $eksfoto = strtolower(end($foto));
                                $ukuranfoto = $_FILES['file']['size'];
                                $tmpfoto = $_FILES['file']['tmp_name'];
                                if (in_array($eksfoto, $eks_foto_boleh) === true) {
                                    if ($ukuranfoto < 1500000) {
                                        //  Generate Nama Gambar Baru
                                        $new_Foto = uniqid() . "_" . $_POST['nama'];

                                        $new_Foto .= '.';
                                        $new_Foto .= $eksfoto;
                                        $destination_path = getcwd() . DIRECTORY_SEPARATOR;

                                        // Target
                                        $target_foto = $destination_path . '/upload/' . $new_Foto;

                                        if ($this->model('User_model')->inputUser($_POST, $new_pass, $new_Foto) > 0) {
                                            move_uploaded_file($tmpfoto, $target_foto);
                                            Flasher::setflash('Berhasil', 'Ditambahkan', 'success');
                                            header('Location:' . BASEURL . '/user/pegawai');
                                            exit;
                                        } else {
                                            Flasher::setflash('Gagal', 'Ditambahkan, Terjadi Kesalahan Dalam Input Data', 'danger');
                                            header('Location:' . BASEURL . '/user/pegawai');
                                            exit;
                                        }
                                    } else {
                                        Flasher::setflash('Gagal', 'Ditambahkan, Ukuran Foto Melebihi', 'danger');
                                        header('Location:' . BASEURL . '/user/tambah_pegawai');
                                        exit;
                                    }
                                } else {
                                    Flasher::setflash('Gagal', 'Ditambahkan, Ekstensi Foto Tidak Diperbolehkan', 'danger');
                                    header('Location:' . BASEURL . '/user/tambah_pegawai');
                                    exit;
                                }
                            } else {
                                Flasher::setflash('Gagal', 'Ditambahkan, Foto Wajib Diisi', 'danger');
                                header('Location:' . BASEURL . '/user/pegawai');
                                exit;
                            }
                        }
                    }
                } else {
                    // Menyusun website
                    $this->view('master/header', $data);
                    $this->view('page/tambah_user', $data);
                    $this->view('master/footer', $data);
                }
            }
        }
    }
    public function ubah_user($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $data['title'] = "Tambah Pegawai";
                $user_cari = $this->model('User_model')->getUserWhere($id);
                $data['detail_user'] = $user_cari;
                if (isset($_POST['submit'])) {
                    if ($_POST['nama'] == $user_cari[0]['nama_user'] && $_POST['alamat'] == $user_cari[0]['alamat_asal'] && $_POST['jabatan'] == $user_cari[0]['jabatan'] && $_FILES['file']['error'] != 0) {
                        Flasher::setflash('Berhasil', 'Diubah dan Diperbaharui', 'success');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    } else {

                        // Kalau misal tidak bisa terhapus, kata "penggajian" bisa disesuaian dengan nama folder localhostnya
                        if (unlink($_SERVER['DOCUMENT_ROOT'] . "/penggajian/public/upload/" . $_POST['file_old'])) {
                            // Settingan
                            $eks_foto_boleh = array('png', 'jpg');
                            $nama_foto = $_FILES['file']['name'];
                            $foto = explode('.', $nama_foto);
                            $eksfoto = strtolower(end($foto));
                            $ukuranfoto = $_FILES['file']['size'];
                            $tmpfoto = $_FILES['file']['tmp_name'];
                            if (in_array($eksfoto, $eks_foto_boleh) === true) {
                                if ($ukuranfoto < 1500000) {
                                    //  Generate Nama Gambar Baru
                                    $new_Foto = uniqid() . "_" . $_POST['nama'];
                                    $new_Foto .= '.';
                                    $new_Foto .= $eksfoto;
                                    $destination_path = getcwd() . DIRECTORY_SEPARATOR;
                                    // Target
                                    $target_foto = $destination_path . '/upload/' . $new_Foto;

                                    if ($this->model('User_model')->editUser($_POST, $id, $new_Foto) > 0) {
                                        move_uploaded_file($tmpfoto, $target_foto);
                                        Flasher::setflash('Berhasil', 'Diubah dan Diperbaharui', 'success');
                                        header('Location:' . BASEURL . '/user/pegawai');
                                        exit;
                                    } else {
                                        Flasher::setflash('Gagal', 'Diubah, Terjadi Kesalahan Dalam Ubah Data', 'danger');
                                        header('Location:' . BASEURL . '/user/ubah_user/' . $id);
                                        exit;
                                    }
                                } else {
                                    Flasher::setflash('Gagal', 'Ditambahkan, Ukuran Foto Melebihi', 'danger');
                                    header('Location:' . BASEURL . '/user/tambah_pegawai');
                                    exit;
                                }
                            }
                        }
                    }
                } else {
                    if (!empty($id) && !empty($user_cari)) {
                        // Menyusun website
                        $this->view('master/header', $data);
                        $this->view('page/ubah_user', $data);
                        $this->view('master/footer', $data);
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Error Parameter', 'danger');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    }
                }
            }
        }
    }
    public function hapus_user($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $user_cari = $this->model('User_model')->getUserWhere($id);
                $data['detail_user'] = $user_cari;
                if (!empty($id) && !empty($user_cari)) {
                    // Kalau misal tidak bisa terhapus, kata "penggajian" bisa disesuaian dengan nama folder localhostnya
                    if (unlink($_SERVER['DOCUMENT_ROOT'] . "/penggajian/public/upload/" . $user_cari[0]['foto_user'])) {
                        // Menyusun website
                        if ($this->model('User_model')->deleteUserWhere($id) > 0) {
                            Flasher::setflash('Berhasil', 'Berhasil Dihapus', 'success');
                            header('Location:' . BASEURL . '/user/pegawai');
                            exit;
                        } else {
                            Flasher::setflash('Gagal', 'Dihapus, Terjadi Kesalahan Dalam Hapus Data', 'danger');
                            header('Location:' . BASEURL . '/user/pegawai');
                            exit;
                        }
                    }
                } else {
                    Flasher::setflash('Gagal', 'Dihapus, Error Parameter', 'danger');
                    header('Location:' . BASEURL . '/user/pegawai');
                    exit;
                }
            }
        }
    }
    public function non_aktif($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $user_cari = $this->model('User_model')->getUserWhere($id);
                $data['detail_user'] = $user_cari;
                if (!empty($id) && !empty($user_cari)) {
                    // Menyusun website
                    if ($this->model('User_model')->nonAktifUserWhere($id) > 0) {
                        Flasher::setflash('Berhasil', 'Di Non Aktivasi', 'success');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Terjadi Kesalahan Dalam Aktivasi', 'danger');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    }
                } else {
                    Flasher::setflash('Gagal', 'Diubah, Error Parameter', 'danger');
                    header('Location:' . BASEURL . '/user/pegawai');
                    exit;
                }
            }
        }
    }
    public function aktif($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $user_cari = $this->model('User_model')->getUserWhere($id);
                $data['detail_user'] = $user_cari;
                if (!empty($id) && !empty($user_cari)) {
                    // Menyusun website
                    if ($this->model('User_model')->aktifUserWhere($id) > 0) {
                        Flasher::setflash('Berhasil', 'Diaktivasi', 'success');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Terjadi Kesalahan Dalam Aktivasi', 'danger');
                        header('Location:' . BASEURL . '/user/pegawai');
                        exit;
                    }
                } else {
                    Flasher::setflash('Gagal', 'Diubah, Error Pada Parameter', 'danger');
                    header('Location:' . BASEURL . '/user/pegawai');
                    exit;
                }
            }
        }
    }
    public function set_bayar($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $user_cari = $this->model('User_model')->getGajiWhere($id);
                $data['detail_user'] = $user_cari;
                if (!empty($id) && !empty($user_cari)) {
                    // Menyusun website
                    if ($this->model('User_model')->bayarGajiWhere($id) > 0) {
                        Flasher::setflash('Berhasil', 'Dibayarkan', 'success');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Terjadi Kesalahan Dalam Proses Set Bayar', 'danger');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    }
                } else {
                    Flasher::setflash('Gagal', 'Diubah, Error Parameter', 'danger');
                    header('Location:' . BASEURL . '/user/data_gaji');
                    exit;
                }
            }
        }
    }
    public function ubah_gaji($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $data['title'] = "Ubah Gaji Pegawai";
                $gaji_cari = $this->model('User_model')->getGajiWhere($id);
                $data['detail_gaji'] = $gaji_cari;

                if (isset($_POST['submit'])) {
                    $total_gaji = $gaji_cari[0]['besar_gaji'] * $_POST['hadir'];
                    if ($this->model('User_model')->editGajiUser($_POST, $id, $total_gaji) > 0) {
                        Flasher::setflash('Berhasil', 'Diubah Dan Diperbaharui', 'success');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Terjadi Kesahalan Dalam Ubah Data', 'danger');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    }
                } else {
                    if (!empty($id) && !empty($gaji_cari)) {
                        // Menyusun website
                        $this->view('master/header', $data);
                        $this->view('page/ubah_gaji', $data);
                        $this->view('master/footer', $data);
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Error Parameter', 'danger');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    }
                }
            }
        }
    }
    public function hapus_gaji($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $gaji_cari = $this->model('User_model')->getGajiWhere($id);
                $data['detail_gaji'] = $gaji_cari;
                if (!empty($id) && !empty($gaji_cari)) {
                    // Menyusun website
                    if ($this->model('User_model')->deleteGajiWhere($id) > 0) {
                        Flasher::setflash('Berhasil', 'Dihapus', 'success');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    } else {
                        Flasher::setflash('Gagal', 'Dihapus, Terjadi Kesahalan Dalam Hapus Data', 'danger');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    }
                } else {
                    Flasher::setflash('Gagal', 'Dihapus, Error Parameter', 'danger');
                    header('Location:' . BASEURL . '/user/data_gaji');
                    exit;
                }
            }
        }
    }
    public function data_gaji()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                $data['gaji'] = $this->model('User_model')->getAllGaji();
                $data['title'] = "Data Pegawai";
                $this->view('master/header', $data);
                $this->view('page/gaji', $data);
                $this->view('master/footer', $data);
            }
        }
    }
    public function logout()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $_SESSION = [];
            session_unset();
            session_destroy();
            header('Location:' . BASEURL . '/user');
            exit;
        }
    }
    public function tambah_gaji()
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $besar_gaji = 50000;
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $data['title'] = "Tambah Gaji Pegawai";
                $data['pegawai'] = $this->model('User_model')->getAllUserNoAdmin();
                $bulan = date('F Y');
                if (isset($_POST['submit'])) {
                    if ($this->model('User_model')->cekBulanGaji($_POST['pegawai'], $bulan) > 0) {
                        Flasher::setflash('Gagal', 'Gaji Dibulan "' . date('F Y') . '" Untuk Karyawan Yang Dipilih Sudah Diatur Sebelumnya', 'danger');
                        header('Location:' . BASEURL . '/user/tambah_gaji');
                        exit;
                    } else {
                        $total_gaji = $_POST['hadir'] * $besar_gaji;
                        $create_by = $session[0]['nama_user'];
                        if ($this->model('User_model')->inputGaji($_POST, $bulan, $besar_gaji, $total_gaji, $create_by) > 0) {
                            Flasher::setflash('Berhasil', 'Ditambahkan', 'success');
                            header('Location:' . BASEURL . '/user/data_gaji');
                            exit;
                        } else {
                            Flasher::setflash('Gagal', 'Ditambahkan, Terjadi Kesahalan Dalam Penginputan', 'danger');
                            header('Location:' . BASEURL . '/user/data_gaji');
                            exit;
                        }
                    }
                } else {
                    // Menyusun website
                    $this->view('master/header', $data);
                    $this->view('page/tambah_gaji', $data);
                    $this->view('master/footer', $data);
                }
            }
        }
    }
    public function ganti_password($id = '')
    {
        if (!isset($_SESSION['login'])) {
            header('Location:' . BASEURL . '/user');
            exit;
        } else {
            $session = $this->model('User_model')->getUserWhere($_SESSION['username']);
            if ($session[0]['active'] != 1 || $session[0]['jabatan'] != 1) {
                header('Location:' . BASEURL . '/user/logout');
                exit;
            } else {
                $data['user'] = $session;
                // Ini adalah data yang akan dikirim ke halaman
                $data['title'] = "Ubah Password";
                if (isset($_POST['submit'])) {
                    if ($_POST['passwd'] != $_POST['konf-passwd']) {
                        echo "Password Tidak Sesuai";
                    } else {
                        if (password_verify($_POST['old-passwd'], $session[0]['password'])) {
                            $new_pass = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
                            if ($this->model('User_model')->editPassword($id, $new_pass) > 0) {
                                Flasher::setflash('Berhasil', 'Diubah', 'success');
                                header('Location:' . BASEURL . '/user/home');
                                exit;
                            } else {
                                Flasher::setflash('Gagal', 'Diubah, Terjadi Kesahalan Dalam Ubah Data', 'danger');
                                header('Location:' . BASEURL . '/user/data_gaji');
                                exit;
                            }
                        } else {
                            Flasher::setflash('Gagal', 'Diubah, Password Saat Ini Tidak Sesuai', 'danger');
                            header('Location:' . BASEURL . '/user/data_gaji');
                            exit;
                        }
                    }
                } else {
                    if (!empty($id) && !empty($session)) {
                        // Menyusun website
                        $this->view('master/header', $data);
                        $this->view('page/ubah_password', $data);
                        $this->view('master/footer', $data);
                    } else {
                        Flasher::setflash('Gagal', 'Diubah, Error Parameter', 'danger');
                        header('Location:' . BASEURL . '/user/data_gaji');
                        exit;
                    }
                }
            }
        }
    }
}