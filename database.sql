-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 11:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `divine_vines`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) DEFAULT 1,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiries`
--

CREATE TABLE `contact_enquiries` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `message` text NOT NULL,
  `replied` enum('Replied','Not Replied') NOT NULL DEFAULT 'Not Replied',
  `date_sent` datetime NOT NULL DEFAULT current_timestamp(),
  `view_status` enum('not_viewed','viewed') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'not_viewed' COMMENT 'Tracks whether contact has been viewed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_enquiries`
--

INSERT INTO `contact_enquiries` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `message`, `replied`, `date_sent`, `view_status`) VALUES
(1, 'Alice', 'Smith', 'alice.smith@example.com', '0412345678', 'Interested in your wine tasting events.', 'Not Replied', '2025-05-15 14:32:00', 'not_viewed'),
(2, 'Bob', 'Jones', 'bob.jones@example.com', '0400111222', 'Can you ship to regional NSW?', 'Replied', '2025-05-14 09:12:00', 'viewed'),
(3, 'Cathy', 'Brown', 'cathy.brown@example.com', '0433987654', 'I’d like to book a private tour.', 'Not Replied', '2025-05-16 11:45:00', 'viewed'),
(4, 'David', 'Lee', 'david.lee@example.com', '0422123456', 'Do you offer gift vouchers?', 'Replied', '2025-05-13 16:05:00', 'viewed'),
(5, 'Ella', 'Nguyen', 'ella.nguyen@example.com', '0455667788', 'Are your wines vegan-friendly?', 'Not Replied', '2025-05-17 10:20:00', 'not_viewed'),
(6, 'Frank', 'White', 'frank.white@example.com', '0499887766', 'Having trouble ordering online.', 'Replied', '2025-05-12 08:55:00', 'viewed'),
(7, 'Grace', 'Taylor', 'grace.taylor@example.com', '0400333444', 'Do you offer bulk discounts for weddings?', 'Not Replied', '2025-05-18 13:00:00', 'not_viewed'),
(8, 'Henry', 'O’Connor', 'henry.oconnor@example.com', '0411223344', 'Where are your cellar doors located?', 'Replied', '2025-05-10 17:30:00', 'viewed'),
(9, 'Isla', 'Murphy', 'isla.murphy@example.com', '0400123987', 'Can I visit your vineyard this weekend?', 'Not Replied', '2025-05-18 15:47:00', 'not_viewed'),
(10, 'Jack', 'Wilson', 'jack.wilson@example.com', '0411567890', 'Do you offer wine subscriptions?', 'Replied', '2025-05-17 09:30:00', 'viewed'),
(11, 'Karen', 'Tran', 'karen.tran@example.com', '0455001122', 'Is your venue wheelchair accessible?', 'Not Replied', '2025-05-19 12:22:00', 'not_viewed'),
(12, 'Leo', 'Martin', 'leo.martin@example.com', '0422778899', 'Looking for wine pairing advice.', 'Replied', '2025-05-16 18:05:00', 'viewed'),
(13, 'Mia', 'Davies', 'mia.davies@example.com', '0433111222', 'Where can I find your premium range?', 'Not Replied', '2025-05-20 11:11:00', 'viewed'),
(14, 'Noah', 'Patel', 'noah.patel@example.com', '0400999888', 'Please remove me from the mailing list.', 'Replied', '2025-05-14 08:20:00', 'viewed'),
(15, 'Olivia', 'Wong', 'olivia.wong@example.com', '0466778899', 'Interested in becoming a distributor.', 'Not Replied', '2025-05-19 16:40:00', 'not_viewed'),
(16, 'Paul', 'Green', 'paul.green@example.com', '0488333777', 'Any events scheduled for next month?', 'Not Replied', '2025-05-21 10:00:00', 'not_viewed'),
(17, 'Quinn', 'Cooper', 'quinn.cooper@example.com', '0411999777', 'I never received my order confirmation.', 'Replied', '2025-05-15 13:55:00', 'viewed'),
(18, 'Ruby', 'Scott', 'ruby.scott@example.com', '0422999888', 'Do you offer international shipping?', 'Replied', '2025-05-20 14:15:00', 'viewed');

-- --------------------------------------------------------

--
-- Table structure for table `content_blocks`
--

