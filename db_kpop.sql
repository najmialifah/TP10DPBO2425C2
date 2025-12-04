-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 03:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kpop`
--

-- --------------------------------------------------------

--
-- Table structure for table `acara`
--

CREATE TABLE `acara` (
  `id` int(11) NOT NULL,
  `nama_acara` varchar(150) NOT NULL,
  `jenis_acara` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `tgl_acara` date DEFAULT NULL,
  `id_grup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `acara`
--

INSERT INTO `acara` (`id`, `nama_acara`, `jenis_acara`, `lokasi`, `tgl_acara`, `id_grup`) VALUES
(1, 'FATE PLUS World Tour', 'World Tour', 'KSPO Dome, Seoul', '2024-02-24', 1),
(2, 'SYNK: PARALLEL LINE', 'World Tour', 'Jamsil Indoor Stadium', '2024-06-29', 3),
(3, 'ACT: PROMISE', 'World Tour', 'KSPO Dome', '2024-05-03', 4),
(4, '2024 FESTA', 'Anniversary', 'Seoul', '2024-06-13', 5),
(5, 'THE DREAM SHOW 3', 'World Tour', 'Gocheok Sky Dome', '2024-05-02', 8),
(6, 'SHOW WHAT I HAVE', 'World Tour', 'Tokyo Dome', '2024-09-04', 9),
(7, 'READY TO BE Special', 'Stadium Tour', 'Nissan Stadium', '2024-07-27', 10),
(8, 'TWS 1st Fanmeeting', 'Fanmeeting', 'Seoul', '2024-10-01', 11);

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `judul_album` varchar(150) NOT NULL,
  `jenis_album` varchar(50) DEFAULT NULL,
  `tgl_rilis` date DEFAULT NULL,
  `id_grup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `judul_album`, `jenis_album`, `tgl_rilis`, `id_grup`) VALUES
(1, 'BORDER : DAY ONE', 'Mini Album', '2020-11-30', 1),
(2, 'DIMENSION : DILEMMA', 'Studio Album', '2021-10-12', 1),
(3, 'DARK BLOOD', 'Mini Album', '2023-05-22', 1),
(4, 'ORANGE BLOOD', 'Mini Album', '2023-11-17', 1),
(5, 'ROMANCE : UNTOLD', 'Studio Album', '2024-07-12', 1),
(6, 'ROMANCE : UNTOLD -daydream-', 'Repackage', '2024-11-11', 1),
(7, 'SUPER REAL ME', 'Mini Album', '2024-03-25', 2),
(8, 'I\'LL LIKE YOU', 'Mini Album', '2024-10-21', 2),
(9, 'Savage', 'Mini Album', '2021-10-05', 3),
(10, 'MY WORLD', 'Mini Album', '2023-05-08', 3),
(11, 'Drama', 'Mini Album', '2023-11-10', 3),
(12, 'Armageddon', 'Studio Album', '2024-05-27', 3),
(13, 'Whiplash', 'Mini Album', '2024-10-21', 3),
(14, 'The Chaos Chapter: FREEZE', 'Studio Album', '2021-05-31', 4),
(15, 'The Name Chapter: FREEFALL', 'Studio Album', '2023-10-13', 4),
(16, 'minisode 3: TOMORROW', 'Mini Album', '2024-04-01', 4),
(17, 'The Star Chapter: SANCTUARY', 'Mini Album', '2024-11-04', 4),
(18, 'Map of the Soul: 7', 'Studio Album', '2020-02-21', 5),
(19, 'BE', 'Studio Album', '2020-11-20', 5),
(20, 'Proof', 'Anthology', '2022-06-10', 5),
(21, 'ANTIFRAGILE', 'Mini Album', '2022-10-17', 6),
(22, 'UNFORGIVEN', 'Studio Album', '2023-05-01', 6),
(23, 'EASY', 'Mini Album', '2024-02-19', 6),
(24, 'CRAZY', 'Mini Album', '2024-08-30', 6),
(25, 'BABYMONS7ER', 'Mini Album', '2024-04-01', 7),
(26, 'DRIP', 'Studio Album', '2024-11-01', 7),
(27, 'Hot Sauce', 'Studio Album', '2021-05-10', 8),
(28, 'ISTJ', 'Studio Album', '2023-07-17', 8),
(29, 'DREAM( )SCAPE', 'Mini Album', '2024-03-25', 8),
(30, 'DREAMSCAPE', 'Studio Album', '2024-11-11', 8),
(31, 'I\'ve IVE', 'Studio Album', '2023-04-10', 9),
(32, 'I\'VE MINE', 'EP', '2023-10-13', 9),
(33, 'IVE SWITCH', 'EP', '2024-04-29', 9),
(34, 'Formula of Love: O+T=<3', 'Studio Album', '2021-11-12', 10),
(35, 'Ready To Be', 'Mini Album', '2023-03-10', 10),
(36, 'With YOU-th', 'Mini Album', '2024-02-23', 10),
(37, 'STRATEGY', 'Mini Album', '2024-12-06', 10),
(38, 'Sparkling Blue', 'Mini Album', '2024-01-22', 11),
(39, 'SUMMER BEAT!', 'Mini Album', '2024-06-24', 11);

-- --------------------------------------------------------

--
-- Table structure for table `grup`
--

CREATE TABLE `grup` (
  `id` int(11) NOT NULL,
  `nama_grup` varchar(100) NOT NULL,
  `agensi` varchar(100) NOT NULL,
  `tahun_debut` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grup`
