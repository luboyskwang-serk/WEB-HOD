-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2024 at 06:50 PM
-- Server version: 10.6.16-MariaDB-log
-- PHP Version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kakarotc_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `apipeam_product`
--

CREATE TABLE `apipeam_product` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `img` text NOT NULL,
  `des` text NOT NULL,
  `price_default` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` text NOT NULL,
  `c_type` text NOT NULL,
  `showitem` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apipeam_product`
--

INSERT INTO `apipeam_product` (`id`, `name`, `img`, `des`, `price_default`, `price`, `stock`, `c_type`, `showitem`) VALUES
(1, 'Netflix ตัด00.00น. (มือถือ) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '❌ ไม่สามารถชมบนทีวีได้ \r\n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\r\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \r\n✔️ แอคเคาท์ไทย 100% \r\n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\r\n✔️ ความละเอียดระดับ UltraHD 4K \r\n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 4.00, 50.00, '0', '0', 0),
(2, 'Netflix 1 วัน (มือถือ) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '❌ ไม่สามารถชมบนทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 8.00, 17.00, '0', 'NETFILX', 1),
(3, 'Netflix 1 วัน (TV) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 15.00, 24.00, '0', 'NETFILX', 1),
(4, 'Netflix 7 วัน (มือถือ) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '❌ ไม่สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 32.00, 39.00, '0', 'NETFILX', 1),
(5, 'Netflix 7 วัน (TV) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 40.00, 49.00, '4', 'NETFILX', 1),
(6, 'Netflix 7 วัน (จอเสริม) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '✔️ สามารถรับชมได้ทุกอุปกรณ์ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 50.00, 59.00, '2', 'NETFILX', 1),
(7, 'เพิ่มประกันโดนปิด (7วัน) ', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', 'เพิ่มประกันของ NETFILX หากมีการโดนปิด\r\n\r\nหรือใช้งานไม่ครบ 7 วัน ร้านจะเคลมจนได้ดูตามจำนวน', 20.00, 29.00, '20', '0', 1),
(8, 'Netflix 30 วัน (มือถือ) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '❌ ไม่สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 100.00, 104.00, '3', 'NETFILX', 1),
(9, 'Netflix 30 วัน (TV) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 145.00, 144.00, '1', 'NETFILX', 1),
(10, 'Netflix 30 วัน (จอเสริม) ตัด GIFT', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', '✔️ สามารถรับชมได้ทุกอุปกรณ์ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 165.00, 174.00, '0', 'NETFILX', 1),
(11, 'เพิ่มประกันโดนปิด (30วัน)', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', 'เพิ่มประกันของ NETFILX หากมีการโดนปิด\r\n\r\nหรือใช้งานไม่ครบ 30 วัน ร้านจะเคลมจนได้ดูตามจำนวน', 30.00, 35.00, '7', '0', 0),
(12, 'ACC NF ตัด GIFT 7 วัน (เฉพาะvip)', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', 'ยกแอค \r\nตัด22.00 ของวันหมดอายุ\r\nเคลียร์จอ ตั้งพินเองได้เลย', 220.00, 149.00, '0', '0', 0),
(13, 'ACC NF ตัด GIFT 30 วัน (เฉพาะvip)', 'https://img2.pic.in.th/pic/Netflix681789d76d794383.png', 'ยกแอค \nตัด22.00 ของวันหมดอายุ\nเคลียร์จอ ตั้งพินเองได้เลย', 540.00, 490.00, '0', 'NETFILX', 0),
(14, 'CANVA 30 วัน ( เมลลค )', 'https://img5.pic.in.th/file/secure-sv1/CANVAd7f206684f4a4e01.png', '<center>✿ CANVA 30 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เมล์ลูกค้าเข้าร่วม \n 【✔️】ใช้แคนวาโปร\n 【✔️】รับประกันตลอดการใช้งาน\n 【❌】กดเข้าร่วมเพียง 1 เมล์  เท่านั้น\n 【⚠】หลังจากเข้าเเล้วเเจ้งเมล์ด้วยทุกครั้ง\n◈ ━━━━━━━━━━━━━━ ◈', 12.00, 21.00, '6', '0', 1),
(15, 'CANVA 30 วัน ( เมลร้าน )', 'https://img5.pic.in.th/file/secure-sv1/CANVAd7f206684f4a4e01.png', '<center>✿ CANVA 30 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เข้าสู้ระบบด้วยเมลเเละรหัส ไม่ใช่ google\n 【✔️】ใช้แคนวาโปร\n 【✔️】รับประกันตลอดการใช้งาน\n◈ ━━━━━━━━━━━━━━ ◈', 15.00, 24.00, '1', '0', 1),
(16, 'YouTube 30 DAYS  (ไม่ต่อ เมลลูกค้า)', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', '⏰ วันใช้งาน 30 วัน\n❌ ไม่ต่ออายุใช้งาน( 1 เมล์เข้าได้ 2 รอบ )\n➢ รับชมแบบไม่มีโฆษณา\n➢ ฟังเพลงปิดหน้าจอได้ ..\n✔️ ใช้เมล์ของลูกค้าเข้าร่วม \n✔️ ได้รับลิ้งค์เข้าร่วมครอบครัว', 8.00, 17.00, '5', '0', 1),
(17, 'YouTube 30 DAYS (ไม่ต่อ เมลร้าน) ', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', '⏰ วันใช้งาน 30 วัน\n❌ ไม่ต่ออายุใช้งาน( 1 เมล์เข้าได้ 2 รอบ )\n➢ รับชมแบบไม่มีโฆษณา\n➢ ฟังเพลงปิดหน้าจอได้ ..\n✔️ เมลร้าน\n❌ ไม่รับเคลมหากโดนปิด ติดยืนยัน', 15.00, 24.00, '10', '0', 1),
(18, 'YouTube 30 DAYS (ต่อเมล์ เมลลค) ', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', 'เมลร้าน +5฿ สามารถเเจ้งแอดมินให้ส่งเมลให้ได้เลย\n\n<center>✿ YouTube 30 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เมล์ลูกค้าเข้าร่วมครอบครัว หากต้องการเมลร้านให้แจ้งแอดมิน\n 【✔️】ฟังเพลงปิดหน้าจอได้ \n 【✔️】รับชมแบบไม่มีโฆษณา\n 【✔️】รับประกันตลอดการใช้งาน\n 【✔️】ตัดจ่ายทุกๆ 30 วัน\n 【✔️】มีกลุ่มแจ้ง ต่อทุกเดือน\n 【❌】1 เมล์ เข้าร่วมได้ครอบครัวได้ 2 ครั้ง\n 【⚠】หากเคยเข้าร่วมครอบครัวมาแล้ว 2 ครั้งกรุณาเปลี่ยนเมล์ใหม่กรณีนี้ไม่รับเคลม\nเว็บไซต์ : https://www.youtube.com\n◈ ━━━━━━━━━━━━━━ ◈', 40.00, 49.00, '1', '0', 1),
(19, 'YouTube 30 DAYS (ต่อเมล์ เมลร้าน)', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', 'เมลร้าน +5฿ สามารถเเจ้งแอดมินให้ส่งเมลให้ได้เลย\n\n<center>✿ YouTube 30 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เมล์ลูกค้าเข้าร่วมครอบครัว หากต้องการเมลร้านให้แจ้งแอดมิน\n 【✔️】ฟังเพลงปิดหน้าจอได้ \n 【✔️】รับชมแบบไม่มีโฆษณา\n 【✔️】รับประกันตลอดการใช้งาน\n 【✔️】ตัดจ่ายทุกๆ 30 วัน\n 【✔️】มีกลุ่มแจ้ง ต่อทุกเดือน\n 【❌】1 เมล์ เข้าร่วมได้ครอบครัวได้ 2 ครั้ง\n 【⚠】หากเคยเข้าร่วมครอบครัวมาแล้ว 2 ครั้งกรุณาเปลี่ยนเมล์ใหม่กรณีนี้ไม่รับเคลม\nเว็บไซต์ : https://www.youtube.com\n◈ ━━━━━━━━━━━━━━ ◈', 45.00, 54.00, '0', '0', 1),
(20, 'YouTube 90 DAYS (ต่อเมล์ เมลลค)', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', '<center>✿ YouTube 90 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เมล์ลูกค้าเข้าร่วมครอบครัว หากต้องการเมลร้านให้แจ้งแอดมิน\n 【✔️】ฟังเพลงปิดหน้าจอได้ \n 【✔️】รับชมแบบไม่มีโฆษณา\n 【✔️】รับประกันตลอดการใช้งาน\n 【✔️】ตัดจ่ายทุกๆ 30 วัน\n 【✔️】มีกลุ่มแจ้ง ต่อทุกเดือน\n 【❌】1 เมล์ เข้าร่วมได้ครอบครัวได้ 2 ครั้ง\n 【⚠】หากเคยเข้าร่วมครอบครัวมาแล้ว 2 ครั้งกรุณาเปลี่ยนเมล์ใหม่กรณีนี้ไม่รับเคลม\nเว็บไซต์ : https://www.youtube.com\n◈ ━━━━━━━━━━━━━━ ◈', 135.00, 149.00, '1', '0', 1),
(21, 'YouTube 90 DAYS (ต่อเมล์ เมลร้าน)', 'https://img5.pic.in.th/file/secure-sv1/you85527237dde54b40.png', '<center>✿ YouTube 90 วัน ✿</center>\n◈ ━━━━━━━━━━━━━━ ◈\n 【✔️】เมล์ร้านเข้าร่วมครอบครัว \n 【✔️】ฟังเพลงปิดหน้าจอได้ \n 【✔️】รับชมแบบไม่มีโฆษณา\n 【✔️】รับประกันตลอดการใช้งาน\n 【✔️】ตัดจ่ายทุกๆ 30 วัน\n 【✔️】มีกลุ่มแจ้ง ต่อทุกเดือน\n\nเว็บไซต์ : https://www.youtube.com\n◈ ━━━━━━━━━━━━━━ ◈', 140.00, 159.00, '1', '0', 1),
(22, 'Wetv 15 วัน (จอหาร)', 'https://img5.pic.in.th/file/secure-sv1/we821f7ff4738b6c43.png', '⏰ วันใช้งาน 15 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอหาร หากจอชนต้องรอ\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 12.00, 21.00, '0', 'WETV / IQIYI / VIU', 1),
(23, 'Wetv 30 วัน (จอหาร) ÷4', 'https://img5.pic.in.th/file/secure-sv1/we821f7ff4738b6c43.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอหาร หากจอชนต้องรอ\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 25.00, 34.00, '1', 'WETV / IQIYI / VIU', 1),
(24, 'Wetv 30 วัน (จอหาร) ÷5', 'https://img5.pic.in.th/file/secure-sv1/we821f7ff4738b6c43.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอหาร หากจอชนต้องรอ\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 20.00, 29.00, '1', 'WETV / IQIYI / VIU', 1),
(25, 'Wetv 30 วัน (จอส่วนตัว)', 'https://img5.pic.in.th/file/secure-sv1/we821f7ff4738b6c43.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จะได้รับเป็น Email/Password\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 65.00, 74.00, '1', 'WETV / IQIYI / VIU', 1),
(26, 'IQIYI Gold 15 วัน (จอหาร)', 'https://img5.pic.in.th/file/secure-sv1/dsacvd.png', '• IQIY Gold ( แชร์ 4 )  \n • รับชมได้ 1 จอ  สามารถรับชมได้พร้อมกันแค่ 2 จอ \n • หากจอชนต้องรอเท่านั้น\n • ความละเอียดระดับ 4K  \n •  ไม่สามารถเปลี่ยนข้อมูลได้   \n • ห้ามกดอัพเกรด หากมีคนกดไม่รับเคลมทุกกรณี', 12.00, 21.00, '0', 'WETV / IQIYI / VIU', 1),
(27, 'IQIYI Gold 30 วัน (จอหาร) ÷3', 'https://img5.pic.in.th/file/secure-sv1/dsacvd.png', '• IQIY Gold ( แชร์ 3 )  \n • รับชมได้ 1 จอ  สามารถรับชมได้พร้อมกันแค่ 2 จอ \n • หากจอชนต้องรอเท่านั้น\n • ความละเอียดระดับ 4K  \n •  ไม่สามารถเปลี่ยนข้อมูลได้   \n • ห้ามกดอัพเกรด หากมีคนกดไม่รับเคลมทุกกรณี', 27.00, 36.00, '2', 'WETV / IQIYI / VIU', 1),
(28, 'IQIYI Gold 30 วัน (จอหาร) ÷4', 'https://img5.pic.in.th/file/secure-sv1/dsacvd.png', '• IQIY Gold ( แชร์ 4 )  \n • รับชมได้ 1 จอ  สามารถรับชมได้พร้อมกันแค่ 2 จอ \n • หากจอชนต้องรอเท่านั้น\n • ความละเอียดระดับ 4K  \n •  ไม่สามารถเปลี่ยนข้อมูลได้   \n • ห้ามกดอัพเกรด หากมีคนกดไม่รับเคลมทุกกรณี', 20.00, 29.00, '3', 'WETV / IQIYI / VIU', 1),
(29, 'IQIYI Gold 30 วัน (จอส่วนตัว)', 'https://img5.pic.in.th/file/secure-sv1/dsacvd.png', '• IQIY Gold ( จอส่วนตัว )  \n • สามารถรับชมได้พร้อมกันแค่ 2 จอ \n • ความละเอียดระดับ 4K  \n •  ไม่สามารถเปลี่ยนข้อมูลได้   \n • ห้ามกดอัพเกรด หากมีคนกดไม่รับเคลมทุกกรณี', 65.00, 74.00, '0', 'WETV / IQIYI / VIU', 1),
(30, 'VIU 7 วัน (จอหาร)', 'https://img2.pic.in.th/pic/dsavgf.png', '⏰ วันใช้งาน 7 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอหาร หากจอชนต้องรอ\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 7.00, 16.00, '4', 'WETV / IQIYI / VIU', 1),
(31, 'VIU 30 วัน (จอหาร) ÷3', 'https://img2.pic.in.th/pic/dsavgf.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 25.00, 34.00, '2', 'WETV / IQIYI / VIU', 1),
(32, 'VIU 30 วัน (จอหาร) ÷4', 'https://img2.pic.in.th/pic/dsavgf.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอหาร หากจอชนต้องรอ\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 15.00, 24.00, '4', 'WETV / IQIYI / VIU', 1),
(33, 'VIU ( mail/pass ) 30 DAYS', 'https://img2.pic.in.th/pic/dsavcx.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จะได้รับเป็น REDEEM\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 60.00, 24.00, '6', 'ทดสอบ 2', 1),
(34, 'VIU ( REDEEM ) 30 DAYS', 'https://img2.pic.in.th/pic/dsavgf.png', '⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จะได้รับเป็น REDEEM\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 60.00, 69.00, '1', 'WETV / IQIYI / VIU', 1),
(35, 'PrimeVideo 7 วัน (ส่วนตัว) ÷5', 'https://img2.pic.in.th/pic/dsavcdwa.png', '⏰ วันใช้งาน 7 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอส่วนตัว\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\nเข้าได้เเค่คอมกับแอนดรอย ios เข้าไม่ได้\n*ไม่เคลมในกรณีโดนปิด*\n⚠ รับประกันตลอดการใช้งาน ⚠', 15.00, 24.00, '9', 'MONO HBO AMAZON', 1),
(36, ' PrimeVideo 30 วัน (ส่วนตัว) ÷5', 'https://img2.pic.in.th/pic/dsavcdwa.png', '\n⏰ วันใช้งาน 30 วัน\n\n➢ บัญชีประเทศไทย\n➢ จอส่วนตัว\n➢ จะได้รับเป็น Email/Password\n❌ ห้ามนำบัญชีไปหารต่อ / แบน\n❌ ห้ามเปลี่ยนรหัสบัญชี / แบน\nเข้าได้เเค่คอมกับแอนดรอย ios เข้าไม่ได้\n*ไม่เคลมในกรณีโดนปิด*\n\n⚠ รับประกันตลอดการใช้งาน ⚠', 35.00, 44.00, '8', 'MONO HBO AMAZON', 1),
(37, 'เพิ่มประกันโดนปิด (Prime video)', 'https://img2.pic.in.th/pic/dsavcdwa.png', 'เพิ่มประกันของ Prime video หากมีการโดนปิด\n\nหรือใช้งานไม่ครบ 30 วัน ร้านจะเคลมจนได้ดูตามจำนวน', 20.00, 20.00, '13', 'MONO HBO AMAZON', 0),
(38, 'HBO GO 7 วัน ÷4', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 16.00, 25.00, '0', 'MONO HBO AMAZON', 1),
(39, 'HBO GO 7 วัน ÷5', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 12.00, 21.00, '0', 'MONO HBO AMAZON', 1),
(40, 'HBO GO 15 วัน ', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 15.00, 24.00, '0', 'MONO HBO AMAZON', 1),
(41, 'HBO GO 30 วัน ÷4', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 30.00, 39.00, '1', 'MONO HBO AMAZON', 1),
(42, 'HBO GO 30 วัน ÷5', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 23.00, 29.00, '1', 'MONO HBO AMAZON', 1),
(43, 'HBO GO 30 วัน (ยกแอค)', 'https://img2.pic.in.th/pic/dsavcx.png', '▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> ', 105.00, 99.00, '6', 'MONO HBO AMAZON', 1),
(44, 'MONOMAX 15 วัน (จอส่วนตัว)', 'https://img2.pic.in.th/pic/ddsa.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></I>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 15.00, 24.00, '0', 'MONO HBO AMAZON', 1),
(45, 'MONOMAX/15วัน (จอแชร์)', 'https://img2.pic.in.th/pic/ddsa.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที<\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</I>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 10.00, 19.00, '0', 'MONO HBO AMAZON', 1),
(46, 'MONOMAX 30 วัน (จอส่วนตัว) ÷4', 'https://img2.pic.in.th/pic/ddsa.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></I>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 30.00, 39.00, '3', 'MONO HBO AMAZON', 1),
(47, 'MONOMAX 30 วัน (จอส่วนตัว) ÷5', 'https://img2.pic.in.th/pic/ddsa.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></I>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 25.00, 34.00, '4', 'MONO HBO AMAZON', 1),
(48, 'MONOMAX/30วัน (จอแชร์)', 'https://img2.pic.in.th/pic/ddsa.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที<\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</I>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 15.00, 24.00, '3', 'MONO HBO AMAZON', 1),
(49, 'MONOMAX 30 วัน (ยกแอค)', 'https://img5.pic.in.th/file/secure-sv1/dsvcxsdc.png', '▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span>\n▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></I>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span>\n<li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> ', 90.00, 29.00, '8', 'ทดสอบ 2', 1),
(50, 'Bilibili 15 วัน ( จอหาร )', 'https://img5.pic.in.th/file/secure-sv1/sda.png', '▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> ', 12.00, 21.00, '0', 'รายการอื่นๆ', 1),
(51, 'Bilibili 30 วัน ( จอหาร ) ÷3', 'https://img5.pic.in.th/file/secure-sv1/sda.png', '▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> ', 35.00, 44.00, '1', '0', 1),
(52, 'Bilibili 30 วัน ( จอหาร ) ÷4', 'https://img5.pic.in.th/file/secure-sv1/sda.png', '▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> ', 20.00, 29.00, '1', '0', 1),
(53, 'Bilibili 30 วัน ( REDEEM )', 'https://img5.pic.in.th/file/secure-sv1/sda.png', '▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> ', 85.00, 94.00, '1', '0', 1),
(54, 'Bilibili 30 วัน ( mail/pass )', 'https://img5.pic.in.th/file/secure-sv1/dsadfs.png', '▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> ', 85.00, 104.00, '4', 'ทดสอบ 2', 1),
(55, 'YOUKU VIP 15 วัน (จอหาร)', 'https://img2.pic.in.th/pic/dsabvd.png', '▶️ YOUKU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  \n▶️ รับชม YOUKU Premium แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ YOUKU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://youku.tv/\" target=\"_blank\">https://youku.tv/</a></li> ', 10.00, 19.00, '0', 'YOUKU BILIBILI', 1),
(56, 'YOUKU VIP 30 วัน (จอหาร) ÷3', 'https://img2.pic.in.th/pic/dsabvd.png', '▶️ YOUKU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  \n▶️ รับชม YOUKU Premium แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ YOUKU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://youku.tv/\" target=\"_blank\">https://youku.tv/</a></li> ', 25.00, 34.00, '2', 'YOUKU BILIBILI', 1),
(57, 'YOUKU VIP 30 วัน (จอหาร) ÷4', 'https://img2.pic.in.th/pic/dsabvd.png', '▶️ YOUKU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  \n▶️ รับชม YOUKU Premium แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ YOUKU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://youku.tv/\" target=\"_blank\">https://youku.tv/</a></li> ', 15.00, 24.00, '3', 'YOUKU BILIBILI', 1),
(58, 'YOUKU VIP 30 วัน (จอส่วนตัว)', 'https://img2.pic.in.th/pic/dsabvd.png', '▶️ YOUKU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  \n▶️ รับชม YOUKU Premium แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ YOUKU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://youku.tv/\" target=\"_blank\">https://youku.tv/</a></li> ', 55.00, 64.00, '1', '0', 1),
(59, 'Spotify Premium 30 วัน (ลูกค้า)', 'https://img2.pic.in.th/pic/dsavcxv.png', '▶️ Spotify แอปฟังเพลงออนไลน์ รวมเพลงทุกประเทศ\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> ระดับพรีเมียม</span>\n▶️ ฟังเพลงขนาดปิดหน้าจอไม่มีโฆษณากวนใจ\n▶️ โหลดเพลงไว้ฟังขนาดออฟไลน์ได้\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Spotify แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span\n <li>website <a href=\"https://open.spotify.com/\" target=\"_blank\">https://open.spotify.com/</a></li> ', 29.00, 38.00, '6', '0', 1),
(60, 'Spotify Premium 30 วัน (เมลร้าน)', 'https://img2.pic.in.th/pic/dsavcxv.png', '▶️ Spotify แอปฟังเพลงออนไลน์ รวมเพลงทุกประเทศ\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> ระดับพรีเมียม</span>\n▶️ ฟังเพลงขนาดปิดหน้าจอไม่มีโฆษณากวนใจ\n▶️ โหลดเพลงไว้ฟังขนาดออฟไลน์ได้\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Spotify แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span\n <li>website <a href=\"https://open.spotify.com/\" target=\"_blank\">https://open.spotify.com/</a></li> ', 35.00, 44.00, '4', '0', 1),
(61, 'Spotify Premium 30 วัน (ต่อเมลลูกค้า)', 'https://img2.pic.in.th/pic/dsavcxv.png', 'เมลร้าน +5฿ สามารถเเจ้งแอดมินให้ส่งเมลให้ได้เลย\n\n▶️ Spotify แอปฟังเพลงออนไลน์ รวมเพลงทุกประเทศ\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> ระดับพรีเมียม</span>\n▶️ ฟังเพลงขนาดปิดหน้าจอไม่มีโฆษณากวนใจ\n▶️ โหลดเพลงไว้ฟังขนาดออฟไลน์ได้\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Spotify แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span\n <li>website <a href=\"https://open.spotify.com/\" target=\"_blank\">https://open.spotify.com/</a></li> ', 45.00, 54.00, '5', '0', 1),
(62, 'Spotify Premium 30 วัน (ต่อเมลร้าน)', 'https://img2.pic.in.th/pic/dsavcxv.png', 'เมลร้าน +5฿ สามารถเเจ้งแอดมินให้ส่งเมลให้ได้เลย\n\n▶️ Spotify แอปฟังเพลงออนไลน์ รวมเพลงทุกประเทศ\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> ระดับพรีเมียม</span>\n▶️ ฟังเพลงขนาดปิดหน้าจอไม่มีโฆษณากวนใจ\n▶️ โหลดเพลงไว้ฟังขนาดออฟไลน์ได้\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ Spotify แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span\n <li>website <a href=\"https://open.spotify.com/\" target=\"_blank\">https://open.spotify.com/</a></li> ', 50.00, 59.00, '1', '0', 1),
(63, 'TrueID+ 15 วัน ( จอหาร )', 'https://img5.pic.in.th/file/secure-sv1/dsvcxsdc.png', '▶️ TrueID แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark \"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ รับชม TrueID+ แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Phone/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ TrueID แพ็กเกจ  <span class=\"badge bg-warning\">TrueID+ รายเดือน</span></h6>  <li>website <a href=\"https://www.trueid.net/watch/th-th/trueidplus\" target=\"_blank\">https://www.trueid.net/watch/th-th/trueidplus</a></li> ', 12.00, 21.00, '0', 'รายการอื่นๆ', 1),
(64, 'TrueID+ 30 วัน ÷3', 'https://img5.pic.in.th/file/secure-sv1/dsvcxsdc.png', '▶️ TrueID แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark \"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ รับชม TrueID+ แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Phone/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ TrueID แพ็กเกจ  <span class=\"badge bg-warning\">TrueID+ รายเดือน</span></h6>  <li>website <a href=\"https://www.trueid.net/watch/th-th/trueidplus\" target=\"_blank\">https://www.trueid.net/watch/th-th/trueidplus</a></li> ', 27.00, 36.00, '2', 'รายการอื่นๆ', 1),
(65, 'TrueID+ 30 วัน ÷4', 'https://img5.pic.in.th/file/secure-sv1/dsvcxsdc.png', '▶️ TrueID แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark \"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ รับชม TrueID+ แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Phone/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ TrueID แพ็กเกจ  <span class=\"badge bg-warning\">TrueID+ รายเดือน</span></h6>  <li>website <a href=\"https://www.trueid.net/watch/th-th/trueidplus\" target=\"_blank\">https://www.trueid.net/watch/th-th/trueidplus</a></li> ', 22.00, 31.00, '2', 'รายการอื่นๆ', 1),
(66, 'TrueID+ 30 วัน ( จอส่วนตัว )', 'https://img5.pic.in.th/file/secure-sv1/dsvcxsdc.png', '▶️ TrueID แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark \"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1 จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> \n▶️ รับชม TrueID+ แบบไม่มีโฆษณาคั่น\n▶️ จะได้รับเป็น Phone/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ TrueID แพ็กเกจ  <span class=\"badge bg-warning\">TrueID+ รายเดือน</span></h6>  <li>website <a href=\"https://www.trueid.net/watch/th-th/trueidplus\" target=\"_blank\">https://www.trueid.net/watch/th-th/trueidplus</a></li> ', 65.00, 85.00, '14', 'รายการอื่นๆ', 1),
(67, 'CH 3 Plus 30 วัน ÷2', 'https://img2.pic.in.th/pic/dsavcdver.png', '▶️ CH3 Plus แอปดูภาพยนตร์ / ซีรีส์ / ละคร การ์ตูน / ข่าวสด ย้อนหลัง <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ CH3 Plus แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://ch3plus.com/\" target=\"_blank\">https://ch3plus.com/</a></li> ', 39.00, 48.00, '2', 'รายการอื่นๆ', 1),
(68, 'CH 3 Plus 30 วัน ( mail/pass )', 'https://img2.pic.in.th/pic/dsavcdver.png', '▶️ CH3 Plus แอปดูภาพยนตร์ / ซีรีส์ / ละคร การ์ตูน / ข่าวสด ย้อนหลัง <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ CH3 Plus แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://ch3plus.com/\" target=\"_blank\">https://ch3plus.com/</a></l>\n\nวิธี รีดีม โค้ต ch3+\n\n1. เข้า เว็บไซต์ https://ch3plus.com/live#\n2. ล็อคอิน อีเมล+พาส ของลูกค้า\n3. มองมุมขวา  คลิ้ก ☰ เจอรูปคน (สวัสดี)  คลิ้กต่อ\n4. เจอคำว่า Redeem Code คลิ้ก\n5. นำโค้ตทางร้านเติม กดยืนยัน เสร็จ', 70.00, 90.00, '10', 'รายการอื่นๆ', 1),
(69, 'CH 3 Plus 30 วัน ( REDEEM )', 'https://img2.pic.in.th/pic/dsavcdver.png', '▶️ CH3 Plus แอปดูภาพยนตร์ / ซีรีส์ / ละคร การ์ตูน / ข่าวสด ย้อนหลัง <span class=\"badge bg-dark\"></span>\n▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span>\n▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span>\n▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>\n▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที\n▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i>\n▶️ CH3 Plus แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://ch3plus.com/\" target=\"_blank\">https://ch3plus.com/</a></l>\n\nวิธี รีดีม โค้ต ch3+\n\n1. เข้า เว็บไซต์ https://ch3plus.com/live#\n2. ล็อคอิน อีเมล+พาส ของลูกค้า\n3. มองมุมขวา  คลิ้ก ☰ เจอรูปคน (สวัสดี)  คลิ้กต่อ\n4. เจอคำว่า Redeem Code คลิ้ก\n5. นำโค้ตทางร้านเติม กดยืนยัน เสร็จ', 70.00, 79.00, '1', 'รายการอื่นๆ', 1),
(70, 'MAIL GOOGLE', 'https://img5.pic.in.th/file/secure-sv1/dsagre.png', 'เมลเปล่า ไม่ผ่านการใช้งาน สำหรับทำ ยูทูป เเละแอพอื่นๆได้\n\nเมลใหม่ ไม่ติดเบอร์ ไม่ติดยืนยัน \n\nรับเคลม 10 ชม', 7.00, 15.00, '1', 'รายการอื่นๆ', 1),
(71, 'สมาชิกตัวแทน 99 บาท / เดือน', 'https://mucity.online/img/recomproduct.png', 'โปรชั่น เรทราคาส่งพิเศษ และสิทธิพิเศษสำหรับตัวแทน กลุ่มโยน สามารถคุยปัญหาได้ \r\nเพียงเดือนละ 99/ เดือนเท่านั้น\r\n\r\nเดือนถัดไป 50 บาท (ต่อก่อนหมดอายุ)', 50.00, 5000.00, '3', '0', 0),
(72, 'API TEST', 'https://mucity.online/img/recomproduct.png', 'ทดสอบการสั่งซื้อด้วย API', 0.00, 0.00, '154', '0', 0),
(74, 'แอคนอก Netflix 7 วัน  (มือถือ)', 'https://img5.pic.in.th/file/secure-sv1/gre.png', 'แอคนอกเรทราคาต่ำกว่าไทย เเต่บอบบางกว่าแอคไทย\n(ห้ามนำไปหลอกขายว่าเป็นแอคไทยเด็ดขาด)\nขอเเตกต่างระหว่างแอคนอกเเละแอคไทย \n\nแอคนอก\n-ตัดสกุลเงินต่างประเทศ\n-เปลี่ยนได้หลายภาษา\n\nแอคไทย\n-ตัดเงินไทย\n-มีเมนูไทย\n\nปัญหาที่จะพบ \n1. มีความเสี่ยงในการโดนปิดเหมือนแอคไทย\n2. มีการรีรหัสโดยระบบ ซึ่งจะต้องรอเเก้ภายใน 24 ชม. เเละต้องรอ ห้ามเหวี่ยงห้ามวีน', 28.00, 39.00, '8', 'NETFILX', 0),
(75, 'แอคนอก Netflix 7 วัน  (TV)', 'https://img5.pic.in.th/file/secure-sv1/gre.png', 'แอคนอกเรทราคาต่ำกว่าไทย เเต่บอบบางกว่าแอคไทย\n(ห้ามนำไปหลอกขายว่าเป็นแอคไทยเด็ดขาด)\nขอเเตกต่างระหว่างแอคนอกเเละแอคไทย \n\nแอคนอก\n-ตัดสกุลเงินต่างประเทศ\n-เปลี่ยนได้หลายภาษา\n\nแอคไทย\n-ตัดเงินไทย\n-มีเมนูไทย\n\nปัญหาที่จะพบ \n1. มีความเสี่ยงในการโดนปิดเหมือนแอคไทย\n2. มีการรีรหัสโดยระบบ ซึ่งจะต้องรอเเก้ภายใน 24 ชม. เเละต้องรอ ห้ามเหวี่ยงห้ามวีน', 35.00, 49.00, '8', 'NETFILX', 0),
(76, 'แอคนอก Netflix 30 วัน (มือถือ)', 'https://img5.pic.in.th/file/secure-sv1/gre.png', 'แอคนอกเรทราคาต่ำกว่าไทย เเต่บอบบางกว่าแอคไทย\n(ห้ามนำไปหลอกขายว่าเป็นแอคไทยเด็ดขาด)\nขอเเตกต่างระหว่างแอคนอกเเละแอคไทย \n\nแอคนอก\n-ตัดสกุลเงินต่างประเทศ\n-เปลี่ยนได้หลายภาษา\n\nแอคไทย\n-ตัดเงินไทย\n-มีเมนูไทย\n\nปัญหาที่จะพบ \n1. มีความเสี่ยงในการโดนปิดเหมือนแอคไทย\n2. มีการรีรหัสโดยระบบ ซึ่งจะต้องรอเเก้ภายใน 24 ชม. เเละต้องรอ ห้ามเหวี่ยงห้ามวีน', 89.00, 99.00, '6', 'NETFILX', 0),
(77, 'แอคนอก Netflix 30 วัน (TV)', 'https://img5.pic.in.th/file/secure-sv1/gre.png', 'แอคนอกเรทราคาต่ำกว่าไทย เเต่บอบบางกว่าแอคไทย\n(ห้ามนำไปหลอกขายว่าเป็นแอคไทยเด็ดขาด)\nขอเเตกต่างระหว่างแอคนอกเเละแอคไทย \n\nแอคนอก\n-ตัดสกุลเงินต่างประเทศ\n-เปลี่ยนได้หลายภาษา\n\nแอคไทย\n-ตัดเงินไทย\n-มีเมนูไทย\n\nปัญหาที่จะพบ \n1. มีความเสี่ยงในการโดนปิดเหมือนแอคไทย\n2. มีการรีรหัสโดยระบบ ซึ่งจะต้องรอเเก้ภายใน 24 ชม. เเละต้องรอ ห้ามเหวี่ยงห้ามวีน', 115.00, 129.00, '11', 'NETFILX', 0),
(78, 'microsoft 30 วัน ( เมลลค )', 'https://peamsub24hr.online/img/microsoft_13.png', '30 วันต่อเมลไมไ่ด้ค่ะ\r\n\r\nmicrosoft ของเเท้ เป็นเฟรมครอบครัว', 12.00, 25.00, '4', '0', 0),
(79, 'microsoft 30 วัน ( เมลร้าน )', 'https://peamsub24hr.online/img/microsoft_13.png', '30 วัน เมลร้านต่อเมลไมไ่ด้ค่ะ\r\n\r\nmicrosoft ของเเท้ เป็นเฟรมครอบครัว', 15.00, 35.00, '2', '0', 0),
(80, 'Netflix ตัด00.00น. (มือถือ) ตัด wallet', 'https://peamsub24hr.online/img/nfmidnight.png', '❌ ไม่สามารถชมบนทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 4.00, 12.00, '0', 'NETFILX', 0),
(81, 'Netflix 1 วัน (มือถือ) ตัด wallet', 'https://peamsub24hr.online/img/nf1dayphone.png', '❌ ไม่สามารถชมบนทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 8.00, 20.00, '0', 'NETFILX', 0),
(82, 'Netflix 1 วัน (TV) ตัด wallet', 'https://peamsub24hr.online/img/nf1daytv.png', '✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 15.00, 30.00, '6', 'NETFILX', 0),
(83, 'Netflix 7 วัน (มือถือ) ตัด wallet', 'https://peamsub24hr.online/img/nf7dayphone.png', '❌ ไม่สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 28.00, 45.00, '5', 'NETFILX', 0),
(84, 'Netflix 7 วัน (TV) ตัด wallet', 'https://peamsub24hr.online/img/nf7daytv.png', '✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 35.00, 60.00, '1', 'NETFILX', 0),
(85, 'Netflix ทริค 30 วัน (มือถือ) ตัด wallet ', 'https://peamsub24hr.online/img/nf30dayphone.png', 'ตัดทริค 23(ไม่พักชำระ)+7(พักชำระ)\n\n❌ ไม่สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 85.00, 115.00, '5', 'NETFILX', 0),
(86, 'Netflix ทริค 30 วัน (TV) ตัด wallet', 'https://peamsub24hr.online/img/nf30daytv.png', 'ตัดทริค 23(ไม่พักชำระ)+7(พักชำระ)\n\n✔️ สามารถชมผ่านทีวีได้ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 115.00, 135.00, '1', 'NETFILX', 0),
(87, 'Netflix 30 วัน (จอเสริม) ตัด wallet', 'https://peamsub24hr.online/img/nf30dayaddtv.png', '✔️ สามารถรับชมได้ทุกอุปกรณ์ \n❌ ห้ามทำผิดกฎหรือมั่วจออื่น หากทำผิดยึดจอทุกกรณี\n✔️ เปลี่ยนชื่อจอและ PIN ได้ \n✔️ แอคเคาท์ไทย 100% \n✔️ สามารถรับชมได้ 1 จอ ( ห้ามสลับเครื่องไปมา)\n✔️ ความละเอียดระดับ UltraHD 4K \n✔️ ไม่รับเคลมหากโดนปิดบัญชี', 130.00, 165.00, '2', 'รายการอื่นๆ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `bnum` varchar(50) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `fname`, `lname`, `bnum`, `qrcode`, `created_at`, `updated_at`) VALUES
(1, 'อภิวัฒน์', 'พรศรี', '1483640087', 'https://img5.pic.in.th/file/secure-sv1/image80f9089e3fa31bce.png', '2023-02-11 07:48:46', '2024-06-16 05:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `boxlog`
--

CREATE TABLE `boxlog` (
  `id` int(11) NOT NULL,
  `date` datetime(2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `prize_name` varchar(255) NOT NULL,
  `rand` int(2) NOT NULL,
  `uid` varchar(11) NOT NULL,
  `uimg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boxlog`
--

INSERT INTO `boxlog` (`id`, `date`, `username`, `category`, `price`, `prize_name`, `rand`, `uid`, `uimg`) VALUES
(1, '2024-07-20 20:51:18.00', 'aq123123', 'NewProduct01', 19, 'สั่งซื้อสินค้าเรียบร้อย : Niuss@gmail.com : PEsaa1232', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(2, '2024-07-20 21:02:24.00', 'aq123123', 'NewProduct01', 19, 'สั่งซื้อสินค้าเรียบร้อย : Niuss@gmail.com : PEsaa1232', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(3, '2024-07-20 21:43:42.00', 'aq123123', 'NewProduct01', 19, 'สั่งซื้อสินค้าเรียบร้อย : Niuss@gmail.com : PEsaa1232', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(4, '2024-07-23 11:46:33.00', 'aq123123', 'สุ่มไอดีปืนเวล 7', 7, 'เครดิตในเว็บจำนวน 0.00เครดิต', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(5, '2024-07-23 11:55:51.00', 'aq123123', 'สุ่มไอดีปืนเวล 7', 7, 'ได้รับไอดีปืนเวล 7', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(6, '2024-07-28 13:39:45.00', 'aq123123', 'NewProduct01', 19, 'สั่งซื้อสินค้าเรียบร้อย : Niuss@gmail.com : PEsaa1232', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(7, '2024-07-28 13:40:20.00', 'aq123123', 'Test 01', 20, 'เครดิตในเว็บจำนวน 5.00เครดิต', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(8, '2024-07-28 13:52:26.00', 'aq123123', 'test 02', 7, 'ได้รับไอดีปืนเวล 7', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(9, '2024-07-28 13:54:27.00', 'aq123123', 'test 02', 7, 'ได้รับไอดีปืนเวล 7', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(10, '2024-07-28 16:59:01.00', 'aq123123', 'บัตรเติมเดม', 465, 'ฟฟฟฟ', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(11, '2024-07-28 16:59:13.00', 'aq123123', 'บัตรเติมเดม', 465, 'หฟกฟหกหฟ', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(12, '2024-07-28 17:06:01.00', 'aq123123', 'บัตรเติมเดม', 465, 'หฟกหฟกฟหฟก', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(13, '2024-07-28 17:07:43.00', 'aq123123', 'NewProduct01', 19, '231321312', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(14, '2024-07-28 17:07:52.00', 'aq123123', 'NewProduct01', 19, '4545454', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(15, '2024-07-28 17:08:00.00', 'aq123123', 'NewProduct01', 19, '54654645654', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(16, '2024-07-28 17:09:15.00', 'aq123123', 'NewProduct01', 19, '4654654645645', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(17, '2024-07-28 17:21:26.00', 'aq123123', 'บัตรเติมเดม', 465, 'ฟหกฟหกหฟ', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(18, '2024-07-28 22:27:18.00', 'aq123123', 'NewProduct01', 19, 'ฟฟฟฟฟ', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(19, '2024-07-28 22:27:25.00', 'aq123123', 'NewProduct01', 19, '123456789', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(20, '2024-07-28 22:27:35.00', 'aq123123', 'NewProduct01', 19, 'Uuu', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(21, '2024-07-28 22:27:43.00', 'aq123123', 'NewProduct01', 19, 'Iiii', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(22, '2024-07-28 22:27:47.00', 'aq123123', 'NewProduct01', 19, 'Uiiii', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(23, '2024-07-28 22:27:51.00', 'aq123123', 'NewProduct01', 19, 'Iiii', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(24, '2024-07-28 22:27:56.00', 'aq123123', 'NewProduct01', 19, 'Kkkk', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(25, '2024-07-28 22:28:07.00', 'aq123123', 'NewProduct01', 19, 'Kkkk', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(26, '2024-07-30 16:53:07.00', 'aq123123', 'ทดสอบ', 10, 'ไม่ได้รับรางวัล', 1, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png'),
(27, '2024-07-30 17:08:36.00', 'aq123123', 'GAME TEST', 740, '1', 0, '2', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png');

-- --------------------------------------------------------

--
-- Table structure for table `boxlogapp`
--

CREATE TABLE `boxlogapp` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `uid` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `box_product`
--

CREATE TABLE `box_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `price_vip` int(11) NOT NULL,
  `des` varchar(1000) NOT NULL,
  `img` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `percent` int(3) NOT NULL DEFAULT 100,
  `salt_prize` varchar(255) NOT NULL DEFAULT 'ไม่ได้รับรางวัล',
  `c_type` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `box_product`
--

INSERT INTO `box_product` (`id`, `name`, `price`, `price_vip`, `des`, `img`, `type`, `percent`, `salt_prize`, `c_type`) VALUES
(1, 'NewProduct01', 99, 69, '01 Product NEW Strock\n- Coming soon.....', '/assets/img/bzkl.png', 1, 100, 'ไม่ได้รับรางวัล', 'ไอดีเกมออนไลน์'),
(4, 'GAME TEST', 2000, 740, 'GAME TEST', 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', 1, 100, 'ไม่ได้รับรางวัล', 'ไอดีเกมออนไลน์');

-- --------------------------------------------------------

--
-- Table structure for table `box_stock`
--

CREATE TABLE `box_stock` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` int(3) NOT NULL,
  `p_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `byshop`
--

CREATE TABLE `byshop` (
  `status` varchar(255) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `byshop`
--

INSERT INTO `byshop` (`status`, `apikey`, `cost`) VALUES
('on', '-', '10');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `link`) VALUES
(10, '/dz/bannert01.png');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `des` varchar(1000) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`, `des`, `img`) VALUES
(3, 'ไอดีเกมออนไลน์', '   ทดสอบ', '/dz/web.png'),
(6, 'สินค้าอื่นๆ', '   ', '/dz/web.png'),
(8, '03', '03', '/dz/web.png'),
(9, '04', '04', '/dz/web.png');

-- --------------------------------------------------------

--
-- Table structure for table `crecom`
--

CREATE TABLE `crecom` (
  `recom_1` int(11) NOT NULL DEFAULT 0,
  `recom_2` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crecom`
--

INSERT INTO `crecom` (`recom_1`, `recom_2`) VALUES
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `r_type` enum('wheel','slide','chest') NOT NULL DEFAULT 'wheel',
  `img` varchar(255) NOT NULL,
  `border` varchar(10) NOT NULL,
  `bg` varchar(10) NOT NULL DEFAULT '#000000',
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `name`, `price`, `r_type`, `img`, `border`, `bg`, `cid`) VALUES
(1, 'Test 01', 20.00, 'wheel', '/dz/web.png', '#529b39', '#ffffff', 1),
(4, 'test 02', 7.00, 'wheel', '/dz/web.png', '#ffffff', '#000000', 1),
(6, 'กกกกกก', 100.00, 'wheel', 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '#ff0000', '#000000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_category`
--

CREATE TABLE `game_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_category`
--

INSERT INTO `game_category` (`id`, `name`, `img`, `created_at`, `updated_at`) VALUES
(1, 'ทดสอบวงล้อ', '/dz/web.png', '2024-06-22 22:12:44', '2024-07-24 09:51:46'),
(3, 'ทดสอบวงล้อ', 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 20:51:39', '2024-07-30 13:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `game_item`
--

CREATE TABLE `game_item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` int(3) NOT NULL,
  `img` varchar(255) NOT NULL,
  `bg` varchar(10) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `type` enum('point','reward') NOT NULL,
  `p_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_item`
--

INSERT INTO `game_item` (`id`, `name`, `percent`, `img`, `bg`, `credit`, `type`, `p_id`) VALUES
(1, 'ไม่ได้รางวัล', 0, 'https://dedazen.com/dz/no.png', '000000', 0.00, 'point', '1'),
(6, 'ได้รับ 10 เครดิต', 10, 'https://dedazen.com/dz/10.png', '000000', 10.00, 'point', '1'),
(7, 'ได้รับ 5 เครดิต', 90, 'https://dedazen.com/dz/5.png', '#000000', 5.00, 'point', '1'),
(9, 'ได้รับไอดีปืนเวล 7', 0, 'https://thephub.in.th/img/7.png', '000000', 0.00, 'reward', '1'),
(13, 'ได้รับ 100 เครดิต', 0, 'https://dedazen.com/dz/100.png', '#000000', 100.00, 'point', '1'),
(14, 'ได้รับไอดีกล้ามทอง', 0, 'https://thephub.in.th/img/thong.png', '#000000', 0.00, 'reward', '1'),
(15, 'ได้รับ 68 เพชร', 0, 'https://thephub.in.th/img/68.png', '#000000', 0.00, 'reward', '5'),
(16, 'ไม่ได้รับรางวัล', 50, 'https://dedazen.com/dz/no.png', '#000000', 0.00, 'point', '5'),
(17, 'ได้รับ 172 เพชร', 0, 'https://thephub.in.th/img/72.png', '#000000', 0.00, 'reward', '5'),
(18, 'ได้รับ 310 เพชร', 0, 'https://thephub.in.th/img/310.png', '#000000', 0.00, 'reward', '5'),
(19, 'ไม่ได้รับรางวัล', 100, 'https://dedazen.com/dz/no.png', '#000000', 0.00, 'point', '5'),
(20, 'ได้รับ 517 เพชร', 0, 'https://thephub.in.th/img/517.png', '#000000', 0.00, 'reward', '5'),
(21, 'ได้รับ 1052 เพชร', 0, 'https://thephub.in.th/img/1052.png', '#000000', 0.00, 'reward', '5'),
(22, 'ได้รับ 3698 เพชร', 0, 'https://thephub.in.th/img/3698.png', '#000000', 0.00, 'reward', '5'),
(23, 'ไม่ได้รับรางวัล', 0, 'https://dedazen.com/dz/no.png', '#000000', 0.00, 'point', '1'),
(24, 'ได้รับไอดีปืนเวล 7', 100, 'https://thephub.in.th/img/7.png', '#000000', 0.00, 'reward', '4'),
(25, 'ไม่ได้รับรางวัล', 50, 'https://dedazen.com/dz/no.png', '#000000', 0.00, 'point', '4'),
(26, 'ได้รับ 10 เครดิต', 5, 'https://dedazen.com/dz/10.png', '#000000', 10.00, 'point', '4'),
(27, 'ได้รับ 1000 เครดิต', 0, 'https://dedazen.com/dz/1000.png', '#000000', 1000.00, 'point', '4'),
(28, 'ได้รับ 500 เครดิต', 0, 'https://dedazen.com/dz/500.png', '#000000', 500.00, 'point', '4'),
(29, 'ไม่ได้รับรางวัล', 40, 'https://dedazen.com/dz/no.png', '#000000', 0.00, 'point', '4'),
(30, 'ได้รับ 5 เครดิต', 5, 'https://dedazen.com/dz/5.png', '#000000', 5.00, 'point', '4');

-- --------------------------------------------------------

--
-- Table structure for table `game_stock`
--

CREATE TABLE `game_stock` (
  `id` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `p_id` varchar(11) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_stock`
--

INSERT INTO `game_stock` (`id`, `data`, `p_id`, `date`) VALUES
(14, 'ได้รับไอดีกล้ามทอง', '14', '2024-06-23 19:30:08'),
(16, 'ได้รับไอดีปืนเวล 7', '9', '2024-06-23 19:30:43'),
(17, 'ได้รับไอดีปืนเวล 7', '9', '2024-06-23 19:30:43'),
(18, 'ได้รับไอดีปืนเวล 7', '9', '2024-06-23 19:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `history_api`
--

CREATE TABLE `history_api` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `info` varchar(9999) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `timeadd` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `history_api`
--

INSERT INTO `history_api` (`id`, `name`, `status`, `info`, `price`, `timeadd`, `username`, `product_id`) VALUES
(5, 'Youtube Premium/30วัน (เมลตัวเอง)', 'success', 'email : -<br>password : -<br><br><a class=\"byshop1 btn btn-block text-white bg-dark\" target=\"_blank\" href=\"//families.google.com/u/4/join/promo/p4ge7x64SxPMbiIXRipAAIRy88jPIw?pli=1\"> <img width=\"30px;\" class=\"img-fluid\" src=\"//img_app.byshop.me/buy/img/yt.png\">Youtube Premium<br><u>(กดรับสิทธิ์เข้าร่วมครอบครัว)</u></a></h1><br><p><i class=\"far fa-calendar-alt\"></i>วันหมดอายุ →  26/3/2024</p><br><h5><i class=\"fa fa-exclamation-triangle\"></i> คำเตือน!!! (อ่าน)</h5><p>ตรวจสอบ Gmail ก่อนกดเข้าร่วม \"ครอบครัว\" หากกดเข้าไปแล้วจะไม่สามารถแก้ไขได้!</p><hr>1. หากขึ้นแบบให้แสดงว่า Gmail จำกัดการเข้าครอบครัวแล้วให้เปลี่ยน Gmail ใหม่รับสิทธิ์แทน <b>(1 Gmail สามารถเข้าครอบครัวได้2รอบ)</b> หากเต็มให้สร้างบัญชีใหม่เข้าแทน <a target=\"_blank\" href=\"//accounts.google.com/signup/v2/webcreateaccount?flowName=GlifWebSignIn&flowEntry=SignUp\"><u>สร้างบัญชี Gmail</u></a><img src=\"//css_script.byshop.me/buy/img/noyt1.png\" width=\"100%;\" /><hr>2. หากขึ้นแบบนี้ให้ออกครอบครัวเก่าก่อนแล้วค่อยกดเข้าครอบครัวใหม่แทน<img src=\"//css_script.byshop.me/buy/img/noyt2.png\" width=\"100%;\" /><br><br><p class=\"modal-title\"><h3><u>วิธีออกจาก Family เก่า</u></h3></p><div class=\"modal-body\"><li>1. เข้าลิ้ง <a target=\"_blank\" href=\"//families.google.com/families\">families.google.com/families</a></li><li>2. ขั้นตอนถัดไป</li><br><img src=\"/buy/img/y1.png\" width=\"100%;\" /><br><br><img src=\"/buy/img/y2.jpg\" width=\"100%;\" /></div><br><p hidden><i class=\"fa fa-user\" aria-hidden=\"true\"></i>Family -  knewqp</p>', '389.00', '2024-02-26 19:49:01', 'admin', '7'),
(6, 'TEST API', 'success', 'email : ทดสอบAPI<br>password : ทดสอบAPI<x309>', '9999.00', '2024-05-11 20:10:43', 'xzpritex', '100'),
(10, 'TEST API', 'success', 'email : ทดสอบAPI<br>password : ทดสอบAPI<x5196>', '9999.00', '2024-05-29 23:56:04', 'karan2002', '100');

-- --------------------------------------------------------

--
-- Table structure for table `his_purchase`
--

CREATE TABLE `his_purchase` (
  `order_id` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `server` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `price` text DEFAULT NULL COMMENT 'ราคาเต็ม',
  `uid` varchar(255) DEFAULT NULL,
  `status` text DEFAULT '\'1\'' COMMENT '1 : กำลังทำรายการ\r\n2 : รายการสา เร็จ\r\n4 : รายการล ้มเหลว (คืนเงินเข ้าระบบ wePAY)',
  `dest_ref` text DEFAULT NULL,
  `transaction_id` text DEFAULT NULL,
  `type` enum('game','cashcard','topup') DEFAULT NULL,
  `sms` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `his_purchase`
--

INSERT INTO `his_purchase` (`order_id`, `ref`, `description`, `server`, `product`, `price`, `uid`, `status`, `dest_ref`, `transaction_id`, `type`, `sms`, `date`) VALUES
(1, '3610861214303346', '<b>10 บาท</b> ได้รับ 12 คูปอง</small>', '', 'ROV-M', '9.99', '16', '1', 'B8C1A4230165', '364809036', 'game', '', '2024-07-24 10:32:06'),
(2, '0959963505', NULL, NULL, 'TRMV', '5', '2', '2', 'CCA1141884B1', '367035537', 'topup', 'null', '2024-08-13 11:41:13'),
(3, '0959963505', NULL, NULL, 'TRMV', '5', '2', '2', 'CC49B021950B', '367035990', 'topup', 'null', '2024-08-13 11:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `kbank_trans`
--

CREATE TABLE `kbank_trans` (
  `id` int(11) NOT NULL,
  `qr` varchar(255) NOT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `sender` varchar(100) DEFAULT NULL,
  `date` datetime(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kbank_trans`
--

INSERT INTO `kbank_trans` (`id`, `qr`, `ref`, `sender`, `date`) VALUES
(1, '0041000600000101030040220014171235311ATF082055102TH91046A00', '014171235311ATF08205', 'นาย พีรพล เ', '2024-06-19 11:53:38.00'),
(2, '0041000600000101030040220014172190933ATF028195102TH91043A26', '014172190933ATF02819', 'นาย ธนกฤต จ', '2024-06-20 07:10:05.00'),
(3, '004600060000010103014022520240620586rnKXPHjwEDqBiM5102TH9104A30C', '20240620586rnKXPHjwEDqBiM', 'นาย พิพัฒน์ ผ', '2024-06-20 08:31:22.00'),
(4, '0046000600000101030140225202406200UCy0qJ0DEIoTMfRF5102TH9104BE74', '202406200UCy0qJ0DEIoTMfRF', 'นาย คณิศร ฎ', '2024-06-20 09:21:16.00'),
(5, '0041000600000101030040220014173152650CTF032045102TH91041303', '014173152650CTF03204', 'นาย สุทธิภัทร เ', '2024-06-21 03:27:18.00'),
(6, '0046000600000101030250225KMA240621180747wmUervZjtn5102TH91041DD0', 'KMA240621180747wmUervZjtn', 'NADCHA I', '2024-06-21 06:08:43.00'),
(7, '004600060000010103002022520240621210817240066223085102TH91043CD2', '2024062121081724006622308', NULL, '2024-06-21 09:12:55.00'),
(8, '0038000600000101030060217Ae186a6099bfb42865102TH9104CD6C', 'Ae186a6099bfb4286', 'นวพล แ', '2024-06-22 11:55:38.00');

-- --------------------------------------------------------

--
-- Table structure for table `mmn_setting`
--

CREATE TABLE `mmn_setting` (
  `id` int(11) NOT NULL,
  `access_token` varchar(100) DEFAULT NULL,
  `merchant_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mmn_setting`
--

INSERT INTO `mmn_setting` (`id`, `access_token`, `merchant_id`) VALUES
(1, 'dc36870b-c2f9-4a58-911e-b9dbca6f8fc2', '014000007447881');

-- --------------------------------------------------------

--
-- Table structure for table `product_imgs`
--

CREATE TABLE `product_imgs` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_imgs`
--

INSERT INTO `product_imgs` (`id`, `pid`, `img`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://images.nightcafe.studio/jobs/F1y0DaYiDvLVFlqYLHxo/F1y0DaYiDvLVFlqYLHxo--1--mp6si.jpg?tr=w-1600,c-at_max', '2024-07-29 16:47:52', '2024-07-29 09:47:52'),
(2, 1, 'https://www.beartai.com/wp-content/uploads/2017/12/115707781.jpg', '2024-07-29 16:47:52', '2024-07-29 09:47:52'),
(4, 1, 'https://images.nightcafe.studio/jobs/F1y0DaYiDvLVFlqYLHxo/F1y0DaYiDvLVFlqYLHxo--1--mp6si.jpg?tr=w-1600,c-at_max', '2024-07-29 18:45:19', '2024-07-29 11:45:28'),
(5, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:16', '2024-07-30 10:00:16'),
(6, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:19', '2024-07-30 10:00:19'),
(7, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:23', '2024-07-30 10:00:23'),
(8, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:25', '2024-07-30 10:00:25'),
(9, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:29', '2024-07-30 10:00:29'),
(10, 3, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-07-30 17:00:37', '2024-07-30 10:00:37'),
(11, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:29', '2024-08-01 06:25:29'),
(12, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:32', '2024-08-01 06:25:32'),
(13, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:35', '2024-08-01 06:25:35'),
(14, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:37', '2024-08-01 06:25:37'),
(15, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:40', '2024-08-01 06:25:40'),
(16, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:45', '2024-08-01 06:25:45'),
(17, 4, 'https://cdn-webth.garenanow.com/webth/cdn/gth/rov/non-events/official/91fc22c214f3a693e0ec188fdd87e4d7765031264.jpg', '2024-08-01 13:25:48', '2024-08-01 06:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `recom`
--

CREATE TABLE `recom` (
  `recom_1` int(11) NOT NULL DEFAULT 0,
  `recom_2` int(11) NOT NULL DEFAULT 0,
  `recom_3` int(11) NOT NULL DEFAULT 0,
  `recom_4` int(11) NOT NULL DEFAULT 0,
  `recom_5` int(11) NOT NULL DEFAULT 0,
  `recom_6` int(11) NOT NULL DEFAULT 0,
  `recom_7` int(11) NOT NULL DEFAULT 0,
  `recom_8` int(11) NOT NULL DEFAULT 0,
  `recom_9` int(11) NOT NULL DEFAULT 0,
  `recom_10` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recom`
--

INSERT INTO `recom` (`recom_1`, `recom_2`, `recom_3`, `recom_4`, `recom_5`, `recom_6`, `recom_7`, `recom_8`, `recom_9`, `recom_10`) VALUES
(1, 1, 1, 1, 84, 71, 8, 7, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `redeem`
--

CREATE TABLE `redeem` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `max_count` int(11) NOT NULL,
  `prize` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeem`
--

INSERT INTO `redeem` (`id`, `code`, `count`, `max_count`, `prize`) VALUES
(1, 'ทดสอบ', 1, 5, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `redeem_his`
--

CREATE TABLE `redeem_his` (
  `id` int(11) NOT NULL,
  `uid` varchar(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date` datetime(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeem_his`
--

INSERT INTO `redeem_his` (`id`, `uid`, `code`, `date`) VALUES
(1, '2', 'ทดสอบ', '2024-07-28 13:55:31.00');

-- --------------------------------------------------------

--
-- Table structure for table `service_cate`
--

CREATE TABLE `service_cate` (
  `s_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `img` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_cate`
--

INSERT INTO `service_cate` (`s_id`, `name`, `des`, `img`) VALUES
(1, 'Dedazen1', 'Dedazen1', 'https://dedazen.com/assets/img/bzkl.png'),
(2, 'Dedazen2', 'Dedazen2', 'https://dedazen.com/assets/img/bzkl.png');

-- --------------------------------------------------------

--
-- Table structure for table `service_order`
--

CREATE TABLE `service_order` (
  `id` int(11) NOT NULL,
  `cosid` varchar(255) NOT NULL,
  `prod` varchar(255) NOT NULL,
  `user` mediumtext NOT NULL,
  `pass` mediumtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `del` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_order`
--

INSERT INTO `service_order` (`id`, `cosid`, `prod`, `user`, `pass`, `status`, `del`) VALUES
(1, '2', '999', '1111111', 'undefined', 'yes', 'no'),
(2, '2', 'FF 150 เพชร', 'ทดสอบ', 'undefined', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `service_prod`
--

CREATE TABLE `service_prod` (
  `id` int(11) NOT NULL,
  `cate` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `img` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_prod`
--

INSERT INTO `service_prod` (`id`, `cate`, `name`, `des`, `price`, `img`) VALUES
(1, 'Dedazen2', 'FF 150 เพชร', '- ทดสอบ', 99, 'https://dedazen.com/assets/img/bzkl.png'),
(2, 'Dedazen2', '999', '- ทดสอบ', 299, 'https://dedazen.com/assets/img/bzkl.png');

-- --------------------------------------------------------

--
-- Table structure for table `service_setting`
--

CREATE TABLE `service_setting` (
  `status` varchar(255) NOT NULL,
  `mes` varchar(255) NOT NULL,
  `img` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_setting`
--

INSERT INTO `service_setting` (`status`, `mes`, `img`) VALUES
('on', 'บริการเติม Roblox', 'https://cdn.discordapp.com/attachments/1155002379314413588/1173969648937619466/New_Project_20_Copy_2_EE53A6B.png?ex=6565e36f&is=65536e6f&hm=9b65ed1308b9d3c217f1650fe4e20a3fbab986d37ee51030a1364b2d1648a7cf&');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `wallet` varchar(255) NOT NULL,
  `fee` enum('on','off') NOT NULL DEFAULT 'off',
  `bg` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ann` varchar(255) NOT NULL,
  `main_color` varchar(255) NOT NULL,
  `sec_color` varchar(255) NOT NULL,
  `discord` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `date` datetime(2) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `c1_dedazen` varchar(255) NOT NULL,
  `c2_dedazen` varchar(255) NOT NULL,
  `c3_dedazen` varchar(255) NOT NULL,
  `c4_dedazen` varchar(255) NOT NULL,
  `bg_premium` varchar(255) NOT NULL,
  `premium_img` varchar(255) NOT NULL,
  `webhook_dc` varchar(255) NOT NULL,
  `bg_ann` varchar(500) NOT NULL,
  `tx_ann` varchar(250) NOT NULL,
  `help` varchar(255) NOT NULL,
  `fb` varchar(255) NOT NULL,
  `lined` varchar(255) NOT NULL,
  `oaccept` int(2) NOT NULL,
  `apipeamsub` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`wallet`, `fee`, `bg`, `name`, `ann`, `main_color`, `sec_color`, `discord`, `des`, `date`, `ip`, `logo`, `c1_dedazen`, `c2_dedazen`, `c3_dedazen`, `c4_dedazen`, `bg_premium`, `premium_img`, `webhook_dc`, `bg_ann`, `tx_ann`, `help`, `fb`, `lined`, `oaccept`, `apipeamsub`) VALUES
('0959963505', 'on', 'https://img5.pic.in.th/file/secure-sv1/image2048bb44e9e6a099.png', 'Dedazen Store - ดีด้าเซนต์', 'บริการจำหน่ายไอดีเกมราคาถูก เติมเกมออนไลน์ สั่งซื้อได้ตลอด 24 ชม', '#0061fe', '#3a87fe', '-', 'บริการจำหน่ายไอดีเกมราคาถูก เติมเกมออนไลน์ สั่งซื้อได้ตลอด 24 ชม', '2022-12-25 12:30:39.00', '::1', '/logodedazen12.png', 'undefined', 'undefined', 'undefined', 'undefined', '/dz/web.png', 'https://i.postimg.cc/VLX853ry/image.png', '#', 'undefined', 'undefined', 'https://cdn.discordapp.com/attachments/1170981715506892801/1224202419303485491/Frame_436.png?ex=661ca259&is=660a2d59&hm=c4ba996344bf1d7af02d365c6c11fefa5ba8c09b6ac977125d1913b94b6d759b&', 'https://www.facebook.com/Mtshopcream', '-', 1, '#');

-- --------------------------------------------------------

--
-- Table structure for table `setup_topupapi`
--

CREATE TABLE `setup_topupapi` (
  `status` int(2) NOT NULL,
  `pubkey` text NOT NULL,
  `secrets` text NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setup_topupapi`
--

INSERT INTO `setup_topupapi` (`status`, `pubkey`, `secrets`, `price`) VALUES
(2, '#', '#', '-1');

-- --------------------------------------------------------

--
-- Table structure for table `static`
--

CREATE TABLE `static` (
  `s_count` int(11) NOT NULL DEFAULT 2575,
  `b_count` int(11) NOT NULL DEFAULT 3525,
  `m_count` int(11) NOT NULL DEFAULT 5468,
  `last_change` datetime(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `static`
--

INSERT INTO `static` (`s_count`, `b_count`, `m_count`, `last_change`) VALUES
(0, 0, 0, '2024-07-24 16:55:10.00');

-- --------------------------------------------------------

--
-- Table structure for table `stock_api`
--

CREATE TABLE `stock_api` (
  `id` int(11) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `price_web` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `up` varchar(255) DEFAULT NULL,
  `showitem` int(11) NOT NULL DEFAULT 1,
  `category` varchar(255) DEFAULT NULL,
  `info` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `stock_api`
--

INSERT INTO `stock_api` (`id`, `product_id`, `name`, `price`, `price_web`, `img`, `stock`, `status`, `up`, `showitem`, `category`, `info`) VALUES
(27, '1', 'Netflix 4K /30วัน (จอส่วนตัว)', '90.00', '130', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">รายเดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(28, '2', 'Netflix 4K /7วัน (จอส่วนตัว)', '29.00', '35.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">7วัน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(29, '3', 'Netflix 4K /30วัน (จอแชร์)', '69.00', '89.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">รายเดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(30, '4', 'Netflix 4K /7วัน (จอแชร์)', '15.00', '25.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">7วัน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>'),
(31, '5', 'Disney+ /30วัน (จอส่วนตัว) (ทุกอุปกรณ์)', '79.00', '89.00', 'https://img_app.byshop.me/api/img/app/Disney.png', '18', 'พร้อมส่ง', '', 1, '3', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Disney+ แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD 4K</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6> <h6>▶️ จะได้รับเป็น Phone/OTP เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6> <h6>▶️ Disney แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span></h6>    <li>website <a href=\"https://www.hotstar.com/th\" target=\"_blank\">https://www.hotstar.com/th</a></li>  '),
(32, '6', 'Youtube Premium/30วัน (เมลร้าน)', '10.00', '40.00', 'https://img_app.byshop.me/api/img/app/yt.png', '10', 'พร้อมส่ง', '', 1, '2', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ รับชม Youtube แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ ฟังเพลง Youtube Music แบบปิดหน้าจอได้</h6>  <h6>▶️ ดาวน์โหลดเพลงหรือบันทึกวิดีโอเล่นแบบออฟไลน์</h6>  <h6>▶️ จะได้รับเป็น Email/Password | <span class=\"text-light badge bg-dark\">ลิ้งคำเชิญ <img width=\"25px;\" class=\"img-fluid\" src=\"https://byshop.me/buy/img/yt.png\">family</span> เข้าใช้งานได้ทันที</h6>   <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Youtube Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.youtube.com/\" target=\"_blank\">https://www.youtube.com/</a></li> '),
(33, '7', 'Youtube Premium/1ปี (เมลตัวเอง)', '10.00', '389.00', 'https://img_app.byshop.me/api/img/app/yt.png', '42', 'พร้อมส่ง', '', 1, '2', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ รับชม Youtube แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ ฟังเพลง Youtube Music แบบปิดหน้าจอได้</h6>  <h6>▶️ ดาวน์โหลดเพลงหรือบันทึกวิดีโอเล่นแบบออฟไลน์</h6>  <h6>▶️ จะได้รับเป็น Email/Password | <span class=\"text-light badge bg-dark\">ลิ้งคำเชิญ <img width=\"25px;\" class=\"img-fluid\" src=\"https://byshop.me/buy/img/yt.png\">family</span> เข้าใช้งานได้ทันที</h6>   <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Youtube Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.youtube.com/\" target=\"_blank\">https://www.youtube.com/</a></li> '),
(34, '8', 'Youtube Premium/30วัน (เมลตัวเอง)', '450.00', '40.00', 'https://img_app.byshop.me/api/img/app/yt.png', '0', 'สินค้าหมด', '', 1, '2', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ รับชม Youtube แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ ฟังเพลง Youtube Music แบบปิดหน้าจอได้</h6>  <h6>▶️ ดาวน์โหลดเพลงหรือบันทึกวิดีโอเล่นแบบออฟไลน์</h6>  <h6>▶️ จะได้รับเป็น Email/Password | <span class=\"text-light badge bg-dark\">ลิ้งคำเชิญ <img width=\"25px;\" class=\"img-fluid\" src=\"https://byshop.me/buy/img/yt.png\">family</span> เข้าใช้งานได้ทันที</h6>   <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Youtube Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.youtube.com/\" target=\"_blank\">https://www.youtube.com/</a></li> '),
(35, '9', 'MONOMAX/30วัน (จอส่วนตัว)', '35.00', '49.00', 'https://img_app.byshop.me/api/img/app/monomax.png', '12', 'พร้อมส่ง', '', 1, '4', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> '),
(36, '10', 'MONOMAX/30วัน (จอแชร์)', '25.00', '39.00', 'https://img_app.byshop.me/api/img/app/monomax.png', '11', 'พร้อมส่ง', '', 1, '4', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ MONOMAX แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ MONOMAX แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.monomax.me/\" target=\"_blank\">https://www.monomax.me/</a></li> '),
(37, '11', 'HBO GO/30วัน', '45.00', '60.00', 'https://img_app.byshop.me/api/img/app/hbo.png', '3', 'พร้อมส่ง', '', 1, '5', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ HBO GO แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"text-light badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ HBO GO แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.hbogo.co.th/\" target=\"_blank\">https://www.hbogo.co.th/</a></li> '),
(38, '12', 'VIU Premium/30วัน', '10.00', '29.00', 'https://img_app.byshop.me/api/img/app/viu.png', '43', 'พร้อมส่ง', '', 1, '6', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ VIU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6> <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  <h6>▶️ รับชม VIU Premium แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ VIU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.viu.com/\" target=\"_blank\">https://www.viu.com/</a></li> '),
(39, '13', 'iQIYI GOLD /30วัน', '22.00', '39.00', 'https://img_app.byshop.me/api/img/app/iq.png', '3', 'พร้อมส่ง', '', 1, '7', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ iQIYI แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ รับชม iqiyi VIP แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ iQIYI VIP แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.iq.com/\" target=\"_blank\">https://www.iq.com/</a></li> '),
(40, '14', 'WeTV VIP /30วัน', '20.00', '39.00', 'https://img_app.byshop.me/api/img/app/wetv.png', '39', 'พร้อมส่ง', '', 1, '8', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ WeTV แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ รับชม WeTV VIP แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ WeTV VIP แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://wetv.vip/\" target=\"_blank\">https://wetv.vip/</a></li> '),
(41, '15', 'Amazon Prime Video/30วัน', '45.00', '59.00', 'https://img_app.byshop.me/api/img/app/pv.png', '0', 'สินค้าหมด', '', 1, '9', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Amazon Prime Video แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Amazon Prime Video แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.primevideo.com/\" target=\"_blank\">https://www.primevideo.com/</a></li> '),
(42, '16', 'Amazon Prime Video/7วัน', '10.00', '20.00', 'https://byshop.me/api/img/app/pv.png', '0', 'สินค้าหมด', '', 1, '9', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Amazon Prime Video แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Amazon Prime Video แพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://www.primevideo.com/\" target=\"_blank\">https://www.primevideo.com/</a></li> '),
(43, '17', 'Spotify Premium/30วัน(เมลร้าน)', '10.00', '29.00', 'https://img_app.byshop.me/api/img/app/sf.png', '0', 'สินค้าหมด', '', 1, '10', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Spotify แอปฟังเพลงออนไลน์ รวมเพลงทุกประเทศ</h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> ระดับพรีเมียม</span></h6> <h6>▶️ ฟังเพลงขนาดปิดหน้าจอไม่มีโฆษณากวนใจ</h6>  <h6>▶️ โหลดเพลงไว้ฟังขนาดออฟไลน์ได้</h6>  <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6> <h6>▶️ Spotify แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span></h6>    <li>website <a href=\"https://open.spotify.com/\" target=\"_blank\">https://open.spotify.com/</a></li> '),
(44, '18', 'TrueID+ /30วัน', '25.00', '29.00', 'https://img_app.byshop.me/api/img/app/trueid+.png', '0', 'สินค้าหมด', '', 1, '11', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ TrueID แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ รับชม TrueID+ แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ จะได้รับเป็น Phone/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ TrueID แพ็กเกจ  <span class=\"badge bg-warning\">TrueID+ รายเดือน</span></h6>  <li>website <a href=\"https://www.trueid.net/watch/th-th/trueidplus\" target=\"_blank\">https://www.trueid.net/watch/th-th/trueidplus</a></li> '),
(45, '19', 'AIS Play /30วัน', '10.00', '29.00', 'https://img_app.byshop.me/api/img/app/ais.png', '0', 'สินค้าหมด', '', 1, '12', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ AIS Play แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน/TVออนไลน์<span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Phone/OTP เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ AIS Play แพ็กเกจ  <span class=\"badge bg-warning\">family รายเดือน</span></h6>  <li>website <a href=\"https://aisplay.ais.co.th/\" target=\"_blank\">https://aisplay.ais.co.th/</a></li> '),
(46, '20', 'Bilibili /30วัน', '25.00', '35.00', 'https://img_app.byshop.me/api/img/app/bb.png', '39', 'พร้อมส่ง', '', 1, '13', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Bilibili แอปดูการ์ตูนอนิเมะ<span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ Bilibili แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://www.bilibili.tv/th\" target=\"_blank\">https://www.bilibili.tv/th</a></li> '),
(47, '21', 'Netflix 4K /1วัน (จอส่วนตัว)', '7.00', '10.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">1วัน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(48, '22', 'Netflix 4K /1วัน (จอแชร์)', '5.00', '8.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">1วัน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(49, '23', 'Netflix 4K /30วัน (TV) (จอส่วนตัว)', '159.00', '179.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">รายเดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(50, '24', 'YOUKU VIP /30วัน', '29.00', '39.00', 'https://img_app.byshop.me/api/img/app/&n.png', '1', 'พร้อมส่ง', '', 1, '16', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ YOUKU แอปดูหนัง/ซีรีย์ <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6> <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i>  <h6>▶️ รับชม YOUKU Premium แบบไม่มีโฆษณาคั่น</h6>  <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ YOUKU Premiumแพ็กเกจ  <span class=\"badge bg-warning\">รายเดือน</span></h6>  <li>website <a href=\"https://youku.tv/\" target=\"_blank\">https://youku.tv/</a></li> '),
(51, '25', 'BeinSports /30วัน', '49.00', '69.00', 'https://img_app.byshop.me/api/img/app/bs.png', '2', 'พร้อมส่ง', '', 1, '14', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ beinsports แอปดูกีฬา LIVE สด - ย้อนหลัง<span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ beinsports แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://connect-th.beinsports.com/th\" target=\"_blank\">https://connect-th.beinsports.com/th</a></li> '),
(52, '26', 'CH3 Plus /30วัน', '39.00', '59.00', 'https://img_app.byshop.me/api/img/app/ch3.png', '11', 'พร้อมส่ง', '', 1, '15', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ CH3 Plus แอปดูภาพยนตร์ / ซีรีส์ / ละคร การ์ตูน / ข่าวสด ย้อนหลัง <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i> <h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>  <h6>▶️ CH3 Plus แพ็กเกจ  <span class=\"badge bg-warning\">Premium รายเดือน</span></h6>  <li>website <a href=\"https://ch3plus.com/\" target=\"_blank\">https://ch3plus.com/</a></li> '),
(53, '27', 'Disney+ /30วัน (จอส่วนตัว) (มือถือ)', '49.00', '69.00', 'https://img_app.byshop.me/api/img/app/Disney.png', '0', 'สินค้าหมด', '', 1, '3', '<h3><u>รายละเอียด</u></h3>  <h6>▶️ Disney+ แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน <span class=\"badge bg-dark\"></h6>  <h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> <h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">Full HD 4K</span></h6>  <h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6> <h6>▶️ จะได้รับเป็น Phone/OTP เข้าใช้งานได้ทันที</h6>  <h6>▶️ รองรับอุปกรณ์ <i>(มือถือ)</i></h6> <h6>▶️ Disney แพ็กเกจ <span class=\"badge bg-warning\">รายเดือน</span></h6>    <li>website <a href=\"https://www.hotstar.com/th\" target=\"_blank\">https://www.hotstar.com/th</a></li>  '),
(54, '28', 'Netflix 4K /60วัน (TV) (จอส่วนตัว)', '299.00', '350.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(TV,Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">2เดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(55, '29', 'Netflix 4K /60วัน (จอส่วนตัว)', '180.00', '220.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">2เดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(56, '30', 'Netflix 4K /60วัน (จอแชร์)', '138.00', '169.00', 'https://img_app.byshop.me/api/img/app/netflix.png', '0', 'สินค้าหมด', '', 1, '1', '<h3><u>รายละเอียด</u></h3> \n<h6>▶️ Netflix แอปดูหนังภาพยนตร์/ซีรีย์/การ์ตูน </h6> \n<h6>▶️ Soundเสียง <span class=\"text-light badge bg-dark\"><i class=\"fa fa-volume-up\" aria-hidden=\"true\"></i> พากย์ไทย/ซับไทย</span></h6> \n<h6>▶️ ความชัดระดับ <span class=\"text-light badge bg-dark\">UltraHD 4K</span></h6> \n<h6>▶️ สามารถรับชมจำนวน 1จอ <i class=\"fa fa-desktop\" aria-hidden=\"true\"></i></h6>\n<h6>▶️ แอคเคาท์ไทยแท้100%</b></h6>\n<h6>▶️ จะได้รับเป็น Email/Password เข้าใช้งานได้ทันที</h6> \n<h6>▶️ รองรับทุกอุปกรณ์ <i>(Com, Ipad ,มือถือ)</i></h6>\n<h6>▶️ Netflixแพ็กเกจ UltraHD 4K <span class=\"badge bg-warning\">2เดือน</span></h6>  \n<li>website <a href=\"https://www.netflix.com/\" target=\"_blank\">https://www.netflix.com/</a></li>  '),
(57, '100', 'TEST API', '0.00', '9999.00', 'https://img_app.byshop.me/buy/img/img_app/te.png', '999', 'พร้อมส่ง', '', 1, '0', 'ทดสอบ API');

-- --------------------------------------------------------

--
-- Table structure for table `topup_his`
--

CREATE TABLE `topup_his` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `date` datetime NOT NULL,
  `uid` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `uimg` text NOT NULL,
  `ref` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topup_his`
--

INSERT INTO `topup_his` (`id`, `link`, `amount`, `date`, `uid`, `uname`, `uimg`, `ref`) VALUES
(1, 'TOPUP QR', 1.00, '2024-06-27 20:53:49', 1, '11', '', ''),
(2, 'TOPUP QR', 1.00, '2024-07-30 11:58:19', 6, 'aq123', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `point` float(10,2) NOT NULL,
  `total` float(10,2) NOT NULL,
  `pin` varchar(6) NOT NULL,
  `profile` text DEFAULT '/dz/user.png',
  `rank` int(1) NOT NULL DEFAULT 0,
  `vip_role` int(1) NOT NULL DEFAULT 0,
  `accept` int(11) NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `social_type` enum('line','discord','none') NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `date`, `point`, `total`, `pin`, `profile`, `rank`, `vip_role`, `accept`, `social_id`, `social_type`) VALUES
(2, NULL, 'aq123123', 'ecd782f5b01daad7a13dba45ebd51c8e', '2024-06-27', 999249.12, 0.00, '', 'https://cdn.discordapp.com/avatars/844249791747981362/847ab95b73a1a51eaec8a7b3ce28b534.png', 1, 1, 1, '', 'none'),
(5, NULL, 'user1', 'ecd782f5b01daad7a13dba45ebd51c8e', '2024-07-20', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(6, NULL, 'aq123', 'ecd782f5b01daad7a13dba45ebd51c8e', '2024-07-20', 1.00, 1.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(7, NULL, 'sajhong', '81dc9bdb52d04dc20036dbd8313ed055', '2024-07-24', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(8, NULL, 'MRPEEz', '5233a4a1c8108f2c401fb4390282be67', '2024-07-25', 0.00, 0.00, '', '/dz/user.png', 0, 1, 1, '', 'none'),
(9, NULL, 'Boeing', '0acf03f408f90ea0dcba786d300620db', '2024-07-27', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(10, NULL, 'Test111', '4061863caf7f28c0b0346719e764d561', '2024-07-27', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(11, NULL, 'testza001', 'ab64effa8e99f290bc9344a606415efb', '2024-07-28', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(12, 'tunpisittune@gmail.com', 'yosiketdev', '6512bd43d9caa6e02c990b0a82652dca', '2024-07-28', 0.00, 0.00, '', '/dz/user.png', 1, 1, 1, '', 'none'),
(13, NULL, 'testza999', '79f539a787ffdfbb116c5c4ea5244cec', '2024-07-30', 0.00, 0.00, '', '/dz/user.png', 0, 1, 1, '', 'none'),
(15, 'ysxtest@gmail.com', 'ysxtest', 'cf0e475c41cfec1f4b946fea5f54f8f7', '2024-07-31', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(16, 'Hnawny@gmail.com', 'Hnawny', '0405cf0afc01eca87d15f8c7e9b6b628', '2024-08-10', 999990.12, 0.00, '', '/dz/user.png', 1, 0, 1, '', 'none'),
(17, 'poppeezn@gmail.com', 'aq123a', '155a71133c9983db65a464d945e76496', '2024-08-11', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none'),
(18, 'p0983848494@gmail.com', 'Ford', '827ccb0eea8a706c4c34a16891f84e7b', '2024-08-11', 0.00, 0.00, '', '/dz/user.png', 0, 0, 1, '', 'none');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apipeam_product`
--
ALTER TABLE `apipeam_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boxlog`
--
ALTER TABLE `boxlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `boxlogapp`
--
ALTER TABLE `boxlogapp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_product`
--
ALTER TABLE `box_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_stock`
--
ALTER TABLE `box_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_category`
--
ALTER TABLE `game_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_item`
--
ALTER TABLE `game_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_stock`
--
ALTER TABLE `game_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_api`
--
ALTER TABLE `history_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `his_purchase`
--
ALTER TABLE `his_purchase`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `kbank_trans`
--
ALTER TABLE `kbank_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mmn_setting`
--
ALTER TABLE `mmn_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_imgs`
--
ALTER TABLE `product_imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redeem`
--
ALTER TABLE `redeem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redeem_his`
--
ALTER TABLE `redeem_his`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_cate`
--
ALTER TABLE `service_cate`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `service_order`
--
ALTER TABLE `service_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_prod`
--
ALTER TABLE `service_prod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`oaccept`);

--
-- Indexes for table `setup_topupapi`
--
ALTER TABLE `setup_topupapi`
  ADD PRIMARY KEY (`status`);

--
-- Indexes for table `stock_api`
--
ALTER TABLE `stock_api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topup_his`
--
ALTER TABLE `topup_his`
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
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `boxlog`
--
ALTER TABLE `boxlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `boxlogapp`
--
ALTER TABLE `boxlogapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `box_product`
--
ALTER TABLE `box_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `box_stock`
--
ALTER TABLE `box_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `game_category`
--
ALTER TABLE `game_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `game_item`
--
ALTER TABLE `game_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `game_stock`
--
ALTER TABLE `game_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `history_api`
--
ALTER TABLE `history_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `his_purchase`
--
ALTER TABLE `his_purchase`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kbank_trans`
--
ALTER TABLE `kbank_trans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mmn_setting`
--
ALTER TABLE `mmn_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_imgs`
--
ALTER TABLE `product_imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `redeem`
--
ALTER TABLE `redeem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `redeem_his`
--
ALTER TABLE `redeem_his`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_cate`
--
ALTER TABLE `service_cate`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_order`
--
ALTER TABLE `service_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_prod`
--
ALTER TABLE `service_prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `oaccept` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_api`
--
ALTER TABLE `stock_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `topup_his`
--
ALTER TABLE `topup_his`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
