-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2026 at 05:47 AM
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
-- Database: `shopping_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(19, 'Notebooks & Paper Products', 'Notebooks, fillers, yellow pads, index cards, graphing paper, and other writing materials used for classes and projects.', '2026-06-07 02:48:05', '2026-06-07 02:48:05'),
(20, 'Writing Instruments', 'Ballpens, gel pens, pencils, mechanical pencils, markers, highlighters, correction pens, and refills.', '2026-06-07 02:48:16', '2026-06-07 02:48:16'),
(21, 'Art & Drawing Supplies', 'Coloring materials, sketch pads, watercolor sets, paint brushes, drawing pencils, and art project essentials.', '2026-06-07 02:48:25', '2026-06-07 02:48:25'),
(22, 'Mathematics & Engineering Tools', 'Rulers, protractors, compasses, triangles, calculators, engineering scales, and drafting materials.', '2026-06-07 02:48:35', '2026-06-07 02:48:35'),
(23, 'Office & Organization Supplies', 'Folders, binders, envelopes, clips, staplers, punches, labels, organizers, and filing materials.', '2026-06-07 02:48:43', '2026-06-07 02:48:43'),
(24, 'School Bags & Storage', 'Backpacks, tote bags, pencil cases, document cases, and storage organizers for school use.', '2026-06-07 02:48:52', '2026-06-07 02:48:52'),
(25, 'Technology Accessories', 'USB drives, memory cards, computer peripherals, adapters, chargers, and student tech essentials.', '2026-06-07 02:49:02', '2026-06-07 02:49:02'),
(26, 'Printing & Presentation Materials', 'Bond paper, photo paper, folders, presentation boards, laminating sheets, and printing supplies.', '2026-06-07 02:49:13', '2026-06-07 02:49:13'),
(27, 'Computer Accessories', 'Mouse, keyboards, mouse pads, USB hubs, webcams, and other computer peripherals.', '2026-06-07 02:49:32', '2026-06-07 02:49:32'),
(28, 'Data Storage Devices', 'Flash drives, external hard drives, SSDs, memory cards, and backup storage devices.', '2026-06-07 02:49:43', '2026-06-07 02:49:43'),
(29, 'Study Essentials', 'Desk organizers, study lamps, sticky notes, bookmarks, and productivity tools.', '2026-06-07 02:50:56', '2026-06-07 02:50:56'),
(30, 'Project Materials', 'Cartolinas, illustration boards, glue, scissors, cutters, tapes, and project-making supplies.', '2026-06-07 02:51:12', '2026-06-07 02:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(9, 2, '2026-06-07 11:40:27', 6072.00, 'processing', '2026-06-07 03:40:27', '2026-06-07 03:45:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `name`, `quantity`, `price`, `subtotal`, `image`, `created_at`, `updated_at`) VALUES
(13, 9, 14, 'Awagami A4 Washi Paper Pack – ‘Tanabata’ Confetti Inclusions 20-pack', 23, 264.00, 6072.00, '1780803183_ad628cf4f3b2053ba6a8.png', '2026-06-07 03:40:27', '2026-06-07 03:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(12, 21, 'Vintage Leather Cover Journals Handmade Travel Kraft Paper Blank Notebook', 'A beautifully crafted vintage-style journal featuring a durable leather cover and blank kraft paper pages. Ideal for writing, sketching, journaling, note-taking, and travel memories. Its handmade design combines elegance, durability, and functionality for everyday use.', 94.67, 1042, '1780802756_eae59b757b9f951370a7.png', NULL, NULL),
(13, 21, 'A5 Hardcover Spiral Planner Notebook', 'Stay organized with this A5 Hardcover Spiral Planner Notebook, featuring daily, weekly, and monthly planning pages. Perfect for scheduling, note-taking, goal setting, and academic or professional use. Durable, practical, and designed for everyday productivity.', 94.32, 410, '1780802962_a15eedf11ff8519228e8.png', NULL, NULL),
(14, 21, 'Awagami A4 Washi Paper Pack – ‘Tanabata’ Confetti Inclusions 20-pack', 'Premium A4 Japanese washi paper with decorative Tanabata confetti inclusions. Ideal for calligraphy, crafts, invitations, scrapbooking, and creative projects. Includes 20 beautifully textured sheets.', 264.00, 2134, '1780803183_ad628cf4f3b2053ba6a8.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'James Emmanuel', 'Fernandez', 'james.fernandez1239@gmail.com', '$2y$10$QIZN9.OyygM/SLHCn6s7geFD5R40Q/gQk85rFaWiHPDdMn/G7aNfq', 'customer', '2026-06-05 11:24:07', '2026-06-05 11:24:07'),
(2, 'James Emmanuel', 'Fernandez', 'james.fernandez1230@gmail.com', '$2y$10$f6mlBwfBhkpAsZYXFPMkh.Dao.CrJvGEOsy62gpmYMHkX/gRO6tOS', 'customer', '2026-06-05 11:26:13', '2026-06-06 20:43:45'),
(3, 'James Emmanuel', 'Fernandez', 'james.fernandez1238@gmail.com', '$2y$10$pn50l0l8TQTfxqQyga7O0uYbBpQEMdEjmX0ezf4heGtHBMJWreyTW', 'customer', '2026-06-05 11:29:18', '2026-06-05 11:29:18'),
(4, 'James Emmanuel', 'Fernandez', 'james.fernandez1237@gmail.com', '$2y$10$XmlBN1rRQKVWQnTYG7f44uNDYaAVgYgEzyrgSA.JqvUIhd15jTEZC', 'customer', '2026-06-05 11:33:48', '2026-06-05 11:33:48'),
(5, 'System', 'Administrator', 'admin.studenthub@gmail.com', '$2y$10$o8esSZ9/ZR4kqeKUJhhxVOQCdR0bqToh9JsWQ9pY31valglKCADuW', 'admin', '2026-06-05 20:11:24', '2026-06-07 03:34:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
