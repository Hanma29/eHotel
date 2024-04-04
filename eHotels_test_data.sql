-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2024 at 10:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eHotels`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `archive_id` int(11) DEFAULT NULL,
  `a_rent_id` int(11) DEFAULT NULL,
  `a_book_id` int(11) DEFAULT NULL,
  `a_fromDate` datetime DEFAULT NULL,
  `a_toDate` datetime DEFAULT NULL,
  `a_roomId` int(11) DEFAULT NULL,
  `a_custId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `fromDate` datetime DEFAULT NULL,
  `toDate` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chain_emails`
--

CREATE TABLE `chain_emails` (
  `chain_id` int(11) NOT NULL,
  `chain_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chain_phone_numbers`
--

CREATE TABLE `chain_phone_numbers` (
  `chain_id` int(11) NOT NULL,
  `chain_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `cust_fname` varchar(255) DEFAULT NULL,
  `cust_addressline1` text DEFAULT NULL,
  `cust_addressline2` text DEFAULT NULL,
  `id_type` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `cust_fname`, `cust_addressline1`, `cust_addressline2`, `id_type`, `registration_date`) VALUES
(1, 'Tevin', 'ottawa', 'canada', 'ssn', NULL),
(2, 'Ryan', '123', '123223RASD', 'on', NULL),
(3, 'Ruben', 'Customer2 Address', 'Trinidad', 'on', NULL),
(4, 'Nick', 'Customer2 Address', 'Trinidad', 'on', NULL),
(5, 'Devin', 'Customer2 Address', 'Trinidad', 'on', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employ_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `employ_fname` varchar(255) DEFAULT NULL,
  `employ_addressline1` text DEFAULT NULL,
  `employ_addressline2` text DEFAULT NULL,
  `id_type` varchar(255) DEFAULT NULL,
  `position_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employ_id`, `hotel_id`, `employ_fname`, `employ_addressline1`, `employ_addressline2`, `id_type`, `position_name`) VALUES
(1, 0, 'A real employee', 'asdasdasd', 'asdasd', 'License', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `chain_id` int(11) DEFAULT NULL,
  `h_name` varchar(255) DEFAULT NULL,
  `hotel_addressline1` text DEFAULT NULL,
  `hotel_addressline2` text DEFAULT NULL,
  `totalRooms` int(11) DEFAULT NULL,
  `hotel_email` varchar(255) DEFAULT NULL,
  `hotel_score` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `chain_id`, `h_name`, `hotel_addressline1`, `hotel_addressline2`, `totalRooms`, `hotel_email`, `hotel_score`, `manager_id`) VALUES
