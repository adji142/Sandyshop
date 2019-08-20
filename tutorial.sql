-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27 Jan 2018 pada 11.53
-- Versi Server: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tutorial`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
`id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(2, 'Nike'),
(5, 'Sketchers'),
(6, 'Polo'),
(7, 'Adidas'),
(8, 'Diadora'),
(9, 'Stone Islands');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`id` int(11) NOT NULL,
  `items` text NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(19, '[{"id":"4","size":"S","quantity":"75"}]', '2016-03-16 15:27:46', 1, 1),
(20, '[{"id":"9","size":"29","quantity":"1"}]', '2016-03-18 12:00:51', 1, 1),
(21, '[{"id":"13","size":"36","quantity":"95"}]', '2016-03-18 13:18:30', 1, 0),
(22, '[{"id":"11","size":"37","quantity":"6"},{"id":"10","size":"L","quantity":117},{"id":"13","size":"37","quantity":21}]', '2016-03-19 02:51:09', 1, 0),
(23, '[{"id":"4","size":"L","quantity":"21"}]', '2016-03-19 08:28:34', 1, 0),
(24, '[{"id":"2","size":"small","quantity":"1"}]', '2018-02-22 13:09:18', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Shirts', 1),
(6, 'Pants', 1),
(7, 'Shoes', 1),
(8, 'Accessories', 1),
(9, 'Shirts', 2),
(10, 'Pants', 2),
(11, 'Shoes', 2),
(12, 'Dresses', 2),
(13, 'Shirts', 3),
(14, 'Dresses', 3),
(15, 'Dresses', 4),
(16, 'Shoes', 4),
(17, 'Accessories', 2),
(21, 'Home Decor', 18),
(24, 'Accessories', 23),
(25, 'Pants', 3),
(26, 'Pants', 4),
(27, 'Shoes', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `last_price` int(255) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `last_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'Levi&#039;s Jeans', 30000, 50000, 1, '6', '/tutorial/images/productse3036b252bca6e4dd83c50bcb4947496.png', 'wakwaw', 1, '28:3:2,32:5:2,36:1:2', 1),
(2, 'Beautiful Shirts', 60000, 90000, 1, '5', '/tutorial/images/products/men1.png', 'Ini adalah shirts paling maknyoss seluruh dunia yang indehoy banget gaesss...', 1, 'small:3:4,medium:6:2,large:7:1', 1),
(4, 'Restu Violinist', 79000, 100000, 5, '7', '/tutorial/images/products0a82d8ae02d9a4a7057da4d4930f4496.jpg', 'Ini adalah restu sang master violinist di dunia, Heheheh insyaallah :D', 1, 'S:3:,M:3:,L:3:,XL:12:', 1),
(8, 'wakwaw', 88000, 96000, 6, '8', '/tutorial/images/products7931341e167450339d644b21d9e2e254.png', 'Jika Jija Jika Jika Jika Jija Jika Jika Jika Jija Jika Jika Jika Jija Jika Jika Jika Jija Jika Jika Jika Jija Jika Jika Jika Jija Jika JikavJika Jija Jika Jika Jika Jija Jika Jikav v Jika Jija Jika Jika', 1, 'S:23:19', 1),
(9, 'Barang Mewah', 50000, 100000, 1, '6', '/tutorial/images/products8dc35341b4613b6bb06e1f1a496b7d04.jpg', 'Barang termahal sejagat raya brother', 1, '29:30:21', 1),
(10, 'Barang Geunah', 3000000, 3500000, 6, '17', '/tutorial/images/products9178eb14156ad89200f14ee498b2560c.png', 'Barang Terhits Seantero Dunia!', 1, 'L:-113:', 1),
(11, 'Barang Gaul', 750000, 977000, 1, '25', '/tutorial/images/products967bfb31dfed0b9d5812653e57efc8ce.png', 'Barang tergaul di 2016 guys', 1, '36:4:,37:-4:', 1),
(12, 'Baby shirt', 75000, 100000, 5, '15', '/tutorial/images/products341113e9eb22d107b1c4365d7ae87e6c.jpg', 'Cocok buat bayi lucu anda :D mang', 1, '17:3:1,18:9:3,19:2:1,20:7:4', 1),
(13, 'Barang Sangat Mahal', 5000000, 5500000, 8, '7', '/tutorial/images/productsc0d529ce58092db3478a2f07666d6b85.png,/tutorial/images/productsc18c2f35027590e6cb55f858a97314c0.png,/tutorial/images/products45436c02dc2f801668206c94a2956bfa.png,/tutorial/images/productsefe2bf1b6d32eb2152c58dc6385a992c.png,/tutorial/images/productsf8d996dc7ee9de79dd8b2727bdf8a5ef.png,/tutorial/images/products1c9fb6b1c46859910ddb740921f4c54b.png,/tutorial/images/products98f7eeb06446e510cc6a9c7354daa05a.jpg,/tutorial/images/products23cb608e6a1fa3015f039bc0f4ef7713.png,/tutorial/images/products622855527b74a3d21d7181a42dadfea2.png,/tutorial/images/products731565a837d33756c215308888be1059.png,/tutorial/images/products7129207782d037993b8035fbc259e8ae.png,/tutorial/images/products8b607f741463d5b74f9486f018394336.png', 'wawk', 1, '36:9:,37:-21:', 1),
(14, 'test', 150000, 150000, 7, '14', '/tutorial/images/productsfaf5574f493ed8187f68b26618ec2019.png', 'asd', 0, 'xs:20:10', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
`id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street2` varchar(255) NOT NULL,
  `city` varchar(175) NOT NULL,
  `state` varchar(175) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `country` varchar(175) NOT NULL,
  `sub_total` int(255) NOT NULL,
  `tax` int(255) NOT NULL,
  `grand_total` int(255) NOT NULL,
  `description` text NOT NULL,
  `txn_date` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_date`) VALUES
(1, 19, 'restugans', 'alupadia@yahoo.com', 'asfdf', 'dfsdf', 'sdfsdffds', 'sdfsdfds', '123456', 'endonesia', 5925000, 515475, 6440475, '75 items dari Shauntas Boutique.', '2016-02-17 19:15:11'),
(2, 20, 'Anak Gantenga', 'anakgans@gmail.com', 'bandung kota', 'bandung timur', 'jawa barat', 'jawa', '123456', 'Endonesia', 50000, 4350, 54350, '1 item dari Shauntas Boutique.', '2016-02-14 12:45:31'),
(3, 21, 'Ahmad Haerul Zam Zam', 'ahmadlupa@yahoo.com', 'Komplek Perum', 'Blok.2 Beulah Sisi', 'Bandung', 'Jawa Barat', '123456', 'Indonesia', 475000000, 41325000, 516325000, '95 items dari Shauntas Boutique.', '2016-02-17 13:19:35'),
(4, 22, 'Bambang Haerul Zam Zam', 'bambangedan@gmail.com', 'Rawamangun', 'Klender', 'Jakarta', 'Jakarta Pusat', '123456', 'Indonesia', 460500000, 40063500, 500563500, '144 items dari Shauntas Boutique.', '2016-02-18 02:52:53'),
(5, 22, 'Bambang Haerul Zam Zam', 'bambangedan@gmail.com', 'Rawamangun', 'Klender', 'Jakarta', 'Jakarta Pusat', '123456', 'Indonesia', 460500000, 40063500, 500563500, '144 items dari Shauntas Boutique.', '2016-02-18 02:55:46'),
(6, 23, 'Ahmad Taefu', 'ahmadlatif@yahoo.com', 'komplek bina muda', 'jl.kuat no21', 'Garut', 'Jawa Barat', '123456', 'Indonesia', 1659000, 144333, 1803333, '21 items dari Shauntas Boutique.', '2016-02-18 08:29:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(3, 'Prasetyo Aji Wibowo', 'prasetyoajiw@gmail.com', '$2y$10$QNmkR/As6zEtWbfmS6KTVeFPP4HmV1.D0YRAJ8FxOEGUTHpwR7CU.', '2018-01-23 19:05:09', '2018-01-27 17:49:17', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
