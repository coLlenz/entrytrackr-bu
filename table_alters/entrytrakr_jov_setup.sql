-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2021 at 07:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `entrytrakr`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entry_allowed_temp`
--

CREATE TABLE `entry_allowed_temp` (
  `id` int(11) NOT NULL,
  `temp` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `entry_allowed_temp`
--

INSERT INTO `entry_allowed_temp` (`id`, `temp`) VALUES
(2, 37.5);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(11, '2020_12_07_072443_create_contacts_table', 1),
(12, '2020_12_07_072443_create_failed_jobs_table', 1),
(13, '2020_12_07_072443_create_password_resets_table', 1),
(14, '2020_12_07_072443_create_supports_table', 1),
(15, '2020_12_07_072443_create_templates_table', 1),
(16, '2020_12_07_072443_create_trakr_types_table', 1),
(17, '2020_12_07_072443_create_trakr_views_table', 1),
(18, '2020_12_07_072443_create_trakrs_table', 1),
(19, '2020_12_07_072443_create_users_table', 1),
(20, '2020_12_17_024434_add_safe_marked_date_to_trakr_table', 1),
(21, '2020_12_17_042142_update_date_marked_safe_to_nullable', 2),
(22, '2020_12_17_043044_add_safe_marked_date', 3),
(23, '2020_12_17_044733_update_safe_marked_to_string', 4),
(24, '2020_12_17_044913_add_safe_marked', 5),
(25, '2020_12_19_001107_update_trakr_table', 6),
(26, '2021_01_21_162239_add_timezone_column_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('freelance.durk@gmail.com', '$2y$10$OmlloIzYVV8jtOFtI6.XheWdsbkOND/3LViP94L/Q22GjlcImpjwe', '2021-01-03 12:36:08');

-- --------------------------------------------------------

--
-- Table structure for table `question_logs`
--

CREATE TABLE `question_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `visitor_type` int(5) NOT NULL,
  `visitor_name` varchar(100) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question_title` longtext NOT NULL,
  `temperature` float NOT NULL,
  `freetext` longtext NOT NULL,
  `answers` longtext NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-allowed , 1-denied',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_logs`
--