(1, 1, 'Mariott SF', 'SAN Fransico', '123', 100, 'tevin@gmail.com', 4, 1),
(2, 1, 'Hilton San Bernadino', 'LA CALIFORNA', '123', 100, 'tevin@gmail.com', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_chain`
--

CREATE TABLE `hotel_chain` (
  `chain_id` int(11) NOT NULL,
  `chain_name` varchar(999) DEFAULT NULL,
  `chain_addressline1` text DEFAULT NULL,
  `chain_addressline2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_chain`
--

INSERT INTO `hotel_chain` (`chain_id`, `chain_name`, `chain_addressline1`, `chain_addressline2`) VALUES
(1, 'Hotel Chain1', 'LA', 'Califronia');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_phone_numbers`
--

CREATE TABLE `hotel_phone_numbers` (
  `hotel_id` int(11) NOT NULL,
  `hotel_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `renting`
--

CREATE TABLE `renting` (
  `rent_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `employ_id` int(11) DEFAULT NULL,
  `fromDate` int(11) DEFAULT NULL,
  `toDate` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `paid` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renting`
--

INSERT INTO `renting` (`rent_id`, `hotel_id`, `room_id`, `cust_id`, `employ_id`, `fromDate`, `toDate`, `duration`, `paid`) VALUES
(16, 2, 1, 2, 1, 1713132000, 1714082400, 950400, 0),
(20, 1, 2, -1, -1, 1712268000, 1712959200, 691200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `view_type` varchar(255) DEFAULT NULL,
  `canExtend` tinyint(1) DEFAULT NULL,
  `damage_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `hotel_id`, `price`, `amenities`, `capacity`, `view_type`, `canExtend`, `damage_notes`) VALUES
(1, 2, 200, 'AC, TV, Mini Fridge', 2, 'Sea', 1, ''),
(2, 1, 400, 'TV', 1, 'Mountain', 1, '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_aggregated_capacity_per_hotel`
-- (See below for the actual view)
--
CREATE TABLE `view_aggregated_capacity_per_hotel` (
`hotel_id` int(11)
,`HotelName` varchar(255)
,`AggregatedCapacity` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_available_rooms_per_area`
-- (See below for the actual view)
--
CREATE TABLE `view_available_rooms_per_area` (
`Area` text
,`AvailableRooms` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `view_aggregated_capacity_per_hotel`
--
DROP TABLE IF EXISTS `view_aggregated_capacity_per_hotel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ehotels`.`view_aggregated_capacity_per_hotel`  AS SELECT `ehotels`.`hotels`.`hotel_id` AS `hotel_id`, `ehotels`.`hotels`.`h_name` AS `HotelName`, sum(`ehotels`.`rooms`.`capacity`) AS `AggregatedCapacity` FROM (`ehotels`.`hotels` join `ehotels`.`rooms` on(`ehotels`.`hotels`.`hotel_id` = `ehotels`.`rooms`.`hotel_id`)) GROUP BY `ehotels`.`hotels`.`hotel_id`, `ehotels`.`hotels`.`h_name` ;

-- --------------------------------------------------------

--
-- Structure for view `view_available_rooms_per_area`
--
DROP TABLE IF EXISTS `view_available_rooms_per_area`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ehotels`.`view_available_rooms_per_area`  AS SELECT `ehotels`.`hotels`.`hotel_addressline1` AS `Area`, count(`ehotels`.`rooms`.`room_id`) AS `AvailableRooms` FROM ((`ehotels`.`hotels` join `ehotels`.`rooms` on(`ehotels`.`hotels`.`hotel_id` = `ehotels`.`rooms`.`room_id`)) left join `ehotels`.`renting` on(`ehotels`.`rooms`.`room_id` = `ehotels`.`renting`.`rent_id`)) WHERE `ehotels`.`renting`.`rent_id` is null OR `ehotels`.`renting`.`fromDate` < curdate() GROUP BY `ehotels`.`hotels`.`hotel_addressline1` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `chain_emails`
--
ALTER TABLE `chain_emails`
  ADD PRIMARY KEY (`chain_id`);

--
-- Indexes for table `chain_phone_numbers`
--
ALTER TABLE `chain_phone_numbers`
  ADD PRIMARY KEY (`chain_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employ_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `hotel_chain`
--
ALTER TABLE `hotel_chain`
  ADD PRIMARY KEY (`chain_id`);

--
-- Indexes for table `hotel_phone_numbers`
--
ALTER TABLE `hotel_phone_numbers`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `renting`
--
ALTER TABLE `renting`
  ADD PRIMARY KEY (`rent_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`,`hotel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel_chain`
--
ALTER TABLE `hotel_chain`
  MODIFY `chain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `renting`
--
ALTER TABLE `renting`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `chain_emails`
--
ALTER TABLE `chain_emails`
  ADD CONSTRAINT `chain_emails_ibfk_1` FOREIGN KEY (`chain_id`) REFERENCES `hotel_chain` (`chain_id`);

--
-- Constraints for table `chain_phone_numbers`
--
ALTER TABLE `chain_phone_numbers`
  ADD CONSTRAINT `chain_phone_numbers_ibfk_1` FOREIGN KEY (`chain_id`) REFERENCES `hotel_chain` (`chain_id`);

--
-- Constraints for table `hotel_phone_numbers`
--
ALTER TABLE `hotel_phone_numbers`
  ADD CONSTRAINT `hotel_phone_numbers_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
