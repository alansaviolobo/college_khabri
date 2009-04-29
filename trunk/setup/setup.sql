/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--
-- Create schema collegekhabri
--
DROP DATABASE IF EXISTS collegekhabri;
CREATE DATABASE collegekhabri;
USE collegekhabri;

--
-- Table structure for table `collegekhabri`.`users`
--

CREATE TABLE `users` (
  `user_id` integer unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `birth_date` date NOT NULL,
  `mobile` char(10) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`universities`
--

CREATE TABLE `universities` (
  `id` tinyint unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
--  `city` varchar(45) NOT NULL default '',
  `districts_under_control` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`institutes`
--

CREATE TABLE `institutes` (
  `code` char(10) NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `university` tinyint unsigned NOT NULL,
  `status` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `district` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `pincode` varchar(255) NOT NULL default '',
  `stdcode` varchar(5) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `established_in` varchar(255) NOT NULL default '',
  `closest_busstop` varchar(255) NOT NULL default '',
  `closest_railway_station` varchar(255) NOT NULL default '',
  `closest_airport` varchar(255) NOT NULL default '',
  `library` varchar(255) NOT NULL default '',
  `building` varchar(255) NOT NULL default '',
  `classrooms` varchar(255) NOT NULL default '',
  `land_availability` varchar(255) NOT NULL default '',
  `computers` varchar(255) NOT NULL default '',
  `laboratory` varchar(255) NOT NULL default '',
  `boys_hostel` integer unsigned NOT NULL default 0,
  `girls_hostel` integer unsigned NOT NULL default 0,
  `sactioned_intake` tinyint unsigned NOT NULL default 0,
  `required_faculty` tinyint unsigned NOT NULL default 0,
  `professors` tinyint unsigned NOT NULL default 0,
  `asst_professors` tinyint unsigned NOT NULL default 0,
  `lecturers` tinyint unsigned NOT NULL default 0,
  `visiting_faculty` tinyint unsigned NOT NULL default 0,
  `permanent_faculty` tinyint unsigned NOT NULL default 0,
  `apporved_faculty` tinyint unsigned NOT NULL default 0,
  `adhoc_faculty` tinyint unsigned NOT NULL default 0,
  PRIMARY KEY  (`code`),
  FOREIGN KEY (`university`) REFERENCES `universities`(`id`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`faculty`
--

CREATE TABLE `faculty` (
  `id` integer NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `designation` varchar(255) NOT NULL default '',
  `qualification` enum('ug','pg','doctorate') default NULL,
  `experience` enum('teaching','industry','research') default NULL,
  `joining_institute` varchar(45) NOT NULL default '',
  `choice_code` varchar(45) NOT NULL default '',
  `category` varchar(45) NOT NULL default '',
  `LessThan6Months` boolean NOT NULL,
  `6monthTo1yr` boolean NOT NULL,
  `institute_code` char(10) NOT NULL,
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`institute_code`) REFERENCES `institutes`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`courses`
--

CREATE TABLE `courses` (
  `id` integer unsigned NOT NULL auto_increment,
  `code` integer unsigned,
  `name` varchar(255) NOT NULL default '',
  UNIQUE KEY  (`code`),
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`institutecourse`
--

CREATE TABLE `institutecourse` (
  `course_code` int(10) unsigned NOT NULL auto_increment,
  `institute_code` char(10) NOT NULL default '',
  `AccreditedFrom` varchar(45) NOT NULL default '',
  `Intake` varchar(45) NOT NULL default '',
  `StartYear` varchar(45) NOT NULL default '',
  `CAPSeats` varchar(45) NOT NULL default '',
  `MSSeats` varchar(45) NOT NULL default '',
  `InstituteSeats` varchar(45) NOT NULL default '',
  `MinoritySeats` varchar(45) NOT NULL default '',
  `MKB` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`course_code`, `institute_code`),
  FOREIGN KEY (`course_code`) REFERENCES `courses`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`institute_code`) REFERENCES `institutes`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`admissions_status`
--

CREATE TABLE `admissions_status` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `year` year(4) NOT NULL,
  `sanctioned_intake` integer NOT NULL default 0,
  `actual_admissions` integer NOT NULL default 0,
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`approval_status`
--

CREATE TABLE `approval_status` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `accredition_valid_from` year(4) NOT NULL default '',
  `accredition_valid_to` year(4) NOT NULL default '',
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`cutoff`
--

CREATE TABLE `cutoff` (
  `choice_code` int(10) unsigned NOT NULL auto_increment,
  `category_code` varchar(45) NOT NULL default '',
  `home_uni_status` enum('home', 'outside') NOT NULL default 'home',
  `ladies_status` enum('ladies', 'general') NOT NULL default 'general',
  `cutoff_merit_rank` mediumint unsigned NOT NULL default '0',
  `cutoff_cet_score` mediumint unsigned NOT NULL default '0',
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`fees_heads`
--

CREATE TABLE `fees_heads` (
  `fee_head_code` integer unsigned NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`fee_head_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`fee_structure`
--

CREATE TABLE `fee_structure` (
  `institute_code` char(10) NOT NULL,
  `tuition_fee` integer NOT NULL default 0,
  `development_fee` integer NOT NULL default 0,
  `total_fee` integer NOT NULL default 0,
  `year` char(7) NOT NULL,
  PRIMARY KEY  (`institute_code`, `year`),
  FOREIGN KEY (`institute_code`) REFERENCES `institutes`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`passdata`
--

CREATE TABLE `passdata` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `Year` varchar(45) NOT NULL default '',
  `SactionedIntake` varchar(45) NOT NULL default '',
  `Admitted` varchar(45) NOT NULL default '',
  `FirstAttemptPassPercent` varchar(45) NOT NULL default '',
  `DistinctionPassPercent` varchar(45) NOT NULL default '',
  `FirstDivisionPercent` varchar(45) NOT NULL default '',
  `SecondDivisionPercent` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`placementcompanies`
--

CREATE TABLE `placementcompanies` (
  `Year` int(10) unsigned NOT NULL auto_increment,
  `NameOfCompany` varchar(45) NOT NULL default '',
  `TotalPlaced` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`Year`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`placementdata`
--

CREATE TABLE `placementdata` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `PlacementFacility` varchar(45) NOT NULL default '',
  `Year` varchar(45) NOT NULL default '',
  `TotalPassingStudents` varchar(45) NOT NULL default '',
  `TotalPlaced` varchar(45) NOT NULL default '',
  `MinimumSalary` varchar(45) NOT NULL default '',
  `MaxSalary` varchar(45) NOT NULL default '',
  `AverageSalary` varchar(45) NOT NULL default '',
  `MedianSalary` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`reservation`
--

CREATE TABLE `reservation` (
  `CategoryCode` int(10) unsigned NOT NULL auto_increment,
  `Category` varchar(45) NOT NULL default '',
  `ReservationPercentage` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`CategoryCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`seatdistribution`
--

CREATE TABLE `seatdistribution` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `CategoryCode` varchar(45) NOT NULL default '',
  `HUorOHU` varchar(45) NOT NULL default '',
  `GeneralOrLadies` varchar(45) NOT NULL default '',
  `Intake` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`vacancyposition`
--

CREATE TABLE `vacancyposition` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `Round` varchar(45) NOT NULL default '',
  `Vacancy` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

GRANT ALL PRIVILEGES ON collegekhabri.* TO 'collegekhabri'@'localhost' IDENTIFIED BY 'collegekhabri';
