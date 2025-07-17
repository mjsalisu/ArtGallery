-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 17, 2025 at 12:21 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `art_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `artworks`
--

CREATE TABLE `artworks` (
  `artworkID` int NOT NULL,
  `artistID` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT 'digital',
  `description` varchar(500) NOT NULL,
  `price` int NOT NULL,
  `quantity` int DEFAULT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artworks`
--

INSERT INTO `artworks` (`artworkID`, `artistID`, `title`, `category`, `type`, `description`, `price`, `quantity`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(6, 28, 'In temporibus quis e', 'digital_art', 'physical', 'Eveniet voluptatem ', 648, 8, 'uploads/artworks/6873eaf4df447_1694107968613.png', 1, '2025-07-13 17:20:52', '2025-07-13 17:20:52'),
(8, 28, 'Printed Image', 'photography', 'physical', 'GMP', 100000, 5, 'uploads/artworks/6873ec61b37e3_4d44645a-face-428c-ad5d-e142bdae703e_wm.jpeg', 1, '2025-07-13 17:26:57', '2025-07-13 17:26:57'),
(9, 30, 'Art of Late Gen. Muhammadu Buhari', 'digital_art', 'physical', 'text here....', 25000, 10, 'uploads/artworks/68763de7a1c83_The-President-Major-General-Muhammadu-Buhari-retd.jpg', 1, '2025-07-15 11:39:19', '2025-07-15 11:39:19');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requests`
--

CREATE TABLE `custom_requests` (
  `requestID` int NOT NULL,
  `created_by` int NOT NULL,
  `artistID` int DEFAULT NULL,
  `request_title` varchar(200) NOT NULL,
  `specifications` varchar(500) NOT NULL,
  `offered_price` int NOT NULL,
  `sketch_sample` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uploaded_artwork` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` int NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `custom_requests`
--

INSERT INTO `custom_requests` (`requestID`, `created_by`, `artistID`, `request_title`, `specifications`, `offered_price`, `sketch_sample`, `uploaded_artwork`, `status`, `created_at`, `updated_at`) VALUES
(1, 27, NULL, 'Abstract Family Portrait', 'A large canvas abstract style, warm tones, 36x48 inches', 45000, NULL, NULL, 0, '2025-07-06 14:43:25.000000', '2025-07-06 14:43:25.000000'),
(2, 28, NULL, 'Modern Sculpture Design', 'Concept: “Freedom”; medium: recycled metals', 70000, NULL, NULL, -1, '2025-07-06 14:43:25.000000', '2025-07-06 14:43:25.000000'),
(3, 27, 28, 'Pet Illustration', 'Detailed sketch of a golden retriever with pastel colors', 30000, 'uploads/sketches/Sketch.jpg', 'uploads/artworks/request/Design.jpg', 2, '2025-07-06 14:43:25.000000', '2025-07-06 14:43:25.000000'),
(4, 28, 27, 'Wall Mural Request', '3m x 2m mural with African heritage theme for home wall', 120000, 'uploads/sketches/Sketch.jpg', 'uploads/artworks/request/Design.jpg', 2, '2025-07-06 14:43:25.000000', '2025-07-06 14:43:25.000000'),
(5, 27, NULL, 'Digital Comic Strip', 'A 3-panel humorous strip based on office life', 20000, NULL, NULL, 0, '2025-07-06 14:43:25.000000', '2025-07-06 14:43:25.000000'),
(6, 27, NULL, 'Ut sed quo quia cumq', 'Reprehenderit volup', 393, '', '', -1, '2025-07-06 15:00:04.325145', '2025-07-06 15:00:04.325145'),
(7, 27, 28, 'My Kaduna Gov', 'Et dignissimos iure ', 98000, '', '', 1, '2025-07-06 15:01:20.545557', '2025-07-06 15:01:20.545557'),
(8, 27, 30, 'MJ luffy picture as a developer', 'One Piece!', 100, '', 'uploads/artworks/request/artwork_68763f156bfa45.40307912.jpeg', 2, '2025-07-06 15:02:54.073019', '2025-07-06 15:02:54.073019'),
(9, 27, NULL, 'Necessitatibus bland', 'Vel veritatis volupt', 336, '', '', 0, '2025-07-06 15:51:11.226038', '2025-07-06 15:51:11.226038'),
(10, 27, NULL, 'Debitis ipsum quaer', 'Rerum inventore cum ', 28, '', '', -1, '2025-07-06 15:52:36.913273', '2025-07-06 15:52:36.913273'),
(11, 27, 28, 'Aspernatur voluptate', 'Sit sit quaerat ip', 118, '', 'uploads/artworks/request/artwork_6873d9f57244f0.52419500.jpg', 2, '2025-07-06 16:12:23.639330', '2025-07-06 16:12:23.639330'),
(12, 29, NULL, 'Nabeel Accusamus porro alia', 'Excepteur dolore qui', 150000, '', '', 0, '2025-07-07 16:38:05.338387', '2025-07-07 16:38:05.338387'),
(32, 29, 28, 'Can you handle this for me at low budget cost?', 'Esse repellendus E', 25000, 'uploads/sketches/sketch_6873dbaaa6e4f2.74755271.jpg', '', 1, '2025-07-13 16:15:38.684046', '2025-07-13 16:15:38.684046'),
(33, 31, 30, 'Jobberman Logo showing the HQ', 'I need a new logo', 150000, 'uploads/sketches/sketch_6876407f394025.57462211.jpg', 'uploads/artworks/request/artwork_68764151eb7b32.37658206.jpg', 2, '2025-07-15 11:50:23.235669', '2025-07-15 11:50:23.235669');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` int NOT NULL,
  `artworkID` int NOT NULL,
  `artistID` int NOT NULL,
  `buyerID` int NOT NULL,
  `amount` int NOT NULL,
  `delivery_address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `payment_status` int NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionID`, `artworkID`, `artistID`, `buyerID`, `amount`, `delivery_address`, `payment_status`, `created_at`) VALUES
