-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 28 2024 г., 13:20
-- Версия сервера: 10.8.4-MariaDB
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dlyapalati`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `event_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `text`, `photo`, `date`, `event_id`) VALUES
(5, 'В своих социальных сетях губернатор рассказал, что принял участие в голосовании на выборах Президента Российской Федерации. \n \nГлава региона в числе первых исполнил свой гражданский долг. \n \nОлег Мельниченко попросил всех пензенцев отдать свой голос за будущее нашей страны. \n15,16, 17 марта будут идти выборы Президента страны. Избирательные участки работают с 8 до 20 часов. \n \n#ОбщественнаяпалатаПензенскойобласти', 'https://sun9-18.userapi.com/impg/jgo4s2_KSn4FmJLyeMbZyQcvPNbxGdfpM21ywQ/hUMQiFqBkvI.jpg?size=510x510&quality=96&sign=a96e2f7b0dc9d048b70eca7f176d8a50&c_uniq_tag=wpBg_o2n4ZzkbBQ-9kTjPItmomsbjFVAeJPN9YYj0dc&type=album', '2024-03-17', '48d2f2b12abc276604ee5cec4b5439f90267ab3d');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
