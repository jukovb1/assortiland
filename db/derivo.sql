-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2014 at 07:13 AM
-- Server version: 5.5.25
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `derivo`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_statuses`
--

CREATE TABLE IF NOT EXISTS `all_statuses` (
  `status_id` smallint(2) NOT NULL,
  `status_var` varchar(50) NOT NULL,
  `status_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `all_statuses`
--

INSERT INTO `all_statuses` (`status_id`, `status_var`, `status_title`) VALUES
(0, 'hide', 'Контент скрыт'),
(1, 'show', 'Контент показан'),
(-1, 'del', 'Контент удалён'),
(2, 'fix', 'Новый контент');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `com_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `com_parent_id` mediumint(8) NOT NULL DEFAULT '0',
  `com_nesting` smallint(1) NOT NULL DEFAULT '0',
  `com_module` varchar(100) CHARACTER SET cp1251 NOT NULL,
  `com_target_id` mediumint(8) NOT NULL,
  `com_user_id` smallint(8) NOT NULL,
  `com_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_text` text CHARACTER SET cp1251 NOT NULL,
  `com_status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`com_id`, `com_parent_id`, `com_nesting`, `com_module`, `com_target_id`, `com_user_id`, `com_date`, `com_text`, `com_status`) VALUES
(1, 0, 0, 'product', 28, 2, '2014-02-17 08:46:47', 'dfghghfghfgh', 1),
(2, 0, 0, 'product', 44, 6, '2014-02-17 08:48:28', 'hello', -1),
(3, 0, 0, 'product', 44, 6, '2014-02-17 08:49:00', 'addffd fghfghgfhfgh gfhghfghghfgh', -1),
(4, 0, 0, 'product', 44, 6, '2014-02-17 08:58:27', 'Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п''ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. \n\nВона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп''ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.', 1),
(5, 0, 0, 'product', 44, 6, '2014-02-17 09:34:31', 'gfhfghfgh', -1),
(6, 0, 0, 'product', 44, 6, '2014-02-17 09:36:18', 'fghfghfghfgh', -1),
(7, 0, 0, 'product', 44, 6, '2014-02-17 09:42:05', 'fghfghfghfghfgh', -1),
(8, 0, 0, 'product', 44, 6, '2014-02-17 09:42:46', 'fghfghfgh', -1),
(9, 0, 0, 'product', 44, 6, '2014-02-17 09:43:33', 'fghfghfgh', -1),
(10, 0, 0, 'product', 44, 6, '2014-02-17 09:50:58', 'hfghfgh', 1),
(11, 0, 0, 'product', 47, 2, '2014-02-18 14:18:11', 'апрапрапр', 1),
(12, 0, 0, 'product', 47, 2, '2014-02-18 14:18:34', 'арапрапрапр', 1),
(13, 0, 0, 'product', 47, 2, '2014-02-18 14:19:35', 'прапрапрапр', 1),
(14, 0, 0, 'product', 47, 2, '2014-02-18 14:23:39', 'dfghfghfgh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `constants`
--

CREATE TABLE IF NOT EXISTS `constants` (
  `const_id` int(4) NOT NULL AUTO_INCREMENT,
  `const_alias` varchar(50) NOT NULL,
  `const_name` varchar(50) NOT NULL,
  `const_group` smallint(2) NOT NULL,
  `const_type` smallint(1) NOT NULL,
  `const_num_val` bigint(20) NOT NULL,
  `const_txt_val` text NOT NULL,
  `const_str_val` varchar(50) NOT NULL,
  `const_status` smallint(2) NOT NULL DEFAULT '1',
  `const_sort` smallint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`const_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `constants`
--

INSERT INTO `constants` (`const_id`, `const_alias`, `const_name`, `const_group`, `const_type`, `const_num_val`, `const_txt_val`, `const_str_val`, `const_status`, `const_sort`) VALUES
(1, 'site_name', 'const_name[site_name]', 2, 31, 0, '', 'const_str_val[site_name]', 1, 0),
(2, 'path_index', 'const_name[path_index]', 1, 21, 0, '/', '', 1, 0),
(3, 'site_description', 'const_name[site_description]', 2, 32, 0, '', 'const_str_val[site_description]', 1, 0),
(4, 'site_keywords', 'const_name[site_keywords]', 2, 32, 0, '', 'const_str_val[site_keywords]', 1, 0),
(5, 'main_page_offers_title', 'const_name[main_page_offers_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_title]', 1, 0),
(6, 'separator_6', 'const_name[separator_6]', 3, -1, 0, '', 'const_str_val[separator_6]', 1, 0),
(7, 'main_page_offers_partners_title', 'const_name[main_page_offers_partners_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_partners_title]', 1, 0),
(8, 'main_page_offers_partners_desc', 'const_name[main_page_offers_partners_desc]', 3, 33, 0, '', 'const_str_val[main_page_offers_partners_desc]', 1, 0),
(9, 'main_page_offers_partners_button_title', 'const_name[main_page_offers_partners_button_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_partners_button_tit', 1, 0),
(10, 'separator_10', 'const_name[separator_10]', 3, -1, 0, '', 'const_str_val[separator_10]', 1, 0),
(11, 'main_page_offers_sellers_title', 'const_name[main_page_offers_sellers_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_sellers_title]', 1, 0),
(12, 'main_page_offers_sellers_desc', 'const_name[main_page_offers_sellers_desc]', 3, 33, 0, '', 'const_str_val[main_page_offers_sellers_desc]', 1, 0),
(13, 'main_page_offers_sellers_button_title', 'const_name[main_page_offers_sellers_button_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_sellers_button_titl', 1, 0),
(14, 'separator_14', 'const_name[separator_14]', 3, -1, 0, '', 'const_str_val[separator_14]', 1, 0),
(15, 'main_page_offers_helpful_title', 'const_name[main_page_offers_helpful_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_helpful_title]', 1, 0),
(16, 'main_page_offers_helpful_text', 'const_name[main_page_offers_helpful_text]', 3, 33, 0, '', 'const_str_val[main_page_offers_helpful_text]', 1, 0),
(17, 'separator_17', 'const_name[separator_17]', 3, -1, 0, '', 'const_str_val[separator_17]', 1, 0),
(18, 'main_page_offers_sales_title', 'const_name[main_page_offers_sales_title]', 3, 31, 0, '', 'const_str_val[main_page_offers_sales_title]', 1, 0),
(19, 'main_page_offers_sales_desc', 'const_name[main_page_offers_sales_desc]', 3, 32, 0, '', 'const_str_val[main_page_offers_sales_desc]', 1, 0),
(20, 'catalog_seo_keywords', 'const_name[catalog_seo_keywords]', 4, 31, 0, '', 'const_str_val[catalog_seo_keywords]', 1, 0),
(21, 'catalog_seo_title', 'const_name[catalog_seo_title]', 4, 31, 0, '', 'const_str_val[catalog_seo_title]', 1, 0),
(22, 'catalog_seo_desc', 'const_name[catalog_seo_desc]', 4, 32, 0, '', 'const_str_val[catalog_seo_desc]', 1, 0),
(23, 'site_commerce_min', 'const_name[site_commerce_min]', 5, 1, 10, '', '', 1, 0),
(24, 'site_commerce_middle', 'const_name[site_commerce_middle]', 5, 1, 12, '', '', 1, 0),
(25, 'site_commerce_high', 'const_name[site_commerce_high]', 5, 1, 15, '', '', 1, 0),
(26, 'delivery_services', 'const_name[delivery_services]', 6, 22, 0, '', '', 1, 0),
(27, 'site_main_menu', 'const_name[site_main_menu]', 7, 32, 0, '', 'const_str_val[site_main_menu]', 1, 0),
(28, 'site_slides', 'const_name[site_slides]', 8, 32, 0, '', 'const_str_val[site_slides]', 1, 0),
(29, 'site_sliders', 'const_name[site_sliders]', 9, 32, 0, '', 'const_str_val[site_sliders]', 1, 0),
(30, 'separator_30', 'const_name[separator_30]', 2, -1, 0, '', 'const_str_val[separator_30]', 1, 0),
(31, 'footer_info_title', 'const_name[footer_info_title]', 2, 31, 0, '', 'const_str_val[footer_info_title]', 1, 0),
(32, 'footer_info_content', 'const_name[footer_info_content]', 2, 33, 0, '', 'const_str_val[footer_info_content]', 1, 0),
(33, 'separator_33', 'const_name[separator_33]', 2, -1, 0, '', 'const_str_val[separator_33]', 1, 0),
(34, 'email_support', 'const_name[email_support]', 2, 21, 0, 'support@assorty.com', '', 1, 0),
(35, 'email_support_reg', 'const_name[email_support_reg]', 2, 11, 0, '', 'const_str_val[email_support_reg]', 1, 0),
(36, 'email_support_join', 'const_name[email_support_join]', 2, 11, 0, '', 'const_str_val[email_support_join]', 1, 0),
(37, 'email_support_order_error', 'const_name[email_support_order_error]', 2, 11, 0, '', 'const_str_val[email_support_order_error]', 1, 0),
(38, 'site_commerce_bank_requisites', 'const_name[site_commerce_bank_requisites]', 5, 32, 0, '', 'const_str_val[site_commerce_bank_requisites]', 1, 0),
(39, 'site_quotes', 'const_name[site_quotes]', 10, 32, 0, '', 'const_str_val[site_quotes]', 1, 0),
(40, 'site_regions', 'const_name[site_regions]', 12, 32, 0, '', 'const_str_val[site_regions]', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `constants_groups`
--

CREATE TABLE IF NOT EXISTS `constants_groups` (
  `const_group_id` int(3) NOT NULL AUTO_INCREMENT,
  `const_group_alias` varchar(50) NOT NULL,
  `const_group_name` varchar(50) NOT NULL,
  PRIMARY KEY (`const_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `constants_groups`
--

INSERT INTO `constants_groups` (`const_group_id`, `const_group_alias`, `const_group_name`) VALUES
(1, 'system', 'const_group_name[system]'),
(2, 'global', 'const_group_name[global]'),
(3, 'page_main', 'const_group_name[page_main]'),
(4, 'page_catalog', 'const_group_name[page_catalog]'),
(5, 'global_commerce', 'const_group_name[global_commerce]'),
(6, 'global_delivery', 'const_group_name[global_delivery]'),
(7, 'global_main_menu', 'const_group_name[global_main_menu]'),
(8, 'global_slides', 'const_group_name[global_slides]'),
(9, 'global_sliders', 'const_group_name[global_sliders]'),
(10, 'global_quote_sliders', 'const_group_name[global_quote_sliders]'),
(11, 'global_reg_page_agreement', 'const_group_name[global_reg_page_agreement]'),
(12, 'global_regions', 'const_group_name[global_regions]');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `cont_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `cont_type` smallint(3) NOT NULL,
  `cont_group_id` smallint(3) NOT NULL,
  `cont_title` varchar(100) NOT NULL,
  `cont_desc` text NOT NULL,
  `cont_content` text NOT NULL,
  `cont_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cont_user_id` mediumint(9) NOT NULL DEFAULT '1',
  `cont_url` varchar(50) NOT NULL,
  `cont_status` smallint(2) NOT NULL,
  `cont_sort` smallint(2) NOT NULL,
  `cont_files` text NOT NULL,
  `cont_likes` mediumint(9) NOT NULL,
  `cont_views` mediumint(9) NOT NULL,
  `cont_seo_title` varchar(100) NOT NULL,
  `cont_seo_desc` text NOT NULL,
  `cont_seo_keys` varchar(255) NOT NULL,
  `cont_seo_canonical` varchar(100) NOT NULL,
  `cont_allow_comment` tinyint(1) NOT NULL,
  `cont_show_slider` tinyint(1) NOT NULL,
  `cont_menu_item` tinyint(1) NOT NULL,
  `cont_dop_field_1` smallint(3) NOT NULL,
  `cont_dop_field_2` varchar(255) NOT NULL,
  `cont_dop_field_3` text NOT NULL,
  PRIMARY KEY (`cont_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`cont_id`, `cont_type`, `cont_group_id`, `cont_title`, `cont_desc`, `cont_content`, `cont_date`, `cont_user_id`, `cont_url`, `cont_status`, `cont_sort`, `cont_files`, `cont_likes`, `cont_views`, `cont_seo_title`, `cont_seo_desc`, `cont_seo_keys`, `cont_seo_canonical`, `cont_allow_comment`, `cont_show_slider`, `cont_menu_item`, `cont_dop_field_1`, `cont_dop_field_2`, `cont_dop_field_3`) VALUES
(1, 1, 0, 'cont_title[1]', '', 'cont_content[1]', '2013-08-13 21:00:00', 0, 'main', 1, 0, '', 0, 0, 'cont_seo_title[1]', 'cont_seo_desc[1]', 'cont_seo_keys[1]', 'cont_seo_canonical[1]', 0, 1, 0, 0, '', ''),
(2, 1, 0, 'cont_title[2]', '', 'cont_content[2]', '2013-08-21 06:21:00', 1, 'faq', 1, 0, '', 0, 0, 'cont_seo_title[2]', 'cont_seo_desc[2]', 'cont_seo_keys[2]', 'cont_seo_canonical[2]', 0, 1, 0, 0, '', ''),
(3, 1, 0, 'cont_title[3]', '', 'cont_content[3]', '2013-09-11 00:37:00', 0, 'test', 1, 16, '', 0, 3, 'cont_seo_title[3]', 'cont_seo_desc[3]', 'cont_seo_keys[3]', 'cont_seo_canonical[3]', 0, 1, 1, 0, '', ''),
(4, 1, 0, 'cont_title[4]', '', 'cont_content[4]', '2013-09-11 12:37:00', 1, 'fsdfsd', -1, 0, '', 0, 0, 'cont_seo_title[4]', 'cont_seo_desc[4]', 'cont_seo_keys[4]', 'cont_seo_canonical[4]', 0, 0, 0, 0, '', ''),
(5, 3, 0, 'cont_title[5]', 'cont_desc[5]', 'cont_content[5]', '2013-09-11 13:29:00', 1, 'article_1', 1, 0, '', 0, 0, 'cont_seo_title[5]', 'cont_seo_desc[5]', 'cont_seo_keys[5]', 'cont_seo_canonical[5]', 1, 0, 0, 0, '', ''),
(6, 3, 0, 'cont_title[6]', 'cont_desc[6]', 'cont_content[6]', '2013-09-11 13:32:00', 1, '', 0, 0, '', 0, 0, 'cont_seo_title[6]', 'cont_seo_desc[6]', 'cont_seo_keys[6]', 'cont_seo_canonical[6]', 0, 0, 0, 0, '', ''),
(7, 1, 0, 'cont_title[7]', '', 'cont_content[7]', '2013-09-11 14:32:00', 1, 'ghvhjg', 0, 0, '', 0, 0, 'cont_seo_title[7]', 'cont_seo_desc[7]', 'cont_seo_keys[7]', 'cont_seo_canonical[7]', 0, 0, 0, 0, '', ''),
(8, 1, 0, 'cont_title[8]', '', 'cont_content[8]', '2013-11-11 14:31:00', 1, 'about', 1, 0, '', 0, 0, 'cont_seo_title[8]', 'cont_seo_desc[8]', 'cont_seo_keys[8]', 'cont_seo_canonical[8]', 0, 0, 0, 0, '', ''),
(9, 1, 0, 'cont_title[9]', '', 'cont_content[9]', '2013-12-11 14:08:00', 0, 'sellers-info-page', 1, 0, '', 0, 0, 'cont_seo_title[9]', 'cont_seo_desc[9]', 'cont_seo_keys[9]', 'cont_seo_canonical[9]', 0, 1, 0, 0, '', ''),
(10, 1, 0, 'cont_title[10]', '', 'cont_content[10]', '2013-12-11 14:14:00', 0, 'partners-info-page', 0, 0, '', 0, 0, 'cont_seo_title[10]', 'cont_seo_desc[10]', 'cont_seo_keys[10]', 'cont_seo_canonical[10]', 0, 0, 0, 0, '', ''),
(11, 2, 0, 'cont_title[11]', 'cont_desc[11]', '', '2014-01-23 10:58:00', 1, '', 1, 0, 'dfgdgfdfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(12, 2, 0, 'cont_title[12]', 'cont_desc[12]', '', '2014-01-23 11:01:00', 1, '', 1, 0, 'dfgdfgdfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(13, 2, 0, 'cont_title[13]', 'cont_desc[13]', '', '2014-01-23 11:01:00', 1, '', 1, 0, 'dfgdfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(14, 2, 0, 'cont_title[14]', 'cont_desc[14]', '', '2014-01-23 11:02:00', 1, '', 1, 0, 'dgdfgdfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(15, 2, 0, 'cont_title[15]', 'cont_desc[15]', '', '2014-01-23 11:03:00', 1, '', 1, 0, 'dgdfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(16, 2, 0, 'cont_title[16]', 'cont_desc[16]', '', '2014-01-23 11:03:00', 1, '', 1, 0, 'ddfgdfg', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(17, 2, 0, 'cont_title[17]', 'cont_desc[17]', '', '2014-01-23 11:03:00', 1, '', 1, 0, 'gfhfgfghgfh', 0, 0, '', '', '', '', 0, 0, 0, 0, '', ''),
(18, 2, 0, 'cont_title[18]', 'cont_desc[18]', '', '2014-01-23 11:04:00', 1, '', 1, 0, 'gffgh', 0, 0, '', '', '', '', 0, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `content_groups`
--

CREATE TABLE IF NOT EXISTS `content_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_type_id` smallint(3) NOT NULL,
  `group_title` varchar(50) NOT NULL,
  `group_desc` text NOT NULL,
  `group_status` smallint(2) NOT NULL,
  `group_files` text NOT NULL,
  `group_url` varchar(50) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_groups_data`
--

CREATE TABLE IF NOT EXISTS `content_groups_data` (
  `group_id` int(11) NOT NULL,
  `content_id` mediumint(9) NOT NULL,
  `group_data_title` varchar(50) NOT NULL,
  `group_data_sort` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `content_types`
--

CREATE TABLE IF NOT EXISTS `content_types` (
  `type_id` smallint(3) NOT NULL AUTO_INCREMENT,
  `type_alias` varchar(50) NOT NULL,
  `type_title` varchar(50) NOT NULL,
  `type_main_field` text NOT NULL,
  `type_field_for_table` text NOT NULL,
  `type_field_names` text NOT NULL,
  `type_status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `content_types`
--

INSERT INTO `content_types` (`type_id`, `type_alias`, `type_title`, `type_main_field`, `type_field_for_table`, `type_field_names`, `type_status`) VALUES
(1, 'pages', 'type_title[pages]', '*cont_title,cont_content^,cont_date,cont_user_id,*cont_url,cont_views,cont_seo_title,cont_seo_desc,cont_seo_keys,cont_seo_canonical,cont_show_slider', 'cont_title,cont_user_id,cont_date', 'cont_title=type_field_names[pages][cont_title],cont_url=type_field_names[pages][cont_url],cont_content=type_field_names[pages][cont_content],cont_user_id=type_field_names[pages][cont_user_id],cont_date=type_field_names[pages][cont_date],cont_views=type_field_names[pages][cont_views],cont_seo_title=type_field_names[pages][cont_seo_title],cont_seo_desc=type_field_names[pages][cont_seo_desc],cont_seo_keys=type_field_names[pages][cont_seo_keys],cont_seo_canonical=type_field_names[pages][cont_seo_canonical],cont_show_slider=type_field_names[pages][cont_show_slider]', 1),
(2, 'clients', 'type_title[clients]', '*cont_title,cont_desc^,cont_date,cont_url,cont_status,cont_sort,*cont_files,cont_views', 'cont_title,cont_date', 'cont_title=type_field_names[clients][cont_title],cont_desc=type_field_names[clients][cont_desc],cont_date=type_field_names[clients][cont_date],cont_url=type_field_names[clients][cont_url],cont_status=type_field_names[clients][cont_status],cont_sort=type_field_names[clients][cont_sort],cont_files=type_field_names[clients][cont_files],cont_views=type_field_names[clients][cont_views]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE IF NOT EXISTS `langs` (
  `lang_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `lang_abbr` varchar(3) NOT NULL,
  `lang_name` varchar(30) NOT NULL,
  `lang_status` smallint(1) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`lang_id`, `lang_abbr`, `lang_name`, `lang_status`) VALUES
(1, 'ru', 'Русский', 1),
(2, 'en', 'English', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lang_texts`
--

CREATE TABLE IF NOT EXISTS `lang_texts` (
  `text_id` bigint(9) NOT NULL AUTO_INCREMENT,
  `text_lang_id` smallint(2) NOT NULL,
  `text_index` varchar(50) NOT NULL,
  `text_content` text NOT NULL,
  `text_for_search` tinyint(1) NOT NULL,
  PRIMARY KEY (`text_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=671 ;

--
-- Dumping data for table `lang_texts`
--

INSERT INTO `lang_texts` (`text_id`, `text_lang_id`, `text_index`, `text_content`, `text_for_search`) VALUES
(1, 1, 'type_title[pages]', 'Страницы', 0),
(2, 1, 'type_field_names[pages][cont_title]', 'Название', 0),
(3, 1, 'type_field_names[pages][cont_content]', 'Контент', 0),
(4, 1, 'type_field_names[pages][cont_date]', 'Дата', 0),
(5, 1, 'type_field_names[pages][cont_user_id]', 'Автор', 0),
(6, 1, 'const_group_name[system]', 'Системные параметры', 0),
(7, 2, 'const_group_name[system]', 'System', 0),
(8, 1, 'const_group_name[global]', 'Глобальные параметры', 0),
(9, 2, 'const_group_name[global]', 'Global', 0),
(10, 1, 'const_group_name[users]', 'Пользователи', 0),
(11, 2, 'const_group_name[users]', 'Users', 0),
(12, 1, 'const_name[site_name]', 'Название сайта', 0),
(13, 2, 'const_name[site_name]', 'Site name', 0),
(14, 1, 'const_str_val[site_name]', 'Ассорти', 0),
(15, 2, 'const_str_val[site_name]', 'AssortiLand', 0),
(16, 1, 'const_name[path_index]', 'Рабочая папка сайта', 0),
(17, 2, 'const_name[path_index]', 'Working directory site', 0),
(18, 1, 'const_name[site_description]', 'Описание сайта', 0),
(19, 2, 'const_name[site_description]', 'Site description', 0),
(20, 1, 'const_str_val[site_description]', 'Русское описание', 0),
(21, 2, 'const_str_val[site_description]', 'English desc', 0),
(22, 1, 'const_name[site_keywords]', 'Ключевые слова', 0),
(23, 2, 'const_name[site_keywords]', 'Site keywords', 0),
(24, 1, 'const_str_val[site_keywords]', 'Русские слова', 0),
(25, 2, 'const_str_val[site_keywords]', 'English keys', 0),
(26, 1, 'const_name[user_qwer]', 'Польз тест', 0),
(27, 2, 'const_name[user_qwer]', 'Site keywords', 0),
(28, 1, 'const_str_val[separator_6]', 'Блок &quot;Партнерам&quot;', 0),
(29, 2, 'const_str_val[separator_6]', 'Block &quot;Partners&quot;', 0),
(30, 1, 'const_str_val[separator_7]', 'Разделитель 2', 0),
(31, 2, 'const_str_val[separator_7]', 'separator 2', 0),
(32, 1, 'const_name[user_num]', 'Польз номер', 0),
(33, 2, 'const_name[user_num]', 'Site keywords', 0),
(34, 1, 'type_field_names[pages][cont_url]', 'URL', 0),
(35, 1, 'type_field_names[pages][cont_sort]', 'Сортировка', 0),
(36, 1, 'type_field_names[pages][cont_views]', 'Посещения', 0),
(37, 1, 'type_field_names[pages][cont_seo_title]', 'Заголовок для СЕО', 0),
(38, 1, 'type_field_names[pages][cont_seo_desc]', 'Описание для СЕО', 0),
(39, 1, 'type_field_names[pages][cont_seo_keys]', 'Ключевые слова для СЕО', 0),
(40, 1, 'type_field_names[pages][cont_seo_canonical]', 'Canonical для СЕО', 0),
(41, 1, 'type_field_names[pages][cont_show_slider]', 'Показывать слайдер', 0),
(42, 1, 'type_field_names[pages][cont_menu_item]', 'Входит в меню', 0),
(43, 1, 'type_title[sliders]', 'Слайдеры', 0),
(44, 1, 'type_field_names[sliders][cont_group_id]', 'Группа', 0),
(45, 1, 'type_field_names[sliders][cont_title]', 'Название', 0),
(46, 1, 'type_field_names[sliders][cont_files]', 'Картинка', 0),
(47, 1, 'cont_title[1]', 'Главная страница', 1),
(48, 2, 'cont_title[1]', 'Main Page', 1),
(49, 1, 'cont_title[2]', 'Вопросы и ответы', 1),
(50, 2, 'cont_title[2]', 'FAQ', 1),
(51, 1, 'us_group_desc[1]', 'Суперадминистраторы могут всё', 0),
(52, 1, 'us_group_title[1]', 'Разработчики', 0),
(101, 1, 'cont_title[3]', 'Тестовая страница', 0),
(102, 2, 'cont_title[3]', 'test page', 0),
(103, 1, 'cont_content[3]', 'Т', 0),
(104, 2, 'cont_content[3]', 'test content', 0),
(105, 1, 'cont_seo_title[3]', 'Тест СЕО заголовка', 0),
(106, 2, 'cont_seo_title[3]', 'test SEO 1', 0),
(107, 1, 'cont_seo_desc[3]', 'Тест СЕО описания', 0),
(108, 2, 'cont_seo_desc[3]', 'test SEO 2', 0),
(109, 1, 'cont_seo_keys[3]', 'Тест СЕО слов', 0),
(110, 2, 'cont_seo_keys[3]', 'test SEO 3', 0),
(111, 1, 'cont_seo_canonical[3]', 'Тест СЕО каноникал', 0),
(112, 2, 'cont_seo_canonical[3]', 'test SEO 4', 0),
(113, 1, 'cont_content[1]', 'контент главной страницы', 0),
(114, 2, 'cont_content[1]', '', 0),
(115, 1, 'cont_seo_title[1]', '', 0),
(116, 2, 'cont_seo_title[1]', '', 0),
(117, 1, 'cont_seo_desc[1]', '', 0),
(118, 2, 'cont_seo_desc[1]', '', 0),
(119, 1, 'cont_seo_keys[1]', '', 0),
(120, 2, 'cont_seo_keys[1]', '', 0),
(121, 1, 'cont_seo_canonical[1]', '', 0),
(122, 2, 'cont_seo_canonical[1]', '', 0),
(123, 1, 'cont_title[4]', 'sdfdsf', 0),
(124, 2, 'cont_title[4]', 'adfs', 0),
(125, 1, 'cont_content[4]', 'sdfsd', 0),
(126, 2, 'cont_content[4]', '', 0),
(127, 1, 'cont_seo_title[4]', '', 0),
(128, 2, 'cont_seo_title[4]', '', 0),
(129, 1, 'cont_seo_desc[4]', '', 0),
(130, 2, 'cont_seo_desc[4]', '', 0),
(131, 1, 'cont_seo_keys[4]', '', 0),
(132, 2, 'cont_seo_keys[4]', '', 0),
(133, 1, 'cont_seo_canonical[4]', '', 0),
(134, 2, 'cont_seo_canonical[4]', '', 0),
(135, 1, 'type_title[articles]', 'Статьи', 0),
(136, 1, 'type_field_names[articles][cont_group_id]', 'Раздел', 0),
(137, 1, 'type_field_names[articles][cont_title]', 'Название', 0),
(138, 1, 'type_field_names[articles][cont_desc]', 'Краткий текст', 0),
(139, 1, 'type_field_names[articles][cont_content]', 'Полный текст', 0),
(140, 1, 'type_field_names[articles][cont_date]', 'Дата', 0),
(141, 1, 'type_field_names[articles][cont_user_id]', 'Добавил', 0),
(142, 1, 'type_field_names[articles][cont_url]', 'URL', 0),
(143, 1, 'type_field_names[articles][cont_status]', 'Статус', 0),
(144, 1, 'type_field_names[articles][cont_sort]', 'Сортировка', 0),
(145, 1, 'type_field_names[articles][cont_likes]', 'Лайки', 0),
(146, 1, 'type_field_names[articles][cont_views]', 'Просмотры', 0),
(147, 1, 'type_field_names[articles][cont_seo_title]', 'СЕО1', 0),
(148, 1, 'type_field_names[articles][cont_seo_desc]', 'Сео2', 0),
(149, 1, 'type_field_names[articles][cont_seo_keys]', 'сео3', 0),
(150, 1, 'type_field_names[articles][cont_seo_canonical]', 'сео 4', 0),
(151, 1, 'type_field_names[articles][cont_allow_comment]', 'Разрешить комментарии', 0),
(152, 1, 'cont_title[5]', 'Статья 1', 0),
(153, 2, 'cont_title[5]', 'qwer', 0),
(154, 1, 'cont_desc[5]', 'Краткий текст статьи', 0),
(155, 2, 'cont_desc[5]', '', 0),
(156, 1, 'cont_content[5]', 'Полный текст', 0),
(157, 2, 'cont_content[5]', 'adasdas', 0),
(158, 1, 'cont_seo_title[5]', '', 0),
(159, 2, 'cont_seo_title[5]', '', 0),
(160, 1, 'cont_seo_desc[5]', '', 0),
(161, 2, 'cont_seo_desc[5]', '', 0),
(162, 1, 'cont_seo_keys[5]', '', 0),
(163, 2, 'cont_seo_keys[5]', '', 0),
(164, 1, 'cont_seo_canonical[5]', '', 0),
(165, 2, 'cont_seo_canonical[5]', '', 0),
(166, 1, 'cont_title[6]', 'Статья 2', 0),
(167, 1, 'cont_desc[6]', '', 0),
(168, 1, 'cont_content[6]', 'sdfsafsf', 0),
(169, 1, 'cont_seo_title[6]', '', 0),
(170, 1, 'cont_seo_desc[6]', '', 0),
(171, 1, 'cont_seo_keys[6]', '', 0),
(172, 1, 'cont_seo_canonical[6]', '', 0),
(173, 1, 'cont_title[7]', 'mnbjhb', 0),
(174, 1, 'cont_content[7]', '', 0),
(175, 1, 'cont_seo_title[7]', '', 0),
(176, 1, 'cont_seo_desc[7]', '', 0),
(177, 1, 'cont_seo_keys[7]', '', 0),
(178, 1, 'cont_seo_canonical[7]', '', 0),
(179, 1, 'type_title[news]', 'Новости', 0),
(180, 1, 'type_field_names[news][cont_title]', 'Название новости', 0),
(181, 1, 'type_field_names[news][cont_desc]', 'Крактий текст', 0),
(182, 1, 'type_field_names[news][cont_content]', 'Полный текст', 0),
(183, 1, 'type_field_names[news][cont_date]', 'Дата создания', 0),
(184, 1, 'type_field_names[news][cont_user_id]', 'Автор', 0),
(185, 1, 'type_field_names[news][cont_url]', 'URL', 0),
(186, 1, 'type_field_names[news][cont_sort]', 'Сортировка', 0),
(187, 1, 'type_field_names[news][cont_likes]', 'Лайки', 0),
(188, 1, 'type_field_names[news][cont_views]', 'Просмотры', 0),
(189, 1, 'type_field_names[news][cont_seo_title]', 'Заголовок для СЕО', 0),
(190, 1, 'type_field_names[news][cont_seo_desc]', 'Описание для СЕО', 0),
(191, 1, 'type_field_names[news][cont_seo_keys]', 'Ключевые слова для СЕО', 0),
(192, 1, 'type_field_names[news][cont_seo_canonical]', 'Canonical для СЕО', 0),
(193, 1, 'type_field_names[news][cont_allow_comment]', 'Разрешены комментарии', 0),
(194, 1, 'const_group_name[page_main]', 'Главная страница', 0),
(195, 2, 'const_group_name[page_main]', 'Main page', 0),
(196, 1, 'const_group_name[footer_contacts]', 'Контактные данные', 0),
(197, 2, 'const_group_name[footer_contacts]', 'Contact data', 0),
(198, 1, 'const_str_val[separator_9]', 'Наши предложения', 0),
(199, 2, 'const_str_val[separator_9]', 'Our offers', 0),
(200, 1, 'const_name[main_page_offers_title]', 'Заголовок блока предложений', 0),
(201, 2, 'const_name[main_page_offers_title]', 'Name of the title for &quot;Our offers&quot;', 0),
(202, 1, 'const_str_val[main_page_offers_title]', 'Наши предложения', 0),
(203, 2, 'const_str_val[main_page_offers_title]', 'Your title', 0),
(204, 1, 'const_str_val[separator_11]', 'Блок о &quot;Партнерах&quot;', 0),
(205, 2, 'const_str_val[separator_11]', 'Block about &quot;Partners&quot;', 0),
(206, 1, 'const_name[main_page_offers_partners_title]', 'Заголовок блока', 0),
(207, 2, 'const_name[main_page_offers_partners_title]', 'Name of the title', 0),
(208, 1, 'const_str_val[main_page_offers_partners_title]', 'Партнерам', 0),
(209, 2, 'const_str_val[main_page_offers_partners_title]', 'Partners', 0),
(210, 1, 'const_name[main_page_offers_partners_desc]', 'Контент блока', 0),
(211, 2, 'const_name[main_page_offers_partners_desc]', 'Content', 0),
(212, 1, 'const_str_val[main_page_offers_partners_desc]', 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.', 0),
(213, 2, 'const_str_val[main_page_offers_partners_desc]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.', 0),
(214, 1, 'const_name[main_page_offers_partners_button_title]', 'Надпись на кнопке', 0),
(215, 2, 'const_name[main_page_offers_partners_button_title]', 'Name of the button title for &quot;Partners&quot;', 0),
(216, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Ваше название', 0),
(217, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(218, 1, 'const_name[main_page_offers_partners_button_url]', 'Ссылка для кнопки блока &quot;Партнеров&quot;', 0),
(219, 2, 'const_name[main_page_offers_partners_button_url]', 'URL of the button title for &quot;Partners&quot;', 0),
(220, 1, 'const_str_val[main_page_offers_partners_button_url', 'Ваша ссылка', 0),
(221, 2, 'const_str_val[main_page_offers_partners_button_url', 'Your link', 0),
(222, 1, 'const_str_val[separator_16]', 'Блок о &quot;Продавцах&quot;', 0),
(223, 2, 'const_str_val[separator_16]', 'Block about &quot;Sellers&quot;', 0),
(224, 1, 'const_name[main_page_offers_sellers_title]', 'Заголовок блока', 0),
(225, 2, 'const_name[main_page_offers_sellers_title]', 'Name of the title', 0),
(226, 1, 'const_str_val[main_page_offers_sellers_title]', 'Продавцам', 0),
(227, 2, 'const_str_val[main_page_offers_sellers_title]', 'Sellers', 0),
(228, 1, 'const_name[main_page_offers_sellers_desc]', 'Контент блока', 0),
(229, 2, 'const_name[main_page_offers_sellers_desc]', 'Content', 0),
(230, 1, 'const_str_val[main_page_offers_sellers_desc]', 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.', 0),
(231, 2, 'const_str_val[main_page_offers_sellers_desc]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.', 0),
(232, 1, 'const_name[main_page_offers_sellers_button_title]', 'Надпись на кнопке', 0),
(233, 2, 'const_name[main_page_offers_sellers_button_title]', 'Name of the button title for &quot;Partners&quot;', 0),
(234, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Ваше название', 0),
(235, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(236, 1, 'const_name[main_page_offers_sellers_button_url]', 'Ссылка для кнопки блока &quot;Продавцов&quot;', 0),
(237, 2, 'const_name[main_page_offers_sellers_button_url]', 'URL of the button title for &quot;Sellers&quot;', 0),
(238, 1, 'const_str_val[main_page_offers_sellers_button_url]', 'Ваша ссылка', 0),
(239, 2, 'const_str_val[main_page_offers_sellers_button_url]', 'Your link', 0),
(240, 1, 'const_str_val[separator_21]', 'Блок о &quot;Помощи роста&quot;', 0),
(241, 2, 'const_str_val[separator_21]', 'Block about &quot;Help of groove&quot;', 0),
(242, 1, 'const_name[main_page_offers_helpful_title]', 'Заголовок', 0),
(243, 2, 'const_name[main_page_offers_helpful_title]', 'Title', 0),
(244, 1, 'const_str_val[main_page_offers_helpful_title]', 'Как мы можем помочь вашему бизнесу расти?', 0),
(245, 2, 'const_str_val[main_page_offers_helpful_title]', 'Your title', 0),
(246, 1, 'const_name[main_page_offers_helpful_s_desc]', 'Короткое описание &quot;Помощи&quot;', 0),
(247, 2, 'const_name[main_page_offers_helpful_s_desc]', 'Short description for &quot;Help&quot;', 0),
(248, 1, 'const_str_val[main_page_offers_helpful_s_desc]', 'Lorem Ipsum - это текст-\\"рыба\\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \\"рыбой\\" для текстов на латинице с начала XVI века.', 0),
(249, 2, 'const_str_val[main_page_offers_helpful_s_desc]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.', 0),
(250, 1, 'const_name[main_page_offers_helpful_l_desc]', 'Большое описание для &quot;Помощи&quot;', 0),
(251, 2, 'const_name[main_page_offers_helpful_l_desc]', 'Big description for &quot;Help&quot;', 0),
(252, 1, 'const_str_val[main_page_offers_helpful_l_desc]', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.', 0),
(253, 2, 'const_str_val[main_page_offers_helpful_l_desc]', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.', 0),
(254, 1, 'const_str_val[separator_25]', 'Блок &quot;Акционных предложений&quot;', 0),
(255, 2, 'const_str_val[separator_25]', 'Block of &quot;Action sales&quot;', 0),
(256, 1, 'const_name[main_page_offers_sales_title]', 'Заголовок', 0),
(257, 2, 'const_name[main_page_offers_sales_title]', 'Name of the title for &quot;Action sales&quot;', 0),
(258, 1, 'const_str_val[main_page_offers_sales_title]', 'Акционные предложения', 0),
(259, 2, 'const_str_val[main_page_offers_sales_title]', 'Action sales', 0),
(260, 1, 'const_name[main_page_offers_sales_desc]', 'Краткий текст', 0),
(261, 2, 'const_name[main_page_offers_sales_desc]', 'Short text', 0),
(262, 1, 'const_str_val[main_page_offers_sales_desc]', 'В данном блоке отображены последние из поступивших акционных предложений. Нажмите на кнопку ниже, чтобы просмотреть больше.', 0),
(263, 2, 'const_str_val[main_page_offers_sales_desc]', 'В данном блоке отображены последние из поступивших акционных предложений. Нажмите на кнопку ниже, чтобы просмотреть больше.', 0),
(264, 1, 'const_name[main_page_offers_sales_button_all_title', 'Название для кнопки &quot;Смотреть все предложения&quot;', 0),
(265, 2, 'const_name[main_page_offers_sales_button_all_title', 'Name of the button &quot;See all sales&quot;', 0),
(266, 1, 'const_str_val[main_page_offers_sales_button_all_ti', 'Смотреть все предложения', 0),
(267, 2, 'const_str_val[main_page_offers_sales_button_all_ti', 'See all sales', 0),
(268, 1, 'const_name[main_page_offers_sales_button_all_url]', 'Ссылка для кнопки блока &quot;Смотреть все предложения&quot;', 0),
(269, 2, 'const_name[main_page_offers_sales_button_all_url]', 'URL of the button title for &quot;See all sales&quot;', 0),
(270, 1, 'const_str_val[main_page_offers_sales_button_all_ur', 'Ваша ссылка', 0),
(271, 2, 'const_str_val[main_page_offers_sales_button_all_ur', 'Your link', 0),
(272, 1, 'const_name[main_page_offers_sales_button_actions_t', 'Название для кнопки &quot;Акции&quot;', 0),
(273, 2, 'const_name[main_page_offers_sales_button_actions_t', 'Name of the button &quot;Sales&quot;', 0),
(274, 1, 'const_str_val[main_page_offers_sales_button_action', 'Акции', 0),
(275, 2, 'const_str_val[main_page_offers_sales_button_action', 'Sales', 0),
(276, 1, 'const_name[main_page_offers_sales_button_actions_u', 'Ссылка для кнопки блока &quot;Акции&quot;', 0),
(277, 2, 'const_name[main_page_offers_sales_button_actions_u', 'URL of the button title for &quot;Sales&quot;', 0),
(278, 1, 'const_str_val[main_page_offers_sales_button_action', 'Ваша ссылка', 0),
(279, 2, 'const_str_val[main_page_offers_sales_button_action', 'Your link', 0),
(280, 1, 'const_name[main_page_offers_sales_button_new_title', 'Название для кнопки &quot;Новинки&quot;', 0),
(281, 2, 'const_name[main_page_offers_sales_button_new_title', 'Name of the button &quot;New&quot;', 0),
(282, 1, 'const_str_val[main_page_offers_sales_button_new_ti', 'Новинки', 0),
(283, 2, 'const_str_val[main_page_offers_sales_button_new_ti', 'New', 0),
(284, 1, 'const_name[main_page_offers_sales_button_new_url]', 'Ссылка для кнопки блока &quot;Новинки&quot;', 0),
(285, 2, 'const_name[main_page_offers_sales_button_new_url]', 'URL of the button title for &quot;New&quot;', 0),
(286, 1, 'const_str_val[main_page_offers_sales_button_new_ur', 'Ваша ссылка', 0),
(287, 2, 'const_str_val[main_page_offers_sales_button_new_ur', 'Your link', 0),
(288, 1, 'const_name[main_page_offers_sales_button_leader_ti', 'Название для кнопки &quot;Лидеры&quot;', 0),
(289, 2, 'const_name[main_page_offers_sales_button_leader_ti', 'Name of the button &quot;Leaders&quot;', 0),
(290, 1, 'const_str_val[main_page_offers_sales_button_leader', 'Лидеры', 0),
(291, 2, 'const_str_val[main_page_offers_sales_button_leader', 'Leaders', 0),
(292, 1, 'const_name[main_page_offers_sales_button_leader_ur', 'Ссылка для кнопки блока &quot;Лидеры&quot;', 0),
(293, 2, 'const_name[main_page_offers_sales_button_leader_ur', 'URL of the button title for &quot;Leaders&quot;', 0),
(294, 1, 'const_str_val[main_page_offers_sales_button_leader', 'Ваша ссылка', 0),
(295, 2, 'const_str_val[main_page_offers_sales_button_leader', 'Your link', 0),
(296, 1, 'const_str_val[separator_36]', 'Блок &quot;Наши партнеры и клиенты&quot;', 0),
(297, 2, 'const_str_val[separator_36]', 'Block of &quot;Our partners and clients&quot;', 0),
(298, 1, 'const_name[main_page_offers_clients_title]', 'Название для заголовка &quot;Наши партнеры и клиенты&quot;', 0),
(299, 2, 'const_name[main_page_offers_clients_title]', 'Name of the title for &quot;Our partners and clients&quot;', 0),
(300, 1, 'const_str_val[main_page_offers_clients_title]', 'Наши партнеры и клиенты', 0),
(301, 2, 'const_str_val[main_page_offers_clients_title]', 'Our partners and clients', 0),
(302, 1, 'const_str_val[separator_38]', 'Контактные данные', 0),
(303, 2, 'const_str_val[separator_38]', 'Contact data', 0),
(304, 1, 'const_name[footer_contact_title]', 'Заголовок', 0),
(305, 2, 'const_name[footer_contact_title]', 'Title', 0),
(306, 1, 'const_str_val[footer_contact_title]', 'Информация', 0),
(307, 2, 'const_str_val[footer_contact_title]', 'Information', 0),
(308, 1, 'const_name[footer_contact_telephone_title]', 'Название для заголовка &quot;Телефон&quot;', 0),
(309, 2, 'const_name[footer_contact_telephone_title]', 'Name of the title for &quot;Telephone&quot;', 0),
(310, 1, 'const_str_val[footer_contact_telephone_title]', 'Телефон:123-45-78<br>e-mail:support@assortiland.com', 0),
(311, 2, 'const_str_val[footer_contact_telephone_title]', 'Telephone:123-45-78<br>e-mail:support@assortiland.com', 0),
(312, 1, 'const_name[footer_contact_telephone_info]', 'Контактный номер для поля &quot;Телефон&quot;', 0),
(313, 2, 'const_name[footer_contact_telephone_info]', 'Contact number for block &quot;Telephone&quot;', 0),
(314, 1, 'const_str_val[footer_contact_telephone_info]', 'номер', 0),
(315, 2, 'const_str_val[footer_contact_telephone_info]', 'number', 0),
(316, 1, 'const_name[footer_contact_email_title]', 'Название для заголовка &quot;E-mail&quot;', 0),
(317, 2, 'const_name[footer_contact_email_title]', 'Name of the title for &quot;E-mail&quot;', 0),
(318, 1, 'const_str_val[footer_contact_email_title]', 'E-mail', 0),
(319, 2, 'const_str_val[footer_contact_email_title]', 'E-mail', 0),
(320, 1, 'const_name[footer_contact_email_info]', 'Контактные данные для поля &quot;E-mail&quot;', 0),
(321, 2, 'const_name[footer_contact_email_info]', 'Contact data for block &quot;E-mail&quot;', 0),
(322, 1, 'const_str_val[footer_contact_email_info]', 'support@assortiland.com', 0),
(323, 2, 'const_str_val[footer_contact_email_info]', 'support@assortiland.com', 0),
(324, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(325, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(326, 1, 'const_str_val[separator_10]', 'Блок &quot;Продавцам&quot;', 0),
(327, 2, 'const_str_val[separator_10]', 'Block &quot;Sellers&quot;', 0),
(328, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(329, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(330, 1, 'const_str_val[separator_14]', 'Блок &quot;Помощь роста&quot;', 0),
(331, 2, 'const_str_val[separator_14]', 'Block about &quot;Help of groove&quot;', 0),
(332, 1, 'const_name[main_page_offers_helpful_text]', 'Контент', 0),
(333, 2, 'const_name[main_page_offers_helpful_text]', 'Content', 0),
(334, 1, 'const_str_val[main_page_offers_helpful_text]', '<p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.</p>', 0),
(335, 2, 'const_str_val[main_page_offers_helpful_text]', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.', 0),
(336, 1, 'const_str_val[separator_17]', 'Блок &quot;Акционных предложений&quot;', 0),
(337, 2, 'const_str_val[separator_17]', 'Block of &quot;Action sales&quot;', 0),
(338, 1, 'const_str_val[separator_20]', 'Информация в футере', 0),
(339, 2, 'const_str_val[separator_20]', 'Info in footer', 0),
(340, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(341, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(342, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(343, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(344, 1, 'const_name[footer_info_title]', 'Заголовок', 0),
(345, 2, 'const_name[footer_info_title]', 'Title', 0),
(346, 1, 'const_str_val[footer_info_title]', 'Информация', 0),
(347, 2, 'const_str_val[footer_info_title]', 'Information', 0),
(348, 1, 'const_name[footer_info_content]', 'Контент', 0),
(349, 2, 'const_name[footer_info_content]', 'Content', 0),
(350, 1, 'const_str_val[footer_info_content]', 'Телефон:123-45-78<br>e-mail:support@assortiland.com', 0),
(351, 2, 'const_str_val[footer_info_content]', 'Telephone:123-45-78<br>e-mail:support@assortiland.com', 0),
(352, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(353, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(354, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(355, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(356, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(357, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(358, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(359, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(360, 1, 'cont_title[8]', 'О проекте', 0),
(361, 1, 'cont_content[8]', '\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p><span>Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из колледжа Hampden-Sydney, штат Вирджиния, взял одно из самых странных слов в Lorem Ipsum, \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"consectetur\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\", и занялся его поисками в классической латинской литературе. В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"de Finibus Bonorum et Malorum\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" (\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"О пределах добра и зла\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"), написанной Цицероном в 45 году н.э. Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum, \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Lorem ipsum dolor sit amet..\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\", происходит от одной из строк в разделе 1.10.32</span></p>\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>лассический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"de Finibus Bonorum et Malorum\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.</p><h2>Почему он используется?</h2>\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\\\\\\\\\r\\\\\\\\\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\n\\\\r\\\\n\\\\r\\\\n\\r\\n\\r\\n<p>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"lorem ipsum\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).</p>', 0),
(362, 1, 'cont_seo_title[8]', 'о нас', 0),
(363, 1, 'cont_seo_desc[8]', 'бла, бла, бла', 0),
(364, 1, 'cont_seo_keys[8]', 'о, нас', 0),
(365, 1, 'cont_seo_canonical[8]', '', 0),
(366, 1, 'cont_content[2]', '<h2>Откуда он появился?</h2>\\r\\n\\r\\n<p>Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из колледжа Hampden-Sydney, штат Вирджиния, взял одно из самых странных слов в Lorem Ipsum, \\"consectetur\\", и занялся его поисками в классической латинской литературе. В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги \\"de Finibus Bonorum et Malorum\\" (\\"О пределах добра и зла\\"), написанной Цицероном в 45 году н.э. Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum, \\"Lorem ipsum dolor sit amet..\\", происходит от одной из строк в разделе 1.10.32</p>\\r\\n\\r\\n<p>Классический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 \\"de Finibus Bonorum et Malorum\\" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.</p><h2>Почему он используется?</h2>\\r\\n\\r\\n<p>Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации \\"Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..\\" Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам \\"lorem ipsum\\" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).</p>', 0),
(367, 1, 'cont_seo_title[2]', '', 0),
(368, 1, 'cont_seo_desc[2]', '', 0),
(369, 1, 'cont_seo_keys[2]', '', 0),
(370, 1, 'cont_seo_canonical[2]', '', 0),
(371, 1, 'const_group_name[page_catalog]', 'Cтраница Каталога', 0),
(372, 2, 'const_group_name[page_catalog]', 'Catalog page', 0),
(373, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(374, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(375, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(376, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(377, 1, 'const_name[catalog_seo_keywords]', 'SEO ключевые слова', 0),
(378, 2, 'const_name[catalog_seo_keywords]', 'SEO keywords', 0),
(379, 1, 'const_str_val[catalog_seo_keywords]', 'каталог, каталог товаров, каталог продуктов', 0),
(380, 2, 'const_str_val[catalog_seo_keywords]', 'catalog, catalog of products, catalog of services', 0),
(381, 1, 'const_name[catalog_seo_title]', 'SEO заголовок', 0),
(382, 2, 'const_name[catalog_seo_title]', 'SEO title', 0),
(383, 1, 'const_str_val[catalog_seo_title]', 'Интернет-проект АссортиЛенд', 0),
(384, 2, 'const_str_val[catalog_seo_title]', 'Project Assortiland', 0),
(385, 1, 'const_name[catalog_seo_desc]', 'SEO описание', 0),
(386, 2, 'const_name[catalog_seo_desc]', 'SEO description', 0),
(387, 1, 'const_str_val[catalog_seo_desc]', 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.', 0),
(388, 2, 'const_str_val[catalog_seo_desc]', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.', 0),
(389, 1, 'const_str_val[separator_23]', 'Информация в футере', 0),
(390, 2, 'const_str_val[separator_23]', 'Info in footer', 0);
INSERT INTO `lang_texts` (`text_id`, `text_lang_id`, `text_index`, `text_content`, `text_for_search`) VALUES
(391, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(392, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(393, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(394, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(395, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(396, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(397, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(398, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(399, 2, 'us_group_title[1]', 'Developers', 0),
(400, 1, 'us_group_title[2]', 'Администраторы', 0),
(401, 2, 'us_group_title[2]', 'Admins', 0),
(402, 1, 'us_group_desc[2]', 'Администраторы имеют доступ к глобальным настройкам сайта, управлению пользователями и т.д.', 0),
(403, 1, 'us_group_title[3]', 'Пользователи', 0),
(404, 2, 'us_group_title[3]', 'Users', 0),
(405, 1, 'us_group_desc[3]', 'Обычные пользователи', 0),
(406, 1, 'us_group_title[4]', 'Продавцы', 0),
(407, 2, 'us_group_title[4]', 'Sellers', 0),
(408, 1, 'us_group_desc[4]', 'Могут добавлять товары', 0),
(409, 1, 'us_group_title[5]', 'Партнёры', 0),
(410, 2, 'us_group_title[5]', 'Partners', 0),
(411, 1, 'us_group_desc[5]', 'Могут распространять чужие товары', 0),
(412, 1, 'us_group_title[6]', 'Заблокированные', 0),
(413, 2, 'us_group_title[6]', 'Banned', 0),
(414, 1, 'us_group_desc[6]', 'Запрет на любые операции.', 0),
(415, 1, 'us_group_title[7]', 'Молчуны', 0),
(416, 2, 'us_group_title[7]', 'Silent', 0),
(417, 1, 'us_group_desc[7]', 'Запрет на комментарии.', 0),
(418, 1, 'us_group_title[8]', 'Ещё заблокированые', 0),
(419, 2, 'us_group_title[8]', 'Banned 2', 0),
(420, 1, 'us_group_desc[8]', 'Запрет на что-то.', 0),
(421, 1, 'us_group_title[9]', 'Финансовые менеджеры', 0),
(422, 2, 'us_group_title[9]', 'Finaces', 0),
(423, 1, 'us_group_desc[9]', 'Менеджеры, следящие за состоянием счетов и выплат. Имеют доступ в админку, только в управление счеами.', 0),
(424, 1, 'us_group_title[10]', 'Контент-менеджеры (по товарам)', 0),
(425, 2, 'us_group_title[10]', 'Contents manager (products)', 0),
(426, 1, 'us_group_desc[10]', 'Модераторы товаров. Имеют доступ в админку, только в управление товарами.', 0),
(427, 1, 'us_group_title[11]', 'Контент-менеджеры (прочее)', 0),
(428, 2, 'us_group_title[11]', 'Contents manager (others)', 0),
(429, 1, 'us_group_desc[11]', 'Модераторы следящие за порядком. Не имеют доступ в админку.', 0),
(430, 1, 'taxes_title[1]', 'Предприниматель', 0),
(431, 1, 'taxes_title[2]', 'Юридическое лицо', 0),
(432, 1, 'taxes_title[3]', 'Физическое лицо', 0),
(433, 1, 'taxes_title[4]', 'Предприниматель', 0),
(434, 1, 'taxes_title[5]', 'Юридическое лицо', 0),
(435, 1, 'type_field_names[pages][cont_seo_date]', 'Дата добавления', 0),
(436, 1, 'type_title[clients]', 'Клиенты', 0),
(437, 1, 'type_field_names[clients][cont_title]', 'Наименование', 0),
(438, 1, 'type_field_names[clients][cont_desc]', 'Информация', 0),
(439, 1, 'type_field_names[clients][cont_date]', 'Дата добавления', 0),
(440, 1, 'type_field_names[clients][cont_url]', 'Адрес сайта', 0),
(441, 1, 'type_field_names[clients][cont_status]', 'Статус', 0),
(442, 1, 'type_field_names[clients][cont_sort]', 'Сортировка в слайдере', 0),
(443, 1, 'type_field_names[clients][cont_files]', 'Логотип', 0),
(444, 1, 'type_field_names[clients][cont_views]', 'Просмотры', 0),
(445, 1, 'const_group_name[global_commerce]', 'Глобальные коммерческие параметры', 0),
(446, 2, 'const_group_name[global_commerce]', 'Global commerce', 0),
(447, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(448, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(449, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(450, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(451, 1, 'const_name[site_commerce_min]', 'Процент < 1000', 0),
(452, 2, 'const_name[site_commerce_min]', 'Percent < 1000', 0),
(453, 1, 'const_str_val[site_commerce_min]', '', 0),
(454, 2, 'const_str_val[site_commerce_min]', '', 0),
(455, 1, 'const_name[site_commerce_middle]', 'Процент >= 1000 и < 5000', 0),
(456, 2, 'const_name[site_commerce_middle]', 'Percent >= 1000 & < 5000', 0),
(457, 1, 'const_str_val[site_commerce_middle]', '', 0),
(458, 2, 'const_str_val[site_commerce_middle]', '', 0),
(459, 1, 'const_name[site_commerce_high]', 'Процент > 5000', 0),
(460, 2, 'const_name[site_commerce_high]', 'Percent > 5000', 0),
(461, 1, 'const_str_val[site_commerce_high]', '', 0),
(462, 2, 'const_str_val[site_commerce_high]', '', 0),
(463, 1, 'const_str_val[separator_26]', 'Информация в футере', 0),
(464, 2, 'const_str_val[separator_26]', 'Info in footer', 0),
(465, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(466, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(467, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(468, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(469, 1, 'const_group_name[global_delivery]', 'Доставка', 0),
(470, 2, 'const_group_name[global_delivery]', 'Delivery', 0),
(471, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(472, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(473, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(474, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(475, 1, 'const_name[delivery_services]', 'Способы доставки', 0),
(476, 2, 'const_name[delivery_services]', 'Delivery services', 0),
(477, 1, 'const_str_val[delivery_services]', 'Курьером по Одессе, Самовывоз в Одессе, Доставка по Украине, Доставка Новой Почтой', 0),
(478, 2, 'const_str_val[delivery_services]', 'Курьером по Одессе, Самовывоз в Одессе, Доставка по Украине, Доставка Новой Почтой', 0),
(479, 1, 'const_str_val[separator_27]', 'Информация в футере', 0),
(480, 2, 'const_str_val[separator_27]', 'Info in footer', 0),
(481, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(482, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(483, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(484, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(485, 1, 'cont_title[9]', 'Информация для продавцов', 0),
(486, 1, 'cont_content[9]', '<p><span>ПРАВИЛА ПРОДАЖИ ТОВАРОВ/УСЛУГ</span></p><h3><font style="background-color: rgb(255, 255, 255);" color="#f79646">РЕКОМЕНДАЦИИ </font></h3>\r\n\r\n<p> \r\n<br/></p>\r\n\r\n<p> НАШИ РЕГИСТРАЦИОННЫЕ ДОКУМЕНТЫ\r\n<br/>  АГЕНТСКИЙ ДОГОВОР\r\n<br/> 1. ОБЩИЕ ПОЛОЖЕНИЯ\r\n<br/> 2. ПРЕДМЕТ ДОГОВОРА</p>\r\n\r\n<p>Данный документ, согласно Гражданского Кодекса Украины является официальным предложением (далее – “Офертой”) Общества с ограниченной ответственностью “НетПоинт”, далее по тексту - Провайдер, заключить Договор о предоставлении услуг доступа в сеть передачи данных Провайдера с выходом в глобальную сеть “Интернет”, далее – “Договор”.</p>\r\n\r\n<p>В соответствии с ч.2 ст.642 Гражданского Кодекса Украины в случае принятия ниже указанных условий и подачи заявки об оказании услуг, юридические и физические лица этим засвидетельствуют свое желания заключить Договор. Изложенное действие и есть принятием предложения (акцепт), и с этого момента они обозначаются как “Абоненты”.</p>\r\n\r\n<p>В связи с вышеуказанным, просим внимательно ознакомиться с текстом данной Оферты, и если Вы не согласны с условиями этой Оферты или с отдельными из ее пунктов, Провайдер предлагает Вам отказаться от оказания услуг.</p>\r\n\r\n<p>Провайдер принимает на себя обязательства по предоставлению Абоненту услуг доступа в сеть передачи данных Провайдера (далее Сеть) с выходом в глобальную сеть “Интернет”.</p>\r\n\r\n<p>Регламент является официальным документом Провайдера, неотъемлемой частью настоящего Договора и устанавливается Провайдером одинаковым для всех Абонентов.</p>', 0),
(487, 1, 'cont_seo_title[9]', 'апрапрапрапр', 0),
(488, 1, 'cont_seo_desc[9]', 'ПРАВИЛА ПРОДАЖИ ТОВАРОВ/УСЛУГ\r\n\r\nРЕКОМЕНДАЦИИ\r\n\r\nНАШИ РЕГИСТРАЦИОННЫЕ ДОКУМЕНТЫ\r\n\r\nАГЕНТСКИЙ ДОГОВОР\r\n1. ОБЩИЕ ПОЛОЖЕНИЯ\r\n\r\nДанный документ, согласно Гражданского Кодекса Украины является официальным предложением (далее – “Офертой”) Общества с ограниченной ответственностью “НетПоинт”, далее по тексту - Провайдер, заключить Договор о предоставлении услуг доступа в сеть передачи данных Провайдера с выходом в глобальную сеть “Интернет”, далее – “Договор”.\r\n\r\nВ соответствии с ч.2 ст.642 Гражданского Кодекса Украины в случае принятия ниже указанных условий и подачи заявки об оказании услуг, юридические и физические лица этим засвидетельствуют свое желания заключить Договор. Изложенное действие и есть принятием предложения (акцепт), и с этого момента они обозначаются как “Абоненты”.\r\n\r\nВ связи с вышеуказанным, просим внимательно ознакомиться с текстом данной Оферты, и если Вы не согласны с условиями этой Оферты или с отдельными из ее пунктов, Провайдер предлагает Вам отказаться от оказания услуг.\r\n\r\n2. ПРЕДМЕТ ДОГОВОРА\r\n\r\nПровайдер принимает на себя обязательства по предоставлению Абоненту услуг доступа в сеть передачи данных Провайдера (далее Сеть) с выходом в глобальную сеть “Интернет”.\r\n\r\nРегламент является официальным документом Провайдера, неотъемлемой частью настоящего Договора и устанавливается Провайдером одинаковым для всех Абонентов.', 0),
(489, 1, 'cont_seo_keys[9]', 'впвап, авпввап', 0),
(490, 1, 'cont_seo_canonical[9]', '', 0),
(491, 1, 'cont_title[10]', 'Информация для партнеров', 0),
(492, 1, 'cont_content[10]', '<p><span>ПРАВИЛА</span></p>РЕКОМЕНДАЦИИ\r\n\r\n<div>\r\n<br/></div>\r\n\r\n<div>ПАРТНЕРСКАЯ ПРОГРАММА\r\n\r\n<p>Партнёрская программа позволит владельцам сайтов заработать, принимая платежи за мобильную связь, интернет, ТВ и т.п. Вам достаточно лишь добавить Виджет на свой сайт, либо реализовать программное взаимодействие&nbsp;<a>между вашим сайтом и нашим сервером</a>. Накопленное вознаграждение Вы будете получать на свой U-кошелек, при этом требования о минимальных оборотах за день/месяц - отсутствуют!</p><h3>В ЧЁМ ВЫГОДА?</h3>\r\n<ul>\r\n	<li>Вы предлагаете посетителям своего сайта дополнительные сервисы (оплата услуг операторов и провайдеров Украины).</li>\r\n	<li>Вы зарабатываете на оплате услуг (сколько именно, см.&nbsp;<a>Тарифы)</a>.</li>\r\n	<li>Вам не нужно заключать никакие договора.</li>\r\n</ul><h3>КАК ЗАРЕГИСТРИРОВАТЬСЯ?</h3>\r\n\r\n<p>Чтобы стать участником нашей партнерской программы, необходимо при первом добавлении сайта согласиться с&nbsp;<a>правилами</a>&nbsp;и указать кошелёк для получения вознаграждения.</p></div>', 0),
(493, 1, 'cont_seo_title[10]', 'впвапвап', 0),
(494, 1, 'cont_seo_desc[10]', 'ПРАВИЛА\r\nРЕКОМЕНДАЦИИ\r\nПАРТНЕРСКАЯ ПРОГРАММА\r\nПартнёрская программа позволит владельцам сайтов заработать, принимая платежи за мобильную связь, интернет, ТВ и т.п. Вам достаточно лишь добавить Виджет на свой сайт, либо реализовать программное взаимодействие между вашим сайтом и нашим сервером. Накопленное вознаграждение Вы будете получать на свой U-кошелек, при этом требования о минимальных оборотах за день/месяц - отсутствуют!\r\n\r\nВ ЧЁМ ВЫГОДА?\r\n\r\nВы предлагаете посетителям своего сайта дополнительные сервисы (оплата услуг операторов и провайдеров Украины).\r\nВы зарабатываете на оплате услуг (сколько именно, см. Тарифы).\r\nВам не нужно заключать никакие договора.\r\nКАК ЗАРЕГИСТРИРОВАТЬСЯ?\r\n\r\nЧтобы стать участником нашей партнерской программы, необходимо при первом добавлении сайта согласиться с правилами и указать кошелёк для получения вознаграждения.', 0),
(495, 1, 'cont_seo_keys[10]', 'апвпвап', 0),
(496, 1, 'cont_seo_canonical[10]', '', 0),
(497, 1, 'const_group_name[global_main_menu]', 'Главное меню', 0),
(498, 2, 'const_group_name[global_main_menu]', 'Main menu', 0),
(499, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(500, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(501, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(502, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(503, 1, 'const_name[main_menu_menus]', 'Главное меню', 0),
(504, 2, 'const_name[main_menu_menus]', 'Main menu', 0),
(505, 1, 'const_str_val[main_menu_menus]', 'Главная, http://httpdocs.assortiland|Профиль, http://httpdocs.assortiland/profile', 0),
(506, 2, 'const_str_val[main_menu_menus]', 'Main, http://httpdocs.assortiland|Profile, http://httpdocs.assortiland/profile', 0),
(507, 1, 'const_str_val[separator_28]', 'Информация в футере', 0),
(508, 2, 'const_str_val[separator_28]', 'Info in footer', 0),
(509, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(510, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(511, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(512, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(513, 1, 'const_name[site_main_menu]', 'Главное меню', 0),
(514, 2, 'const_name[site_main_menu]', 'Main menu', 0),
(515, 1, 'const_str_val[site_main_menu]', 'Главная|http://httpdocs.assortiland, Профиль|http://httpdocs.assortiland/profile', 0),
(516, 2, 'const_str_val[site_main_menu]', 'Main|http://httpdocs.assortiland, Profile|http://httpdocs.assortiland/profile', 0),
(517, 1, 'const_group_name[global_slider]', 'Слайдер', 0),
(518, 2, 'const_group_name[global_slider]', 'Slider', 0),
(519, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(520, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(521, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(522, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(523, 1, 'const_name[site_sliders]', 'Слайдеры', 0),
(524, 2, 'const_name[site_sliders]', 'Sliders', 0),
(525, 1, 'const_str_val[site_sliders]', '', 0),
(526, 2, 'const_str_val[site_sliders]', '', 0),
(527, 1, 'const_str_val[separator_29]', 'Информация в футере', 0),
(528, 2, 'const_str_val[separator_29]', 'Info in footer', 0),
(529, 1, 'const_str_val[separator_32]', 'Уведомления администратора', 0),
(530, 2, 'const_str_val[separator_32]', 'Notify the administrator', 0),
(531, 1, 'const_name[email_support]', 'E-mail для уведомлений', 0),
(532, 2, 'const_name[email_support]', 'E-mail notification', 0),
(533, 1, 'const_name[email_support_reg]', 'Регистрация нового пользователя', 0),
(534, 2, 'const_name[email_support_reg]', 'New user registration', 0),
(535, 1, 'const_name[email_support_join]', 'Заявки на вступление в спец. группу', 0),
(536, 2, 'const_name[email_support_join]', 'Requests to join special group', 0),
(537, 1, 'const_group_name[global_slides]', 'Слайды', 0),
(538, 2, 'const_group_name[global_slides]', 'Slides', 0),
(539, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(540, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(541, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(542, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(543, 1, 'const_name[site_slides]', 'Слайды', 0),
(544, 2, 'const_name[site_slides]', 'Slides', 0),
(545, 1, 'const_str_val[site_slides]', 'slide1|Название|Под название|Описание|Кнопка|http://httpdocs.assortiland|http://httpdocs.assortiland; slide2|Название|Под название|Описание|Кнопка|http://httpdocs.assortiland|http://httpdocs.assortiland', 0),
(546, 2, 'const_str_val[site_slides]', 'slide1|Name|Subname|Description|Button|http://httpdocs.assortiland|http://httpdocs.assortiland; slide2|Name|Subname|Description|Button|http://httpdocs.assortiland|http://httpdocs.assortiland', 0),
(547, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(548, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(549, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(550, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(551, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(552, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(553, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(554, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(555, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(556, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(557, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(558, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(559, 1, 'const_group_name[global_sliders]', 'Слайдеры', 0),
(560, 2, 'const_group_name[global_sliders]', 'Sliders', 0),
(561, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(562, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(563, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(564, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(565, 1, 'const_str_val[separator_30]', 'Информация в футере', 0),
(566, 2, 'const_str_val[separator_30]', 'Info in footer', 0),
(567, 1, 'const_str_val[separator_33]', 'Уведомления администратора', 0),
(568, 2, 'const_str_val[separator_33]', 'Notify the administrator', 0),
(569, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(570, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(571, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(572, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(573, 1, 'const_name[email_support_order_error]', 'Ошибки оформления заказа', 0),
(574, 2, 'const_name[email_support_order_error]', 'Ordering Errors', 0),
(575, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(576, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(577, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(578, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(579, 1, 'const_name[site_commerce_bank_requisites]', 'Реквизиты банка', 0),
(580, 2, 'const_name[site_commerce_bank_requisites]', 'Percent < 1000', 0),
(581, 1, 'const_str_val[site_commerce_bank_requisites]', 'Наименование: БАНК КРЕДИТНЫЙ \r\nПолучатель:11111 \r\nМФО:11111', 0),
(582, 2, 'const_str_val[site_commerce_bank_requisites]', 'Наименование: БАНК КРЕДИТНЫЙ \r\nПолучатель:11111 \r\nМФО:11111', 0),
(583, 2, 'cont_title[9]', 'Информация для продавцов', 0),
(584, 2, 'cont_content[9]', '<p><span>ПРАВИЛА ПРОДАЖИ ТОВАРОВ/УСЛУГ</span></p><h3><font style="background-color: rgb(255, 255, 255);" color="#f79646">РЕКОМЕНДАЦИИ </font></h3>\r\n\r\n<p> \r\n<br/></p>\r\n\r\n<p> НАШИ РЕГИСТРАЦИОННЫЕ ДОКУМЕНТЫ\r\n<br/>  АГЕНТСКИЙ ДОГОВОР\r\n<br/> 1. ОБЩИЕ ПОЛОЖЕНИЯ\r\n<br/> 2. ПРЕДМЕТ ДОГОВОРА</p>\r\n\r\n<p>Данный документ, согласно Гражданского Кодекса Украины является официальным предложением (далее – “Офертой”) Общества с ограниченной ответственностью “НетПоинт”, далее по тексту - Провайдер, заключить Договор о предоставлении услуг доступа в сеть передачи данных Провайдера с выходом в глобальную сеть “Интернет”, далее – “Договор”.</p>\r\n\r\n<p>В соответствии с ч.2 ст.642 Гражданского Кодекса Украины в случае принятия ниже указанных условий и подачи заявки об оказании услуг, юридические и физические лица этим засвидетельствуют свое желания заключить Договор. Изложенное действие и есть принятием предложения (акцепт), и с этого момента они обозначаются как “Абоненты”.</p>\r\n\r\n<p>В связи с вышеуказанным, просим внимательно ознакомиться с текстом данной Оферты, и если Вы не согласны с условиями этой Оферты или с отдельными из ее пунктов, Провайдер предлагает Вам отказаться от оказания услуг.</p>\r\n\r\n<p>Провайдер принимает на себя обязательства по предоставлению Абоненту услуг доступа в сеть передачи данных Провайдера (далее Сеть) с выходом в глобальную сеть “Интернет”.</p>\r\n\r\n<p>Регламент является официальным документом Провайдера, неотъемлемой частью настоящего Договора и устанавливается Провайдером одинаковым для всех Абонентов.</p>', 0),
(585, 2, 'cont_seo_title[9]', 'апрапрапрапр', 0),
(586, 2, 'cont_seo_desc[9]', 'ПРАВИЛА ПРОДАЖИ ТОВАРОВ/УСЛУГ\r\n\r\nРЕКОМЕНДАЦИИ\r\n\r\nНАШИ РЕГИСТРАЦИОННЫЕ ДОКУМЕНТЫ\r\n\r\nАГЕНТСКИЙ ДОГОВОР\r\n1. ОБЩИЕ ПОЛОЖЕНИЯ\r\n\r\nДанный документ, согласно Гражданского Кодекса Украины является официальным предложением (далее – “Офертой”) Общества с ограниченной ответственностью “НетПоинт”, далее по тексту - Провайдер, заключить Договор о предоставлении услуг доступа в сеть передачи данных Провайдера с выходом в глобальную сеть “Интернет”, далее – “Договор”.\r\n\r\nВ соответствии с ч.2 ст.642 Гражданского Кодекса Украины в случае принятия ниже указанных условий и подачи заявки об оказании услуг, юридические и физические лица этим засвидетельствуют свое желания заключить Договор. Изложенное действие и есть принятием предложения (акцепт), и с этого момента они обозначаются как “Абоненты”.\r\n\r\nВ связи с вышеуказанным, просим внимательно ознакомиться с текстом данной Оферты, и если Вы не согласны с условиями этой Оферты или с отдельными из ее пунктов, Провайдер предлагает Вам отказаться от оказания услуг.\r\n\r\n2. ПРЕДМЕТ ДОГОВОРА\r\n\r\nПровайдер принимает на себя обязательства по предоставлению Абоненту услуг доступа в сеть передачи данных Провайдера (далее Сеть) с выходом в глобальную сеть “Интернет”.\r\n\r\nРегламент является официальным документом Провайдера, неотъемлемой частью настоящего Договора и устанавливается Провайдером одинаковым для всех Абонентов.', 0),
(587, 2, 'cont_seo_keys[9]', 'впвап, авпввап', 0),
(588, 2, 'cont_seo_canonical[9]', '', 0),
(589, 1, 'const_group_name[global_quote_sliders]', 'Цитаты', 0),
(590, 2, 'const_group_name[global_quote_sliders]', 'Quotes', 0),
(591, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(592, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(593, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(594, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(595, 1, 'const_name[site_quotes]', 'Цитаты', 0),
(596, 2, 'const_name[site_quotes]', 'Quotes', 0),
(597, 1, 'const_str_val[site_quotes]', 'Lorem Ipsum 1|Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.; Lorem Ipsum 2|Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн.', 0),
(598, 2, 'const_str_val[site_quotes]', 'Lorem Ipsum 3|Lorem Ipsum is simply dummy text of the printing and typesetting industry.; Lorem Ipsum 4|Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 0),
(599, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(600, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(601, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(602, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(603, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(604, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(605, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(606, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(607, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(608, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(609, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(610, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(611, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(612, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(613, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(614, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(615, 1, 'cont_title[11]', 'Boss', 0),
(616, 2, 'cont_title[11]', 'boss', 0),
(617, 1, 'cont_desc[11]', '<p>&nbsp;dgdfgsdfgdfgdf</p>', 0),
(618, 2, 'cont_desc[11]', '', 0),
(619, 1, 'cont_title[12]', 'Boss 1', 0),
(620, 2, 'cont_title[12]', 'bosss', 0),
(621, 1, 'cont_desc[12]', '', 0),
(622, 2, 'cont_desc[12]', '', 0),
(623, 1, 'cont_title[13]', 'dfgdfgdfg', 0),
(624, 2, 'cont_title[13]', 'dfgdfgdfgdfg', 0),
(625, 1, 'cont_desc[13]', '', 0),
(626, 2, 'cont_desc[13]', '', 0),
(627, 1, 'cont_title[14]', 'dfgdfgdfg', 0),
(628, 2, 'cont_title[14]', 'dfgdfgdfgdfgf', 0),
(629, 1, 'cont_desc[14]', '', 0),
(630, 2, 'cont_desc[14]', '', 0),
(631, 1, 'cont_title[15]', 'd4234234234234', 0),
(632, 2, 'cont_title[15]', 'dgd3234345345', 0),
(633, 1, 'cont_desc[15]', '', 0),
(634, 2, 'cont_desc[15]', '', 0),
(635, 1, 'cont_title[16]', '2323312312', 0),
(636, 2, 'cont_title[16]', '23423423423423423', 0),
(637, 1, 'cont_desc[16]', '', 0),
(638, 2, 'cont_desc[16]', '', 0),
(639, 1, 'cont_title[17]', 'ghfghfghfghfghfgh', 0),
(640, 2, 'cont_title[17]', 'fe4345345', 0),
(641, 1, 'cont_desc[17]', '', 0),
(642, 2, 'cont_desc[17]', '', 0),
(643, 1, 'cont_title[18]', 'dgdfghjk56745674567', 0),
(644, 2, 'cont_title[18]', 'hghj4563567567567', 0),
(645, 1, 'cont_desc[18]', '', 0),
(646, 2, 'cont_desc[18]', '', 0),
(647, 1, 'const_group_name[global_reg_page_agreement]', 'Регистрационные соглашения', 0),
(648, 2, 'const_group_name[global_reg_page_agreement]', 'Registration agreements', 0),
(649, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(650, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(651, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(652, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(653, 1, 'const_name[reg_page_assignments_public_offer]', 'Условия публичной оферты', 0),
(654, 2, 'const_name[reg_page_assignments_public_offer]', 'The conditions of the public offer', 0),
(655, 1, 'const_str_val[reg_page_assignments_public_offer]', '<p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.</p>', 0),
(656, 2, 'const_str_val[reg_page_assignments_public_offer]', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat volutpat.', 0),
(657, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(658, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(659, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(660, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(661, 1, 'const_group_name[global_regions]', 'Список областей', 0),
(662, 2, 'const_group_name[global_regions]', 'List of regions', 0),
(663, 1, 'const_str_val[main_page_offers_partners_button_tit', 'Стать партнёром', 0),
(664, 2, 'const_str_val[main_page_offers_partners_button_tit', 'Your title', 0),
(665, 1, 'const_str_val[main_page_offers_sellers_button_titl', 'Стать продавцом', 0),
(666, 2, 'const_str_val[main_page_offers_sellers_button_titl', 'Your title', 0),
(667, 1, 'const_name[site_regions]', 'Список регионов Украины', 0),
(668, 2, 'const_name[site_regions]', 'List of Ukraine regions', 0),
(669, 1, 'const_str_val[site_regions]', 'Винницкая область, Волынская область, Днепропетровская область, Донецкая область, Житомирская область, Закарпатская область, Запорожская область, Ивано-Франковская область, Киевская область, Кировоградская область, Крым, Луганская область, Львовская область, Николаевская область, Одесская область, Полтавская область, Ровенская область, Сумская область, Тернопольская область, Харьковская область, Херсонская область, Хмельницкая область, Черкасская область, Черниговская область, Черновицкая область', 0),
(670, 2, 'const_str_val[site_regions]', 'Винницкая область, Волынская область, Днепропетровская область, Донецкая область, Житомирская область, Закарпатская область, Запорожская область, Ивано-Франковская область, Киевская область, Кировоградская область, Крым, Луганская область, Львовская область, Николаевская область, Одесская область, Полтавская область, Ровенская область, Сумская область, Тернопольская область, Харьковская область, Херсонская область, Хмельницкая область, Черкасская область, Черниговская область, Черновицкая область', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_statistic`
--

CREATE TABLE IF NOT EXISTS `order_statistic` (
  `order_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `order_index` varchar(50) NOT NULL,
  `order_user_id` mediumint(8) NOT NULL,
  `order_owner_user_id` mediumint(8) NOT NULL,
  `order_partner_user_id` mediumint(8) NOT NULL DEFAULT '0',
  `order_fulltext` text NOT NULL,
  `order_product_id` mediumint(8) NOT NULL,
  `order_product_title` varchar(100) NOT NULL,
  `order_product_article` varchar(50) NOT NULL,
  `order_product_price` int(6) NOT NULL,
  `order_product_count` smallint(3) NOT NULL DEFAULT '1',
  `order_product_customer_percent` float(3,1) NOT NULL DEFAULT '10.0',
  `order_status` smallint(1) NOT NULL DEFAULT '1',
  `order_date_updt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_date_add` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `order_statistic`
--

INSERT INTO `order_statistic` (`order_id`, `order_index`, `order_user_id`, `order_owner_user_id`, `order_partner_user_id`, `order_fulltext`, `order_product_id`, `order_product_title`, `order_product_article`, `order_product_price`, `order_product_count`, `order_product_customer_percent`, `order_status`, `order_date_updt`, `order_date_add`) VALUES
(1, '1391004392-2-95-0-product_55', 2, 95, 0, '<h5>Покупатель</h5>  <br>ФИО: Кирилл Маляренко <br>E-mail: kirillmalyarenko@derivo.com.ua <br>Телефон: dfgdfgdgfdfgdgfdfg <br>Адрес:  <br>  <br>  <br><h5>Заказ</h5>  <br>Артикул: product_55 <br>Название:  <br>Цена: 6024 <br>Кол-во: 1 <br>Стоимость: 6024 <br>Доставка: УКРПОЧТА <br>Примечание к доставке: dfgdfgdfgdfgdg', 0, '', 'product_55', 6024, 1, 15.0, 4, '2014-01-29 14:13:40', '2014-01-29 14:06:34'),
(2, '1393167299-2-45-0-product_50', 2, 45, 0, '<h5>Покупатель</h5>  <br>ФИО: Кирилл Маляренко <br>E-mail: kirillmalyarenko@derivo.com.ua <br>Телефон: 06776676 <br>Адрес:  <br>  <br>  <br><h5>Заказ</h5>  <br>Артикул: product_50 <br>Название:  <br>Цена: 5765 <br>Кол-во: 1 <br>Стоимость: 5765 <br>Доставка: НОВАЯ ПОЧТА (на почтовое отделение) <br>Примечание к доставке: dfgdfg <br>Регион доставки: Ивано-Франковская область', 0, '', 'product_50', 5765, 1, 20.0, 1, '2014-02-23 14:55:00', '2014-02-23 14:55:00'),
(3, '1393167299-2-5-0-product_20', 2, 5, 0, '<h5>Покупатель</h5>  <br>ФИО: Кирилл Маляренко <br>E-mail: kirillmalyarenko@derivo.com.ua <br>Телефон: 06776676 <br>Адрес:  <br>  <br>  <br><h5>Заказ</h5>  <br>Артикул: product_20 <br>Название:  <br>Цена: 6069 <br>Кол-во: 1 <br>Стоимость: 6069 <br>Доставка: УКРПОЧТА <br>Примечание к доставке: dfgdfg <br>Регион доставки: Одесская область', 0, '', 'product_20', 6069, 1, 12.0, 1, '2014-02-23 14:55:00', '2014-02-23 14:55:00'),
(4, '1393167300-2-6-0-product_46', 2, 6, 0, '<h5>Покупатель</h5>  <br>ФИО: Кирилл Маляренко <br>E-mail: kirillmalyarenko@derivo.com.ua <br>Телефон: 06776676 <br>Адрес:  <br>  <br>  <br><h5>Заказ</h5>  <br>Артикул: product_46 <br>Название:  <br>Цена: 7952 <br>Кол-во: 1 <br>Стоимость: 7952 <br>Доставка: УКРПОЧТА <br>Примечание к доставке: dfgdfg <br>Регион доставки: Киевская область', 0, '', 'product_46', 7952, 1, 12.0, 0, '2014-04-01 12:30:18', '2014-02-23 14:55:00'),
(5, '1397328356-2-6-0-product_19', 2, 6, 0, '<h5>Покупатель</h5>  <br>ФИО: Кирилл Маляренко <br>E-mail: kirillmalyarenko@derivo.com.ua <br>Телефон: 06776676 <br>Адрес:  <br>  <br>  <br><h5>Заказ</h5>  <br>Артикул: product_19 <br>Название:  <br>Цена: 3168 <br>Кол-во: 1 <br>Стоимость: 3168 <br>Доставка: НОВАЯ ПОЧТА (на почтовое отделение) <br>Примечание к доставке: iu7tiuyg <br>Регион доставки: Одесская область', 0, '', 'product_19', 3168, 1, 19.0, 1, '2014-04-12 18:45:56', '2014-04-12 18:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `params`
--

CREATE TABLE IF NOT EXISTS `params` (
  `param_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `param_name` varchar(50) DEFAULT NULL,
  `param_description` varchar(200) DEFAULT NULL,
  `param_type` tinyint(1) unsigned DEFAULT NULL,
  `param_decimal` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `param_for_obj` tinyint(1) NOT NULL DEFAULT '1',
  `param_sort` mediumint(9) DEFAULT '0',
  `param_status` smallint(1) NOT NULL DEFAULT '1',
  `param_required` smallint(1) NOT NULL DEFAULT '0',
  `param_attr` text NOT NULL,
  PRIMARY KEY (`param_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `params`
--

INSERT INTO `params` (`param_id`, `param_name`, `param_description`, `param_type`, `param_decimal`, `param_for_obj`, `param_sort`, `param_status`, `param_required`, `param_attr`) VALUES
(1, '!system!', '', 1, 0, 1, 0, 1, 0, ''),
(2, 'Название', '', 3, 0, 1, 1, 1, 1, ''),
(3, 'Описание', '', 7, 0, 1, 2, 1, 0, ''),
(4, 'Акционная цена', '', 2, 0, 1, 9, 1, 0, 'min="0"'),
(5, 'Розничная цена', '', 2, 0, 1, 5, 1, 1, 'min="1"'),
(6, 'Просмотры', '', 2, 0, 1, 12, 1, 0, 'min="0"'),
(7, 'Лайки', '', 2, 0, 1, 13, 1, 0, 'min="0"'),
(8, 'Акция', '', 4, 0, 1, 8, 1, 0, ''),
(9, 'Фото', 'Если у вас современный бразер, вы можете двигать изображения и расставлять их в необходимом порядке', 8, 0, 1, 18, 1, 0, 'accept="image/jpeg,image/jpg,image/png,image/gif"'),
(10, 'Владелец', '', 3, 0, 1, 14, 1, 0, ''),
(11, 'Индивидуальное вознаграждение (%)', '', 2, 0, 1, 17, 1, 0, 'min="10" max="100" step="0.5"'),
(12, 'Преимущества товара', 'Указать слово и нажать кнопку "Добавить"', 3, 0, 1, 3, 1, 0, ''),
(13, 'Начало акции', '', 3, 0, 1, 10, 1, 0, ''),
(14, 'Конец акции', '', 3, 0, 1, 11, 1, 0, ''),
(15, 'Оптовая цена', '', 2, 0, 1, 6, 1, 0, 'min="0"'),
(16, 'Количество (опт.)', '', 2, 0, 1, 7, 1, 0, 'min="0"'),
(17, 'Способы доставки', 'Укажите доступные способы доставки для данного товара', 6, 0, 1, 4, 1, 1, ''),
(18, 'TOP продаж', '', 4, 0, 1, 15, 1, 0, ''),
(19, 'Активировать продукт', '', 4, 0, 1, 16, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `params_groups`
--

CREATE TABLE IF NOT EXISTS `params_groups` (
  `params_group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `params_group_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`params_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `params_groups`
--

INSERT INTO `params_groups` (`params_group_id`, `params_group_name`) VALUES
(1, 'Параметры в таблице админки'),
(2, 'Параметры в предпросмотре на фронте'),
(3, 'Параметры в предпросмотре каталога продавца');

-- --------------------------------------------------------

--
-- Table structure for table `params_groups_params`
--

CREATE TABLE IF NOT EXISTS `params_groups_params` (
  `params_group_id` smallint(5) unsigned NOT NULL,
  `param_id` mediumint(8) unsigned NOT NULL,
  `param_sort` mediumint(9) DEFAULT '0',
  `param_name` varchar(30) DEFAULT NULL,
  KEY `params_group_id` (`params_group_id`),
  KEY `param_id` (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `params_groups_params`
--

INSERT INTO `params_groups_params` (`params_group_id`, `param_id`, `param_sort`, `param_name`) VALUES
(1, 2, 0, ''),
(1, 10, 0, ''),
(2, 2, 0, ''),
(2, 9, 0, ''),
(2, 7, 0, ''),
(2, 6, 0, ''),
(2, 8, 0, ''),
(2, 4, 0, ''),
(2, 18, 0, ''),
(2, 11, 0, ''),
(3, 2, 0, ''),
(3, 9, 0, ''),
(3, 3, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `params_options`
--

CREATE TABLE IF NOT EXISTS `params_options` (
  `option_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `param_id` mediumint(8) unsigned NOT NULL,
  `option_int_val` int(11) DEFAULT NULL,
  `option_str_val` varchar(50) DEFAULT NULL,
  `option_str_long_val` varchar(160) NOT NULL DEFAULT '',
  `option_sort` mediumint(9) DEFAULT '0',
  `option_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`option_id`),
  KEY `param_id` (`param_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `params_options`
--

INSERT INTO `params_options` (`option_id`, `param_id`, `option_int_val`, `option_str_val`, `option_str_long_val`, `option_sort`, `option_type`) VALUES
(1, 1, NULL, 'Yes', '', 1, NULL),
(2, 1, NULL, 'No', '', 2, NULL),
(3, 17, NULL, 'НОВАЯ ПОЧТА (на почтовое отделение)', 'Укажите номер и <a class="prod-in-cart-offices" target="_blank" href="http://novaposhta.ua/frontend/brunchoffices?lang=ukr">адрес почтового отделения</a>', 0, NULL),
(4, 17, NULL, 'НОВАЯ ПОЧТА (по адресу)', 'Укажите город и адрес доставки', 0, NULL),
(5, 17, NULL, 'УКРПОЧТА', 'Укажите индекс почтового отделения, город и ваш адрес', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product_group` mediumint(8) unsigned NOT NULL,
  `product_article` varchar(50) DEFAULT NULL,
  `product_user_id` mediumint(9) NOT NULL DEFAULT '1',
  `product_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `product_status` tinyint(1) DEFAULT '0',
  `product_sort` mediumint(9) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_article_UNIQUE` (`product_article`),
  KEY `obj_status_sort` (`product_id`,`product_status`,`product_sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_group`, `product_article`, `product_user_id`, `product_date`, `product_status`, `product_sort`) VALUES
(1, 0, 'product_1', 17, '2014-02-06 22:00:00', 1, 0),
(2, 0, 'product_2', 8, '2014-10-27 22:00:00', 1, 0),
(3, 0, 'product_3', 8, '2014-06-11 21:00:00', 1, 0),
(4, 0, 'product_4', 47, '2014-05-26 21:00:00', 1, 0),
(5, 0, 'product_5', 8, '2014-07-04 21:00:00', 1, 0),
(6, 0, 'product_6', 17, '2014-03-27 22:00:00', 1, 0),
(7, 0, 'product_7', 47, '2014-07-14 21:00:00', 1, 0),
(8, 0, 'product_8', 5, '2014-07-23 21:00:00', 1, 0),
(9, 0, 'product_9', 22, '2014-02-02 22:00:00', 1, 0),
(10, 0, 'product_10', 17, '2014-09-26 21:00:00', 1, 0),
(11, 0, 'product_11', 17, '2014-08-04 21:00:00', 1, 0),
(12, 0, 'product_12', 5, '2014-02-26 22:00:00', 1, 0),
(13, 0, 'product_13', 22, '2014-05-05 21:00:00', 1, 0),
(14, 0, 'product_14', 6, '2014-01-20 22:00:00', 1, 0),
(15, 0, 'product_15', 8, '2014-04-13 21:00:00', 1, 0),
(16, 0, 'product_16', 16, '2014-07-18 21:00:00', 1, 0),
(17, 0, 'product_17', 17, '2014-06-25 21:00:00', 1, 0),
(18, 0, 'product_18', 47, '2014-07-22 21:00:00', 1, 0),
(19, 0, 'product_19', 6, '2014-10-27 22:00:00', 1, 0),
(20, 0, 'product_20', 6, '2014-02-16 22:00:00', 1, 0),
(21, 0, 'product_21', 47, '2014-10-19 21:00:00', 1, 0),
(22, 0, 'product_22', 17, '2014-06-11 21:00:00', 1, 0),
(23, 0, 'product_23', 8, '2014-06-07 21:00:00', 1, 0),
(24, 0, 'product_24', 8, '2014-10-09 21:00:00', 1, 0),
(25, 0, 'product_25', 16, '2014-05-08 21:00:00', 1, 0),
(26, 0, 'product_26', 47, '2014-03-01 22:00:00', 1, 0),
(27, 0, 'product_27', 22, '2014-01-07 22:00:00', 1, 0),
(28, 0, 'product_28', 17, '2014-03-11 22:00:00', 1, 0),
(29, 0, 'product_29', 22, '2014-05-16 21:00:00', 1, 0),
(30, 0, 'product_30', 8, '2014-03-05 22:00:00', 1, 0),
(31, 0, 'product_31', 22, '2014-09-12 21:00:00', 1, 0),
(32, 0, 'product_32', 17, '2014-08-16 21:00:00', 1, 0),
(33, 0, 'product_33', 47, '2014-06-08 21:00:00', 1, 0),
(34, 0, 'product_34', 16, '2014-10-10 21:00:00', 1, 0),
(35, 0, 'product_35', 22, '2014-02-05 22:00:00', 1, 0),
(36, 0, 'product_36', 47, '2014-03-02 22:00:00', 1, 0),
(37, 0, 'product_37', 22, '2014-01-06 22:00:00', 1, 0),
(38, 0, 'product_38', 17, '2014-09-23 21:00:00', 1, 0),
(39, 0, 'product_39', 5, '2014-01-27 22:00:00', 1, 0),
(40, 0, 'product_40', 22, '2014-06-04 21:00:00', 1, 0),
(41, 0, 'product_41', 17, '2014-06-07 21:00:00', 1, 0),
(42, 0, 'product_42', 6, '2014-04-25 21:00:00', 1, 0),
(43, 0, 'product_43', 22, '2014-05-11 21:00:00', 1, 0),
(44, 0, 'product_44', 8, '2014-07-02 21:00:00', 1, 0),
(45, 0, 'product_45', 6, '2014-01-12 22:00:00', 1, 0),
(46, 0, 'product_46', 6, '2014-07-14 21:00:00', 1, 0),
(47, 0, 'product_47', 16, '2014-05-19 21:00:00', 1, 0),
(48, 0, 'product_48', 16, '2014-10-21 21:00:00', 1, 0),
(49, 0, 'product_49', 6, '2014-06-03 21:00:00', 1, 0),
(50, 0, 'product_50', 6, '2014-09-22 21:00:00', 1, 0),
(51, 0, '0000051', 6, '2014-03-18 17:54:34', 0, 0),
(52, 0, '0000052', 6, '2014-03-18 17:57:43', 0, 0),
(53, 0, '0000053', 6, '2014-03-19 09:23:05', 0, 0),
(54, 0, '0000054', 6, '2014-03-19 09:23:30', 0, 0),
(55, 0, '0000055', 6, '2014-03-19 09:23:43', 0, 0),
(56, 0, '0000056', 6, '2014-03-19 09:23:49', 0, 0),
(57, 0, '0000057', 6, '2014-03-19 09:24:17', 0, 0),
(58, 0, '0000058', 6, '2014-03-19 09:32:46', 0, 0),
(59, 0, '0000059', 6, '2014-03-19 09:33:12', 0, 0),
(60, 0, '0000060', 6, '2014-03-19 09:33:20', 0, 0),
(61, 0, '0000061', 6, '2014-03-19 09:33:30', 0, 0),
(62, 0, '0000062', 6, '2014-03-19 09:33:52', 0, 0),
(63, 0, '0000063', 6, '2014-03-19 09:34:19', 0, 0),
(64, 0, '0000064', 6, '2014-03-19 09:36:25', 0, 0),
(65, 0, '0000065', 6, '2014-03-19 09:36:39', 0, 0),
(66, 0, '0000066', 6, '2014-03-19 09:40:45', 0, 0),
(67, 0, '0000067', 6, '2014-03-19 09:40:55', 0, 0),
(68, 0, '0000068', 6, '2014-03-19 09:41:24', 0, 0),
(69, 0, '0000069', 6, '2014-03-19 09:43:29', 0, 0),
(70, 0, '0000070', 6, '2014-03-19 09:44:32', 0, 0),
(71, 0, '0000071', 6, '2014-03-19 09:45:35', 0, 0),
(72, 0, '0000072', 6, '2014-03-19 09:47:54', 0, 0),
(73, 0, '0000073', 6, '2014-03-19 09:48:43', 0, 0),
(74, 0, '0000074', 6, '2014-03-19 09:48:53', 0, 0),
(75, 0, '0000075', 6, '2014-03-19 09:49:00', 0, 0),
(76, 0, '0000076', 6, '2014-03-19 09:49:03', 0, 0),
(77, 0, '0000077', 6, '2014-03-19 09:49:09', 0, 0),
(78, 0, '0000078', 6, '2014-03-19 09:49:48', 0, 0),
(79, 0, '0000079', 6, '2014-03-19 09:50:16', 0, 0),
(80, 0, '0000080', 6, '2014-03-19 09:50:43', 0, 0),
(81, 0, '0000081', 6, '2014-03-19 09:59:06', 0, 0),
(82, 0, '0000082', 6, '2014-03-19 09:59:40', 0, 0),
(83, 0, '0000083', 6, '2014-03-19 10:00:28', 0, 0),
(84, 0, '0000084', 6, '2014-03-19 10:01:06', 0, 0),
(85, 0, '0000085', 6, '2014-03-19 10:01:35', 0, 0),
(86, 0, '0000086', 6, '2014-03-19 10:02:26', 0, 0),
(87, 0, '0000087', 6, '2014-03-19 10:02:42', 0, 0),
(88, 0, '0000088', 6, '2014-03-19 10:03:13', 0, 0),
(89, 0, '0000089', 6, '2014-03-19 10:03:36', 0, 0),
(90, 0, '0000090', 6, '2014-03-19 10:03:51', 0, 0),
(91, 0, '0000091', 6, '2014-03-19 10:04:50', 0, 0),
(92, 0, '0000092', 6, '2014-03-19 10:05:34', 0, 0),
(93, 0, '0000093', 6, '2014-03-19 10:05:49', 0, 0),
(94, 0, '0000094', 6, '2014-03-19 10:06:02', 0, 0),
(95, 0, '0000095', 6, '2014-03-19 10:06:29', 0, 0),
(96, 0, '0000096', 6, '2014-03-19 10:06:43', 0, 0),
(97, 0, '0000097', 6, '2014-03-19 10:07:10', 0, 0),
(98, 0, '0000098', 6, '2014-03-19 10:07:25', 0, 0),
(99, 0, '0000099', 6, '2014-03-19 10:08:23', 0, 0),
(100, 0, '0000100', 6, '2014-03-19 10:12:44', 0, 0),
(101, 0, '0000101', 6, '2014-03-19 10:16:03', 0, 0),
(102, 0, '0000102', 6, '2014-03-19 10:26:02', 0, 0),
(103, 0, '0000103', 6, '2014-03-19 11:43:59', 0, 0),
(104, 0, '0000104', 6, '2014-03-19 11:58:57', 0, 0),
(105, 0, '0000105', 6, '2014-03-19 12:03:37', 0, 0),
(106, 0, '0000106', 6, '2014-03-19 12:06:09', 0, 0),
(107, 0, '0000107', 6, '2014-03-19 12:08:14', 0, 0),
(108, 0, '0000108', 6, '2014-03-19 12:55:54', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_fulltext`
--

CREATE TABLE IF NOT EXISTS `products_fulltext` (
  `product_id` mediumint(8) unsigned NOT NULL,
  `product_article` varchar(20) NOT NULL,
  `product_fulltext` text,
  `product_status` int(1) NOT NULL,
  PRIMARY KEY (`product_id`),
  FULLTEXT KEY `ft1` (`product_article`,`product_fulltext`),
  FULLTEXT KEY `ft2` (`product_fulltext`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products_groups`
--

CREATE TABLE IF NOT EXISTS `products_groups` (
  `group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_parent_group` mediumint(8) NOT NULL DEFAULT '0',
  `group_nesting` smallint(1) NOT NULL DEFAULT '0',
  `group_sort` mediumint(9) NOT NULL DEFAULT '0',
  `group_short_name` varchar(20) NOT NULL,
  `group_full_name` varchar(100) NOT NULL,
  `group_description` text NOT NULL,
  `group_img` varchar(255) NOT NULL,
  `group_status` int(1) NOT NULL DEFAULT '1',
  `group_param_1` varchar(250) NOT NULL,
  `group_param_2` varchar(250) NOT NULL,
  `group_param_3` varchar(250) NOT NULL,
  `group_param_4` varchar(250) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `products_groups`
--

INSERT INTO `products_groups` (`group_id`, `group_parent_group`, `group_nesting`, `group_sort`, `group_short_name`, `group_full_name`, `group_description`, `group_img`, `group_status`, `group_param_1`, `group_param_2`, `group_param_3`, `group_param_4`) VALUES
(1, 0, 0, 0, 'group_1', 'Строительные товары', '', '', 1, '', '', '', ''),
(2, 1, 1, 0, 'group_2', 'Инструменты', '', '', 1, '', '', '', ''),
(3, 1, 1, 0, 'group_3', 'Шурупы/Саморезы', '', '', 1, '', '', '', ''),
(4, 0, 0, 0, 'group_4', 'Одежда и Аксессуары', '', '', 1, '', '', '', ''),
(5, 4, 1, 0, 'group_5', 'Верхняя одежда', '', '', 1, '', '', '', ''),
(6, 4, 1, 0, 'group_6', 'Обувь', '', '', 1, '', '', '', ''),
(7, 6, 2, 0, 'group_7', 'Мужская обувь', '', '', 1, '', '', '', ''),
(8, 6, 2, 0, 'group_8', 'Женская обувь', '', '', 1, '', '', '', ''),
(9, 7, 3, 0, 'group_9', 'Кроссовки', '', '', 1, '', '', '', ''),
(10, 5, 2, 0, 'group_10', 'Зимняя одежда', '', '', 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `products_groups_products`
--

CREATE TABLE IF NOT EXISTS `products_groups_products` (
  `group_id` mediumint(8) unsigned NOT NULL,
  `product_id` mediumint(8) unsigned NOT NULL,
  `product_sort` smallint(2) NOT NULL DEFAULT '0',
  `product_best_deal` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_groups_products`
--

INSERT INTO `products_groups_products` (`group_id`, `product_id`, `product_sort`, `product_best_deal`) VALUES
(9, 1, 0, 0),
(3, 2, 0, 0),
(7, 3, 0, 0),
(3, 4, 0, 0),
(4, 5, 0, 0),
(4, 5, 0, 0),
(6, 6, 0, 0),
(9, 6, 0, 0),
(8, 7, 0, 0),
(5, 7, 0, 0),
(9, 8, 0, 0),
(8, 8, 0, 0),
(4, 9, 0, 0),
(3, 10, 0, 0),
(4, 11, 0, 0),
(4, 12, 0, 0),
(10, 12, 0, 0),
(2, 13, 0, 0),
(3, 14, 0, 0),
(10, 15, 0, 0),
(5, 16, 0, 0),
(1, 16, 0, 0),
(1, 17, 0, 0),
(8, 17, 0, 0),
(7, 17, 0, 0),
(5, 18, 0, 0),
(2, 19, 0, 0),
(7, 19, 0, 0),
(10, 20, 0, 0),
(2, 21, 0, 0),
(7, 21, 0, 0),
(6, 21, 0, 0),
(8, 22, 0, 0),
(10, 23, 0, 0),
(3, 24, 0, 0),
(3, 24, 0, 0),
(10, 24, 0, 0),
(4, 25, 0, 0),
(7, 26, 0, 0),
(6, 26, 0, 0),
(5, 27, 0, 0),
(10, 28, 0, 0),
(1, 28, 0, 0),
(9, 29, 0, 0),
(8, 29, 0, 0),
(5, 29, 0, 0),
(3, 30, 0, 0),
(1, 30, 0, 0),
(5, 31, 0, 0),
(4, 31, 0, 0),
(5, 32, 0, 1),
(5, 33, 0, 0),
(8, 33, 0, 0),
(9, 33, 0, 0),
(2, 34, 0, 0),
(3, 35, 0, 1),
(3, 36, 0, 0),
(4, 37, 0, 0),
(9, 38, 0, 0),
(1, 38, 0, 0),
(5, 39, 0, 0),
(10, 39, 0, 0),
(4, 40, 0, 0),
(2, 41, 0, 0),
(3, 42, 0, 0),
(10, 43, 0, 0),
(2, 44, 0, 0),
(2, 44, 0, 0),
(8, 45, 0, 0),
(8, 45, 0, 0),
(2, 46, 0, 0),
(10, 46, 0, 0),
(2, 47, 0, 0),
(4, 47, 0, 0),
(10, 48, 0, 0),
(8, 49, 0, 0),
(1, 49, 0, 0),
(10, 50, 0, 1),
(10, 50, 0, 0),
(4, 51, 0, 0),
(4, 52, 0, 0),
(4, 69, 0, 0),
(4, 71, 0, 0),
(4, 90, 0, 0),
(4, 98, 0, 0),
(4, 99, 0, 0),
(4, 102, 0, 0),
(4, 103, 0, 0),
(4, 104, 0, 0),
(4, 105, 0, 0),
(4, 106, 0, 0),
(4, 107, 0, 0),
(4, 108, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_partners`
--

CREATE TABLE IF NOT EXISTS `products_partners` (
  `p_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `p_product_id` mediumint(8) NOT NULL,
  `p_partner_user_id` mediumint(8) NOT NULL,
  `p_date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `p_status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products_partners`
--

INSERT INTO `products_partners` (`p_id`, `p_product_id`, `p_partner_user_id`, `p_date_add`, `p_status`) VALUES
(1, 39, 8, '2014-02-03 13:37:00', 1),
(2, 2, 8, '2014-02-03 13:38:00', 1),
(3, 28, 6, '2014-02-15 12:46:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products_specs`
--

CREATE TABLE IF NOT EXISTS `products_specs` (
  `spec_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`spec_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `products_specs`
--

INSERT INTO `products_specs` (`spec_id`, `product_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31),
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(38, 38),
(39, 39),
(40, 40),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(46, 46),
(47, 47),
(48, 48),
(49, 49),
(50, 50),
(51, 51),
(52, 52),
(53, 53),
(54, 54),
(55, 55),
(56, 56),
(57, 57),
(58, 58),
(59, 59),
(60, 60),
(61, 61),
(62, 62),
(63, 63),
(64, 64),
(65, 65),
(66, 66),
(67, 67),
(68, 68),
(69, 69),
(70, 70),
(71, 71),
(72, 72),
(73, 73),
(74, 74),
(75, 75),
(76, 76),
(77, 77),
(78, 78),
(79, 79),
(80, 80),
(81, 81),
(82, 82),
(83, 83),
(84, 84),
(85, 85),
(86, 86),
(87, 87),
(88, 88),
(89, 89),
(90, 90),
(91, 91),
(92, 92),
(93, 93),
(94, 94),
(95, 95),
(96, 96),
(97, 97),
(98, 98),
(99, 99),
(100, 100),
(101, 101),
(102, 102),
(103, 103),
(104, 104),
(105, 105),
(106, 106),
(107, 107),
(108, 108);

-- --------------------------------------------------------

--
-- Table structure for table `specs_params_files`
--

CREATE TABLE IF NOT EXISTS `specs_params_files` (
  `spec_id` mediumint(8) unsigned NOT NULL,
  `param_id` mediumint(8) unsigned NOT NULL,
  `param_file_name` varchar(37) DEFAULT NULL,
  `param_file_name_real` varchar(30) NOT NULL,
  `param_file_path` varchar(100) DEFAULT NULL,
  `param_sort` mediumint(8) NOT NULL DEFAULT '0',
  KEY `spec_id` (`spec_id`),
  KEY `param_id` (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specs_params_files`
--

INSERT INTO `specs_params_files` (`spec_id`, `param_id`, `param_file_name`, `param_file_name_real`, `param_file_path`, `param_sort`) VALUES
(7, 9, NULL, 'ee2244a.pdf', NULL, 0),
(12, 9, NULL, 'ab8130e.pdf', NULL, 0),
(21, 9, NULL, 'ee2244a.pdf', NULL, 0),
(24, 9, NULL, 'ee2244a.pdf', NULL, 0),
(26, 9, NULL, 'ee2244a.pdf', NULL, 0),
(43, 9, NULL, 'ee2244a.pdf', NULL, 0),
(49, 9, NULL, 'ab8130e.pdf', NULL, 0),
(102, 9, '50181b9b72d9808c0cc339397a3ad519.jpg', 'tumblr_m7djx6Be1J1r0j1wwo1_500', '/adm_dop_files/upload_files_object/', 0),
(102, 9, '5f4cdee5d6ab649acc7a4bf3a3254795.jpg', 'tumblr_mzopfeGr981t367u7o1_500', '/adm_dop_files/upload_files_object/', 0),
(103, 9, '50181b9b72d9808c0cc339397a3ad519.jpg', 'tumblr_m7djx6Be1J1r0j1wwo1_500', '/adm_dop_files/upload_files_object/', 0),
(103, 9, '5f4cdee5d6ab649acc7a4bf3a3254795.jpg', 'tumblr_mzopfeGr981t367u7o1_500', '/adm_dop_files/upload_files_object/', 1),
(104, 9, '2642a3efe5467151ee3c579aa14c1ee3.jpg', 'IHFfr0zo25o.jpg', '/adm_dop_files/upload_files_object/', 0),
(104, 9, '5f4cdee5d6ab649acc7a4bf3a3254795.jpg', 'tumblr_mzopfeGr981t367u7o1_500', '/adm_dop_files/upload_files_object/', 1),
(105, 9, 'd41d8cd98f00b204e9800998ecf8427e.jpg', 'tumblr_m7djx6Be1J1r0j1wwo1_500', '/adm_dop_files/upload_files_object/', 1),
(105, 9, 'd41d8cd98f00b204e9800998ecf8427e.jpg', 'tumblr_mzopfeGr981t367u7o1_500', '/adm_dop_files/upload_files_object/', 0),
(106, 9, '5cb116eb4853906324fa9a1864ceae3d.jpg', '49beea0e9450.jpg', '/adm_dop_files/upload_files_object/', 1),
(106, 9, 'd0c4b8055f9825d56a791dabfe33a990.jpeg', 'ddb2036c9f47.jpeg', '/adm_dop_files/upload_files_object/', 0),
(107, 9, '5cb116eb4853906324fa9a1864ceae3d.jpg', '49beea0e9450.jpg', '/adm_dop_files/upload_files_object/', 1),
(107, 9, 'ec205025c78696db1ab4f57a75cb59d9.jpg', 'Indian_blog_046.jpg', '/adm_dop_files/upload_files_object/', 0),
(108, 9, '5cb116eb4853906324fa9a1864ceae3d.jpg', '49beea0e9450.jpg', '/adm_dop_files/upload_files_object/', 1),
(108, 9, '5367028b0fbf4dd51f8caf1c53963b3b.jpg', 'port-loft-3a.jpg', '/adm_dop_files/upload_files_object/', 0);

-- --------------------------------------------------------

--
-- Table structure for table `specs_params_number_val`
--

CREATE TABLE IF NOT EXISTS `specs_params_number_val` (
  `spec_id` mediumint(8) unsigned NOT NULL,
  `param_id` mediumint(8) unsigned NOT NULL,
  `param_number_val` int(11) DEFAULT NULL,
  KEY `param_id` (`param_id`),
  KEY `param_val` (`param_id`,`param_number_val`),
  KEY `fk_objects_params_options_objects00111` (`spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specs_params_number_val`
--

INSERT INTO `specs_params_number_val` (`spec_id`, `param_id`, `param_number_val`) VALUES
(1, 4, 303),
(1, 5, 218),
(1, 6, 1),
(1, 7, 5113),
(1, 11, 10),
(1, 15, 844),
(1, 16, 479),
(2, 4, 671),
(2, 5, 7137),
(2, 6, 4),
(2, 7, 5368),
(2, 11, 20),
(2, 15, 154),
(2, 16, 780),
(3, 4, 2729),
(3, 5, 6737),
(3, 6, 4),
(3, 7, 8328),
(3, 11, 12),
(3, 15, 169),
(3, 16, 876),
(4, 4, 1906),
(4, 5, 3802),
(4, 6, 3),
(4, 7, 2938),
(4, 11, 10),
(4, 15, 353),
(4, 16, 339),
(5, 4, 7584),
(5, 5, 1062),
(5, 6, 5),
(5, 7, 2183),
(5, 11, 10),
(5, 15, 689),
(5, 16, 435),
(6, 4, 2884),
(6, 5, 3137),
(6, 6, 2),
(6, 7, 2895),
(6, 11, 10),
(6, 15, 562),
(6, 16, 760),
(7, 4, 1842),
(7, 5, 7126),
(7, 6, 2),
(7, 7, 6963),
(7, 11, 12),
(7, 15, 275),
(7, 16, 563),
(8, 4, 672),
(8, 5, 3902),
(8, 6, 4),
(8, 7, 3825),
(8, 11, 18),
(8, 15, 76),
(8, 16, 39),
(9, 4, 976),
(9, 5, 2537),
(9, 6, 3),
(9, 7, 2333),
(9, 11, 14),
(9, 15, 84),
(9, 16, 405),
(10, 4, 9427),
(10, 5, 8855),
(10, 6, 1),
(10, 7, 2027),
(10, 11, 18),
(10, 15, 917),
(10, 16, 350),
(11, 4, 5398),
(11, 5, 371),
(11, 6, 3),
(11, 7, 6760),
(11, 11, 13),
(11, 15, 964),
(11, 16, 685),
(12, 4, 456),
(12, 5, 9844),
(12, 6, 3),
(12, 7, 1224),
(12, 11, 16),
(12, 15, 19),
(12, 16, 125),
(13, 4, 5635),
(13, 5, 7182),
(13, 6, 5),
(13, 7, 6609),
(13, 11, 12),
(13, 15, 983),
(13, 16, 877),
(14, 4, 1270),
(14, 5, 8972),
(14, 6, 2),
(14, 7, 4332),
(14, 11, 17),
(14, 15, 522),
(14, 16, 346),
(15, 4, 6786),
(15, 5, 2791),
(15, 6, 1),
(15, 7, 5183),
(15, 11, 13),
(15, 15, 778),
(15, 16, 524),
(16, 4, 2991),
(16, 5, 3718),
(16, 6, 4),
(16, 7, 7596),
(16, 11, 17),
(16, 15, 988),
(16, 16, 909),
(17, 4, 737),
(17, 5, 6700),
(17, 6, 2),
(17, 7, 4542),
(17, 11, 17),
(17, 15, 327),
(17, 16, 479),
(18, 4, 3423),
(18, 5, 5695),
(18, 6, 1),
(18, 7, 8054),
(18, 11, 18),
(18, 15, 523),
(18, 16, 403),
(19, 4, 3168),
(19, 5, 7383),
(19, 6, 9),
(19, 7, 8383),
(19, 11, 19),
(19, 15, 430),
(19, 16, 277),
(20, 4, 1584),
(20, 5, 9796),
(20, 6, 5),
(20, 7, 9351),
(20, 11, 18),
(20, 15, 100),
(20, 16, 136),
(21, 4, 6979),
(21, 5, 1193),
(21, 6, 4),
(21, 7, 7336),
(21, 11, 13),
(21, 15, 845),
(21, 16, 340),
(22, 4, 566),
(22, 5, 5573),
(22, 6, 4),
(22, 7, 8610),
(22, 11, 14),
(22, 15, 624),
(22, 16, 642),
(23, 4, 1772),
(23, 5, 7912),
(23, 6, 4),
(23, 7, 6134),
(23, 11, 16),
(23, 15, 86),
(23, 16, 681),
(24, 4, 2730),
(24, 5, 5120),
(24, 6, 2),
(24, 7, 2555),
(24, 11, 11),
(24, 15, 6),
(24, 16, 600),
(25, 4, 3388),
(25, 5, 3345),
(25, 6, 4),
(25, 7, 2124),
(25, 11, 14),
(25, 15, 996),
(25, 16, 859),
(26, 4, 8931),
(26, 5, 6333),
(26, 6, 3),
(26, 7, 336),
(26, 11, 12),
(26, 15, 168),
(26, 16, 299),
(27, 4, 3621),
(27, 5, 2131),
(27, 6, 5),
(27, 7, 6090),
(27, 11, 17),
(27, 15, 66),
(27, 16, 749),
(28, 4, 324),
(28, 5, 2980),
(28, 6, 2),
(28, 7, 2362),
(28, 11, 18),
(28, 15, 944),
(28, 16, 457),
(29, 4, 7824),
(29, 5, 9142),
(29, 6, 2),
(29, 7, 9460),
(29, 11, 11),
(29, 15, 421),
(29, 16, 114),
(30, 4, 4615),
(30, 5, 6193),
(30, 6, 3),
(30, 7, 7412),
(30, 11, 19),
(30, 15, 124),
(30, 16, 240),
(31, 4, 911),
(31, 5, 5226),
(31, 6, 1),
(31, 7, 2645),
(31, 11, 10),
(31, 15, 886),
(31, 16, 458),
(32, 4, 2838),
(32, 5, 214),
(32, 6, 3),
(32, 7, 6227),
(32, 11, 14),
(32, 15, 504),
(32, 16, 662),
(33, 4, 5273),
(33, 5, 4418),
(33, 6, 1),
(33, 7, 6981),
(33, 11, 14),
(33, 15, 451),
(33, 16, 977),
(34, 4, 9016),
(34, 5, 3518),
(34, 6, 4),
(34, 7, 4075),
(34, 11, 19),
(34, 15, 496),
(34, 16, 458),
(35, 4, 6348),
(35, 5, 4397),
(35, 6, 4),
(35, 7, 4613),
(35, 11, 16),
(35, 15, 876),
(35, 16, 682),
(36, 4, 3228),
(36, 5, 4407),
(36, 6, 5),
(36, 7, 2702),
(36, 11, 17),
(36, 15, 863),
(36, 16, 446),
(37, 4, 1711),
(37, 5, 2514),
(37, 6, 3),
(37, 7, 7587),
(37, 11, 19),
(37, 15, 692),
(37, 16, 382),
(38, 4, 9774),
(38, 5, 5274),
(38, 6, 4),
(38, 7, 4519),
(38, 11, 12),
(38, 15, 101),
(38, 16, 425),
(39, 4, 9262),
(39, 5, 8014),
(39, 6, 2),
(39, 7, 1463),
(39, 11, 19),
(39, 15, 289),
(39, 16, 47),
(40, 4, 9079),
(40, 5, 4063),
(40, 6, 5),
(40, 7, 5307),
(40, 11, 14),
(40, 15, 145),
(40, 16, 420),
(41, 4, 3402),
(41, 5, 9055),
(41, 6, 1),
(41, 7, 5548),
(41, 11, 16),
(41, 15, 409),
(41, 16, 802),
(42, 4, 671),
(42, 5, 5520),
(42, 6, 1),
(42, 7, 9597),
(42, 11, 19),
(42, 15, 115),
(42, 16, 909),
(43, 4, 2211),
(43, 5, 3070),
(43, 6, 2),
(43, 7, 5160),
(43, 11, 20),
(43, 15, 587),
(43, 16, 175),
(44, 4, 1625),
(44, 5, 8563),
(44, 6, 1),
(44, 7, 5392),
(44, 11, 13),
(44, 15, 380),
(44, 16, 834),
(45, 4, 4531),
(45, 5, 3521),
(45, 6, 2),
(45, 7, 2644),
(45, 11, 10),
(45, 15, 143),
(45, 16, 340),
(46, 4, 5152),
(46, 5, 5865),
(46, 6, 5),
(46, 7, 9372),
(46, 11, 12),
(46, 15, 638),
(46, 16, 132),
(47, 4, 5376),
(47, 5, 5348),
(47, 6, 4),
(47, 7, 25),
(47, 11, 16),
(47, 15, 47),
(47, 16, 233),
(48, 4, 4435),
(48, 5, 3511),
(48, 6, 2),
(48, 7, 8683),
(48, 11, 17),
(48, 15, 247),
(48, 16, 744),
(49, 4, 4616),
(49, 5, 4576),
(49, 6, 1),
(49, 7, 1640),
(49, 11, 10),
(49, 15, 253),
(49, 16, 932),
(50, 4, 5064),
(50, 5, 7411),
(50, 6, 5),
(50, 7, 8206),
(50, 11, 11),
(50, 15, 377),
(50, 16, 78),
(51, 5, 56456),
(52, 5, 56456),
(69, 5, 46456456),
(71, 5, 46456456),
(81, 5, 46456456),
(82, 5, 46456456),
(84, 5, 46456456),
(85, 5, 46456456),
(86, 5, 46456456),
(87, 5, 46456456),
(88, 5, 46456456),
(89, 5, 46456456),
(90, 5, 46456456),
(91, 5, 46456456),
(92, 5, 46456456),
(93, 5, 46456456),
(94, 5, 46456456),
(95, 5, 46456456),
(96, 5, 46456456),
(97, 5, 46456456),
(98, 5, 46456456),
(99, 5, 456456),
(100, 5, 45345),
(101, 5, 45345),
(102, 5, 45345),
(103, 5, 456456456),
(104, 5, 456456456),
(105, 5, 456456456),
(106, 5, 4545645),
(107, 5, 456456),
(108, 5, 435345345);

-- --------------------------------------------------------

--
-- Table structure for table `specs_params_options`
--

CREATE TABLE IF NOT EXISTS `specs_params_options` (
  `spec_id` mediumint(8) unsigned NOT NULL,
  `param_id` mediumint(8) unsigned NOT NULL,
  `option_id` mediumint(8) unsigned NOT NULL,
  KEY `spec_id` (`spec_id`),
  KEY `param_id` (`param_id`),
  KEY `option_id` (`option_id`),
  KEY `param_option` (`param_id`,`option_id`),
  KEY `spec_param_option` (`spec_id`,`param_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specs_params_options`
--

INSERT INTO `specs_params_options` (`spec_id`, `param_id`, `option_id`) VALUES
(1, 17, 4),
(2, 17, 5),
(3, 17, 5),
(3, 18, 1),
(3, 19, 1),
(4, 8, 1),
(4, 17, 3),
(4, 18, 1),
(5, 17, 5),
(6, 17, 5),
(6, 18, 1),
(6, 19, 1),
(7, 17, 3),
(8, 17, 3),
(9, 17, 5),
(9, 18, 1),
(10, 8, 1),
(10, 17, 4),
(10, 18, 1),
(11, 17, 5),
(12, 17, 3),
(12, 19, 1),
(13, 17, 5),
(14, 17, 5),
(15, 17, 3),
(16, 8, 1),
(16, 17, 5),
(17, 8, 1),
(17, 17, 4),
(18, 17, 4),
(19, 17, 3),
(20, 17, 3),
(21, 17, 3),
(22, 8, 1),
(22, 17, 3),
(22, 18, 1),
(23, 17, 3),
(24, 17, 3),
(24, 19, 1),
(25, 17, 3),
(26, 8, 1),
(26, 17, 3),
(27, 8, 1),
(27, 17, 5),
(28, 17, 4),
(29, 17, 5),
(29, 19, 1),
(30, 17, 5),
(30, 19, 1),
(31, 17, 5),
(32, 17, 3),
(32, 19, 1),
(33, 17, 4),
(34, 8, 1),
(34, 17, 5),
(34, 19, 1),
(35, 17, 4),
(35, 19, 1),
(36, 17, 3),
(37, 17, 5),
(37, 19, 1),
(38, 17, 5),
(39, 8, 1),
(39, 17, 5),
(40, 17, 5),
(40, 18, 1),
(41, 17, 4),
(42, 17, 4),
(42, 19, 1),
(43, 17, 3),
(43, 19, 1),
(44, 17, 5),
(45, 17, 3),
(46, 17, 4),
(46, 19, 1),
(47, 8, 1),
(47, 17, 5),
(48, 17, 4),
(49, 17, 4),
(49, 18, 1),
(49, 19, 1),
(50, 17, 5),
(51, 17, 4),
(52, 17, 4),
(69, 17, 4),
(71, 17, 4),
(81, 17, 4),
(82, 17, 4),
(84, 17, 4),
(85, 17, 4),
(86, 17, 4),
(87, 17, 4),
(88, 17, 4),
(89, 17, 4),
(90, 17, 4),
(91, 17, 4),
(92, 17, 4),
(93, 17, 4),
(94, 17, 4),
(95, 17, 4),
(96, 17, 4),
(97, 17, 4),
(98, 17, 4),
(99, 17, 4),
(100, 17, 4),
(101, 17, 4),
(102, 17, 4),
(103, 17, 4),
(104, 17, 4),
(105, 17, 4),
(106, 17, 4),
(107, 17, 4),
(108, 17, 4);

-- --------------------------------------------------------

--
-- Table structure for table `specs_params_text_val`
--

CREATE TABLE IF NOT EXISTS `specs_params_text_val` (
  `spec_id` mediumint(8) unsigned NOT NULL,
  `param_id` mediumint(8) unsigned NOT NULL,
  `param_text_val` text,
  KEY `spec_id` (`spec_id`),
  KEY `param_id` (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `specs_params_text_val`
--

INSERT INTO `specs_params_text_val` (`spec_id`, `param_id`, `param_text_val`) VALUES
(11, 10, 'Компания 4'),
(12, 10, 'Компания 2'),
(14, 3, 'описание 4'),
(25, 2, 'ТОРТ НАПОЛЕОН'),
(30, 10, 'Компания 1'),
(35, 10, 'Компания 5'),
(39, 10, 'Компания 2'),
(40, 10, 'Компания 2'),
(51, 2, 'test1'),
(52, 2, 'test1'),
(69, 2, 'test1'),
(71, 2, 'test1'),
(81, 2, 'test1'),
(82, 2, 'test1'),
(84, 2, 'test1'),
(85, 2, 'test1'),
(86, 2, 'test1'),
(87, 2, 'test1'),
(88, 2, 'test1'),
(89, 2, 'test1'),
(90, 2, 'test1'),
(91, 2, 'test1'),
(92, 2, 'test1'),
(93, 2, 'test1'),
(94, 2, 'test1'),
(95, 2, 'test1'),
(96, 2, 'test1'),
(97, 2, 'test1'),
(98, 2, 'test1'),
(99, 2, 'egdfgdfgdgf'),
(100, 2, 'dfgdfgdfgdfg'),
(101, 2, 'dfgdfgdfgdfg'),
(102, 2, 'dfgdfgdfgdfg'),
(103, 2, 'dfgdfgdfg'),
(104, 2, 'вапвапвапвап'),
(105, 2, 'вапвапвап'),
(106, 2, 'вапвапвап'),
(107, 2, 'парпр'),
(108, 2, 'dfgdfgdfg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_default_group` smallint(3) NOT NULL DEFAULT '3',
  `user_status_in_group` smallint(1) NOT NULL DEFAULT '1',
  `user_gender` smallint(1) NOT NULL,
  `user_login` varchar(20) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_phone` text NOT NULL,
  `user_avatar` varchar(100) NOT NULL,
  `user_date_add` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_date_edit` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_homepage` varchar(50) NOT NULL,
  `user_time_zone` varchar(200) NOT NULL DEFAULT 'Europe/Kiev',
  `user_status` smallint(1) NOT NULL DEFAULT '0',
  `users_key_activated` varchar(32) NOT NULL,
  `user_key_activated` varchar(32) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_default_group`, `user_status_in_group`, `user_gender`, `user_login`, `user_fullname`, `user_pass`, `user_email`, `user_phone`, `user_avatar`, `user_date_add`, `user_date_edit`, `user_homepage`, `user_time_zone`, `user_status`, `users_key_activated`, `user_key_activated`) VALUES
(1, 1, 1, 1, 'Ashterix', 'Ashterix', '378f210164d426d5e9c7ce96cd95c427', 'am@russianfood.com', '', '', '2013-07-31 21:00:00', '2013-07-31 21:00:00', '', 'Europe/Kiev', 1, '', ''),
(2, 1, 1, 1, 'mally', 'Кирилл Маляренко', '827ccb0eea8a706c4c34a16891f84e7b', 'kirillmalyarenko@derivo.com.ua', '06776676', '', '2013-09-30 21:00:00', '2014-02-23 13:45:42', '', 'Europe/Kiev', 1, '', ''),
(3, 5, 0, 1, 'Qtipowev', 'Христиан Кононов', '0a572ed38072baf89942e09f9adddf35', 'Qtipowev@sitemail.com', '345345345345', '', '2014-08-15 13:21:00', '2014-02-15 12:35:31', 'Qtipowev.net', 'Europe/Kiev', 1, '', ''),
(4, 2, 1, 0, 'Kowykut', 'Беата Леонардская', '0a572ed38072baf89942e09f9adddf35', 'Kowykut@site_mail.com', '', '', '2014-08-20 08:37:00', '2014-02-14 16:48:00', 'Kowykut.ua', 'Europe/Kiev', 1, '', ''),
(5, 4, 1, 1, 'Rcujeq', 'Фалалей Теодоров', '0a572ed38072baf89942e09f9adddf35', 'Rcujeq@site_mail.com', '', '', '2014-11-20 09:13:00', '2014-02-14 16:48:00', 'Rcujeq.net', 'Europe/Kiev', 1, '', ''),
(6, 4, 1, 1, 'Jpumi', 'Павел Адамский', '0a572ed38072baf89942e09f9adddf35', 'Jpumi@sitemail.com', '5645645645645', '', '2014-10-13 08:30:00', '2014-02-23 13:46:16', 'Jpumi.com', 'Europe/Kiev', 1, '', ''),
(7, 3, 1, 1, 'Myzwitm', 'Назарий Гавриилов', '0a572ed38072baf89942e09f9adddf35', 'Myzwitm@sitemail.com', '45455646456456', '', '2014-10-01 07:34:00', '2014-02-18 13:18:06', 'Myzwitm.ru', 'Europe/Kiev', 1, '', ''),
(8, 4, 1, 1, 'Xefyrem', 'Прокоп Климентский', '0a572ed38072baf89942e09f9adddf35', 'Xefyrem@site_mail.com', '', '', '2014-09-04 16:20:00', '2014-02-14 16:48:00', 'Xefyrem.ru', 'Europe/Kiev', 1, '', ''),
(9, 2, 1, 0, 'Tyscotis', 'Евампия Вавилаская', '0a572ed38072baf89942e09f9adddf35', 'Tyscotis@site_mail.com', '', '', '2014-09-20 17:17:00', '2014-02-14 16:49:00', 'Tyscotis.com', 'Europe/Kiev', 1, '', ''),
(10, 5, 1, 1, 'Tvupuft', 'Алексей Карпов', '0a572ed38072baf89942e09f9adddf35', 'Tvupuft@sitemail.com', '45645645645456', '', '2014-09-16 08:41:00', '2014-02-23 13:49:31', 'Tvupuft.ua', 'Europe/Kiev', 1, '', ''),
(11, 5, 1, 1, 'Cxuqam', 'Сармат Альбертский', '0a572ed38072baf89942e09f9adddf35', 'Cxuqam@site_mail.com', '', '', '2014-09-17 20:16:00', '2014-02-14 16:49:00', 'Cxuqam.ru', 'Europe/Kiev', 1, '', ''),
(12, 5, 1, 1, 'Xedyjyk', 'Пантелей Добрыняский', '0a572ed38072baf89942e09f9adddf35', 'Xedyjyk@site_mail.com', '', '', '2014-08-24 20:42:00', '2014-02-14 16:49:00', 'Xedyjyk.net', 'Europe/Kiev', 1, '', ''),
(13, 5, 1, 1, 'Vxynv', 'Ян Капитонов', '0a572ed38072baf89942e09f9adddf35', 'Vxynv@site_mail.com', '', '', '2014-08-20 07:15:00', '2014-02-14 16:49:00', 'Vxynv.net', 'Europe/Kiev', 1, '', ''),
(14, 5, 1, 0, 'Fapexx', 'Стелла Емельянова', '0a572ed38072baf89942e09f9adddf35', 'Fapexx@site_mail.com', '', '', '2014-09-06 20:50:00', '2014-02-14 16:49:00', 'Fapexx.ru', 'Europe/Kiev', 1, '', ''),
(15, 3, 1, 1, 'Gpizawsu', 'Архип Макарский', '0a572ed38072baf89942e09f9adddf35', 'Gpizawsu@site_mail.com', '', '', '2014-10-15 20:23:00', '2014-02-14 16:49:00', 'Gpizawsu.com', 'Europe/Kiev', 1, '', ''),
(16, 4, 1, 0, 'Felhur', 'Надежда Валентинская', '0a572ed38072baf89942e09f9adddf35', 'Felhur@site_mail.com', '', '', '2014-10-10 14:30:00', '2014-02-14 16:49:00', 'Felhur.net', 'Europe/Kiev', 1, '', ''),
(17, 4, 1, 1, 'Cekzic', 'Ратибор Серапионский', '0a572ed38072baf89942e09f9adddf35', 'Cekzic@site_mail.com', '', '', '2014-11-07 12:34:00', '2014-02-14 16:49:00', 'Cekzic.ua', 'Europe/Kiev', 1, '', ''),
(18, 3, 1, 1, 'Gqincuhv', 'Савел Егоренко', '0a572ed38072baf89942e09f9adddf35', 'Gqincuhv@site_mail.com', '', '', '2014-10-06 14:55:00', '2014-02-14 16:49:00', 'Gqincuhv.ru', 'Europe/Kiev', 1, '', ''),
(19, 2, 1, 1, 'Pubum', 'Фортунат Вильямов', '0a572ed38072baf89942e09f9adddf35', 'Pubum@site_mail.com', '', '', '2014-11-23 20:22:00', '2014-02-14 16:49:00', 'Pubum.net', 'Europe/Kiev', 1, '', ''),
(20, 3, 1, 1, 'Lzikocxi', 'Афиноген Силаский', '0a572ed38072baf89942e09f9adddf35', 'Lzikocxi@site_mail.com', '', '', '0000-00-00 00:00:00', '2014-02-14 16:49:00', 'Lzikocxi.ru', 'Europe/Kiev', 1, '', ''),
(21, 5, 1, 0, 'Pysxefge', 'Селина Адаменко', '0a572ed38072baf89942e09f9adddf35', 'Pysxefge@site_mail.com', '', '', '2014-09-22 15:16:00', '2014-02-14 16:49:00', 'Pysxefge.com', 'Europe/Kiev', 1, '', ''),
(22, 4, 1, 0, 'Nhacyn', 'Эмилия Артамоненко', '0a572ed38072baf89942e09f9adddf35', 'Nhacyn@site_mail.com', '', '', '2014-11-17 13:47:00', '2014-02-14 16:49:00', 'Nhacyn.ru', 'Europe/Kiev', 1, '', ''),
(23, 5, 1, 0, 'Xyvjo', 'Василиса Дорофейская', '0a572ed38072baf89942e09f9adddf35', 'Xyvjo@site_mail.com', '', '', '2014-11-13 08:29:00', '2014-02-14 16:49:00', 'Xyvjo.ua', 'Europe/Kiev', 1, '', ''),
(24, 5, 1, 1, 'Homfoxf', 'Марк Кондратский', '0a572ed38072baf89942e09f9adddf35', 'Homfoxf@site_mail.com', '', '', '2014-10-04 18:14:00', '2014-02-14 16:49:00', 'Homfoxf.com', 'Europe/Kiev', 1, '', ''),
(25, 5, 1, 0, 'Fekkog', 'Матильда Прокофийенко', '0a572ed38072baf89942e09f9adddf35', 'Fekkog@site_mail.com', '', '', '2014-11-04 17:46:00', '2014-02-14 16:49:00', 'Fekkog.ru', 'Europe/Kiev', 1, '', ''),
(26, 2, 1, 1, 'Xpume', 'Казимир Святополкенко', '0a572ed38072baf89942e09f9adddf35', 'Xpume@site_mail.com', '', '', '2014-11-13 08:59:00', '2014-02-14 16:49:00', 'Xpume.ua', 'Europe/Kiev', 1, '', ''),
(27, 5, 1, 1, 'Lacuw', 'Гурий Сидорский', '0a572ed38072baf89942e09f9adddf35', 'Lacuw@site_mail.com', '', '', '2014-08-17 08:56:00', '2014-02-14 16:49:00', 'Lacuw.net', 'Europe/Kiev', 1, '', ''),
(28, 5, 1, 0, 'Xagatjy', 'Земфира Осипская', '0a572ed38072baf89942e09f9adddf35', 'Xagatjy@site_mail.com', '', '', '2014-09-26 11:30:00', '2014-02-14 16:49:00', 'Xagatjy.ru', 'Europe/Kiev', 1, '', ''),
(29, 5, 1, 1, 'Glycv', 'Ермак Пахомский', '0a572ed38072baf89942e09f9adddf35', 'Glycv@site_mail.com', '', '', '2014-08-21 10:24:00', '2014-02-14 16:49:00', 'Glycv.com', 'Europe/Kiev', 1, '', ''),
(30, 2, 1, 0, 'Riwaw', 'Анисия Фадейская', '0a572ed38072baf89942e09f9adddf35', 'Riwaw@site_mail.com', '', '', '2014-09-28 12:19:00', '2014-02-14 16:49:00', 'Riwaw.ua', 'Europe/Kiev', 1, '', ''),
(31, 3, 1, 0, 'Syfbuhka', 'Марья Нифонтская', '0a572ed38072baf89942e09f9adddf35', 'Syfbuhka@site_mail.com', '', '', '2014-11-02 17:32:00', '2014-02-14 16:49:00', 'Syfbuhka.ua', 'Europe/Kiev', 1, '', ''),
(32, 2, 1, 1, 'Rdaleq', 'Всеслав Иакинфов', '0a572ed38072baf89942e09f9adddf35', 'Rdaleq@site_mail.com', '', '', '2014-10-11 13:46:00', '2014-02-14 16:49:00', 'Rdaleq.ua', 'Europe/Kiev', 1, '', ''),
(33, 2, 1, 1, 'Fahduvi', 'Алексей Спиридоненко', '0a572ed38072baf89942e09f9adddf35', 'Fahduvi@site_mail.com', '', '', '2014-11-22 11:47:00', '2014-02-14 16:49:00', 'Fahduvi.com', 'Europe/Kiev', 1, '', ''),
(34, 2, 1, 1, 'Jadfobja', 'Назарий Арсенийенко', '0a572ed38072baf89942e09f9adddf35', 'Jadfobja@site_mail.com', '', '', '2014-08-13 13:13:00', '2014-02-14 16:49:00', 'Jadfobja.net', 'Europe/Kiev', 1, '', ''),
(35, 5, 1, 1, 'Kxakuc', 'Ян Самсонский', '0a572ed38072baf89942e09f9adddf35', 'Kxakuc@site_mail.com', '', '', '2014-09-25 09:13:00', '2014-02-14 16:49:00', 'Kxakuc.net', 'Europe/Kiev', 1, '', ''),
(36, 2, 1, 0, 'Sujku', 'Ирина Климская', '0a572ed38072baf89942e09f9adddf35', 'Sujku@site_mail.com', '', '', '2014-09-17 12:31:00', '2014-02-14 16:49:00', 'Sujku.com', 'Europe/Kiev', 1, '', ''),
(37, 5, 1, 1, 'Cvigaj', 'Епифан Кондратийов', '0a572ed38072baf89942e09f9adddf35', 'Cvigaj@site_mail.com', '', '', '2014-11-23 12:28:00', '2014-02-14 16:49:00', 'Cvigaj.com', 'Europe/Kiev', 1, '', ''),
(38, 2, 1, 1, 'Jyhyzox', 'Северин Пётрский', '0a572ed38072baf89942e09f9adddf35', 'Jyhyzox@site_mail.com', '', '', '2014-10-27 10:10:00', '2014-02-14 16:49:00', 'Jyhyzox.com', 'Europe/Kiev', 1, '', ''),
(39, 5, 1, 1, 'Howfu', 'Северин Теодоров', '0a572ed38072baf89942e09f9adddf35', 'Howfu@site_mail.com', '', '', '2014-11-06 14:27:00', '2014-02-14 16:49:00', 'Howfu.com', 'Europe/Kiev', 1, '', ''),
(40, 5, 1, 1, 'Taqawjy', 'Никодим Пименский', '0a572ed38072baf89942e09f9adddf35', 'Taqawjy@site_mail.com', '', '', '2014-08-26 12:51:00', '2014-02-14 16:49:00', 'Taqawjy.ua', 'Europe/Kiev', 1, '', ''),
(41, 5, 1, 0, 'Hfudixva', 'Леонтина Илларионенко', '0a572ed38072baf89942e09f9adddf35', 'Hfudixva@site_mail.com', '', '', '2014-08-18 08:50:00', '2014-02-14 16:49:00', 'Hfudixva.com', 'Europe/Kiev', 1, '', ''),
(42, 5, 1, 1, 'Xariwix', 'Аристарх Феликсов', '0a572ed38072baf89942e09f9adddf35', 'Xariwix@site_mail.com', '', '', '2014-11-11 16:55:00', '2014-02-14 16:49:00', 'Xariwix.ua', 'Europe/Kiev', 1, '', ''),
(43, 5, 1, 1, 'Muxethyq', 'Парамон Денисский', '0a572ed38072baf89942e09f9adddf35', 'Muxethyq@site_mail.com', '', '', '2014-09-15 13:21:00', '2014-02-14 16:49:00', 'Muxethyq.ru', 'Europe/Kiev', 1, '', ''),
(44, 5, 1, 0, 'Daqoq', 'Мелания Константиненко', '0a572ed38072baf89942e09f9adddf35', 'Daqoq@site_mail.com', '', '', '2014-09-11 08:38:00', '2014-02-14 16:49:00', 'Daqoq.net', 'Europe/Kiev', 1, '', ''),
(45, 5, 1, 0, 'Digzuhix', 'Ефимия Семенова', '0a572ed38072baf89942e09f9adddf35', 'Digzuhix@site_mail.com', '', '', '2014-08-10 19:47:00', '2014-02-14 16:49:00', 'Digzuhix.ua', 'Europe/Kiev', 1, '', ''),
(46, 2, 1, 1, 'Gbyxwez', 'Конон Яковенко', '0a572ed38072baf89942e09f9adddf35', 'Gbyxwez@site_mail.com', '', '', '2014-09-22 15:35:00', '2014-02-14 16:49:00', 'Gbyxwez.ua', 'Europe/Kiev', 1, '', ''),
(47, 4, 1, 1, 'Mpicimyg', 'Мстислав Олимпов', '0a572ed38072baf89942e09f9adddf35', 'Mpicimyg@site_mail.com', '', '', '2014-11-13 08:23:00', '2014-02-14 16:49:00', 'Mpicimyg.com', 'Europe/Kiev', 1, '', ''),
(48, 2, 1, 1, 'Hapale', 'Святослав Прокофийский', '0a572ed38072baf89942e09f9adddf35', 'Hapale@site_mail.com', '', '', '2014-09-20 11:37:00', '2014-02-14 16:49:00', 'Hapale.ru', 'Europe/Kiev', 1, '', ''),
(49, 5, 1, 0, 'Canycdu', 'Луиза Валерийенко', '0a572ed38072baf89942e09f9adddf35', 'Canycdu@site_mail.com', '', '', '2014-08-09 10:38:00', '2014-02-14 16:49:00', 'Canycdu.com', 'Europe/Kiev', 1, '', ''),
(50, 2, 1, 0, 'Cgaxna', 'Мелания Демидова', '0a572ed38072baf89942e09f9adddf35', 'Cgaxna@site_mail.com', '', '', '2014-08-01 07:24:00', '2014-02-14 16:49:00', 'Cgaxna.ua', 'Europe/Kiev', 1, '', ''),
(51, 3, 1, 0, 'test11', 'dgdfgdfgsdfgsdfg', 'e10adc3949ba59abbe56e057f20f883e', 'dfds@dfgdgdfg.com', '345345345345', '', '2014-02-19 13:05:42', '2014-02-19 13:06:00', '', 'Europe/Kiev', 0, '', 'f36d0ead318b8a095b193f5ca71012d8');

-- --------------------------------------------------------

--
-- Table structure for table `users_cart`
--

CREATE TABLE IF NOT EXISTS `users_cart` (
  `cart_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `cart_user_id` mediumint(8) NOT NULL,
  `cart_owner_user_id` mediumint(8) NOT NULL,
  `cart_product_id` mediumint(8) NOT NULL,
  `cart_product_count` int(11) NOT NULL,
  `cart_status` smallint(1) NOT NULL DEFAULT '0',
  `cart_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `users_cart`
--

INSERT INTO `users_cart` (`cart_id`, `cart_user_id`, `cart_owner_user_id`, `cart_product_id`, `cart_product_count`, `cart_status`, `cart_date`) VALUES
(10, 6, 0, 0, 1, 0, '2013-12-12 14:04:02'),
(11, 6, 0, 0, 1, 0, '2013-12-12 14:04:08'),
(12, 6, 0, 0, 1, 0, '2013-12-12 14:06:04'),
(13, 6, 0, 0, 1, 0, '2013-12-12 14:07:11'),
(26, 0, 0, 0, 1, 0, '2013-12-13 17:01:52'),
(27, 0, 0, 0, 1, 0, '2013-12-13 17:02:30'),
(29, 2, 95, 55, 3, 1, '2014-02-07 13:32:29'),
(33, 6, 6, 23, 1, 1, '2014-01-29 12:49:41'),
(35, 3, 45, 50, 1, 1, '2014-02-13 12:45:16'),
(36, 3, 79, 76, 1, 1, '2014-02-13 12:47:23'),
(37, 3, 11, 46, 1, 1, '2014-02-13 12:59:22'),
(38, 4, 49, 28, 1, 1, '2014-02-14 11:16:23'),
(39, 4, 4, 6, 1, 1, '2014-02-14 11:16:30'),
(40, 5, 49, 28, 1, 1, '2014-02-14 16:50:03'),
(43, 51, 45, 50, 1, 1, '2014-02-13 12:34:30'),
(44, 6, 5, 32, 1, 1, '2014-02-20 08:51:51'),
(45, 10, 8, 32, 1, 1, '2014-02-23 14:20:27'),
(47, 2, 6, 19, 1, 1, '2014-04-12 19:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `users_cart_guests`
--

CREATE TABLE IF NOT EXISTS `users_cart_guests` (
  `cart_guest_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cart_guest_unique_key` varchar(35) NOT NULL,
  `cart_guest_owner_user_id` mediumint(8) NOT NULL,
  `cart_guest_product_id` mediumint(8) NOT NULL,
  `cart_guest_product_count` int(11) NOT NULL,
  `cart_guest_status` smallint(1) NOT NULL DEFAULT '0',
  `cart_guest_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_guest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_cart_guests`
--

INSERT INTO `users_cart_guests` (`cart_guest_id`, `cart_guest_unique_key`, `cart_guest_owner_user_id`, `cart_guest_product_id`, `cart_guest_product_count`, `cart_guest_status`, `cart_guest_date`) VALUES
(1, '249d4bcbd94028df8e892e3c3ebec60d', 8, 32, 1, 1, '2014-02-23 14:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `users_cash`
--

CREATE TABLE IF NOT EXISTS `users_cash` (
  `cash_id` bigint(10) NOT NULL AUTO_INCREMENT,
  `cash_user_id` mediumint(8) NOT NULL,
  `cash_action_user_id` mediumint(8) NOT NULL,
  `cash_count` int(11) NOT NULL,
  `cash_money_operations` varchar(10) NOT NULL,
  `cash_dop_info` text NOT NULL,
  `cash_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cash_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_full_data`
--

CREATE TABLE IF NOT EXISTS `users_full_data` (
  `user_id` mediumint(9) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_phone` text NOT NULL,
  `user_private_code` bigint(10) NOT NULL,
  `user_bank_fullname` varchar(100) NOT NULL,
  `user_bank_code` bigint(15) NOT NULL,
  `user_bank_mfo` int(6) NOT NULL,
  `user_bank_name` varchar(50) NOT NULL,
  `user_bank_rated_number` bigint(20) NOT NULL,
  `user_bank_card_number` bigint(16) NOT NULL,
  `user_taxes` smallint(2) NOT NULL,
  `user_delivery_region` varchar(250) DEFAULT NULL,
  `user_bank_contact_fullname` varchar(100) NOT NULL,
  `user_bank_contact_phone` text NOT NULL,
  `user_company_name` varchar(50) NOT NULL,
  `user_company_desc` text NOT NULL,
  `user_company_dop_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_full_data`
--

INSERT INTO `users_full_data` (`user_id`, `user_address`, `user_phone`, `user_private_code`, `user_bank_fullname`, `user_bank_code`, `user_bank_mfo`, `user_bank_name`, `user_bank_rated_number`, `user_bank_card_number`, `user_taxes`, `user_delivery_region`, `user_bank_contact_fullname`, `user_bank_contact_phone`, `user_company_name`, `user_company_desc`, `user_company_dop_info`) VALUES
(3, '', '', 2147483647, '34534535353453453453', 2147483647, 2147483647, 'Христиан Кононов', 2147483647, 0, 1, NULL, '', '', '', '', ''),
(6, 'Ул. Новой Надежды 14/5', '', 2147483647, '456456456456464646', 34341234, 2147483647, 'Павел Адамский', 456456, 0, 1, 'Кировоградская область', 'Павел Адамский', '465567567567567567567567', '', '', '<p>Ул. Новой Надежды 14/4</p>'),
(2, '', '', 0, '', 0, 0, '', 0, 0, 0, 'Одесская область', '', '', '', '', ''),
(10, '', '', 0, 'Fkmasdgf gdfgdfg', 2147483647, 2147483647, 'Алексей Карпов', 45565645, 0, 1, 'Ровенская область', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `us_group_id` smallint(3) NOT NULL AUTO_INCREMENT,
  `us_group_title` varchar(50) NOT NULL,
  `us_group_desc` text NOT NULL,
  `us_group_color` varchar(10) NOT NULL DEFAULT 'green',
  `us_group_prefix` varchar(50) NOT NULL,
  `us_group_sufix` varchar(20) NOT NULL,
  `us_group_status` smallint(2) NOT NULL,
  PRIMARY KEY (`us_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`us_group_id`, `us_group_title`, `us_group_desc`, `us_group_color`, `us_group_prefix`, `us_group_sufix`, `us_group_status`) VALUES
(1, 'us_group_title[1]', 'us_group_desc[1]', '#FFA500', '<b>', '</b>', 1),
(2, 'us_group_title[2]', 'us_group_desc[2]', '#FF0000', '<b>', '</b>', 1),
(3, 'us_group_title[3]', 'us_group_desc[3]', '#3399FF', '', '', 1),
(4, 'us_group_title[4]', 'us_group_desc[4]', '#00008B', '', '', 1),
(5, 'us_group_title[5]', 'us_group_desc[5]', '#00008B', '', '', 1),
(6, 'us_group_title[6]', 'us_group_desc[6]', '#000000', '<s>', '</s>', 1),
(7, 'us_group_title[7]', 'us_group_desc[7]', '#000000', '<s>', '</s>', 1),
(8, 'us_group_title[8]', 'us_group_desc[8]', '#000000', '<s>', '</s>', 1),
(9, 'us_group_title[9]', 'us_group_desc[9]', '#008B00', '<b>', '</b>', 1),
(10, 'us_group_title[10]', 'us_group_desc[10]', '#008B00', '<b>', '</b>', 1),
(11, 'us_group_title[11]', 'us_group_desc[11]', '#008B00', '<b>', '</b>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_group_users`
--

CREATE TABLE IF NOT EXISTS `users_group_users` (
  `us_group_id` smallint(3) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `in_g_temporarily` smallint(1) NOT NULL DEFAULT '0',
  `in_g_added_user_id` mediumint(9) NOT NULL,
  `in_g_date_added` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `in_g_date_exclusion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_group_users`
--

INSERT INTO `users_group_users` (`us_group_id`, `user_id`, `in_g_temporarily`, `in_g_added_user_id`, `in_g_date_added`, `in_g_date_exclusion`) VALUES
(7, 4, 1, 1, '2014-08-20 08:37:00', '2014-02-15 16:48:00'),
(5, 6, 0, 1, '2014-10-13 08:30:00', '0000-00-00 00:00:00'),
(9, 7, 0, 1, '2014-10-01 07:34:00', '0000-00-00 00:00:00'),
(7, 8, 1, 1, '2014-09-04 16:20:00', '2014-02-15 16:49:00'),
(6, 9, 1, 1, '2014-09-20 17:17:00', '2014-02-15 16:49:00'),
(9, 12, 0, 1, '2014-08-24 20:42:00', '0000-00-00 00:00:00'),
(9, 14, 0, 1, '2014-09-06 20:50:00', '0000-00-00 00:00:00'),
(10, 16, 0, 1, '2014-10-10 14:30:00', '0000-00-00 00:00:00'),
(9, 17, 0, 1, '2014-11-07 12:34:00', '0000-00-00 00:00:00'),
(5, 19, 0, 1, '2014-11-23 20:22:00', '0000-00-00 00:00:00'),
(7, 20, 1, 1, '0000-00-00 00:00:00', '2014-02-15 16:49:00'),
(4, 21, 0, 1, '2014-09-22 15:16:00', '0000-00-00 00:00:00'),
(4, 22, 0, 1, '2014-11-17 13:47:00', '0000-00-00 00:00:00'),
(9, 23, 0, 1, '2014-11-13 08:29:00', '0000-00-00 00:00:00'),
(9, 26, 0, 1, '2014-11-13 08:59:00', '0000-00-00 00:00:00'),
(9, 28, 0, 1, '2014-09-26 11:30:00', '0000-00-00 00:00:00'),
(6, 32, 1, 1, '2014-10-11 13:46:00', '2014-02-15 16:49:00'),
(6, 34, 1, 1, '2014-08-13 13:13:00', '2014-02-15 16:49:00'),
(5, 40, 0, 1, '2014-08-26 12:51:00', '0000-00-00 00:00:00'),
(10, 41, 0, 1, '2014-08-18 08:50:00', '0000-00-00 00:00:00'),
(4, 42, 0, 1, '2014-11-11 16:55:00', '0000-00-00 00:00:00'),
(4, 43, 0, 1, '2014-09-15 13:21:00', '0000-00-00 00:00:00'),
(4, 45, 0, 1, '2014-08-10 19:47:00', '0000-00-00 00:00:00'),
(9, 46, 0, 1, '2014-09-22 15:35:00', '0000-00-00 00:00:00'),
(4, 47, 0, 1, '2014-11-13 08:23:00', '0000-00-00 00:00:00'),
(9, 50, 0, 1, '2014-08-01 07:24:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users_likes`
--

CREATE TABLE IF NOT EXISTS `users_likes` (
  `like_user_id` mediumint(8) NOT NULL,
  `like_type` smallint(1) NOT NULL DEFAULT '1',
  `like_item_id` mediumint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `ses_user_id` mediumint(9) NOT NULL,
  `ses_key` varchar(32) NOT NULL,
  `ses_user_ip` int(10) NOT NULL,
  `ses_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`ses_user_id`, `ses_key`, `ses_user_ip`, `ses_time`) VALUES
(2, '2458665c6ea3fe422c7a02c11bf9ca5f', 2130706433, '2014-04-13 18:29:42'),
(2, '63febc6aca8b107a81c82bf3500529b6', 2130706433, '2014-04-13 18:33:51'),
(2, 'c82d737140ddc361a10c6fb6b67b6ec2', 2130706433, '2014-04-13 18:48:07'),
(2, '2366ef66596ba58ac57c8f1f781b8f67', 2130706433, '2014-04-14 04:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `users_subscribe`
--

CREATE TABLE IF NOT EXISTS `users_subscribe` (
  `subscr_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `subscr_user_id` mediumint(8) NOT NULL,
  `subscr_status` smallint(1) NOT NULL DEFAULT '1',
  `subscr_date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users_subscribe`
--

INSERT INTO `users_subscribe` (`subscr_id`, `subscr_user_id`, `subscr_status`, `subscr_date_add`) VALUES
(12, 103, 0, '2014-02-05 14:20:26'),
(13, 2, 1, '2014-02-07 10:43:41'),
(14, 104, 1, '2014-02-07 14:24:13'),
(15, 6, 0, '2014-02-08 13:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_taxes_system`
--

CREATE TABLE IF NOT EXISTS `users_taxes_system` (
  `taxes_id` smallint(2) NOT NULL AUTO_INCREMENT,
  `taxes_title` varchar(50) NOT NULL,
  `taxes_desc` text NOT NULL,
  `taxes_status` smallint(2) NOT NULL,
  PRIMARY KEY (`taxes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_taxes_system`
--

INSERT INTO `users_taxes_system` (`taxes_id`, `taxes_title`, `taxes_desc`, `taxes_status`) VALUES
(1, 'taxes_title[1]', '', 1),
(2, 'taxes_title[2]', '', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `params_groups_params`
--
ALTER TABLE `params_groups_params`
  ADD CONSTRAINT `fk_params_groups_params_params1111` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_params_groups_params_params_groups1111` FOREIGN KEY (`params_group_id`) REFERENCES `params_groups` (`params_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `params_options`
--
ALTER TABLE `params_options`
  ADD CONSTRAINT `fk_params_options_params1111` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products_specs`
--
ALTER TABLE `products_specs`
  ADD CONSTRAINT `obj1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `specs_params_files`
--
ALTER TABLE `specs_params_files`
  ADD CONSTRAINT `fk_objects_params_options_params100001110` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `specs_params_number_val`
--
ALTER TABLE `specs_params_number_val`
  ADD CONSTRAINT `fk_objects_params_options_params100111` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `specs_params_options`
--
ALTER TABLE `specs_params_options`
  ADD CONSTRAINT `fk_objects_params_options_params1111` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_objects_params_options_params_options1111` FOREIGN KEY (`option_id`) REFERENCES `params_options` (`option_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `specs_params_text_val`
--
ALTER TABLE `specs_params_text_val`
  ADD CONSTRAINT `fk_objects_params_options_params10000111` FOREIGN KEY (`param_id`) REFERENCES `params` (`param_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
