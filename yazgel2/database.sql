-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 05 Oca 2024, 22:25:33
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `canan`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders`
--

CREATE TABLE `ders` (
  `ders_id` int(11) NOT NULL,
  `ders_ad` varchar(50) DEFAULT NULL,
  `ders_gun` varchar(20) DEFAULT NULL,
  `ders_saat` varchar(11) DEFAULT NULL,
  `ders_classes` int(11) DEFAULT NULL,
  `ders_hoca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ders`
--

INSERT INTO `ders` (`ders_id`, `ders_ad`, `ders_gun`, `ders_saat`, `ders_classes`, `ders_hoca`) VALUES
(1, 'Fizik - 1', 'Perşembe', '12:00', NULL, 1),
(2, 'Nanoteknoloji', NULL, NULL, NULL, 1),
(3, 'Algoritma Programlama', NULL, NULL, NULL, 2),
(4, 'Oyun Programlama', NULL, NULL, NULL, 2),
(5, 'Yazlab', NULL, NULL, NULL, 2),
(6, 'Programlama Lab', NULL, NULL, NULL, 2),
(7, 'Web Tasarım', NULL, NULL, NULL, 3),
(8, 'Web Tasarım Lab', NULL, NULL, NULL, 3),
(9, 'Bulut Bilişim', NULL, NULL, NULL, 3),
(10, 'Mobil Uygulama', 'Perşembe', '10:00', NULL, 3),
(11, 'Veri Yapıları ve Algoritmalar', NULL, NULL, NULL, 1),
(12, 'Veri Yapıları Lab', NULL, NULL, NULL, 4),
(13, 'Linux', NULL, NULL, NULL, 4),
(14, 'Görüntü İşleme', NULL, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hoca`
--

CREATE TABLE `hoca` (
  `hoca_id` int(11) NOT NULL,
  `hoca_isim` varchar(256) DEFAULT NULL,
  `hoca_istenmeyengun` varchar(500) DEFAULT NULL,
  `hoca_dersProgrami` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `hoca`
--

INSERT INTO `hoca` (`hoca_id`, `hoca_isim`, `hoca_istenmeyengun`, `hoca_dersProgrami`) VALUES
(1, 'Hikmet Hakan Gürel', 'Pazartesi,Salı,Çarşamba', '{\"dersprogrami\":[{\"id\":1,\"ad\":\"Fizik - 1\",\"gun\":\"Per\\u015fembe\",\"saat\":\"12:00\",\"classes\":\"Derslik 1\"},{\"id\":2,\"ad\":\"Nanoteknoloji\",\"gun\":\"Per\\u015fembe\",\"saat\":\"10:00\",\"classes\":\"Derslik 1\"},{\"id\":11,\"ad\":\"Veri Yap\\u0131lar\\u0131 ve Algoritmalar\",\"gun\":\"Per\\u015fembe\",\"saat\":\"11:00\",\"classes\":\"Derslik 1\"}]}'),
(2, 'Yavuz Selim Fatihoğlu', 'Pazartesi', '{\"dersprogrami\":[{\"id\":3,\"ad\":\"Algoritma Programlama\",\"gun\":\"Sal\\u0131\",\"saat\":\"09:00\",\"classes\":\"Derslik 1\"},{\"id\":4,\"ad\":\"Oyun Programlama\",\"gun\":\"Sal\\u0131\",\"saat\":\"10:00\",\"classes\":\"Derslik 1\"},{\"id\":5,\"ad\":\"Yazlab\",\"gun\":\"Sal\\u0131\",\"saat\":\"11:00\",\"classes\":\"Derslik 1\"},{\"id\":6,\"ad\":\"Programlama Lab\",\"gun\":\"Sal\\u0131\",\"saat\":\"12:00\",\"classes\":\"Derslik 1\"}]}'),
(3, 'Önder Yakut', NULL, '{\"dersprogrami\":[{\"id\":7,\"ad\":\"Web Tasar\\u0131m\",\"gun\":\"Pazartesi\",\"saat\":\"09:00\",\"classes\":\"Derslik 1\"},{\"id\":8,\"ad\":\"Web Tasar\\u0131m Lab\",\"gun\":\"Pazartesi\",\"saat\":\"10:00\",\"classes\":\"Derslik 1\"},{\"id\":9,\"ad\":\"Bulut Bili\\u015fim\",\"gun\":\"Pazartesi\",\"saat\":\"11:00\",\"classes\":\"Derslik 1\"},{\"id\":10,\"ad\":\"Mobil Uygulama\",\"gun\":\"Per\\u015fembe\",\"saat\":\"10:00\",\"classes\":\"Derslik 2\"}]}'),
(4, 'Serdar Solak', NULL, '{\"dersprogrami\":[{\"id\":12,\"ad\":\"Veri Yap\\u0131lar\\u0131 Lab\",\"gun\":\"Pazartesi\",\"saat\":\"09:00\",\"classes\":\"Derslik 2\"},{\"id\":13,\"ad\":\"Linux\",\"gun\":\"Pazartesi\",\"saat\":\"10:00\",\"classes\":\"Derslik 2\"},{\"id\":14,\"ad\":\"G\\u00f6r\\u00fcnt\\u00fc \\u0130\\u015fleme\",\"gun\":\"Pazartesi\",\"saat\":\"11:00\",\"classes\":\"Derslik 2\"}]}');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sinif`
--

CREATE TABLE `sinif` (
  `sinif_id` int(11) NOT NULL,
  `sinif_isim` varchar(50) DEFAULT NULL,
  `sinif_kod` varchar(50) DEFAULT NULL,
  `sinif_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sinif`
--

INSERT INTO `sinif` (`sinif_id`, `sinif_isim`, `sinif_kod`, `sinif_desc`) VALUES
(1, 'Derslik 1', 'E-321', 'Açıklama'),
(2, 'Derslik 2', 'E-324', 'Açıklama');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ders`
--
ALTER TABLE `ders`
  ADD PRIMARY KEY (`ders_id`);

--
-- Tablo için indeksler `hoca`
--
ALTER TABLE `hoca`
  ADD PRIMARY KEY (`hoca_id`);

--
-- Tablo için indeksler `sinif`
--
ALTER TABLE `sinif`
  ADD PRIMARY KEY (`sinif_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ders`
--
ALTER TABLE `ders`
  MODIFY `ders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `hoca`
--
ALTER TABLE `hoca`
  MODIFY `hoca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `sinif`
--
ALTER TABLE `sinif`
  MODIFY `sinif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
