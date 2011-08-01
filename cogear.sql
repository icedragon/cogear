-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2011 at 11:01 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cogear`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `body` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `created_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `aid`, `pid`, `body`, `ip`, `created_date`) VALUES
(5, 1, 8, 'И тебе привет!', '', 0),
(4, 1, 8, 'Привет, мир!', '', 0),
(6, 1, 8, 'Всем привет!', '', 0),
(7, 1, 8, 'Когир — лучше всех! Когир ждет <b>успех</b>!\r\n<img src="http://cogear.new/sites/cogear.new/uploads/users/1/logos/cogear.jpg">', '', 0),
(8, 1, 8, 'Комменты!', '', 1312147667),
(9, 1, 8, 'Ура!', '', 1312185157),
(10, 7, 8, 'Ура, и я теперь могу комменты постить!', '', 1312216904);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `allow_comments` tinyint(1) unsigned NOT NULL,
  `comments` int(11) unsigned NOT NULL,
  `created_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `aid`, `name`, `url`, `path`, `body`, `allow_comments`, `comments`, `created_date`, `last_update`) VALUES
(1, 1, 'Проба пера', 'privet,-mir!', '                   1', 'Первое сообщение!  ', 0, 0, 1302619389, 1308985715),
(2, 1, 'Привет, мир!', '', '                   2', '<br><div><img src="http://cogear.new/sites/cogear.new/uploads/files/1/Some%20folder/iAvatar-quadro.jpg" height="147" width="147"></div>Первая страница со своим содержимым!  ', 0, 0, 1302733674, 1308985672),
(7, 1, 'Тестируем редактор', '', '                   7', '<h1><img style="width:138px;height:132px" src="/sites/cogear.new/uploads/users/1/photos/chain.jpg"></h1><h1>Первый</h1><br><h2>Второй</h2><br><h3>Третий</h3><br><h4>Четвертый</h4><hr style="width:100px;height:1px;background-color:#999999;border:1px dotted" noshade="noshade"><br><br><ol><li>Во-первых</li><li>Во-вторых</li><li>В-третьих</li><li>В-четвертых</li><li>В-пятых<br></li></ol>', 0, 0, 1312105511, 1312106515),
(8, 1, 'Бета-версия cogear²', '', '                   8', '<br><div class="grid_16" id="header">\r\n                <a href="../../"><img src="../../sites/cogear.new/uploads/theme/logo/logo.png" alt="cogear"></a>            </div>Привет, мир! Встречай, второй <span style="font-weight:bold">когир</span>!', 1, 7, 1312106701, 1312222435);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(3) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `validation_code` varchar(255) NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `hash`, `email`, `name`, `role`, `avatar`, `validation_code`, `is_valid`) VALUES
(1, 'admin', 'efc002c854ab0f77646a496dad4ec39c', '', 'admin@cogear.ru', '', 1, '/avatars/1/e_743b67d8.jpg', '', 1),
(6, 'Дмитрий Беляев', '', '', 'usemac.ru@gmail.com', '', 100, '/avatars/1/1av.jpg', '', 1),
(7, 'User', 'efc002c854ab0f77646a496dad4ec39c', '', 'admin@usemac.ru', '', 100, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_loginza`
--

CREATE TABLE IF NOT EXISTS `users_loginza` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `identity` varchar(255) CHARACTER SET utf8 NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `data` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users_loginza`
--

