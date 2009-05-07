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
  `id` integer unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255),
  `mobile` char(10) NOT NULL,
  `cet_appno` char(9) NOT NULL,
  `cet_marks` smallint NOT NULL,
  `cet_rank` smallint NOT NULL,
  `aieee_appno` char(10) NOT NULL,
  `aieee_marks` smallint NOT NULL,
  `aieee_rank` smallint NOT NULL,
  `home_uni` varchar(255) NOT NULL,
  `status` ENUM('registered', 'premium', 'locked', 'inactive') NOT NULL DEFAULT 'registered',
  PRIMARY KEY  (`id`),
  UNIQUE KEY  (`username`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`payment_log`
--

CREATE TABLE `payment_log` (
  `id` integer unsigned NOT NULL auto_increment,
  `user_id` integer unsigned NOT NULL,
  `code` char(5) NOT NULL,
  `created_on` datetime NOT NULL,
  `paid_on` datetime DEFAULT NULL,
  `applied_on` datetime DEFAULT NULL,
  `amount` smallint unsigned NOT NULL default 100,
  `description` varchar(255) NOT NULL default 'subscription charges',
  `channel` ENUM('creditcard', 'cashdeposit', 'neft') NOT NULL default 'cashdeposit',
  `status` ENUM('pending', 'paid', 'applied') default 'pending',
  PRIMARY KEY  (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`universities`
--

CREATE TABLE `universities` (
  `id` tinyint unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`institutes`
--

CREATE TABLE `institutes` (
  `code` char(10) NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `university_id` tinyint unsigned NOT NULL,
  `aid_status` varchar(255) NOT NULL default '',
  `autonomy_status` varchar(255) NOT NULL default '',
  `minority_status` varchar(255) NOT NULL default '',
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
  `established_in` year NOT NULL,
  `closest_busstop` varchar(255) NOT NULL default '',
  `closest_railway_station` varchar(255) NOT NULL default '',
  `closest_airport` varchar(255) NOT NULL default '',
  `boys_hostel` varchar(255) NOT NULL default '',
  `girls_hostel` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`code`),
  FOREIGN KEY (`university_id`) REFERENCES `universities`(`id`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`courses`
--

CREATE TABLE `courses` (
  `code` smallint unsigned NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `group` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`choice_codes`
--

CREATE TABLE `choice_codes` (
  `code` integer unsigned NOT NULL auto_increment,
  `institute_code` char(10) NOT NULL,
  `course_code` smallint unsigned NOT NULL,
  `accredited_from` year,
  `accredited_to` year,
  `start_year` year,
  PRIMARY KEY  (`code`),
  FOREIGN KEY (`course_code`) REFERENCES `courses`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`institute_code`) REFERENCES `institutes`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`reservation_categories`
--

CREATE TABLE `reservation_categories` (
  `id` tinyint unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`reservation_quotas`
--

CREATE TABLE `choice_code_reservation_quotas` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `category_id` tinyint unsigned NOT NULL,
  `category_parent` tinyint unsigned NOT NULL,
  `quota` tinyint unsigned,
  PRIMARY KEY  (`choice_code`, `category_id`, `category_parent`),
  FOREIGN KEY (`choice_code`) REFERENCES `choice_codes`(`code`)
  ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `reservation_categories`(`id`)
  ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (`category_parent`) REFERENCES `reservation_categories`(`id`)
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
  `choice_code` integer unsigned NOT NULL auto_increment,
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
  `ChoiceCode` integer unsigned NOT NULL auto_increment,
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
  `Year` integer unsigned NOT NULL auto_increment,
  `NameOfCompany` varchar(45) NOT NULL default '',
  `TotalPlaced` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`Year`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`placementdata`
--

CREATE TABLE `placementdata` (
  `ChoiceCode` integer unsigned NOT NULL auto_increment,
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
  `CategoryCode` integer unsigned NOT NULL auto_increment,
  `Category` varchar(45) NOT NULL default '',
  `ReservationPercentage` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`CategoryCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`seatdistribution`
--

CREATE TABLE `seatdistribution` (
  `ChoiceCode` integer unsigned NOT NULL auto_increment,
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
  `ChoiceCode` integer unsigned NOT NULL auto_increment,
  `Round` varchar(45) NOT NULL default '',
  `Vacancy` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

GRANT ALL PRIVILEGES ON collegekhabri.* TO 'collegekhabri'@'localhost' IDENTIFIED BY 'collegekhabri';
