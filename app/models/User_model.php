<?php
class User_model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function cekEmailUser($data)
    {
        $query = "SELECT * FROM user WHERE email =:email_user AND active=:id";
        $this->db->query($query);
        $this->db->bind('email_user', $data);
        $this->db->bind('id', 1);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getUserWhere($data)
    {
        $this->db->query('SELECT*FROM user WHERE id=:id');
        $this->db->bind('id', $data);
        return $this->db->resulSet();
    }
    public function getUserWhereEmail($data)
    {
        $this->db->query('SELECT*FROM user WHERE email=:id');
        $this->db->bind('id', $data);
        return $this->db->resulSet();
    }
    public function cekPasswd($data)
    {
        $query = "SELECT * FROM user WHERE password =:passwd";
        $this->db->query($query);
        $this->db->bind('passwd', $data['passwd']);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getUser($data)
    {
        $this->db->query('SELECT*FROM user WHERE email=:email_user');
        $this->db->bind('email_user', $data);
        return $this->db->single();
    }
    public function getAllUser()
    {
        $this->db->query('SELECT*FROM user');
        return $this->db->resulSet();
    }
    public function getAllUserNoAdmin()
    {
        $this->db->query('SELECT*FROM user WHERE jabatan != 1');
        return $this->db->resulSet();
    }
    public function inputUser($data, $pass, $new_Foto)
    {
        $query = "INSERT INTO user (email,password,foto_user,nama_user,jabatan,alamat_asal,active,create_at) VALUES (:email,:passwd,:foto,:nama,:jabatan,:alamat,:active,:create_at)";
        $this->db->query($query);
        $this->db->bind('email', $data['email']);
        $this->db->bind('passwd', $pass);
        $this->db->bind('foto', $new_Foto);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', 2);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('active', 0);
        $this->db->bind('create_at', date('Y-m-d H:i:s'));
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function editUser($data, $id_user, $new_Foto)
    {
        $query = "UPDATE user SET foto_user=:foto,nama_user=:nama,jabatan=:jabatan,alamat_asal=:alamat WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('foto', $new_Foto);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function editPassword($id_user, $new)
    {
        $query = "UPDATE user SET password=:new WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('new', $new);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function nonAktifUserWhere($id_user)
    {
        $query = "UPDATE user SET active=:id_active WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('id_active', 0);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function aktifUserWhere($id_user)
    {
        $query = "UPDATE user SET active=:id_active WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('id_active', 1);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function deleteUserWhere($id)
    {
        $this->db->query('DELETE FROM user WHERE id=:id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getAllGaji()
    {
        $this->db->query('SELECT gaji_user.*, user.nama_user FROM gaji_user INNER JOIN user ON user.id=gaji_user.id_user');
        return $this->db->resulSet();
    }
    public function cekBulanGaji($user, $bulan)
    {
        $query = "SELECT * FROM gaji_user WHERE id_user =:id_user AND nama_bulan=:bulan";
        $this->db->query($query);
        $this->db->bind('id_user', $user);
        $this->db->bind('bulan', $bulan);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function inputGaji($data, $bulan, $besar_gaji, $total_gaji, $create_by)
    {
        $query = "INSERT INTO gaji_user (id_user,nama_bulan,jumlah_hadir,jumlah_ijin,besar_gaji,total_gaji,status,create_by) VALUES (:id_user,:bulan,:hadir,:ijin,:besar,:total,:status,:create_by)";
        $this->db->query($query);
        $this->db->bind('id_user', $data['pegawai']);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('hadir', $data['hadir']);
        $this->db->bind('ijin', $data['ijin']);
        $this->db->bind('besar', $besar_gaji);
        $this->db->bind('total', $total_gaji);
        $this->db->bind('status', 0);
        $this->db->bind('create_by', $create_by);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function getGajiWhere($id)
    {
        $this->db->query('SELECT gaji_user.*, user.nama_user FROM gaji_user INNER JOIN user ON user.id=gaji_user.id_user WHERE gaji_user.id=:id');
        $this->db->bind('id', $id);
        return $this->db->resulSet();
    }
    public function getAllGajiWhere($id)
    {
        $this->db->query('SELECT gaji_user.*, user.nama_user FROM user INNER JOIN gaji_user ON user.id=gaji_user.id_user WHERE user.id=:id');
        $this->db->bind('id', $id);
        return $this->db->resulSet();
    }
    public function bayarGajiWhere($id_user)
    {
        $query = "UPDATE gaji_user SET status=:id_status,create_at=:tanggal WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('id_status', 1);
        $this->db->bind('tanggal', date("Y-m-d H:i:s"));
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function editGajiUser($data, $id, $total_gaji)
    {
        $query = "UPDATE gaji_user SET jumlah_hadir=:hadir,jumlah_ijin=:ijin,total_gaji=:gaji WHERE id=:id_user";
        $this->db->query($query);
        $this->db->bind('hadir', $data['hadir']);
        $this->db->bind('ijin', $data['ijin']);
        $this->db->bind('gaji', $total_gaji);
        $this->db->bind('id_user', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
    public function deleteGajiWhere($id)
    {
        $this->db->query('DELETE FROM gaji_user WHERE id=:id');
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}