INSERT INTO `question_logs` (`id`, `user_id`, `visitor_id`, `visitor_type`, `visitor_name`, `question_id`, `question_title`, `temperature`, `freetext`, `answers`, `status`, `created_at`) VALUES
(40, 36, 583, 3, 'nicole amaba', 77, 'Sample Question from customer', 34, '[\"sampleeee\"]', '[\"B\"]', 0, '2021-01-21 08:01:24'),
(41, 36, 585, 3, 'Question Test test', 77, 'Sample Question from customer', 34, '[\"123asdasdasd\"]', '[\"A\"]', 0, '2021-01-21 08:25:21'),
(42, 36, 586, 2, 'Normal Dapt A B ang answer', 77, 'Sample Question from customer', 34, '[\"asdasdasd\"]', '[\"B\"]', 1, '2021-01-21 08:26:12'),
(43, 36, 586, 2, 'Normal Dapt A B ang answer', 77, 'Sample Question from customer', 34, '[\"asdasdasd\"]', '[\"B\"]', 1, '2021-01-21 08:26:18'),
(44, 36, 586, 2, 'Normal Dapt A B ang answer', 77, 'Sample Question from customer', 34, '[\"asdasdasd\"]', '[\"B\"]', 1, '2021-01-21 08:26:22'),
(45, 36, 586, 2, 'Normal Dapt A B ang answer', 77, 'Sample Question from customer', 34, '[\"asdasdasd\"]', '[\"B\"]', 1, '2021-01-21 08:26:45'),
(46, 36, 587, 3, 'long quiz vip', 77, 'Sample Question from customer', 34, '[null,\"test\",\"test\"]', '[]', 0, '2021-01-21 09:18:13'),
(47, 36, 588, 3, 'sampol sad', 77, 'Sample Question from customer', 34, '[null,\"sample\",\"sample\"]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\"]', 0, '2021-01-21 09:26:29'),
(48, 36, 589, 3, 'second test test', 77, 'Sample Question from customer', 34, '[null,\"yes na yes\",\"super yes\"]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\"]', 0, '2021-01-21 09:28:21'),
(49, 36, 590, 3, 'double answer amaba', 77, 'Sample Question from customer', 34, '[\"cebu city\",\"double answer\",\"double kill\"]', '[\"B\",\"A\",\"A\",\"B\",\"B\",\"A\",\"A\"]', 0, '2021-01-21 09:30:17'),
(50, 36, 591, 3, 'logged out', 77, 'Sample Question from customer', 34, '[null,\"asd\",\"asd\"]', '[\"A\",\"A\",\"A\",\"A\",\"A\",\"A\",\"A\"]', 1, '2021-01-21 16:12:31'),
(51, 36, 594, 3, 'nicole amaba', 77, 'Sample Question from customer', 34, '[null,null,null]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\"]', 0, '2021-01-21 16:17:06'),
(52, 36, 595, 3, 'My Test Amaba', 77, 'Sample Question from customer', 34, '[\"Cebu City\",\"sample\",\"sample\"]', '[\"B\",\"B\",\"A\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 1, '2021-01-21 18:42:32'),
(53, 36, 596, 3, 'Second Test same question', 77, 'Sample Question from customer', 34, '[\"Cebu City\",\"none\",\"none\"]', '[\"B\",\"A\",\"A\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 1, '2021-01-21 18:44:20'),
(54, 36, 598, 3, 'Some Test Durk', 77, 'Sample Question from customer', 34, '[null,\"no\",\"n\\/a\"]', '[\"B\"]', 0, '2021-01-22 07:46:09'),
(55, 36, 600, 3, 'asdasd asdasd', 77, 'Sample Question from customer', 34, '[null,null,null]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 0, '2021-01-22 09:35:26'),
(56, 36, 601, 1, 'QR Test amaba', 77, 'Sample Question from customer', 23, '[\"Cebu City\",\"test\",\"test\"]', '[\"B\",\"A\",\"A\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 0, '2021-01-22 09:37:04'),
(57, 36, 583, 3, 'nicole amaba', 77, 'Sample Question from customer', 34, '[null,\"323\",\"323\"]', '[\"A\",\"B\",\"B\",\"A\",\"A\",\"A\",\"B\",\"A\"]', 1, '2021-01-22 09:37:37'),
(58, 36, 602, 1, 'asdasdasd asdasd', 78, 'Custom Template', 34, '', '[\"A\",\"B\"]', 0, '2021-01-22 09:40:01'),
(59, 36, 603, 1, 'asdaxzczxc zxcz', 78, 'Custom Template', 34, '', '[\"B\",\"A\"]', 1, '2021-01-22 09:40:54'),
(60, 36, 604, 1, 'yunmnb bmnb', 78, 'Custom Template', 80, '', '[\"A\",\"B\"]', 1, '2021-01-22 09:41:28'),
(61, 36, 605, 1, 'asdasdmbnm xcvxvc', 78, 'Custom Template', 34, '[\"sample\",\"sample\",\"sample\"]', '[]', 0, '2021-01-22 09:42:27'),
(62, 36, 607, 1, 'QR Test vip', 78, 'Custom Template', 34, '[\"asasd\",\"asd\",\"asd\"]', '[]', 0, '2021-01-23 06:24:07'),
(63, 36, 607, 1, 'QR Test vip', 78, 'Custom Template', 34, '[\"asasd\",\"asd\",\"asd\"]', '[]', 0, '2021-01-23 06:24:19'),
(64, 36, 608, 1, 'Globe amaba', 78, 'Custom Template', 34, '[\"asd\",\"asd\",\"asd\"]', '[]', 0, '2021-01-23 06:36:47'),
(65, 36, 583, 1, 'nicole amaba', 78, 'Custom Template', 344, '[\"231\",\"123\",\"123\"]', '[]', 1, '2021-01-23 06:38:03'),
(66, 36, 609, 3, 'Staff staffdd', 80, 'COVID-19 Staff Declaration (VIC)', 34, '[null,null,null]', '[\"Australia\\/Brisbane\",\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\"]', 1, '2021-01-24 17:53:33'),
(67, 36, 609, 3, 'Staff staffdd', 80, 'COVID-19 Staff Declaration (VIC)', 34, '[null,null,null]', '[\"Australia\\/Brisbane\",\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\"]', 1, '2021-01-24 17:55:48'),
(68, 36, 609, 3, 'Staff staffdd', 80, 'COVID-19 Staff Declaration (VIC)', 34, '[null,null,null]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 0, '2021-01-24 17:57:40'),
(69, 36, 610, 3, 'asdasdasasdas Bulokasd', 80, 'COVID-19 Staff Declaration (VIC)', 34, '[null,null,null]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 0, '2021-01-24 18:08:03'),
(70, 36, 612, 3, 'sample2 sample2', 80, 'COVID-19 Staff Declaration (VIC)', 34, '[null,null,null]', '[\"B\",\"A\",\"B\",\"B\",\"B\",\"A\",\"A\",\"B\"]', 0, '2021-01-25 18:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_jobs`
--

CREATE TABLE `scheduled_jobs` (
  `job_id` int(11) NOT NULL,
  `job` varchar(20) NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0-failed,1-success',
  `user_id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scheduled_jobs`
--

INSERT INTO `scheduled_jobs` (`job_id`, `job`, `status`, `user_id`, `visitor_id`, `created_at`) VALUES
(1, 'signout:all', 1, 36, 611, '2021-01-25 19:34:45'),
(2, 'signout:all', 1, 36, 612, '2021-01-25 19:34:45'),
(3, 'signout:all', 1, 36, 611, '2021-01-25 19:56:17'),
(4, 'signout:all', 1, 36, 612, '2021-01-25 19:56:17');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(2556) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supports`
--

INSERT INTO `supports` (`id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Test', '<p>Test</p>', '2020-12-19 20:03:01', '2020-12-19 20:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_html` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_json` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `questions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_type` tinyint(1) NOT NULL COMMENT '0-questionnaire, 1-Notifications',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_copy`
--

CREATE TABLE `template_copy` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` longtext DEFAULT NULL,
  `content_html` longtext DEFAULT NULL,
  `content_json` longtext DEFAULT NULL,
  `questions` longtext DEFAULT NULL,
  `questions_to_flg` varchar(20) NOT NULL DEFAULT '[]',
  `template_type` int(11) NOT NULL COMMENT '0-questionnaire, 1-Notifications	',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-disabled,1-activated',
  `template_status` int(11) NOT NULL DEFAULT 0 COMMENT '1-deleted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `template_copy`
--

INSERT INTO `template_copy` (`id`, `user_id`, `title`, `description`, `content_html`, `content_json`, `questions`, `questions_to_flg`, `template_type`, `status`, `template_status`, `created_at`, `updated_at`) VALUES
(76, 36, 'Sample', '', '', '{\"ops\":[{\"insert\":{\"image\":\"data:image/png;base64,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\"}},{\"insert\":\"\\n\"}]}', NULL, '[]', 1, 0, 0, '2021-01-21 05:39:10', '2021-01-21 05:39:10');
INSERT INTO `template_copy` (`id`, `user_id`, `title`, `description`, `content_html`, `content_json`, `questions`, `questions_to_flg`, `template_type`, `status`, `template_status`, `created_at`, `updated_at`) VALUES
(77, 36, 'Sample Question from customer', 'Sample', '<div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Do you currently have any of the following symptoms: cough, sore throat, runny nose, chills or sweats, a loss or change in the sense of taste or smell, shortness of breath)?</h2>\r\n                        <div class=\"mb-4\" id=\" 8PEM1uVBPVP5m25 \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"ulSagpCTJh\" name=\"oOkx8So7zqVs1eZ\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"ulSagpCTJh\">Yes</label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"67iEB3wJTL\" name=\"oOkx8So7zqVs1eZ\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"67iEB3wJTL\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Are you feeling well?</h2>\r\n                        <div class=\"mb-4\" id=\" dksPIQs6AbvaFgi \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"l9VNGJDppr\" name=\"aWi5mgruclixDPN\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"l9VNGJDppr\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"u9HHGVioEw\" name=\"aWi5mgruclixDPN\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"u9HHGVioEw\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Have you worked at another location(s) in the last 14 days?</h2>\r\n                        <div class=\"mb-4\" id=\" IU4eh8DRhnoc2w9 \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"mv4Tta8dns\" name=\"sNIa0lvUDIVy6nH\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"mv4Tta8dns\">Yes</label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"sMsUJlvFZ4\" name=\"sNIa0lvUDIVy6nH\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"sMsUJlvFZ4\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A,B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you answered \'Yes\' to the previous question, please list the other location(s) where you worked, including the date(s) you worked:</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>In the last 14 days, have you been in contact with a confirmed case of COVID-19 (except in the course of your employment while wearing the appropriate level of PPE)?</h2>\r\n                        <div class=\"mb-4\" id=\" rH7OVq2xoxF3hTc \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"vTOElWkl5h\" name=\"cvKZbLWYEYkeZlw\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"vTOElWkl5h\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Ex9JQXdZm1\" name=\"cvKZbLWYEYkeZlw\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"Ex9JQXdZm1\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Are you currently required to self-isolate or self-quarantine?</h2>\r\n                        <div class=\"mb-4\" id=\" OJtAac5ZTAxxQTJ \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"X392fohwJF\" name=\"tOe9OnVbRMhBMNZ\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"X392fohwJF\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Lakgp0kIUc\" name=\"tOe9OnVbRMhBMNZ\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"Lakgp0kIUc\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Will you wear the appropriate Personal Protective Equipment (PPE) at all times?</h2>\r\n                        <div class=\"mb-4\" id=\" CvOKvPcQuG882es \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"WdsAq2ssHu\" name=\"oG34kGktP29VvFT\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"WdsAq2ssHu\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"W83nyDI3EY\" name=\"oG34kGktP29VvFT\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"W83nyDI3EY\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Will you perform hand hygiene at appropriate times?</h2>\r\n                        <div class=\"mb-4\" id=\" Pwc0fC1K3nQBr2v \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"0I397XgQlB\" name=\"UB3NPxdAnQkIU7G\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"0I397XgQlB\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"YDZWGFHZ9w\" name=\"UB3NPxdAnQkIU7G\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"YDZWGFHZ9w\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div>\r\n                    <div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you have ever been tested for COVID-19, what was the date of your last test?</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you have been previously tested for COVID-19, what was the result (i.e. Positive or Negative)?</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div>\r\n                    <div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Have you visited  a known COVID-19 hotspot?</h2>\r\n                        <div class=\"mb-4\" id=\" ook3JpD8YLYWRyp \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"JzLbcThKMK\" name=\"Lw8W8sA5M3u4fQR\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"JzLbcThKMK\">Yes</label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"rsqDJuNK6K\" name=\"Lw8W8sA5M3u4fQR\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"rsqDJuNK6K\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div>', NULL, '[{\"question\":\"Do you currently have any of the following symptoms: cough, sore throat, runny nose, chills or sweats, a loss or change in the sense of taste or smell, shortness of breath)?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Are you feeling well?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"Have you worked at another location(s) in the last 14 days?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A,B\",\"type\":\"basic\"},{\"question\":\"If you answered \'Yes\' to the previous question, please list the other location(s) where you worked, including the date(s) you worked:\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"In the last 14 days, have you been in contact with a confirmed case of COVID-19 (except in the course of your employment while wearing the appropriate level of PPE)?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Are you currently required to self-isolate or self-quarantine?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Will you wear the appropriate Personal Protective Equipment (PPE) at all times?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"Will you perform hand hygiene at appropriate times?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"If you have ever been tested for COVID-19, what was the date of your last test?\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"If you have been previously tested for COVID-19, what was the result (i.e. Positive or Negative)?\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"Have you visited  a known COVID-19 hotspot?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"}]', '[\"1\",\"2\",\"3\"]', 0, 0, 0, '2021-01-22 17:39:32', '2021-01-22 17:39:32'),
(78, 36, 'Custom Template', 'Sample', '<div class=\"target\"><div class=\"float-right\">\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\n            </div><h2>Text 1</h2>\n                        <div class=\"txtarea\">\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\n                        </div> <hr>\n                    </div><div class=\"target\"><div class=\"float-right\">\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\n            </div><h2>Text 2</h2>\n                        <div class=\"txtarea\">\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\n                        </div> <hr>\n                    </div><div class=\"target\"><div class=\"float-right\">\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\n            </div><h2>Text 3</h2>\n                        <div class=\"txtarea\">\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\n                        </div> <hr>\n                    </div>', NULL, '[{\"question\":\"Text 1\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"Text 2\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"Text 3\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"}]', '[\"1\"]', 0, 0, 0, '2021-01-25 01:51:23', '2021-01-25 01:51:23'),
(80, 36, 'COVID-19 Staff Declaration (VIC)', 'All staff must complete the following screening questions before the commencement of every shift.\r\n\r\nIf at the completion of this questionnaire you are denied entry, please contact your manager or shift supervisor then leave the facility.\r\n\r\nPenalties apply for providing false information. If you have any symptoms, however mild, you must get tested and isolate until your test results are known.', '<div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Do you currently have any of the following symptoms: cough, sore throat, runny nose, chills or sweats, a loss or change in the sense of taste or smell, shortness of breath)?</h2>\r\n                        <div class=\"mb-4\" id=\" hVgQh37ZFXf3QRK \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Ll8UNOHFCV\" name=\"fGzA0jc9KmQrkIz\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"Ll8UNOHFCV\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"e7YbJycvYs\" name=\"fGzA0jc9KmQrkIz\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"e7YbJycvYs\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Are you feeling well?</h2>\r\n                        <div class=\"mb-4\" id=\" 3IRsqV9fnIk1zZg \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"LtqmlshXZZ\" name=\"0R8gILjBtZN6NDT\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"LtqmlshXZZ\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"XJDFDoWQWY\" name=\"0R8gILjBtZN6NDT\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"XJDFDoWQWY\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Have you worked at another location(s) in the last 14 days?</h2>\r\n                        <div class=\"mb-4\" id=\" 8qZyb0iwpoa7jkV \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"ylbZou0M4b\" name=\"x1iFw1FVXuPWa2Q\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"ylbZou0M4b\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"kf9X17iepk\" name=\"x1iFw1FVXuPWa2Q\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"kf9X17iepk\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A,B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you answered \'Yes\' to the previous question, please list the other location(s) where you worked, including the date(s) you worked:</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>In the last 14 days, have you been in contact with a confirmed case of COVID-19 (except in the course of your employment while wearing the appropriate level of PPE)?</h2>\r\n                        <div class=\"mb-4\" id=\" tl65dilT7DEFa7o \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"iKhWO7jY3c\" name=\"jFXCYqfNEY2YTF9\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"iKhWO7jY3c\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"3ByqOgLigo\" name=\"jFXCYqfNEY2YTF9\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"3ByqOgLigo\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Are you currently required to self-isolate or self-quarantine?</h2>\r\n                        <div class=\"mb-4\" id=\" 5Mv7mPvlMFxMyao \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Givng5LpFb\" name=\"taVCAPKaIAntOXa\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"Givng5LpFb\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"mXjpxIKQox\" name=\"taVCAPKaIAntOXa\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"mXjpxIKQox\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Will you wear the appropriate Personal Protective Equipment (PPE) at all times?</h2>\r\n                        <div class=\"mb-4\" id=\" TcnrBHm6QqAov6q \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"8CbxKBGawe\" name=\"IHVGIGYeVGqJIZk\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"8CbxKBGawe\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"myI1bgQH8U\" name=\"IHVGIGYeVGqJIZk\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"myI1bgQH8U\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Will you perform hand hygiene at appropriate times?</h2>\r\n                        <div class=\"mb-4\" id=\" qhesXYac51JBbHk \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"u9ZKZVQiSj\" name=\"Hh9nBOqiw50UZ6I\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"u9ZKZVQiSj\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"sLMK5vfdKz\" name=\"Hh9nBOqiw50UZ6I\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"sLMK5vfdKz\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"A\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you have ever been tested for COVID-19, what was the date of your last test?</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>If you have been previously tested for COVID-19, what was the result (i.e. Positive or Negative)?</h2>\r\n                        <div class=\"txtarea\">\r\n                            <textarea name=\"freetext[]\" class=\"form-control\" row=\"100\"></textarea>\r\n                        </div> <hr>\r\n                    </div><div class=\"target\"><div class=\"float-right\">\r\n            <a class=\"editQue\"> <i class=\"fa fa-pencil mr-2\" aria-hidden=\"true\"></i> </a>\r\n            <a class=\"deleteQue\"> <i class=\"fa fa-trash\"></i> </a>\r\n            </div><h2>Have you visited a known COVID-19 hotspot?</h2>\r\n                        <div class=\"mb-4\" id=\" O4J9hAIcmH7eHag \">\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Y5b90ROZlS\" name=\"EmXnb3PvNUFPMpJ\" class=\"custom-control-input\" value=\"A\"> \r\n                                <label class=\"custom-control-label\" for=\"Y5b90ROZlS\"> Yes </label>\r\n                            </div>\r\n                            <div class=\"custom-control custom-radio\">\r\n                                <input type=\"radio\" id=\"Xum8SRLo0S\" name=\"EmXnb3PvNUFPMpJ\" class=\"custom-control-input\" value=\"B\"> \r\n                                <label class=\"custom-control-label\" for=\"Xum8SRLo0S\">No</label>\r\n                            </div>\r\n                            <br>\r\n                            <div class=\"form-group\">\r\n                                <label for=\"answer\"> Answer </label>\r\n                                <input name=\"answer\" class=\"form-control col-md-4\" value=\"B\" readonly=\"\">\r\n                            </div>\r\n                        </div>\r\n                        <hr>\r\n                    </div>', NULL, '[{\"question\":\"Do you currently have any of the following symptoms: cough, sore throat, runny nose, chills or sweats, a loss or change in the sense of taste or smell, shortness of breath)?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Are you feeling well?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"Have you worked at another location(s) in the last 14 days?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A,B\",\"type\":\"basic\"},{\"question\":\"If you answered \'Yes\' to the previous question, please list the other location(s) where you worked, including the date(s) you worked:\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"In the last 14 days, have you been in contact with a confirmed case of COVID-19 (except in the course of your employment while wearing the appropriate level of PPE)?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Are you currently required to self-isolate or self-quarantine?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"},{\"question\":\"Will you wear the appropriate Personal Protective Equipment (PPE) at all times?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"Will you perform hand hygiene at appropriate times?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"A\",\"type\":\"basic\"},{\"question\":\"If you have ever been tested for COVID-19, what was the date of your last test?\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"If you have been previously tested for COVID-19, what was the result (i.e. Positive or Negative)?\",\"answers\":{\"a\":\"\",\"b\":\"\"},\"correctAnswer\":\"\",\"type\":\"freetext\"},{\"question\":\"Have you visited a known COVID-19 hotspot?\",\"answers\":{\"a\":\"Yes\",\"b\":\"No\"},\"correctAnswer\":\"B\",\"type\":\"basic\"}]', '[\"3\"]', 0, 1, 0, '2021-01-25 01:52:39', '2021-01-25 01:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `trakrs`
--

CREATE TABLE `trakrs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trakr_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trakr_type_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `who` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_of_company` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assistance` tinyint(1) DEFAULT 0 COMMENT '0-no, 1-yes',
  `form` int(11) DEFAULT NULL,
  `answers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0-allowed, 1-denied',
  `safe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_marked_safe` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marked_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checked_in_status` tinyint(1) DEFAULT NULL COMMENT '0-signin, 1-signout',
  `check_in_date` timestamp NULL DEFAULT NULL,
  `check_out_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trakrs`
--

INSERT INTO `trakrs` (`id`, `firstName`, `lastName`, `trakr_id`, `phoneNumber`, `email`, `trakr_type_id`, `user_id`, `who`, `name_of_company`, `assistance`, `form`, `answers`, `status`, `safe`, `date_marked_safe`, `marked_by`, `checked_in_status`, `check_in_date`, `check_out_date`, `created_at`, `updated_at`) VALUES
(575, 'Matthew Derek', 'Amaba', 'Mdevs', '09959505511', NULL, '2', 36, NULL, NULL, 1, NULL, NULL, 0, 'safe', '2021-01-21 12:53:44', NULL, 1, '2021-01-21 04:47:31', '2021-01-25 18:17:46', '2021-01-21 04:47:31', '2021-01-25 18:17:46'),
(576, 'QR Test', 'Bulok', 'sadasd', '09233123', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, 'safe', '2021-01-21 13:10:20', NULL, 1, '2021-01-21 05:05:45', '2021-01-25 18:17:46', '2021-01-21 05:05:45', '2021-01-25 18:17:46'),
(578, 'Normal', 'amaba', 'asdasd', '09233123', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 05:44:04', '2021-01-21 07:57:27', '2021-01-21 05:44:04', '2021-01-21 07:57:27'),
(579, 'vip', 'Bulok', 'asdasd33', '09233123', NULL, '1', 36, 'asd', NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 05:46:04', '2021-01-21 07:57:37', '2021-01-21 05:46:04', '2021-01-21 07:57:37'),
(580, 'nicole', 'asdasd', '441231', 'asdad', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 05:47:21', '2021-01-21 07:57:39', '2021-01-21 05:47:21', '2021-01-21 07:57:39'),
(581, 'Globe', 'amabaaaaa', '332123', '09233123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 05:47:54', '2021-01-25 18:17:46', '2021-01-21 05:47:54', '2021-01-25 18:17:46'),
(582, 'nicoleeeeeee', 'amabaaaaa', '999999999', '9382312', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 06:27:26', '2021-01-25 18:17:46', '2021-01-21 06:27:26', '2021-01-25 18:17:46'),
(583, 'nicole', 'amaba', '22123', '09233123', NULL, '1', 36, '6756', NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-23 06:37:55', '2021-01-23 06:38:03', '2021-01-21 08:01:17', '2021-01-23 06:38:03'),
(584, 'Devs', 'Visitor', NULL, '09233123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 08:06:52', '2021-01-25 18:17:46', '2021-01-21 08:06:52', '2021-01-25 18:17:46'),
(585, 'Question Test', 'test', '3123', '11122', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 08:25:09', '2021-01-25 18:17:46', '2021-01-21 08:25:09', '2021-01-25 18:17:46'),
(586, 'Normal Dapt A', 'B ang answer', NULL, '000001331', NULL, '2', 36, NULL, 'asdas', 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-21 08:25:58', '2021-01-21 08:26:45', '2021-01-21 08:25:58', '2021-01-21 08:26:45'),
(587, 'long quiz', 'vip', '34343', '09999', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 09:17:36', '2021-01-25 18:17:46', '2021-01-21 09:17:36', '2021-01-25 18:17:46'),
(588, 'sampol', 'sad', NULL, '09233123333', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 09:23:18', '2021-01-25 18:17:46', '2021-01-21 09:23:18', '2021-01-25 18:17:46'),
(589, 'second test', 'test', '998877', '09888', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 09:27:55', '2021-01-25 18:17:46', '2021-01-21 09:27:55', '2021-01-25 18:17:46'),
(590, 'double answer', 'amaba', '09992', '09233123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 09:29:32', '2021-01-25 18:17:46', '2021-01-21 09:29:32', '2021-01-25 18:17:46'),
(591, 'logged', 'out', NULL, '23123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-21 16:12:03', '2021-01-21 16:12:31', '2021-01-21 16:12:03', '2021-01-21 16:12:31'),
(594, 'nicole', 'amaba', '65656', '00000100000000000', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 16:16:49', '2021-01-25 18:17:46', '2021-01-21 16:16:49', '2021-01-25 18:17:46'),
(595, 'My Test', 'Amaba', NULL, '8282828147', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-21 18:41:55', '2021-01-21 18:42:32', '2021-01-21 18:41:55', '2021-01-21 18:42:32'),
(596, 'Second Test', 'same question', NULL, '30931', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-21 18:43:33', '2021-01-21 18:44:20', '2021-01-21 18:43:33', '2021-01-21 18:44:20'),
(597, 'thirds', 'try', NULL, '312312', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-21 18:49:41', '2021-01-21 20:00:45', '2021-01-21 18:49:41', '2021-01-21 20:00:45'),
(598, 'Some Test', 'Durk', NULL, '0909022', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 06:38:23', '2021-01-25 18:17:46', '2021-01-22 06:38:23', '2021-01-25 18:17:46'),
(599, 'Normal', 'asdasdad', NULL, '09233123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 08:34:08', '2021-01-25 18:17:46', '2021-01-22 08:34:08', '2021-01-25 18:17:46'),
(600, 'asdasd', 'asdasd', '902930', '213123213', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 08:36:39', '2021-01-25 18:17:46', '2021-01-22 08:36:39', '2021-01-25 18:17:46'),
(601, 'QR Test', 'amaba', '2323', '00000133', NULL, '1', 36, 'ASDAS', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 09:36:10', '2021-01-25 18:17:46', '2021-01-22 09:36:10', '2021-01-25 18:17:46'),
(602, 'asdasdasd', 'asdasd', '3232', '232323', NULL, '1', 36, 'TEST', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 09:39:48', '2021-01-25 18:17:46', '2021-01-22 09:39:48', '2021-01-25 18:17:46'),
(603, 'asdaxzczxc', 'zxcz', NULL, '2787', NULL, '1', 36, 'sdasd', NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-22 09:40:43', '2021-01-22 09:40:54', '2021-01-22 09:40:43', '2021-01-22 09:40:54'),
(604, 'yunmnb', 'bmnb', NULL, '934514', NULL, '1', 36, 'sfsdf', NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-22 09:41:15', '2021-01-22 09:41:28', '2021-01-22 09:41:15', '2021-01-22 09:41:28'),
(605, 'asdasdmbnm', 'xcvxvc', '7676', '65656', NULL, '1', 36, 'asd', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-22 09:42:14', '2021-01-25 18:17:46', '2021-01-22 09:42:14', '2021-01-25 18:17:46'),
(606, 'vip', 'Bulok', '9969699', '34343433', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-23 06:15:27', '2021-01-25 18:17:46', '2021-01-23 05:15:59', '2021-01-25 18:17:46'),
(608, 'Globe', 'amaba', '1232', '09233123', NULL, '1', 36, 'asd', NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-23 06:36:42', '2021-01-25 18:17:46', '2021-01-23 06:36:42', '2021-01-25 18:17:46'),
(609, 'Staff', 'staffdd', NULL, '09233123', NULL, '3', 36, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, 1, '2021-01-24 17:52:58', '2021-01-24 17:55:48', '2021-01-24 17:52:58', '2021-01-24 17:55:48'),
(610, 'asdasdasasdas', 'Bulokasd', '676', '09233123', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-24 18:07:40', '2021-01-25 18:17:46', '2021-01-24 18:07:40', '2021-01-25 18:17:46'),
(611, 'SampleSchedule', 'durk', 'testin123', '090909', NULL, '1', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-25 18:21:33', '2021-01-25 19:56:17', '2021-01-25 18:21:33', '2021-01-25 19:56:17'),
(612, 'sample2', 'sample2', '545454', '00986545', NULL, '3', 36, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, '2021-01-25 18:23:55', '2021-01-25 19:56:17', '2021-01-25 18:23:55', '2021-01-25 19:56:17'),
(613, 'Testing', '123', '090909', '929100', NULL, '1', 36, 'Test', NULL, 0, NULL, NULL, 0, 'safe', '2021-01-26 12:57:33', NULL, 0, '2021-01-26 04:50:04', NULL, '2021-01-26 04:50:04', '2021-01-26 04:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `trakr_types`
--

CREATE TABLE `trakr_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trakr_types`
--

INSERT INTO `trakr_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Visitor', '2020-12-17 05:15:28', '2020-12-17 05:15:28'),
(2, 'Contractor', '2020-12-17 05:15:28', '2020-12-17 05:15:28'),
(3, 'Employee', '2020-12-17 05:16:14', '2020-12-17 05:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `trakr_views`
--

CREATE TABLE `trakr_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_account` tinyint(1) NOT NULL,
  `sub_account_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` int(11) DEFAULT NULL,
  `qr_path` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `profile_path` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `sub_account`, `sub_account_id`, `name`, `contactName`, `email`, `email_verified_at`, `password`, `is_admin`, `qr_path`, `profile_path`, `timezone`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '736129', 0, 0, 'Admin', 'Admin Devs', 'devs@gmail.com', '2020-12-16 20:16:29', '$2y$10$QfQWm9u/IEnzwQwA0LKN7uDrqHtBubLnG7bRd9HmvpcfFmik18q2y', 1, NULL, '', NULL, NULL, NULL, NULL, '2020-12-16 20:16:29', '2020-12-16 20:16:29'),
(36, '836e1046-c138-407c-978e-4f97f0e83e26', 0, 0, 'Devss', 'Demo', 'devsdemo@gmail.com', NULL, '$2y$10$6wN9kR8F18/aqkpJ0.sH/epBvym52DlKhLlEPT7xO1aRwTQ/TsB6S', 0, 'https://qrlogins.s3.ap-southeast-2.amazonaws.com/836e1046-c138-407c-978e-4f97f0e83e26_1609914060.png', 'https://qrlogins.s3.ap-southeast-2.amazonaws.com/profiles/fNQ2SGmC1h5cBdPQIWNQS7pQkixVLopTsHVoiopa.png', 'Australia/Brisbane', NULL, NULL, NULL, '2021-01-06 09:21:35', '2021-01-21 16:38:16'),
(51, '836e1046-c138-407c-978e-4f97f0e83e26', 1, 36, 'New', '', 'Timezone@gmail.com', NULL, '$2y$10$rUzLBtnNQ0GGhbMfSo3vmORpDBGNhE0/MrvLrB6.N57EsMgeiF/Gi', 0, 'https://qrlogins.s3.ap-southeast-2.amazonaws.com/836e1046-c138-407c-978e-4f97f0e83e26_1609914060.png', '', 'Australia/Brisbane', NULL, NULL, NULL, '2021-01-21 20:02:32', '2021-01-21 20:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_log`
--

CREATE TABLE `visitor_log` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0-signin, 1-signout',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor_log`
--

INSERT INTO `visitor_log` (`id`, `visitor_id`, `user_id`, `action`, `created_at`) VALUES
(22, 575, 36, 1, '2021-01-21 05:00:58'),
(23, 576, 36, 0, '2021-01-21 05:05:45'),
(24, 576, 36, 1, '2021-01-21 05:07:18'),
(25, 578, 36, 0, '2021-01-21 05:44:04'),
(26, 579, 36, 0, '2021-01-21 05:46:04'),
(27, 580, 36, 0, '2021-01-21 05:47:21'),
(28, 581, 36, 0, '2021-01-21 05:47:54'),
(29, 581, 36, 1, '2021-01-21 05:50:38'),
(30, 581, 36, 1, '2021-01-21 05:53:44'),
(31, 581, 36, 1, '2021-01-21 05:55:58'),
(32, 581, 36, 1, '2021-01-21 05:59:00'),
(33, 581, 36, 1, '2021-01-21 06:06:19'),
(34, 581, 36, 1, '2021-01-21 06:14:02'),
(35, 581, 36, 1, '2021-01-21 06:15:32'),
(36, 581, 36, 1, '2021-01-21 06:22:35'),
(37, 582, 36, 0, '2021-01-21 06:27:26'),
(38, 583, 36, 0, '2021-01-21 08:01:17'),
(39, 584, 36, 0, '2021-01-21 08:06:52'),
(40, 585, 36, 0, '2021-01-21 08:25:09'),
(41, 586, 36, 0, '2021-01-21 08:25:58'),
(42, 587, 36, 0, '2021-01-21 09:17:36'),
(43, 588, 36, 0, '2021-01-21 09:23:18'),
(44, 589, 36, 0, '2021-01-21 09:27:55'),
(45, 590, 36, 0, '2021-01-21 09:29:32'),
(46, 591, 36, 0, '2021-01-21 16:12:03'),
(47, 592, 36, 0, '2021-01-21 16:12:58'),
(48, 593, 36, 0, '2021-01-21 16:13:30'),
(49, 594, 36, 0, '2021-01-21 16:16:49'),
(50, 595, 36, 0, '2021-01-21 18:41:55'),
(51, 596, 36, 0, '2021-01-21 18:43:33'),
(52, 597, 36, 0, '2021-01-21 18:49:41'),
(53, 597, 36, 1, '2021-01-21 20:00:45'),
(54, 598, 36, 0, '2021-01-22 06:38:23'),
(55, 599, 36, 0, '2021-01-22 08:34:08'),
(56, 600, 36, 0, '2021-01-22 08:36:39'),
(57, 601, 36, 0, '2021-01-22 09:36:10'),
(58, 583, 36, 0, '2021-01-22 09:37:19'),
(59, 602, 36, 0, '2021-01-22 09:39:48'),
(60, 603, 36, 0, '2021-01-22 09:40:43'),
(61, 604, 36, 0, '2021-01-22 09:41:15'),
(62, 605, 36, 0, '2021-01-22 09:42:14'),
(63, 606, 36, 0, '2021-01-23 05:15:59'),
(64, 606, 36, 0, '2021-01-23 05:17:17'),
(65, 606, 36, 0, '2021-01-23 05:17:59'),
(66, 606, 36, 0, '2021-01-23 05:29:52'),
(67, 606, 36, 1, '2021-01-23 05:51:25'),
(68, 606, 36, 1, '2021-01-23 05:52:51'),
(69, 606, 36, 1, '2021-01-23 05:56:37'),
(70, 606, 36, 1, '2021-01-23 05:57:54'),
(71, 606, 36, 1, '2021-01-23 06:00:37'),
(72, 606, 36, 0, '2021-01-23 06:15:27'),
(73, 607, 36, 0, '2021-01-23 06:24:00'),
(74, 583, 36, 0, '2021-01-23 06:34:04'),
(75, 608, 36, 0, '2021-01-23 06:36:42'),
(76, 583, 36, 0, '2021-01-23 06:37:55'),
(77, 609, 36, 0, '2021-01-24 17:52:58'),
(78, 610, 36, 0, '2021-01-24 18:07:40'),
(79, 612, 36, 0, '2021-01-25 18:23:55'),
(80, 613, 36, 0, '2021-01-26 04:50:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entry_allowed_temp`
--
ALTER TABLE `entry_allowed_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `question_logs`
--
ALTER TABLE `question_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduled_jobs`
--
ALTER TABLE `scheduled_jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_copy`
--
ALTER TABLE `template_copy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trakrs`
--
ALTER TABLE `trakrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trakr_types`
--
ALTER TABLE `trakr_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trakr_views`
--
ALTER TABLE `trakr_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_log`
--
ALTER TABLE `visitor_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `entry_allowed_temp`
--
ALTER TABLE `entry_allowed_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `question_logs`
--
ALTER TABLE `question_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `scheduled_jobs`
--
ALTER TABLE `scheduled_jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `template_copy`
--
ALTER TABLE `template_copy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `trakrs`
--
ALTER TABLE `trakrs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=614;

--
-- AUTO_INCREMENT for table `trakr_types`
--
ALTER TABLE `trakr_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trakr_views`
--
ALTER TABLE `trakr_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `visitor_log`
--
ALTER TABLE `visitor_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