CREATE TABLE `content_blocks` (
  `id` int(11) NOT NULL,
  `parent` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `value` text DEFAULT NULL,
  `previous_value` text DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_blocks`
--

INSERT INTO `content_blocks` (`id`, `parent`, `slug`, `label`, `description`, `type`, `value`, `previous_value`, `modified`) VALUES
(1, 'global', 'website-title', 'Website Title', 'Shown on tabs in the users browser.', 'text', 'Divine Vines - Australian Wide Delivery', 'empty testing', '2025-05-13 07:30:26'),
(2, 'global', 'logo', 'Logo', 'Shown in the centre of the home page, and also in the top corner of all administration pages.', 'image', '/content-blocks/uploads/logo.f4b0a22cd1e05324460e3e9acaf30458.ico', '/content-blocks/uploads/logo.835b71c50a7817642c9c7a69fb0317f8.png', '2025-05-12 17:25:54'),
(3, 'home', 'home-business-name', 'Home Page Business Name', 'Displayed business name on home page', 'html', 'Divine Vines', 'Divine Vines', '2025-05-13 08:13:51'),
(4, 'home', 'copyright-message', 'Copyright Message', 'Copyright information shown at the bottom of the home page.', 'text', 'Divine Vines. All Rights Reserved.', 'Divine Vines. All Rights Reserved. Testin', '2025-05-13 08:13:29'),
(5, 'contact-us', 'contact-us-message', 'Contact us message', 'The message displayed on the contact us page.', 'text', 'Complete the form below to contact the team at Divine Vines', NULL, '2025-05-13 08:22:58'),
(6, 'home', 'home-display-message', 'Home Page Display Message', 'Displayed message on home page', 'text', 'ELEVATE YOUR COLLECTION TODAY', NULL, '2025-05-13 08:18:06'),
(7, 'contact-us', 'contact-us-title', 'Contact us title', 'The title displayed on the contact us page.', 'text', 'Contact Us', NULL, '2025-05-13 13:43:49'),
(8, 'global', 'instagram-link', 'Instagram link', 'Link connects to Instagram account page', 'html', '/', 'https://www.instagram.com/mingi.k.0303?igsh=bWFzM3dyZ2Yxbm8x', '2025-05-14 14:12:52'),
(9, 'global', 'facebook-link', 'Facebook link', 'Link connects to Facebook account page', 'html', '/', NULL, '2025-05-14 14:14:51'),
(10, 'global', 'twitter-link', 'Twitter link', 'Link connects to Twitter account page', 'html', '/', NULL, '2025-05-14 14:15:17'),
(11, 'about', 'about-header', 'About header', 'The title displayed on the about us page.', 'text', 'Our Story', NULL, '2025-05-14 16:16:42'),
(12, 'about', 'about-header-message', 'About header message', 'The header message displayed on the about us page.', 'text', 'Discover the passion behind Divine Vines and our commitment to bringing you the finest wines from around the world.', NULL, '2025-05-14 16:19:26'),
(13, 'about', 'about-body-title', 'About body title', 'The body title displayed on the about us page.', 'text', 'Our Mission', NULL, '2025-05-14 16:39:02'),
(14, 'about', 'about-body-message', 'About body message', 'The body message displayed on the about us page.', 'text', 'At Divine Vines, we believe that exceptional wine should be accessible to everyone. We curate a collection of the world\'s finest wines, combining traditional craftsmanship and modern innovation.', NULL, '2025-05-14 16:39:08'),
(15, 'about', 'about-body-first-bullet', 'About body first bullet', 'The body first bullet displayed on the about us page.', 'text', 'Quality First', NULL, '2025-05-14 16:39:14'),
(16, 'about', 'about-body-first-bullet-message', 'About body first bullet message', 'The body first bullet message displayed on the about us page.', 'text', 'Carefully selected for quality and character.', NULL, '2025-05-14 16:39:25'),
(17, 'about', 'about-body-second-bullet', 'About body second bullet', 'The body second bullet displayed on the about us page.', 'text', 'Global Selection', NULL, '2025-05-14 16:40:42'),
(18, 'about', 'about-body-second-bullet-message', 'About body second bullet message', 'The body second bullet message displayed on the about us page.', 'text', 'From renowned regions to hidden gems.', NULL, '2025-05-14 16:40:44'),
(19, 'about', 'about-footer-title', 'About footer title', 'The footer title displayed on the about us page.', 'text', 'Our Values', NULL, '2025-05-14 16:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `content_blocks_phinxlog`
--

CREATE TABLE `content_blocks_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_blocks_phinxlog`
--

INSERT INTO `content_blocks_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20230402063959, 'ContentBlocksMigration', '2025-05-06 12:16:24', '2025-05-06 12:16:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `min_purchase_amount` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `times_used` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`coupon_id`, `discount_amount`, `coupon_code`, `user_id`, `expiry_date`, `is_active`, `min_purchase_amount`, `max_discount_amount`, `usage_limit`, `times_used`, `created`, `modified`) VALUES
(2, 10.00, 'SAVE10', 14, '2025-06-30 00:00:00', 1, 50.00, 10.00, 1, 0, '2025-05-01 10:00:00', '2025-05-01 10:00:00'),
(3, 15.00, 'WELCOME15', 15, '2025-07-15 00:00:00', 1, 75.00, 15.00, 1, 0, '2025-05-02 11:30:00', '2025-05-02 11:30:00'),
(4, 5.00, 'SPRING5', 20, '2025-06-01 00:00:00', 0, 30.00, 5.00, 3, 3, '2025-04-15 09:45:00', '2025-05-10 08:00:00'),
(5, 20.00, 'BIGSAVE20', 15, '2025-08-31 00:00:00', 1, 100.00, 20.00, 2, 1, '2025-05-03 12:00:00', '2025-05-17 14:00:00'),
(6, 12.00, 'FLASH12', 14, '2025-06-10 00:00:00', 1, 60.00, 12.00, 1, 0, '2025-05-05 09:00:00', '2025-05-05 09:00:00'),
(7, 8.00, 'WEEKEND8', 14, '2025-07-01 00:00:00', 1, 40.00, 8.00, 2, 1, '2025-05-07 14:30:00', '2025-05-14 13:00:00'),
(8, 25.00, 'SUMMER25', 20, '2025-09-01 00:00:00', 1, 120.00, 25.00, 1, 0, '2025-05-08 16:15:00', '2025-05-08 16:15:00'),
(9, 6.00, 'MAY6OFF', 20, '2025-05-31 00:00:00', 0, 35.00, 6.00, 1, 1, '2025-05-01 08:20:00', '2025-05-21 10:00:00'),
(18, 15.00, 'BDAYB5D031', 14, '1970-09-23 23:59:59', 1, 50.00, 100.00, 1, 0, '2025-05-14 12:52:56', '2025-05-14 12:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subheading` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `modified_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_published` datetime DEFAULT NULL,
  `status` enum('published','unpublished') DEFAULT 'unpublished',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `title`, `subheading`, `body`, `image`, `modified_at`, `date_published`, `status`, `created_at`) VALUES
(1, 'Cellar Notes', 'Exploring Autumn Reds', 'This issue dives into the bold reds perfect for cooler evenings, highlighting regional favorites and cellar tips.', 'Newsletters/1747819927_1745128546headersample.png', '2025-05-21 09:32:07', '2025-05-10 12:00:00', 'unpublished', '2025-05-08 10:00:00'),
(2, 'Cellar Notes', 'Spring Refreshers', 'We feature crisp whites and rosés to lighten up your spring gatherings.', 'Newsletters/1747819948_samplepopup.jpg', '2025-05-21 09:32:28', '2025-04-15 08:00:00', 'unpublished', '2025-04-10 07:30:00'),
(3, 'Cellar Notes', 'Meet the Winemaker', 'An exclusive interview with our head vintner, sharing secrets behind the latest blends.', 'Newsletters/1747819968_header.webp', '2025-05-21 09:33:30', '2025-05-21 09:33:30', 'published', '2025-03-15 12:45:00'),
(4, 'Cellar Notes', 'Pairing Guide Special', 'Your go-to guide for pairing wines with cheese, seafood, and desserts.', 'Newsletters/1747819996_contactbanner.jpg', '2025-05-21 09:33:16', '2025-02-25 09:00:00', 'unpublished', '2025-02-20 08:00:00'),
(5, 'Cellar Notes', 'Have you heard? Divine Vines Newly Released Wine! ', 'Step into the heart of the vineyard, where time slows and every grape tells a story. This season, we celebrate the beauty of bold reds and crisp whites, handpicked under the golden hues of autumn. Whether you\'re savoring a velvety Shiraz or a refreshing Chardonnay, let each glass be a journey of refinement and pleasure.\r\n \r\nDid you know that wine aging isn’t just about years—it’s about harmony? Tannins soften, acidity mellows, and new aromas emerge over time. In this edition, we explore how aging impacts different varietals and offer tips for proper cellaring at home.', 'newsletters/1747214403_1744714327sample2.jpeg', '2025-05-21 09:33:27', '2025-05-14 15:58:02', 'unpublished', '2025-05-14 09:20:03'),
(6, 'Cellar Notes', 'Have you heard? Divine Vines Newly Released Wine! ', 'Nestled in the heart of wine country, our family-owned winery blends tradition with innovation to produce wines of exceptional character. For over two decades, we have cultivated our vineyards with care, using sustainable practices to respect the land and preserve its richness for generations to come. Our passion for winemaking is reflected in every bottle, crafted to bring people together and celebrate life’s finest moments.', 'newsletters/1747231131_1744865631floweer.jpeg', '2025-05-14 15:57:47', '2025-05-14 15:57:04', 'unpublished', '2025-05-14 13:58:51'),
(7, 'Cellar Notes', 'Vintage Year in Review', 'A look back at standout vintages, sales trends, and what’s aging best in our cellar.', NULL, '2025-01-10 11:45:00', '2025-01-12 10:30:00', 'unpublished', '2025-01-08 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `shipping_name` varchar(100) NOT NULL COMMENT 'Receipient name (might not be user)',
  `shipping_address1` varchar(255) NOT NULL,
  `shipping_address2` varchar(255) DEFAULT NULL COMMENT 'Apartment, suite/ house no.',
  `shipping_city` varchar(100) NOT NULL,
  `shipping_state` varchar(100) NOT NULL,
  `shipping_postcode` varchar(10) NOT NULL,
  `shipping_country` varchar(100) DEFAULT 'Australia',
  `shipping_cost` decimal(10,2) DEFAULT 0.00,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `coupon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `created`, `modified`, `shipping_name`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_postcode`, `shipping_country`, `shipping_cost`, `status`, `coupon_id`) VALUES
(132, 14, 156.35, '2025-05-21 14:10:54', '2025-05-22 00:23:10', 'Emily Waters', '\'123 Vine Street', 'Apt 5B', 'Melbourne', 'Victoria', '3000', 'AU', 23.45, 'pending', NULL),
(133, 20, 130.95, '2025-05-21 14:13:17', '2025-05-21 14:13:17', 'Laura Chen', '55 Wine Road', 'Suite 204', 'Brisbane', 'Queensland', '4000', 'AU', 23.45, 'pending', NULL),
(134, 16, 68.45, '2025-05-21 14:15:24', '2025-05-22 00:23:19', 'Luke Evans', '102 Vineyard Dr', '', 'Hobart', 'Tasmania', '7000', 'AU', 23.45, 'pending', NULL),
(135, 14, 212.00, '2025-05-21 14:18:49', '2025-05-22 00:46:42', 'Jean Dupont', '12 Rue Lafayette', '', 'Paris', 'Île-de-France', '75009', 'FR', 140.60, 'pending', NULL),
(136, 22, 203.75, '2025-05-21 14:21:31', '2025-05-22 00:23:42', 'Zhang Wei', '88 Nanjing Road', '', 'Shanghai', 'Shanghai', '200003', 'CN', 129.05, 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(132, 2, 1, 19.90),
(132, 8, 2, 31.60),
(132, 9, 2, 24.90),
(133, 4, 2, 35.00),
(133, 5, 2, 18.75),
(134, 3, 2, 22.50),
(135, 2, 2, 19.90),
(135, 8, 1, 31.60),
(136, 9, 3, 24.90);

-- --------------------------------------------------------

--
-- Table structure for table `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0 CHECK (`stock_quantity` >= 0),
  `price` decimal(10,2) NOT NULL CHECK (`price` > 0),
  `vintage` year(4) DEFAULT NULL,
  `alcohol_content` decimal(4,2) DEFAULT NULL COMMENT 'Alcohol percentage (e.g., 13.50)',
  `status` varchar(20) NOT NULL COMMENT 'Listed/Unlisted',
  `region` varchar(50) NOT NULL COMMENT 'Geographical origin',
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `volume` decimal(5,3) NOT NULL DEFAULT 0.750 COMMENT 'Volume in liters',
  `brand` varchar(100) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `total_sold` int(11) DEFAULT 0,
  `wine_style_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `stock_quantity`, `price`, `vintage`, `alcohol_content`, `status`, `region`, `image`, `created_at`, `updated_at`, `volume`, `brand`, `product_description`, `total_sold`, `wine_style_id`) VALUES
(1, 'Estate Shiraz Reserve', 120, 29.95, '2021', 14.50, 'Listed', 'Barossa Valley', 'products/1747819124_1744368534sample.jpg', '2025-04-15 10:30:00', '2025-05-21 19:19:49', 0.750, 'Red Oak Vineyards', 'A bold Shiraz with notes of plum, black pepper, and oak.', 120, 1),
(2, 'Summer Rosé Blend', 82, 19.90, '2023', 12.00, 'Listed', 'Yarra Valley', 'products/1747819583_17478192141744714327sample2.jpeg', '2025-04-18 14:00:00', '2025-05-21 14:18:49', 0.750, 'Rosewood Estate', 'Light and refreshing, perfect for warm evenings.', 213, 2),
(3, 'Classic Chardonnay', 148, 22.50, '2022', 13.00, 'Listed', 'Hunter Valley', 'products/1747819096_1744714327sample2.jpeg', '2025-04-20 11:45:00', '2025-05-21 14:15:24', 0.750, 'Golden Hills Winery', 'Buttery and smooth with hints of vanilla and citrus.', 412, 3),
(4, 'Vintage Cabernet Sauvignon', 63, 35.00, '2019', 14.80, 'Listed', 'Coonawarra', 'products/1747819597_174781954317448058061744607329sample1.jpeg', '2025-04-25 12:30:00', '2025-05-21 14:13:17', 0.750, 'Crimson Crest', 'Rich tannins and dark fruit aroma. Aged in French oak.', 160, 1),
(5, 'Sparkling Brut', 198, 18.75, '2023', 11.50, 'Listed', 'Tamar Valley', 'products/1747819259_1744607329sample1.jpeg', '2025-04-10 09:15:00', '2025-05-21 14:13:17', 0.750, 'Silver Ridge', 'Crisp and dry sparkling wine with lively bubbles.', 300, 4),
(6, 'Heritage Merlot', 0, 27.00, '2020', 13.70, 'Unlisted', 'Margaret River', 'products/1747819281_1744714327sample2.jpeg', '2025-04-22 10:05:00', '2025-05-21 09:27:15', 0.750, 'Ocean Crest Wines', 'Smooth and medium-bodied with red berry notes.', 90, 1),
(7, 'Golden Harvest Dessert Wine', 7, 42.00, '2021', 15.50, 'Listed', 'Clare Valley', 'products/1747819214_1744714327sample2.jpeg', '2025-04-12 13:50:00', '2025-05-21 09:26:58', 0.375, 'Sunvale Cellars', 'Lusciously sweet with honey and apricot aromas.', 74, 5),
(8, 'Reserve Pinot Noir', 92, 31.60, '2022', 13.20, 'Listed', 'Mornington Peninsula', 'products/1747819566_1744714327sample2.jpeg', '2025-04-27 16:40:00', '2025-05-21 14:18:49', 0.750, 'Frostwood Wines', 'Elegant and earthy with red cherry and spice.', 189, 1),
(9, 'Organic Sauvignon Blanc', 105, 24.90, '2023', 12.80, 'Listed', 'Adelaide Hills', 'products/1747819555_17478192811744714327sample2.jpeg', '2025-04-19 15:10:00', '2025-05-21 14:21:31', 0.750, 'Green Grove', 'Zesty and vibrant with tropical fruit aromas.', 227, 3),
(10, 'Mulberry Creek Shiraz', 0, 21.45, '2021', 14.20, 'Unlisted', 'McLaren Vale', 'products/1747819543_17448058061744607329sample1.jpeg', '2025-04-14 11:25:00', '2025-05-21 09:27:41', 0.750, 'Mulberry Creek Estate', 'Juicy and peppery with a smooth finish.', 103, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review_text`, `created`, `modified`, `status`) VALUES
(1, 14, 1, 5, 'Absolutely loved this product!', '2025-05-01 12:34:00', '2025-05-01 12:34:00', 'approved'),
(2, 15, 2, 4, 'Very good quality and fast delivery.', '2025-05-02 09:20:00', '2025-05-02 09:20:00', 'approved'),
(3, 16, 3, 3, 'It was okay, not what I expected.', '2025-05-03 14:05:00', '2025-05-03 14:05:00', 'rejected'),
(4, 20, 4, 2, 'Disappointed with the packaging.', '2025-05-04 10:15:00', '2025-05-04 10:15:00', 'pending'),
(5, 22, 5, 1, 'Poor quality, not recommended.', '2025-05-05 17:45:00', '2025-05-05 17:45:00', 'rejected'),
(6, 14, 6, 4, 'Pretty good, would buy again.', '2025-05-06 13:22:00', '2025-05-06 13:22:00', 'approved'),
(7, 15, 7, 5, 'Exceeded my expectations!', '2025-05-07 15:00:00', '2025-05-07 15:00:00', 'approved'),
(8, 16, 8, 3, 'Average product, nothing special.', '2025-05-08 08:30:00', '2025-05-08 08:30:00', 'pending'),
(9, 20, 9, 4, 'Not too bad.', '2025-05-09 11:11:00', '2025-05-09 11:11:00', 'pending'),
(10, 22, 10, 5, 'Perfect in every way!', '2025-05-10 19:05:00', '2025-05-10 19:05:00', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_countries`
--

CREATE TABLE `shipping_countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(37) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shipping_countries`
--

INSERT INTO `shipping_countries` (`id`, `country_name`, `country_code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Albania', 'AL'),
(3, 'Algeria', 'DZ'),
(4, 'Andorra', 'AD'),
(5, 'Angola', 'AO'),
(6, 'Anguilla', 'AI'),
(7, 'Argentina', 'AR'),
(8, 'Armenia', 'AM'),
(9, 'Aruba', 'AW'),
(10, 'Australia', 'AU'),
(11, 'Austria', 'AT'),
(12, 'Azerbaijan', 'AZ'),
(13, 'Bahamas', 'BS'),
(14, 'Bahrain', 'BH'),
(15, 'Bangladesh', 'BD'),
(16, 'Barbados', 'BB'),
(17, 'Belarus', 'BY'),
(18, 'Belgium', 'BE'),
(19, 'Belize', 'BZ'),
(20, 'Benin', 'BJ'),
(21, 'Bermuda', 'BM'),
(22, 'Bhutan', 'BT'),
(23, 'Bolivia', 'BO'),
(24, 'Bosnia and Herzegovina', 'BA'),
(25, 'Botswana', 'BW'),
(26, 'Brazil', 'BR'),
(27, 'British Virgin Islands', 'VG'),
(28, 'Bulgaria', 'BG'),
(29, 'Burkina Faso', 'BF'),
(30, 'Burundi', 'BI'),
(31, 'Cambodia', 'KH'),
(32, 'Cameroon', 'CM'),
(33, 'Canada', 'CA'),
(34, 'Central African Republic', 'CF'),
(35, 'Chile', 'CL'),
(36, 'China', 'CN'),
(37, 'Colombia', 'CO'),
(38, 'Comoros', 'KM'),
(39, 'Congo, the Democratic Republic of the', 'CD'),
(40, 'Cook Islands', 'CK'),
(41, 'Costa Rica', 'CR'),
(42, 'Croatia', 'HR'),
(43, 'Cyprus', 'CY'),
(44, 'Czech Republic', 'CZ'),
(45, 'Denmark', 'DK'),
(46, 'Dominican Republic', 'DO'),
(47, 'Egypt', 'EG'),
(48, 'El Salvador', 'SV'),
(49, 'Equatorial Guinea', 'GQ'),
(50, 'Eritrea', 'ER'),
(51, 'Estonia', 'EE'),
(52, 'Eswatini', 'SZ'),
(53, 'Ethiopia', 'ET'),
(54, 'Falkland Islands (Malvinas)', 'FK'),
(55, 'Faroe Islands', 'FO'),
(56, 'Fiji', 'FJ'),
(57, 'Finland', 'FI'),
(58, 'France', 'FR'),
(59, 'Gabon', 'GA'),
(60, 'Gambia', 'GM'),
(61, 'Georgia', 'GE'),
(62, 'Germany', 'DE'),
(63, 'Ghana', 'GH'),
(64, 'Gibraltar', 'GI'),
(65, 'Greece', 'GR'),
(66, 'Greenland', 'GL'),
(67, 'Guernsey', 'GG'),
(68, 'Guinea', 'GN'),
(69, 'Guinea-Bissau', 'GW'),
(70, 'Hong Kong', 'HK'),
(71, 'Hungary', 'HU'),
(72, 'Iceland', 'IS'),
(73, 'India', 'IN'),
(74, 'Indonesia', 'ID'),
(75, 'Ireland', 'IE'),
(76, 'Italy', 'IT'),
(77, 'Jamaica', 'JM'),
(78, 'Japan', 'JP'),
(79, 'Jersey', 'JE'),
(80, 'Jordan', 'JO'),
(81, 'Kazakhstan', 'KZ'),
(82, 'Kenya', 'KE'),
(83, 'Kiribati', 'KI'),
(84, 'Kuwait', 'KW'),
(85, 'Kyrgyzstan', 'KG'),
(86, 'Laos', 'LA'),
(87, 'Latvia', 'LV'),
(88, 'Lebanon', 'LB'),
(89, 'Lesotho', 'LS'),
(90, 'Liberia', 'LR'),
(91, 'Libya', 'LY'),
(92, 'Liechtenstein', 'LI'),
(93, 'Lithuania', 'LT'),
(94, 'Luxembourg', 'LU'),
(95, 'Macao', 'MO'),
(96, 'Madagascar', 'MG'),
(97, 'Malawi', 'MW'),
(98, 'Malaysia', 'MY'),
(99, 'Maldives', 'MV'),
(100, 'Mali', 'ML'),
(101, 'Malta', 'MT'),
(102, 'Mauritania', 'MR'),
(103, 'Mexico', 'MX'),
(104, 'Moldova, Republic of', 'MD'),
(105, 'Montenegro', 'ME'),
(106, 'Montserrat', 'MS'),
(107, 'Morocco', 'MA'),
(108, 'Mozambique', 'MZ'),
(109, 'Myanmar', 'MM'),
(110, 'Namibia', 'NA'),
(111, 'Nauru', 'NR'),
(112, 'Nepal', 'NP'),
(113, 'Netherlands', 'NL'),
(114, 'New Zealand', 'NZ'),
(115, 'Niger', 'NE'),
(116, 'Nigeria', 'NG'),
(117, 'Norway', 'NO'),
(118, 'Oman', 'OM'),
(119, 'Pakistan', 'PK'),
(120, 'Panama', 'PA'),
(121, 'Papua New Guinea', 'PG'),
(122, 'Paraguay', 'PY'),
(123, 'Peru', 'PE'),
(124, 'Philippines', 'PH'),
(125, 'Pitcairn', 'PN'),
(126, 'Poland', 'PL'),
(127, 'Portugal', 'PT'),
(128, 'Qatar', 'QA'),
(129, 'Romania', 'RO'),
(130, 'Russia', 'RU'),
(131, 'Rwanda', 'RW'),
(132, 'Saint Helena', 'SH'),
(133, 'Saint Kitts & Nevis', 'KN'),
(134, 'Saint Lucia', 'LC'),
(135, 'Saint Martin', 'MF'),
(136, 'Saint Pierre & Miquelon', 'PM'),
(137, 'Saint Vincent & Grenadines', 'VC'),
(138, 'Samoa', 'WS'),
(139, 'San Marino', 'SM'),
(140, 'Sao Tome & Principe', 'ST'),
(141, 'Saudi Arabia', 'SA'),
(142, 'Senegal', 'SN'),
(143, 'Serbia', 'RS'),
(144, 'Seychelles', 'SC'),
(145, 'Sierra Leone', 'SL'),
(146, 'Singapore', 'SG'),
(147, 'Sint Maarten (Dutch part)', 'SX'),
(148, 'Slovakia', 'SK'),
(149, 'Slovenia', 'SI'),
(150, 'South Africa', 'ZA'),
(151, 'South Korea', 'KR'),
(152, 'Spain', 'ES'),
(153, 'Sri Lanka', 'LK'),
(154, 'Sweden', 'SE'),
(155, 'Switzerland', 'CH'),
(156, 'Taiwan', 'TW'),
(157, 'Tanzania', 'TZ'),
(158, 'Thailand', 'TH'),
(159, 'Togo', 'TG'),
(160, 'Tonga', 'TO'),
(161, 'Tunisia', 'TN'),
(162, 'Turkey', 'TR'),
(163, 'Turks & Caicos Islands', 'TC'),
(164, 'Tuvalu', 'TV'),
(165, 'Uganda', 'UG'),
(166, 'Ukraine', 'UA'),
(167, 'United Arab Emirates', 'AE'),
(168, 'United Kingdom', 'GB'),
(169, 'United States', 'US'),
(170, 'Uruguay', 'UY'),
(171, 'Vanuatu', 'VU'),
(172, 'Venezuela', 'VE'),
(173, 'Wallis & Futuna', 'WF'),
(174, 'Western Sahara', 'EH'),
(175, 'Zambia', 'ZM'),
(176, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` char(36) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'Customer',
  `loyalty_points` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `user_address1` varchar(225) DEFAULT NULL,
  `user_address2` varchar(255) DEFAULT NULL,
  `user_city` varchar(100) DEFAULT NULL,
  `user_state` varchar(100) DEFAULT NULL,
  `user_postcode` varchar(10) DEFAULT NULL,
  `user_country` varchar(100) DEFAULT NULL,
  `nonce` varchar(255) DEFAULT NULL,
  `nonce_expiry` datetime DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp(),
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `phone`, `password`, `first_name`, `last_name`, `user_type`, `loyalty_points`, `birthday`, `user_address1`, `user_address2`, `user_city`, `user_state`, `user_postcode`, `user_country`, `nonce`, `nonce_expiry`, `created`, `modified`, `archived`) VALUES
(13, 'test@admin.com', '0412345678', '$2y$12$tBwOfnI3985dMItRHHTex.j/rsOfGFILo3dtr3Li6TTyoQfGagILe', 'Admin', 'Admin', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 14:08:47', '2025-03-29 14:08:47', 0),
(14, 'test@customer.com', '0412345678', '$2y$12$USJg/.YgMafaZ83Zpve.Uu.vWIsvWCdCgzelWC.12uc5Y6DYj2T4i', 'Inseong', 'Hwang', 'Customer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 14:22:22', '2025-03-29 14:22:22', 0),
(15, 'kiriko@gmail.com', '0412345678', '$2y$12$zUc99j/e0Iz9x5UKULGIFeeV3XLmYF5vIiKNYwHKX5QoC4sh1U79e', 'Kiriko', 'Kamori', 'Customer', NULL, '2000-07-07', '3-2-1 Shibuya', NULL, 'Tokyo', 'Kantō', '150-0002', NULL, NULL, NULL, '2025-03-31 01:27:52', '2025-03-31 01:27:52', 0),
(16, 'winston@gmail.com', '12312321', '$2y$12$TOFzAxGv9XWNS/5Y6RWO1eA8wTEJIuHuDdniGGz4b4tx5Zu2pP95m', 'Winston', 'Monke', 'Customer', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-08 09:04:16', '2025-04-08 09:04:16', 0),
(17, 'is8159750@gmail.com', '0412345678', '$2y$12$DPUtBnZVC/gFvzn891jN3ecRr7De5U3Fa2XFYqVmBSSZfP9izaYWu', 'Inseong', 'Hwang', 'Customer', NULL, '1999-08-15', '35 Bourke Street', NULL, 'Melbourne', 'Victoria', '3000', 'AU', NULL, NULL, '2025-04-08 13:33:00', '2025-04-08 13:54:05', 0),
(19, 'sara@example.com', '2343547568785', '$2y$10$wU5avhUiupkNzxw0sHJ8WeiiMHqGhD3XQx7vLPFT4p7xqzrm/xU1C', 'Sara', 'K', 'Admin', NULL, '2025-04-08', '123 Maplewood Drive', 'Apt 4B, , IL , ', 'Springfield', 'Illinois', '62704', 'USA', NULL, NULL, '2025-04-09 03:33:31', '2025-04-09 03:33:31', 0),
(20, 'evie@example.com', '2343547568', '$2y$10$LqEycc3nK81dj7aGj7Pvfu2EBv3BWXSxW38.bLl45YX3mOUJGPCIC', 'Evie', 'Lee', 'Customer', NULL, NULL, '34 Brick Lane', NULL, 'Melbourne', 'Victoria', '3000', 'AU', NULL, NULL, '2025-04-15 09:38:17', '2025-05-20 07:11:53', 0),
(22, 'testing@test.com', '2343547568785', '$2y$10$QeV6vTBLDy2ZIiqKjIB2W.A32XLO2HObFsxD8LfT7wjqT6o9/jhZe', 'testing', 'test', 'Customer', NULL, NULL, NULL, '123 Maplewood Drive, Apt 4B, Springfield, IL 62704, USA', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-16 12:45:15', '2025-05-13 09:08:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wine_styles`
--

CREATE TABLE `wine_styles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wine_styles`
--

INSERT INTO `wine_styles` (`id`, `name`, `modified`, `archived`) VALUES
(1, 'Red', '2025-05-14 08:06:08', 0),
(2, 'White', '2025-05-12 17:28:54', 0),
(3, 'Rose', '2025-05-12 17:26:07', 0),
(4, 'Sparkling', '2025-05-13 10:54:00', 0),
(5, 'Fortified', '2025-05-13 10:53:40', 0),
(6, 'Dessert', '2025-05-21 19:05:09', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_blocks`
--
ALTER TABLE `content_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_blocks_phinxlog`
--
ALTER TABLE `content_blocks_phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_orders_coupon_id` (`coupon_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_product_name` (`name`),
  ADD KEY `fk_wine_style_id` (`wine_style_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shipping_countries`
--
ALTER TABLE `shipping_countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_country_name` (`country_name`),
  ADD UNIQUE KEY `unique_country_code` (`country_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wine_styles`
--
ALTER TABLE `wine_styles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `content_blocks`
--
ALTER TABLE `content_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `wine_styles`
--
ALTER TABLE `wine_styles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_wine_style_id` FOREIGN KEY (`wine_style_id`) REFERENCES `wine_styles` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