(1, 1, 28, 27, 50000, NULL, 1, '2025-07-01 09:30:00.000000'),
(2, 4, 28, 27, 35000, NULL, 0, '2025-07-02 13:15:00.000000'),
(3, 1, 27, 27, 42000, NULL, 2, '2025-07-03 08:45:00.000000'),
(4, 3, 29, 29, 28000, NULL, 1, '2025-07-04 16:00:00.000000'),
(5, 5, 27, 28, 60000, NULL, 0, '2025-07-05 10:20:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Buyer',
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `biography` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `profile_photo` varchar(200) DEFAULT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `email`, `phone`, `role`, `address`, `biography`, `profile_photo`, `password`, `status`, `created_at`, `updated_at`) VALUES
(27, 'Admin', 'admin@gmail.com', '08028752833', 'Admin', NULL, NULL, NULL, '$2y$10$zlTMIDIKODGwo5hRRLeJUObhpraLMWLmXJMoxktCvxymsc2e7PiKC', 1, '2025-07-04 09:11:00.918888', '2025-07-04 09:11:00.918888'),
(28, 'Fatima Muhammad', 'user@gmail.com', '09022334422', 'Artist', NULL, NULL, NULL, '$2y$10$/ZEx7EkC6ks.7OOSG0pAY..2fqLBbaq452meFNTHfNXnywo2f0JIi', 1, '2025-07-04 11:55:43.357484', '2025-07-04 12:20:29.000000'),
(29, 'Nabeelah Garba', 'nda@gmail.com', '08022334455', 'Buyer', NULL, NULL, NULL, '$2y$10$.cglq6YEb.Ob9iSU6HE7aeqTEW2GfPviak6ZpSrBTdFq9NbwpWnaa', 1, '2025-07-07 06:47:35.455707', '2025-07-07 06:47:35.455707'),
(30, 'Fatima Namadi', 'fatima@gmail.com', '08011228899', 'Artist', NULL, NULL, NULL, '$2y$10$PR.Z4vMWMPUAvOml/iYqFOCgg0SirjQoSMHPAaNnWHYpw16gkNglG', 1, '2025-07-15 11:30:31.257850', '2025-07-15 11:33:03.000000'),
(31, 'Ali Aliyu', 'ali@gmail.com', '09022558899', 'Buyer', NULL, NULL, NULL, '$2y$10$720CUjE8aKdspVzmzAtg5.C8SalgKQK3SXqAeKQSl8liMn/dKdsQO', 1, '2025-07-15 11:31:54.266075', '2025-07-15 11:31:54.266075');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artworks`
--
ALTER TABLE `artworks`
  ADD PRIMARY KEY (`artworkID`);

--
-- Indexes for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD PRIMARY KEY (`requestID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artworks`
--
ALTER TABLE `artworks`
  MODIFY `artworkID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `custom_requests`
--
ALTER TABLE `custom_requests`
  MODIFY `requestID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
