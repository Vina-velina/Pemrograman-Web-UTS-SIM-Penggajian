-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2020 pada 06.33
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_vina_fix`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `gaji_user`
--

CREATE TABLE `gaji_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_bulan` varchar(50) NOT NULL,
  `jumlah_hadir` int(11) NOT NULL,
  `jumlah_ijin` int(11) NOT NULL,
  `besar_gaji` float NOT NULL,
  `total_gaji` float NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `create_at` datetime DEFAULT NULL,
  `create_by` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `gaji_user`
--

INSERT INTO `gaji_user` (`id`, `id_user`, `nama_bulan`, `jumlah_hadir`, `jumlah_ijin`, `besar_gaji`, `total_gaji`, `status`, `create_at`, `create_by`) VALUES
(3, 3, 'September 2020', 15, 15, 50000, 750000, 1, '2020-10-16 07:01:48', 'Administrator'),
(4, 3, 'October 2020', 30, 0, 50000, 1500000, 1, '2020-10-30 03:05:15', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `foto_user` text DEFAULT NULL,
  `nama_user` text NOT NULL,
  `jabatan` int(1) NOT NULL DEFAULT 2,
  `alamat_asal` text NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `foto_user`, `nama_user`, `jabatan`, `alamat_asal`, `active`, `create_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$X8PRd8YCuOYnt1SuXaMdduCk/uNGHzzVno7Viw3vGWtGiFiaslmLm', NULL, 'Administrator', 1, 'lovina bali singaraja', 1, '2020-10-15 22:40:56'),
(3, 'riyan.clsg11@gmail.com', '$2y$10$QWw7Ny2iUwrbk6YJAWZNEezvWhpVkd7J7L/8rTr568TWcUNIPjdK6', NULL, 'deyan ardi', 2, 'lovina bali singaraja', 1, '2020-10-15 18:59:18'),
(5, 'riyan@undiksha.ac.id', '$2y$10$ZphmW0dBhLx1ys68io/ZNeNgcgth9Q/vblbvtRK.fedRCeVrH66yy', NULL, 'deyan', 2, 'ardi', 0, '2020-10-30 04:24:02'),
(6, 'ada@gmail.com', '$2y$10$OUWuPAaB6DUXEAYMlH0.heDZOw.WsQtMDfKTP8TezdU0DbGa8Jhzi', '5f9b99080f289_adada.jpg', 'adada', 2, 'adada', 0, '2020-10-30 05:39:36');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `gaji_user`
--
ALTER TABLE `gaji_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `gaji_user`
--
ALTER TABLE `gaji_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `gaji_user`
--
ALTER TABLE `gaji_user`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
