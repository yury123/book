
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 03 2015 г., 20:54
-- Версия сервера: 10.0.20-MariaDB
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `u448417304_ct`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author` char(50) NOT NULL DEFAULT '0',
  `author_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`author`, `author_id`) VALUES
('Генри Райд', 1),
('Крис Чибнелл', 2),
('Эрин Келли', 3),
('Агата Кристи', 4),
('Рэй Брэдбери', 5),
('Автор', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `authors_books`
--

CREATE TABLE IF NOT EXISTS `authors_books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `authors_books`
--

INSERT INTO `authors_books` (`id`, `book_id`, `author_id`) VALUES
(1, 3, 4),
(2, 4, 4),
(3, 1, 1),
(4, 2, 2),
(5, 2, 3),
(6, 5, 5),
(7, 6, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(10) NOT NULL AUTO_INCREMENT,
  `Title` char(50) NOT NULL DEFAULT '',
  `Price` float unsigned DEFAULT NULL,
  `Description` mediumtext,
  PRIMARY KEY (`book_id`),
  KEY `Title` (`Title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`book_id`, `Title`, `Price`, `Description`) VALUES
(1, 'Копи царя Соломона', 48.8, 'Легенда гласит, что нашедший копи царя Соломона станет самым богатым человеком, но их охраняет страшное проклятие. Никто из тех, кто уходил на их поиски, не вернулся. В пустынях Африки исчез и Куртис. Генри, его брат, уговаривает охотника Аллана Квотермейна стать проводником в опасном путешествии в сердце Африки («Копи царя Соломона»).\r\nТакже в книгу вошли «Бенита» и «Приключения Аллана Квотермейна». '),
(2, 'Убийство на пляже', 66.6, '"txt"'),
(3, 'Спящий убийца', 38.3, 'Молодая новобрачная Гвенда Рид делает все возможное, чтобы ее новый дом выглядел современным. Но в доме вдруг начинают происходить странные вещи, которые словно отбрасывают Гвенду в мрачное прошлое. Ей мерещатся призраки, каждый шаг по дому превращается в пытку и становится настоящим испытанием для ее разума.\r\nГениальная мисс Марпл берется помочь девушке, и пока не знает, что ей придется распутывать преступление, совершенное много лет назад... '),
(4, 'Тринадцать загадочных случаев', 38.3, 'Пятеро джентльменов решили организовать клуб «Вторник», где они рассказывают истории про загадочные преступления и пытаются найти разгадку.'),
(5, '451° по Фаренгейту', 48.8, '451 градус по Фаренгейту — температура, при которой воспламеняется и горит бумага. Главный герой — Монтэг — пожарник, но смысл этой профессии давно изменился. Дома теперь строятся из термостойких сплавов, а пожарники занимаются тем, что сжигают книги. Не произведения определенных авторов — запрещена литература вообще и люди, хранящие и читающие книги, совершают преступление против государства. Бессмысленные развлечения, успокоительные таблетки, выматывающая работа — вот и все занятия человека.'),
(6, 'Новая', 0.5, 'Нет описания');

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `genre` char(50) NOT NULL DEFAULT '0',
  `genre_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`genre_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`genre`, `genre_id`) VALUES
('Историко-приключенческие', 1),
('Детективы', 2),
('Фантастика', 3),
('Антиутопия', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `genres_books`
--

CREATE TABLE IF NOT EXISTS `genres_books` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `genre_id` int(10) DEFAULT NULL,
  `book_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `genres_books`
--

INSERT INTO `genres_books` (`id`, `genre_id`, `book_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 5),
(6, 4, 5),
(7, NULL, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
