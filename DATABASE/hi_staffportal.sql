-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2016 at 05:18 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hi_staffportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `startdate` varchar(48) NOT NULL,
  `enddate` varchar(48) NOT NULL,
  `allDay` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hi_balances`
--

CREATE TABLE IF NOT EXISTS `hi_balances` (
  `Year` int(11) NOT NULL COMMENT 'Year',
  `userid` int(11) NOT NULL COMMENT 'Employee ID',
  `BalCL` int(11) NOT NULL DEFAULT '0' COMMENT 'Balance CL',
  `BalEL` int(11) NOT NULL DEFAULT '0' COMMENT 'Balance EL',
  `BalRH` int(11) NOT NULL DEFAULT '0' COMMENT 'Balance RH',
  `BalML` int(11) NOT NULL DEFAULT '0' COMMENT 'Balance ML',
  PRIMARY KEY (`Year`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Balance Leave';

--
-- Dumping data for table `hi_balances`
--

INSERT INTO `hi_balances` (`Year`, `userid`, `BalCL`, `BalEL`, `BalRH`, `BalML`) VALUES
(2016, 10, 15, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `hi_banned`
--

CREATE TABLE IF NOT EXISTS `hi_banned` (
  `userid` int(11) NOT NULL,
  `until` int(11) NOT NULL,
  `by` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hi_groups`
--

CREATE TABLE IF NOT EXISTS `hi_groups` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `canban` int(11) NOT NULL,
  `canhideavt` int(11) NOT NULL,
  `canedit` int(11) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `hi_groups`
--

INSERT INTO `hi_groups` (`groupid`, `name`, `type`, `priority`, `color`, `canban`, `canhideavt`, `canedit`) VALUES
(1, 'Guest', 0, 1, '', 0, 0, 0),
(2, 'Employee', 1, 1, '#08c', 0, 0, 0),
(3, 'Moderator', 2, 1, 'green', 1, 1, 0),
(4, 'Administrator', 3, 1, '#F0A02D', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hi_leaves`
--

CREATE TABLE IF NOT EXISTS `hi_leaves` (
  `LeaveID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Leave ID',
  `userid` int(11) NOT NULL COMMENT 'Employee ID',
  `AppliedDate` date DEFAULT NULL COMMENT 'Applied On Date',
  `LeaveFrom` date NOT NULL COMMENT 'Leave From Date',
  `LeaveTill` date DEFAULT NULL COMMENT 'Leave Till Date',
  `LeaveDays` float(6,1) DEFAULT NULL COMMENT 'Leave Days',
  `LeaveType` enum('AB','CL','EL','RH','ML','CCL','PL') NOT NULL DEFAULT 'AB' COMMENT 'Leave Type',
  `IsVerified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Verified',
  `IsApproved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Approved',
  `Reason` varchar(255) DEFAULT NULL COMMENT 'Leave Reason',
  PRIMARY KEY (`LeaveID`),
  UNIQUE KEY `EmployeeDateIDX` (`userid`,`LeaveFrom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Leave List' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `hi_leaves`
--

INSERT INTO `hi_leaves` (`LeaveID`, `userid`, `AppliedDate`, `LeaveFrom`, `LeaveTill`, `LeaveDays`, `LeaveType`, `IsVerified`, `IsApproved`, `Reason`) VALUES
(16, 10, '2016-12-08', '2016-12-09', '2016-12-13', 4.0, 'CL', 0, 0, 'take a life break');

-- --------------------------------------------------------

--
-- Table structure for table `hi_privacy`
--

CREATE TABLE IF NOT EXISTS `hi_privacy` (
  `userid` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `cell_Number` int(11) NOT NULL,
  `office_Phone` int(11) NOT NULL,
  `nID` int(11) NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hi_privacy`
--

INSERT INTO `hi_privacy` (`userid`, `email`, `cell_Number`, `office_Phone`, `nID`) VALUES
(1, 0, 0, 0, 0),
(10, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hi_settings`
--

CREATE TABLE IF NOT EXISTS `hi_settings` (
  `site_name` varchar(255) NOT NULL DEFAULT 'Demo Site',
  `url` varchar(300) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `max_ban_period` int(11) NOT NULL DEFAULT '10',
  `register` int(11) NOT NULL DEFAULT '1',
  `email_validation` int(11) NOT NULL DEFAULT '0',
  `captcha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hi_settings`
--

INSERT INTO `hi_settings` (`site_name`, `url`, `admin_email`, `max_ban_period`, `register`, `email_validation`, `captcha`) VALUES
('holidayInnStaffPortal', 'http://localhost/staffPortal', 'nor.reply@gmail.com', 10, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hi_users`
--

CREATE TABLE IF NOT EXISTS `hi_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nID` varchar(45) NOT NULL,
  `position` varchar(45) NOT NULL,
  `dept` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `marital_Status` varchar(45) NOT NULL,
  `cell_Number` varchar(45) NOT NULL,
  `office_Phone` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `key` varchar(50) NOT NULL,
  `validated` varchar(100) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '2',
  `lastactive` int(11) NOT NULL,
  `showavt` int(11) NOT NULL DEFAULT '1',
  `banned` int(11) NOT NULL,
  `regtime` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `hi_users`
--

INSERT INTO `hi_users` (`userid`, `username`, `display_name`, `password`, `nID`, `position`, `dept`, `title`, `marital_Status`, `cell_Number`, `office_Phone`, `email`, `key`, `validated`, `groupid`, `lastactive`, `showavt`, `banned`, `regtime`) VALUES
(1, 'admin', 'Admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '64-1234567w77', 'General Manager', '', 'Mr', 'Married', '+263777123456', '04-12345', 'admin@gmail.com', '', '1', 4, 1481206444, 0, 0, 1480306746),
(10, 'Tanaka', 'Tanaka', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '', '', '', '', '', '', 'tanak@gmail.com', '', '1', 2, 1481213441, 1, 0, 1481199719);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