--

INSERT INTO `grup` (`id`, `nama_grup`, `agensi`, `tahun_debut`) VALUES
(1, 'ENHYPEN', 'BELIFT LAB', '2020'),
(2, 'ILLIT', 'BELIFT LAB', '2024'),
(3, 'aespa', 'SM Entertainment', '2020'),
(4, 'TXT', 'BIGHIT MUSIC', '2019'),
(5, 'BTS', 'BIGHIT MUSIC', '2013'),
(6, 'LE SSERAFIM', 'SOURCE MUSIC', '2022'),
(7, 'BABYMONSTER', 'YG Entertainment', '2023'),
(8, 'NCT DREAM', 'SM Entertainment', '2016'),
(9, 'IVE', 'Starship Entertainment', '2021'),
(10, 'TWICE', 'JYP Entertainment', '2015'),
(11, 'TWS', 'Pledis Entertainment', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `nama_panggung` varchar(100) DEFAULT NULL,
  `kewarganegaraan` varchar(50) DEFAULT NULL,
  `id_grup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nama_lengkap`, `nama_panggung`, `kewarganegaraan`, `id_grup`) VALUES
(1, 'Yang Jung-won', 'Jungwon', 'South Korea', 1),
(2, 'Lee Hee-seung', 'Heeseung', 'South Korea', 1),
(3, 'Park Jong-seong', 'Jay', 'USA/South Korea', 1),
(4, 'Sim Jae-yun', 'Jake', 'Australia/South Korea', 1),
(5, 'Park Sung-hoon', 'Sunghoon', 'South Korea', 1),
(6, 'Kim Sun-oo', 'Sunoo', 'South Korea', 1),
(7, 'Nishimura Riki', 'Ni-ki', 'Japan', 1),
(8, 'Noh Yun-ah', 'Yunah', 'South Korea', 2),
(9, 'Park Min-ju', 'Minju', 'South Korea', 2),
(10, 'Sakai Moka', 'Moka', 'Japan', 2),
(11, 'Lee Won-hee', 'Wonhee', 'South Korea', 2),
(12, 'Hokazono Iroha', 'Iroha', 'Japan', 2),
(13, 'Yoo Ji-min', 'Karina', 'South Korea', 3),
(14, 'Uchinaga Aeri', 'Giselle', 'Japan', 3),
(15, 'Kim Min-jeong', 'Winter', 'South Korea', 3),
(16, 'Ning Yizhuo', 'Ningning', 'China', 3),
(17, 'Choi Soo-bin', 'Soobin', 'South Korea', 4),
(18, 'Choi Yeon-jun', 'Yeonjun', 'South Korea', 4),
(19, 'Choi Beom-gyu', 'Beomgyu', 'South Korea', 4),
(20, 'Kang Tae-hyun', 'Taehyun', 'South Korea', 4),
(21, 'Kai Kamal Huening', 'Huening Kai', 'USA', 4),
(22, 'Kim Nam-joon', 'RM', 'South Korea', 5),
(23, 'Kim Seok-jin', 'Jin', 'South Korea', 5),
(24, 'Min Yoon-gi', 'Suga', 'South Korea', 5),
(25, 'Jung Ho-seok', 'J-Hope', 'South Korea', 5),
(26, 'Park Ji-min', 'Jimin', 'South Korea', 5),
(27, 'Kim Tae-hyung', 'V', 'South Korea', 5),
(28, 'Jeon Jung-kook', 'Jungkook', 'South Korea', 5),
(29, 'Kim Chae-won', 'Chaewon', 'South Korea', 6),
(30, 'Sakura Miyawaki', 'Sakura', 'Japan', 6),
(31, 'Huh Yun-jin', 'Yunjin', 'USA', 6),
(32, 'Nakamura Kazuha', 'Kazuha', 'Japan', 6),
(33, 'Hong Eun-chae', 'Eunchae', 'South Korea', 6),
(34, 'Kawai Ruka', 'Ruka', 'Japan', 7),
(35, 'Pharita Chaikong', 'Pharita', 'Thailand', 7),
(36, 'Enami Asa', 'Asa', 'Japan', 7),
(37, 'Jung Ah-yeon', 'Ahyeon', 'South Korea', 7),
(38, 'Shin Ha-ram', 'Rami', 'South Korea', 7),
(39, 'Lee Da-in', 'Rora', 'South Korea', 7),
(40, 'Riracha Phondechaphiphat', 'Chiquita', 'Thailand', 7),
(41, 'Mark Lee', 'Mark', 'Canada', 8),
(42, 'Huang Renjun', 'Renjun', 'China', 8),
(43, 'Lee Je-no', 'Jeno', 'South Korea', 8),
(44, 'Lee Dong-hyuck', 'Haechan', 'South Korea', 8),
(45, 'Na Jae-min', 'Jaemin', 'South Korea', 8),
(46, 'Zhong Chenle', 'Chenle', 'China', 8),
(47, 'Park Ji-sung', 'Jisung', 'South Korea', 8),
(48, 'An Yu-jin', 'Yujin', 'South Korea', 9),
(49, 'Kim Ga-eul', 'Gaeul', 'South Korea', 9),
(50, 'Naoi Rei', 'Rei', 'Japan', 9),
(51, 'Jang Won-young', 'Wonyoung', 'South Korea', 9),
(52, 'Kim Ji-won', 'Liz', 'South Korea', 9),
(53, 'Lee Hyun-seo', 'Leeseo', 'South Korea', 9),
(54, 'Park Ji-hyo', 'Jihyo', 'South Korea', 10),
(55, 'Im Na-yeon', 'Nayeon', 'South Korea', 10),
(56, 'Yoo Jeong-yeon', 'Jeongyeon', 'South Korea', 10),
(57, 'Hirai Momo', 'Momo', 'Japan', 10),
(58, 'Minatozaki Sana', 'Sana', 'Japan', 10),
(59, 'Myoui Mina', 'Mina', 'Japan', 10),
(60, 'Kim Da-hyun', 'Dahyun', 'South Korea', 10),
(61, 'Son Chae-young', 'Chaeyoung', 'South Korea', 10),
(62, 'Chou Tzu-yu', 'Tzuyu', 'Taiwan', 10),
(63, 'Shin Jung-hwan', 'Shinyu', 'South Korea', 11),
(64, 'Kim Do-hoon', 'Dohoon', 'South Korea', 11),
(65, 'Choi Young-jae', 'Youngjae', 'South Korea', 11),
(66, 'Han Zhen', 'Hanjin', 'China', 11),
(67, 'Han Ji-hoon', 'Jihoon', 'South Korea', 11),
(68, 'Lee Kyung-min', 'Kyungmin', 'South Korea', 11);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `jumlah_terjual` int(11) NOT NULL,
  `negara` varchar(50) DEFAULT NULL,
  `sumber_chart` varchar(50) DEFAULT NULL,
  `id_album` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `jumlah_terjual`, `negara`, `sumber_chart`, `id_album`) VALUES
(1, 2300000, 'Global', 'Hanteo', 5),
(2, 600000, 'South Korea', 'Circle', 7),
(3, 1200000, 'South Korea', 'Circle', 12),
(4, 3200000, 'Global', 'Billboard', 20),
(5, 1000000, 'USA', 'Billboard', 24),
(6, 800000, 'Global', 'Circle', 26),
(7, 2500000, 'South Korea', 'Circle', 28),
(8, 1600000, 'South Korea', 'Circle', 33),
(9, 1100000, 'USA', 'Billboard', 36);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grup` (`id_grup`);

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grup` (`id_grup`);

--
-- Indexes for table `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grup` (`id_grup`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_album` (`id_album`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acara`
--
ALTER TABLE `acara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `grup`
--
ALTER TABLE `grup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acara`
--
ALTER TABLE `acara`
  ADD CONSTRAINT `acara_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_grup`) REFERENCES `grup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
