-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2021-09-01 12:35:41
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pachong`
--

-- --------------------------------------------------------

--
-- 表的结构 `datas`
--

CREATE TABLE IF NOT EXISTS `datas` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(600) DEFAULT NULL,
  `link` varchar(900) DEFAULT NULL,
  `date` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `datas`
--

INSERT INTO `datas` (`id`, `title`, `link`, `date`) VALUES
(1, '菜鸟教程 - 学的不仅是技术，更是梦想！', 'https://www.runoob.com/', '2021-09-01 12:35'),
(2, '菜鸟笔记 | 菜鸟教程', 'https://www.runoob.com/w3cnote/', '2021-09-01 12:35'),
(3, '菜鸟笔记 | 菜鸟教程', 'https://www.runoob.com/w3cnote', '2021-09-01 12:35'),
(4, '1.0 Android基础入门教程 | 菜鸟教程', 'https://www.runoob.com/w3cnote/android-tutorial-intro.html', '2021-09-01 12:35'),
(5, '1.1  ES6 教程 | 菜鸟教程', 'https://www.runoob.com/w3cnote/es6-tutorial.html', '2021-09-01 12:35'),
(6, '1.0 十大经典排序算法 | 菜鸟教程', 'https://www.runoob.com/w3cnote/ten-sorting-algorithm.html', '2021-09-01 12:35');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
