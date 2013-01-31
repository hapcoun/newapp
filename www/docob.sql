-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 27 2013 г., 21:15
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `docob`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_item`
--

CREATE TABLE IF NOT EXISTS `tbl_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `tbl_item`
--

INSERT INTO `tbl_item` (`id`, `document`) VALUES
(1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lookup`
--

CREATE TABLE IF NOT EXISTS `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tbl_lookup`
--

INSERT INTO `tbl_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, 'Draft', 1, 'PostStatus', 1),
(2, 'Discussed', 2, 'PostStatus', 2),
(3, 'Familiarizing', 3, 'PostStatus', 3),
(4, 'Archived', 4, 'PostStatus', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `title`, `content`, `status`, `create_time`, `update_time`, `author_id`) VALUES
(1, 'Welcome!', 'This blog system is developed using Yii. It is meant to demonstrate how to use Yii to build a complete real-world application. Complete source code may be found in the Yii releases.\r\n\r\nFeel free to try this system by writing new posts and posting comments.', 2, 1230952187, 1359304450, 1),
(2, 'A Test Post', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 1230952187, 1230952187, 1),
(3, '1232', '213424354546', 3, 1359298778, 1359304417, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `profile` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `profile`) VALUES
(1, 'demo', '$2a$10$JTJf6/XqC94rrOtzuF397OHa4mbmZrVTBOQCmYD9U.obZRUut4BoC', 'webmaster@example.com', NULL),
(3, 'admin', 'admin', 'admin@mail.ru', ''),
(4, '123', '123', '123@mail.ru', '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD CONSTRAINT `FK_post_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
