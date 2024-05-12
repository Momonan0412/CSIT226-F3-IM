-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 12, 2024 at 11:26 AM
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
-- Database: `dbchuaf3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomer`
--

CREATE TABLE `tblcustomer` (
  `customerID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `profileID` int(11) NOT NULL,
  `room_assigned` varchar(255) NOT NULL DEFAULT 'No Room Assigned',
  `payment` varchar(255) NOT NULL DEFAULT 'Payment Not Set',
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`customerID`, `accountID`, `profileID`, `room_assigned`, `payment`, `isActive`) VALUES
(31, 2, 2, 'No Room Assigned', 'Mode of Payment: credit_card', 1),
(32, 1, 1, 'No Room Assigned', 'Mode of Payment: credit_card', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblroomrequest`
--

CREATE TABLE `tblroomrequest` (
  `requestID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `request` varchar(255) NOT NULL,
  `isApprove` tinyint(1) NOT NULL DEFAULT 0,
  `isCurrentRequest` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroomrequest`
--

INSERT INTO `tblroomrequest` (`requestID`, `customerID`, `request`, `isApprove`, `isCurrentRequest`) VALUES
(44, 31, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0, 0),
(45, 31, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0, 0),
(46, 32, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0, 0),
(47, 32, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0, 0),
(48, 31, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `acctid` int(11) NOT NULL,
  `emailadd` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`acctid`, `emailadd`, `username`, `password`, `usertype`) VALUES
(1, 'avrilnigelc@gmail.com', 'Momonan0412', '$2y$10$vJ/pJiGIkHT/MXuuZtyfSeJWHFJS5JsH2ncThiF.38nq8gT0MKTNS', ''),
(2, 'tester@test.test', 'asd', '$2y$10$t0i3jDe9SNbtK2UyNlT63eXg8h0r9jBZ2pMXAymxz9ECcKbzXrSQe', ''),
(3, 'Admin@gmail.com', 'Admin', '$2y$10$YdYgobZRtArZgnmmXJDMSu/pCrKpE9DgFPQN18LrdEFvn8Y3o7aGW', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserprofile`
--

CREATE TABLE `tbluserprofile` (
  `userid` int(11) NOT NULL,
  `acctid` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserprofile`
--

INSERT INTO `tbluserprofile` (`userid`, `acctid`, `firstname`, `lastname`, `gender`) VALUES
(1, 1, 'Avril Nigel', 'Chua', 'Male'),
(2, 2, 'asd', 'asd', 'Male'),
(3, 3, 'Admin', 'Admin', 'Female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `profileID` (`profileID`),
  ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`acctid`);

--
-- Indexes for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `acctid` (`acctid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `acctid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD CONSTRAINT `tblcustomer_ibfk_1` FOREIGN KEY (`profileID`) REFERENCES `tbluserprofile` (`userid`),
  ADD CONSTRAINT `tblcustomer_ibfk_2` FOREIGN KEY (`accountID`) REFERENCES `tbluseraccount` (`acctid`);

--
-- Constraints for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  ADD CONSTRAINT `tblroomrequest_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `tblcustomer` (`customerID`) ON DELETE CASCADE;

--
-- Constraints for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  ADD CONSTRAINT `tbluserprofile_ibfk_1` FOREIGN KEY (`acctid`) REFERENCES `tbluseraccount` (`acctid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
