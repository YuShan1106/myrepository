-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2022-07-10 12:30:18
-- 伺服器版本： 5.7.9-log
-- PHP 版本： 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `guestbook`
--
CREATE DATABASE IF NOT EXISTS `guestbook` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `guestbook`;

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `u_id` varchar(10) CHARACTER SET utf8 NOT NULL,
  `u_password` varchar(10) CHARACTER SET utf8 NOT NULL,
  `u_privilege` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`u_id`, `u_password`, `u_privilege`) VALUES
('andy', '123', 0),
('ben', '123', 0),
('cindy', '123', 0),
('david', '123', 0),
('emma', '123', 0),
('test', '123', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `message`
--

CREATE TABLE `message` (
  `no` int(11) NOT NULL,
  `u_id` varchar(10) NOT NULL DEFAULT '',
  `subject` tinytext NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message`
--

INSERT INTO `message` (`no`, `u_id`, `subject`, `content`, `date`) VALUES
(1, 'andy', '公佈欄介紹', '使用者登入後右上會顯示使用者id。\r\n使用者可以自行發佈公告，並刪除或修改其發佈過的公告。', '2022-07-09 16:52:17'),
(2, 'ben', '搜尋列', '使用者可以透過關鍵字查詢相關的主旨或內容。', '2022-07-09 18:41:22'),
(3, 'cindy', '管理介面', '管理員可以透過點選右上的「管理界面」進入管理系統。', '2022-07-09 18:43:50'),
(4, 'david', '管理員權限', '在管理頁面管理員可以任意編輯、刪除任一使用者的公告。', '2022-07-09 19:01:11'),
(5, 'emma', '管理介面搜尋', '管理員也可以透過搜尋列查詢相關的主旨或內容。', '2022-07-09 19:12:01'),
(6, 'test', '測試', '測試', '2022-07-10 17:12:50');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`u_id`);

--
-- 資料表索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`no`),
  ADD KEY `u_id` (`u_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message`
--
ALTER TABLE `message`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `member` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
