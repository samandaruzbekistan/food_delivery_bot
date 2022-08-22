-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 22 2022 г., 14:04
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cyber079_yagona`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `product_id` int NOT NULL,
  `count` int NOT NULL,
  `price` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id`, `chat_id`, `product_id`, `count`, `price`) VALUES
(27, 1408257581, 35, 1, 4000),
(34, 1801978249, 15, 4, 120000),
(35, 1801978249, 33, 8, 800000);

-- --------------------------------------------------------

--
-- Структура таблицы `delivered`
--

CREATE TABLE `delivered` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `summa` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `delivered`
--

INSERT INTO `delivered` (`id`, `chat_id`, `name`, `phone`, `address`, `summa`, `date`) VALUES
(2, 2105231006, 'Samandar', '975672009', '4 mikrorayon', '800000', '2022-08-22'),
(3, 2105231006, 'Samandar', '975672009', '2 mikrorayon', '161000', '2022-08-22'),
(4, 2105231006, 'Samandar', '975672009', 'Universitet', '228000', '2022-08-22');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `summa` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_profuct`
--

CREATE TABLE `order_profuct` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `product_id` int NOT NULL,
  `count` int NOT NULL,
  `price` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `section_id` int NOT NULL,
  `price` bigint NOT NULL,
  `img` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `section_id`, `price`, `img`) VALUES
(8, 'Osh', 1, 160000, 'AgACAgIAAxkBAAIEO2L83xbL4H28QbtHeTyhZF7KycrQAALZvDEbQx3pS_kbsvNRxzNaAQADAgADcwADKQQ'),
(9, 'Qozon Kabob', 1, 120000, 'AgACAgIAAxkBAAIERmL838cQn0XPDHCToyUJctAeoVEJAALhvDEbQx3pSxo90IaswbEbAQADAgADcwADKQQ'),
(10, 'Tabaka', 1, 50000, 'AgACAgIAAxkBAAIEUWL84CzCLJwP4AQ_Yyl61iWBFCDlAALlvDEbQx3pS8Ub2Pp-r5byAQADAgADcwADKQQ'),
(11, 'Dimlama', 1, 170000, 'AgACAgIAAxkBAAIEXGL84Uo7-udKyTmT7y2wQ6fVGeDjAALmvDEbQx3pS6F0zP8ek8R1AQADAgADcwADKQQ'),
(12, 'free(Kartoshka)', 1, 4000, 'AgACAgIAAxkBAAIEZ2L84Y5SuHo4s5_zjAzEafTAToXwAALovDEbQx3pS8pzz1rZlTNtAQADAgADcwADKQQ'),
(13, 'Perzola', 2, 50000, 'AgACAgIAAxkBAAIEcmL84erA2HMiBU75dmgbR87vTrK2AALqvDEbQx3pS0zqxjh9Bxh1AQADAgADcwADKQQ'),
(14, 'Izgara Kofte', 2, 40000, 'AgACAgIAAxkBAAIEfWL84meERCxeFgt6lYACSWOG_x-MAALrvDEbQx3pSwHGsmjJwFsNAQADAgADcwADKQQ'),
(15, 'Kuzu Shish', 2, 30000, 'AgACAgIAAxkBAAIEiGL84rt3FBKQKHoMfvjEHiJNFVmMAALtvDEbQx3pS7k8sJohw1veAQADAgADcwADKQQ'),
(16, 'Bon Kuskavoy', 2, 70000, 'AgACAgIAAxkBAAIEk2L84yd-V_2eZlt24attPG-iC-oWAAL0vDEbQx3pS-1mlRw8_MHcAQADAgADcwADKQQ'),
(18, 'Tovuq Shish', 2, 40000, 'AgACAgIAAxkBAAIEv2L85O-WBWNBvdzNYYWEDy6t0JMAA_q8MRtDHelLJc1boj3t5PYBAAMCAANzAAMpBA'),
(19, 'Tovuq File', 2, 50000, 'AgACAgIAAxkBAAIE52L85bSXBhb4yptdih_41HTASp--AAL3vDEbQx3pS-LcxEFDHgABjAEAAwIAA3MAAykE'),
(20, 'Pelmen (chuchvara)', 1, 15000, 'AgACAgIAAxkBAAIH0GL92u1zSaZSVDrQVP11uG5wjPuNAAJGuzEbQx3xSxa_BvA7HcHSAQADAgADcwADKQQ'),
(21, 'Teftel', 1, 14000, 'AgACAgIAAxkBAAIH22L92xqvdXo66_3KWF-AEf78exlSAAJHuzEbQx3xS-yuJkE1u376AQADAgADcwADKQQ'),
(23, 'Jiz (Jaz)', 1, 140000, 'AgACAgIAAxkBAAIIN2L95wg8fCQfRiwx52MXG8hkN2QDAAJkuzEbQx3xS2JXBdClg9dEAQADAgADcwADKQQ'),
(24, 'Jarkop', 1, 160000, 'AgACAgIAAxkBAAIIgGL96HbHDrud_oazWHHRgx4941_NAAJpuzEbQx3xS3pUII0P7wvNAQADAgADcwADKQQ'),
(28, 'Absolut 1 L', 5, 60000, 'AgACAgIAAxkBAAIJ_mL-FSZBUncjUMxFBPX-pMrAGJXnAALWxzEbyALxSycAAXs8sQlw-AEAAwIAA3MAAykE'),
(31, 'Kola 1.5 L', 4, 15000, 'AgACAgIAAxkBAAIK4mL-GiKm8MN397MgAAHkq50SDaBzCgAC0ccxG8gC8UvRsLCJguJe4gEAAwIAA3MAAykE'),
(32, 'T - Bone Steak', 3, 75000, 'AgACAgIAAxkBAAILA2L-GtTyLfZ7MuXbbTTsavxC7fvaAALgxzEbyALxS-42WE4OP9uwAQADAgADcwADKQQ'),
(33, 'Mevali Assarti (Kichik)', 7, 100000, 'AgACAgIAAxkBAAILgWL-HPLXUb-JnQy5txyJSw3qoXrJAALsxzEbyALxS0ysTN1FDNTbAQADAgADcwADKQQ'),
(34, 'Baranina Kuskavoy', 8, 15000, 'AgACAgIAAxkBAAILmmL-HekqpNT1QO-AAAEZ3kKYbtFNvwAC88cxG8gC8UvOehDbfzNgRQEAAwIAA3MAAykE'),
(35, 'Turitski Non', 9, 4000, 'AgACAgIAAxkBAAILpWL-HjNzB78hAAE-ml9xSZ09niQ2eQAC9ccxG8gC8UtuSdy5eP94mgEAAwIAA3MAAykE'),
(36, 'Margareta Pitsa', 10, 55000, 'AgACAgIAAxkBAAILsGL-Hmgg2eJ6LMKsQg8yucBBDQZ1AALKxzEbyALxS_9c_Pq5HqGFAQADAgADcwADKQQ'),
(37, 'Shurva', 1, 18000, 'AgACAgIAAxkBAAINV2L-agiHhFL9pRXXwo1N5KLQVV46AAI0vzEbyAL5SyJUbryrxN89AQADAgADcwADKQQ'),
(38, 'Kurinni Lapsha', 1, 15000, 'AgACAgIAAxkBAAINYmL-amuNiHj6nWLRrHmiAX5j6-FOAAI5vzEbyAL5SxwL5Xa2uhlxAQADAgADcwADKQQ'),
(39, 'Lapsha Frikadilka', 1, 15000, 'AgACAgIAAxkBAAINbWL-aqOwJoV56KgsjmA6KCFmevvQAAI6vzEbyAL5S84ZNDZG8SfMAQADAgADcwADKQQ'),
(40, 'Solyanka', 1, 18000, 'AgACAgIAAxkBAAINeGL-ar3J68uobHjAXZUk74BREXVfAAI7vzEbyAL5S_BR6XVTNka4AQADAgADcwADKQQ'),
(41, 'Mastava', 1, 18000, 'AgACAgIAAxkBAAINiWL-aviZvLzWpVSzgTdDkNlO21TKAAI8vzEbyAL5SyYu7omW9QhbAQADAgADcwADKQQ'),
(42, 'Moshxurda', 1, 18000, 'AgACAgIAAxkBAAINlGL-a6RWacZEfHg6lQUroRDWN5RLAAI-vzEbyAL5S_qYKZOPMixqAQADAgADcwADKQQ'),
(43, 'Adana Kebab', 2, 35000, 'AgACAgIAAxkBAAINt2L-bF3qmSVKvtfclUZYLjDIYBMtAAJBvzEbyAL5Sy2Ajj9jeuNeAQADAgADcwADKQQ'),
(44, 'Urfa Kebab', 2, 35000, 'AgACAgIAAxkBAAINwmL-bJ8oHm6h0tsGinBwQ1qrjDuzAAJDvzEbyAL5S7wI8qtBNDRxAQADAgADcwADKQQ'),
(45, 'Tovuq Perzola', 2, 32000, 'AgACAgIAAxkBAAINzWL-bO0CUBn5uyXhyYREVPzS0p3FAAJJvzEbyAL5S5qKvetiEUXKAQADAgADcwADKQQ'),
(46, 'Kuskavoy Govyadina(Mol Gushti)', 8, 15000, 'AgACAgIAAxkBAAIN3mL-bUsad4hPzs_eRzvzNzkbM_uOAAJNvzEbyAL5SyUge_xFH5tIAQADAgADcwADKQQ'),
(47, '', 8, 15000, 'AgACAgIAAxkBAAIN6WL-bXjK0GliQLHp6aNE7t-pW_auAAJPvzEbyAL5S2ZfzzffMc_rAQADAgADcwADKQQ'),
(49, 'Kavkazki Shashlik', 8, 50000, 'AgACAgIAAxkBAAIOLWL-jexA8_3ZxkxaMobkXILIE99LAALYvzEbyAL5S6coWtQ7A_XuAQADAgADcwADKQQ'),
(50, 'Okorochka (Tovuqli)', 8, 15000, 'AgACAgIAAxkBAAIOOGL-jjnPIZ1JLNxVGvehVD65j38-AALbvzEbyAL5S-1SDEf9FGY7AQADAgADcwADKQQ'),
(51, 'Gijduvon (Qiyma)', 8, 15000, 'AgACAgIAAxkBAAIOQ2L-jmUeJ-E38QNEY7tmrhnJEHE-AAJPvzEbyAL5S2ZfzzffMc_rAQADAgADcwADKQQ'),
(52, 'Avganski Non', 9, 11000, 'AgACAgIAAxkBAAIOUmL-kAlA0BRTCCySV3bWCXgfcamNAALgvzEbyAL5S4dg51UQhGgMAQADAgADcwADKQQ'),
(53, 'Patir Non', 9, 4000, 'AgACAgIAAxkBAAIOXWL-kPdnaoYHz_mdqX1TttikiCYlAALkvzEbyAL5S1nsvxjqr8zsAQADAgADcwADKQQ'),
(54, 'Fanta 1.5 L', 4, 15000, 'AgACAgIAAxkBAAIOaGL-khDA3i9APAJv_1zYBZul4ISOAALrvzEbyAL5S6-5TWq30LkrAQADAgADcwADKQQ'),
(55, 'Sprite 1.5 L', 4, 15000, 'AgACAgIAAxkBAAIOc2L-ki7KW-jFiTP4XnAVCV33wlVsAALsvzEbyAL5S2ccWxE8JQmBAQADAgADcwADKQQ'),
(56, 'Flash', 4, 11000, 'AgACAgIAAxkBAAIOfmL-knuvRR22G-y2REkumqqUS0bHAALuvzEbyAL5S2o6WWIjerK8AQADAgADcwADKQQ'),
(57, 'Mesnoy (Gushtli) Pitsa', 10, 60000, 'AgACAgIAAxkBAAIOzmL_rS1Q8YOKjGDKbp7SlvBhrP0oAAIUvzEbZ1cBSGTUrH91WahjAQADAgADcwADKQQ'),
(58, 'Peperonni Pitsa', 10, 50000, 'AgACAgIAAxkBAAIO2WL_rXBj5rn-5-GDkt06H2lDpVaDAAIcvzEbZ1cBSKNjuO5ySHLgAQADAgADcwADKQQ'),
(59, 'Kombirovanni Pitsa', 10, 60000, 'AgACAgIAAxkBAAIO6GL_s4PuvrYrZyANYN2ipIApuqEsAAIwvzEbZ1cBSE2cJ17-wVcsAQADAgADcwADKQQ'),
(60, 'Vegetarianski Pitsa', 10, 50000, 'AgACAgIAAxkBAAIO82L_tfrmiQe6f0FwDy_Vy1p7BzzSAAJCvzEbZ1cBSEolQbheFjSDAQADAgADcwADKQQ'),
(61, 'Sezar Salati', 6, 25000, 'AgACAgIAAxkBAAIPBmL_uT-w_8eyH1xEnldIQY7bsRT5AAJKvzEbZ1cBSCwtdAvk9oACAQADAgADcwADKQQ'),
(62, 'Bodrosti Salati', 6, 25000, 'AgACAgIAAxkBAAIPEWL_w9olbVPdszg1HbJ660TCHXduAAKDvzEbZ1cBSBdkV_rCqrH7AQADAgADcwADKQQ'),
(63, 'Yevropa Salati', 6, 24000, 'AgACAgIAAxkBAAIPI2L_xA8MuXQwSiHSWZyW3TMcyHhiAAKFvzEbZ1cBSDKB-f3r9HNeAQADAgADcwADKQQ'),
(64, 'Grecheski Salati', 6, 23000, 'AgACAgIAAxkBAAIPLmL_xC2EDcfDF5IdpvBSzLtqOEoOAAKGvzEbZ1cBSF4Cl7jRINtuAQADAgADcwADKQQ'),
(65, 'Gribe Jarinni (Quziqorinli) Salati', 6, 23000, 'AgACAgIAAxkBAAIPUWL_xIOf_aOn8YmK7s9fyR_4TsllAAKIvzEbZ1cBSLMoEs-V3280AQADAgADcwADKQQ'),
(66, 'Mujskoe Kapriz Salati', 6, 24000, 'AgACAgIAAxkBAAIPXGL_xKATOc4f1Z6HU2G1amkoAoYAA4q_MRtnVwFIGlOSmsj-SngBAAMCAANzAAMpBA'),
(67, 'Myunxen Salati', 6, 24000, 'AgACAgIAAxkBAAIPZ2L_xMj2KwhFINWQqgfdnKg3g3_gAAKMvzEbZ1cBSFOQy9XtOB-MAQADAgADcwADKQQ'),
(68, 'Oxota Salati', 6, 24000, 'AgACAgIAAxkBAAIPcmL_xO1UupiLnV3ML5_bXTTQAaSQAAKNvzEbZ1cBSEb-8WL-k2odAQADAgADcwADKQQ'),
(69, 'Smak Salati', 6, 23000, 'AgACAgIAAxkBAAIPfWL_xRK7wQyTkBq2zdnclYNjvCSlAAKVvzEbZ1cBSBWA4T4Fz5C2AQADAgADcwADKQQ'),
(70, 'Vecho Salati', 6, 23000, 'AgACAgIAAxkBAAIPiGL_xjU4jVBybp0R-nZ7CucPWQdQAALfvzEbZ1cBSK610YLh8ZuLAQADAgADcwADKQQ'),
(71, 'Xe Telyatina Salati', 6, 24000, 'AgACAgIAAxkBAAIPk2L_xtaji3X3son9jQFDSbHw5hUoAALivzEbZ1cBSGhWN0sa0t_rAQADAgADcwADKQQ'),
(72, 'Yaponski Salati', 6, 24000, 'AgACAgIAAxkBAAIPnmL_xw9T8GBzMasepvXfaYQ5fUDCAALjvzEbZ1cBSHvzvyAxQisiAQADAgADcwADKQQ'),
(73, 'Podvodochka Salati', 6, 23000, 'AgACAgIAAxkBAAIPqWL_x8taLn2WGC-yKBYcw99QcHSgAALlvzEbZ1cBSLOmY-YGx4NwAQADAgADcwADKQQ'),
(74, 'Medalion Steak', 3, 70000, 'AgACAgIAAxkBAAIPwmMAAbwDiYptxkzA4cVOVuzVcJwKtQACBr8xG2dXCUhw7J8wj_zZ9wEAAwIAA3MAAykE'),
(75, 'Ribeye Steak', 3, 55000, 'AgACAgIAAxkBAAIPzWMAAbxu0lgPAq2FKIddBZy0SSpHgQACB78xG2dXCUiLXvYJQ7le8QEAAwIAA3MAAykE'),
(76, 'Baranina Steak', 3, 50000, 'AgACAgIAAxkBAAIP2GMAAbzEW1tH2VCMPoRi8y17gIp1bwACCb8xG2dXCUgRA4XALASXfwEAAwIAA3MAAykE'),
(77, 'Kurinni (Tovuqli) Steak', 3, 35000, 'AgACAgIAAxkBAAIP42MAAb0rFo3C2iSBS_x_ZvD7BtcSuQACC78xG2dXCUjJEW5XsRqFsAEAAwIAA3MAAykE'),
(78, 'Klassechiski Steak', 3, 55000, 'AgACAgIAAxkBAAIP9WMAAb1_0GTmD4FEbluGmWz-CrBYrQACDr8xG2dXCUhUSXHypMc0vAEAAwIAA3MAAykE'),
(79, 'Kurinni File s Gribami', 3, 24000, 'AgACAgIAAxkBAAIQDWMAAb4-H_AOUnVw7WtZj898rNaaXQACGb8xG2dXCUjul8ksBZjnIgEAAwIAA3MAAykE'),
(80, 'Kuritsa s Ovoshami', 3, 24000, 'AgACAgIAAxkBAAIQH2MAAb6jCnoTIBwWR9KWZSSzzqf2QQACGr8xG2dXCUiuEuf08mDzaAEAAwIAA3MAAykE'),
(81, 'Faxitos iz Kuritsi', 3, 22000, 'AgACAgIAAxkBAAIQKmMAAb8aVTpFDBm7K9iO7scLPB27zwACHL8xG2dXCUgQ8AZaxbPJEwEAAwIAA3MAAykE'),
(82, 'Kartofel Po Domashni Kuritsi i Gribi', 3, 24000, 'AgACAgIAAxkBAAIQQ2MAAcAvlYQe_GhwzHBoYrIY2iQ3ngACH78xG2dXCUgHDMydSAXPtAEAAwIAA3MAAykE'),
(83, 'Myaso Po Aziatski', 3, 40000, 'AgACAgIAAxkBAAIQY2MAAcJdyxn1fRka0j69aB_QIua3cgACTb8xG2dXCUiK-9WRGEI7igEAAwIAA3MAAykE'),
(84, 'Telyatina s Ovoshami s Teryaki sousom', 3, 42000, 'AgACAgIAAxkBAAIQbmMAAcLIbFXxp-TlKhXgZ25KMbaD1QACT78xG2dXCUiD9Ge_1fgCNwEAAwIAA3MAAykE'),
(85, 'Telyatina s Gribami v Slivochnom souse', 3, 39000, 'AgACAgIAAxkBAAIQeWMAAcNS5IM2qKZCXxkm1sw7jhIzLwACWb8xG2dXCUg3dxvKvU7LUAEAAwIAA3MAAykE'),
(86, 'Kortofel po Domashnemu', 3, 42000, 'AgACAgIAAxkBAAIQjmMAAcOoOXRFK5mvdCji8be4I9p2tAACW78xG2dXCUjR_eh6R2EU1gEAAwIAA3MAAykE'),
(87, 'Faxitos iz Govyadina', 3, 36000, 'AgACAgIAAxkBAAIQmWMAAcUFpIUMBrwcyMUidmZkyBvz3wACZ78xG2dXCUjhqeQORSqcBAEAAwIAA3MAAykE'),
(88, 'Oxotichni Sosiski', 3, 24000, 'AgACAgIAAxkBAAIQpGMAAcVlIeefOdarKK7DcjYhQfUU3QACaL8xG2dXCUgeBfOrVGB3zQEAAwIAA3MAAykE'),
(89, 'Kolbaski', 3, 24000, 'AgACAgIAAxkBAAIQr2MAAcWpeZSK-vUWTuGV7hp-gjVFvwACbb8xG2dXCUjbyEporT51LAEAAwIAA3MAAykE'),
(90, 'Nagetsi', 3, 30000, 'AgACAgIAAxkBAAIQumMAAcXoyZHJ_OvBD8c9ZJIhtZB8eAACb78xG2dXCUj6GuTWvekCgwEAAwIAA3MAAykE'),
(91, 'Baklajan Jarenni Salati', 6, 20000, 'AgACAgIAAxkBAAIQxWMAAcbgKvkYGFMXNU2jObEhGZ1A5gACcr8xG2dXCUhN-MjI00SkIwEAAwIAA3MAAykE'),
(92, 'Ostriy Salati', 6, 26000, 'AgACAgIAAxkBAAIQ0GMAAceO45vfnXHFnvoZNjnSZI1PxwACeb8xG2dXCUjCRbDMPFQvzwEAAwIAA3MAAykE'),
(93, 'Mimoza Salati', 6, 24000, 'AgACAgIAAxkBAAIQ-mMAAchtjF4xViHIbvZddUgkp_ATuAACfb8xG2dXCUhzmPjQfGXCywEAAwIAA3MAAykE'),
(94, 'Gnezdo Kukushki Salati', 6, 23000, 'AgACAgIAAxkBAAIRGGMAAclTgT2dmlGtbn3MGs_kS7b9sAACfr8xG2dXCUh96BPS-LEJawEAAwIAA3MAAykE'),
(95, 'Opera Salati', 6, 24000, 'AgACAgIAAxkBAAIRLWMAAcnRUd8XqiAwVy4XZBhphvj1ngACg78xG2dXCUiQZFmdQ07O4AEAAwIAA3MAAykE'),
(96, 'Sveji', 6, 10000, 'AgACAgIAAxkBAAIROmMAAcqOYeAbJ-mkaPrQY1NasI3P5gACkL8xG2dXCUiolsVX3X-DWQEAAwIAA3MAAykE'),
(97, 'Shakarop', 6, 7000, 'AgACAgIAAxkBAAIRRWMAAcq30WZrSRbBw5RJYCm0CX72_QACkr8xG2dXCUjr4TOQr7tk3AEAAwIAA3MAAykE');

-- --------------------------------------------------------

--
-- Структура таблицы `section`
--

CREATE TABLE `section` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `section`
--

INSERT INTO `section` (`id`, `name`) VALUES
(1, 'Milliy'),
(2, 'Turk'),
(3, 'Evropa'),
(4, 'Salqin ichimliklar'),
(5, 'Spirtli ichimliklar'),
(6, 'Salatlar'),
(7, 'Asartilar'),
(8, 'Shashliklar'),
(9, 'Non maxsulotlar'),
(10, 'Pitsalar');

-- --------------------------------------------------------

--
-- Структура таблицы `temp_product`
--

CREATE TABLE `temp_product` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `section_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `temp_product`
--

