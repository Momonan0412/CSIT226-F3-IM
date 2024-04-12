-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Apr 12, 2024 at 12:04 PM
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
  `payment` varchar(255) NOT NULL DEFAULT 'Payment Not Set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomer`
--

INSERT INTO `tblcustomer` (`customerID`, `accountID`, `profileID`, `room_assigned`, `payment`) VALUES
(16, 27, 29, 'No Room Assigned', 'Mode of Payment: credit_card'),
(17, 26, 28, 'No Room Assigned', 'Mode of Payment: debit_card');

-- --------------------------------------------------------

--
-- Table structure for table `tblroomrequest`
--

CREATE TABLE `tblroomrequest` (
  `requestID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `request` varchar(255) NOT NULL,
  `isApprove` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroomrequest`
--

INSERT INTO `tblroomrequest` (`requestID`, `customerID`, `request`, `isApprove`) VALUES
(10, 16, 'Room Type: single, Number of Beds: 1, Quality: standard, Capacity: 1 Person(s), Number of Bathrooms: 1,    Pay for Meal: included, Room Size: large', 0),
(11, 17, 'Room Type: double, Number of Beds: 2, Quality: standard, Capacity: 3 Person(s), Number of Bathrooms: 2,    Pay for Meal: not_included, Room Size: small', 0);

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
(26, 'chua.avril_nigel@yahoo.com', 'Momonan0412', '$2y$10$PUtq2AFOjyJHjMWEj7R0vuDXS2t3wJObKklLZu3P4PZ0QKUkNJZIa', ''),
(27, 'tester@test.test', 'asd', '$2y$10$/b5YkFwR1tnF83b6NjCbAeUSOg7NPk4bH66dKSaVs6aH3HnvQt26O', '');

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
(28, 26, 'Avril Nigel', 'Chua', 'Male'),
(29, 27, 'asd', 'asd', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `fk_customer_account_user` (`accountID`),
  ADD KEY `fk_customer_profile_user` (`profileID`);

--
-- Indexes for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `fk_customer_room_request` (`customerID`);

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
  ADD KEY `fk_profile_account_id` (`acctid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `acctid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcustomer`
--
ALTER TABLE `tblcustomer`
  ADD CONSTRAINT `fk_customer_account_user` FOREIGN KEY (`accountID`) REFERENCES `tbluseraccount` (`acctid`),
  ADD CONSTRAINT `fk_customer_profile_user` FOREIGN KEY (`profileID`) REFERENCES `tbluserprofile` (`userid`);

--
-- Constraints for table `tblroomrequest`
--
ALTER TABLE `tblroomrequest`
  ADD CONSTRAINT `fk_customer_room_request` FOREIGN KEY (`customerID`) REFERENCES `tblcustomer` (`customerID`);

--
-- Constraints for table `tbluserprofile`
--
ALTER TABLE `tbluserprofile`
  ADD CONSTRAINT `fk_profile_account_id` FOREIGN KEY (`acctid`) REFERENCES `tbluseraccount` (`acctid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
