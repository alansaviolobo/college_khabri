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
  `category` varchar(255),
  `cet_appno` char(9),
  `projected_cet_score` smallint,
  `cet_score` smallint,
  `cet_rank` smallint,
  `aieee_appno` char(10),
  `projected_aieee_score` smallint,
  `aieee_score` smallint,
  `aieee_rank` smallint,
  `home_uni` varchar(255),
  `gender` ENUM('male', 'female'),
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
-- Table structure for table `collegekhabri`.`saved_searches`
--

CREATE TABLE `saved_searches` (
  `id` integer unsigned NOT NULL auto_increment,
  `user_id` integer unsigned NOT NULL,
  `saved_on` datetime NOT NULL,
  `universities` varchar(255),
  `districts` varchar(255),
  `courses` varchar(255),
  `search` varchar(255),
  `aid` varchar(255),
  `minority` varchar(255),
  `autonomy` varchar(255),
  `fees` varchar(255),
  `hostel` varchar(255),
  `establishedin` varchar(255),
  `ladies` bool,
  `cutoff` varchar(255),
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
  `ladies_only` boolean NOT NULL default false,
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
  `boys_hostel` smallint unsigned NOT NULL default 0,
  `girls_hostel` smallint unsigned NOT NULL default 0,
  `boys_hostel_1styear` smallint unsigned NOT NULL default 0,
  `girls_hostel_1styear` smallint unsigned NOT NULL default 0,
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
  `start_year` year not null,
  `accredited_from` date,
  `accredited_to` date,
  `intake` tinyint default 0,
  `cap_seats` tinyint default 0,
  `ms_seats` tinyint default 0,
  `institute_seats` tinyint default 0,
  `minority_seats` tinyint default 0,
  `mkb` tinyint default 0,
  `aieee_seats` tinyint default 0,
  `tfws` tinyint default 0,
  `tfwsh` tinyint default 0,
  `tfwso` tinyint default 0,
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
  `choice_code` integer unsigned NOT NULL,
  `sanctioned_intake` smallint unsigned NOT NULL default 0,
  `required_faculty` smallint unsigned NOT NULL default 0,
  `total_faculty` smallint unsigned NOT NULL default 0,
  `graduate` smallint unsigned NOT NULL default 0,
  `doctorate` smallint unsigned NOT NULL default 0,
  `post_graduate` smallint unsigned NOT NULL default 0,
  `teaching_experience` smallint unsigned NOT NULL default 0,
  `industry_experience` smallint unsigned NOT NULL default 0,
  `research_experience` smallint unsigned NOT NULL default 0,
  `permanent_faculty_student_ratio` varchar(255) NOT NULL default 0,
  `faculty_student_ratio` varchar(255) NOT NULL default 0,
  UNIQUE KEY  (`choice_code`),
  FOREIGN KEY (`choice_code`) REFERENCES `choice_codes`(`code`)
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
-- Table structure for table `collegekhabri`.`cutoffs`
--

CREATE TABLE cutoffs (
  choicecode integer unsigned DEFAULT NULL,
  seattype char(10) DEFAULT NULL,
  category char(10) DEFAULT NULL,
  cutoffrank int(11) DEFAULT NULL,
  homeuni char(10) DEFAULT NULL,
  round int(11) DEFAULT NULL,
  year year(4) DEFAULT NULL
);

--
-- Table structure for table `collegekhabri`.`fees_heads`
--

CREATE TABLE `fees_heads` (
  `fee_head_code` integer unsigned NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`fee_head_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`fees`
--

CREATE TABLE `fees` (
  `institute_code` char(10) NOT NULL,
  `tuition` integer NOT NULL default 0,
  `development` integer NOT NULL default 0,
  `total` integer NOT NULL default 0,
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
-- Table structure for table `collegekhabri`.`placements`
--

CREATE TABLE `placements` (
  `choice_code` integer unsigned NOT NULL,
  `total_passing` smallint unsigned NOT NULL default 0,
  `total_placed` smallint unsigned NOT NULL default 0,
  `min_salary` integer unsigned NOT NULL default 0,
  `max_salary` integer unsigned NOT NULL default 0,
  `avg_salary` integer unsigned NOT NULL default 0,
  `median_salary` integer unsigned NOT NULL default 0,
  `year` char(7),
  PRIMARY KEY  (`choice_code`, `year`)
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