INSERT INTO `temp_product` (`id`, `chat_id`, `name`, `price`, `img`, `section_id`) VALUES
(69, 848511386, '', '', '', 10),
(170, 499270876, '', '', '', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `chat_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `page` varchar(255) NOT NULL,
  `product_id` int DEFAULT NULL,
  `data` text NOT NULL,
  `order_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `chat_id`, `name`, `page`, `product_id`, `data`, `order_id`) VALUES
(1, 848511386, 'Samandar', 'start', 57, '', '18'),
(3, 499270876, 'ツ乙ᑌᕼᖇᎥᗪᗪᎥᑎ⊂◉‿◉つ⍣ᎥᗷᖇᗩǤᎥᗰᗝᐯ⏤͟͟͞͞', 'statistika', 97, '', '19'),
(4, 1801978249, 'Avazbek', 'start', 33, '', ''),
(5, 1575776796, '꧁༒☬ 𝓩𝓾𝓱𝓻𝓲𝓭𝓭𝓲𝓷 𝓘𝓫𝓻𝓪𝓰𝓲𝓶𝓸𝓿 ☬༒꧂', 'start', 63, '', ''),
(6, 2105231006, 'Samandar', 'start', 55, '', ''),
(7, 5184074686, '𝙳𝚒𝚕𝚍𝚘𝚛𝚊', 'aorders', NULL, '', ''),
(8, 1408257581, '🅐🅩🅘🅩🅑🅔🅚 🅔🅢🅗🅑🅔🅚🅞🅥', 'start', 35, '', ''),
(9, 103602349, '.', 'sendingcount', 52, '', ''),
(10, 5383989551, 'Gulshoda', 'sendingcount', 73, '', ''),
(11, 1597414613, '꧁🅓︎🅘︎🅛︎🅜︎🅤︎🅡︎🅞︎🅓︎꧂', 'select', NULL, '', ''),
(12, 1696121785, 'Samandar', 'start', 10, 'Array', ''),
(13, 828056654, '➣꯭꯭🐼꙲꙰꙲꯭꯭ 𝐙𝐔𝐇𝐑𝐈𝐃𝐃𝐈𝐍 𝐈𝐁𝐑𝐀𝐆𝐈𝐌𝐎𝐕 🐊꙰꙲꯭➣', 'start', 18, 'Array', ''),
(14, 1744126878, 'Uc Service bot Admin', 'start', 28, 'Array', ''),
(15, 2079843692, 'Zuhriddin Ibragimov', 'start', 33, 'Array', ''),
(16, 5136446137, 'USA', 'start', NULL, '{\"update_id\":118852740,\"message\":{\"message_id\":5830,\"from\":{\"id\":5136446137,\"is_bot\":false,\"first_name\":\"USA\",\"language_code\":\"uz\"},\"chat\":{\"id\":5136446137,\"first_name\":\"USA\",\"type\":\"private\"},\"date\":1661151509,\"text\":\"/start\",\"entities\":[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]}}', ''),
(17, 1976644365, 'Joker', 'start', NULL, '{\"update_id\":118852838,\"message\":{\"message_id\":6683,\"from\":{\"id\":1976644365,\"is_bot\":false,\"first_name\":\"Joker\",\"language_code\":\"uz\"},\"chat\":{\"id\":1976644365,\"first_name\":\"Joker\",\"type\":\"private\"},\"date\":1661153927,\"text\":\"/start\",\"entities\":[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]}}', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `delivered`
--
ALTER TABLE `delivered`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_profuct`
--
ALTER TABLE `order_profuct`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `temp_product`
--
ALTER TABLE `temp_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `delivered`
--
ALTER TABLE `delivered`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `order_profuct`
--
ALTER TABLE `order_profuct`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT для таблицы `section`
--
ALTER TABLE `section`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `temp_product`
--
ALTER TABLE `temp_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
