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

CREATE DATABASE /*!32312 IF NOT EXISTS*/ collegekhabri;
USE collegekhabri;
GRANT ALL PRIVILEGES ON collegekhabri.* TO 'collegekhabri'@'localhost' IDENTIFIED BY 'collegekhabri';

--
-- Table structure for table `collegekhabri`.`admissions_status`
--

DROP TABLE IF EXISTS `admissions_status`;
CREATE TABLE `admissions_status` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `year` year(4) NOT NULL,
  `sanctioned_intakte` integer NOT NULL default 0,
  `actual_admissions` integer NOT NULL default 0,
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`approval_status`
--

DROP TABLE IF EXISTS `approval_status`;
CREATE TABLE `approval_status` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `accredition_valid_from` year(4) NOT NULL default '',
  `accredition_valid_to` year(4) NOT NULL default '',
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `code` integer unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`cutoff`
--

DROP TABLE IF EXISTS `cutoff`;
CREATE TABLE `cutoff` (
  `choice_code` int(10) unsigned NOT NULL auto_increment,
  `category_code` varchar(45) NOT NULL default '',
  `home_uni_status` enum('home', 'outside') NOT NULL default 'home',
  `ladies_status` enum('ladies', 'general') NOT NULL default 'general',
  `cutoff_merit_rank` mediumint unsigned NOT NULL default '0',
  `cutoff_cet_score` mediumint unsigned NOT NULL default '',
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `sactioned_intake` tinyint unsigned NOT NULL,
  `required_faculty` tinyint unsigned NOT NULL,
  `professors` tinyint unsigned NOT NULL,
  `asst_professors` tinyint unsigned NOT NULL,
  `lecturers` tinyint unsigned NOT NULL,
  `visiting_faculty` tinyint unsigned NOT NULL,
  `permanent_faculty` tinyint unsigned NOT NULL,
  `apporved_Faculty` tinyint unsigned NOT NULL,
  `adhoc_faculty` tinyint unsigned NOT NULL,
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`faculty_details`
--

DROP TABLE IF EXISTS `faculty_details`;
CREATE TABLE `faculty_details` (
  `id` integer NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `designation` varchar(255) NOT NULL default '',
  `qualification` enum('ug','pg','doctorate') default NULL,
  `experience` enum('teaching','industry','research') default NULL,
  `joining_institute` varchar(45) NOT NULL default '',
  `choice_code` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`Name`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`faculty_stability`
--

DROP TABLE IF EXISTS `faculty_stability`;
CREATE TABLE `faculty_stability` (
  `choice_code` integer unsigned NOT NULL auto_increment,
  `category` varchar(45) NOT NULL default '',
  `LessThan6Months` boolean NOT NULL default '',
  `6monthTo1yr` boolean NOT NULL default '',
  PRIMARY KEY  (`choice_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`fees_heads`
--

DROP TABLE IF EXISTS `fees_heads`;
CREATE TABLE `fees_heads` (
  `fee_head_code` integer unsigned NOT NULL auto_increment,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`fee_head_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`fee_structure`
--

DROP TABLE IF EXISTS `fee_structure`;
CREATE TABLE `fee_structure` (
  `institute_code` integer unsigned NOT NULL auto_increment,
  `fee_head_code` varchar(45) NOT NULL default '',
  `fee` mediumint NOT NULL default '',
  PRIMARY KEY  (`InstituteCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`infrastructure`
--

DROP TABLE IF EXISTS `infrastructure`;
CREATE TABLE `infrastructure` (
  `library` varchar(45) NOT NULL default '',
  `building` varchar(45) NOT NULL default '',
  `classrooms` varchar(45) NOT NULL default '',
  `land_availability` varchar(45) NOT NULL default '',
  `computers` varchar(45) NOT NULL default '',
  `laboratory` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`library`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`institutes`
--

DROP TABLE IF EXISTS `institutes`;
CREATE TABLE `institutes` (
  `institute_code` integer unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  `university_code` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `district` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `fax` varchar(255) NOT NULL default '',
  `pincode` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`institute_code`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`institutecourse`
--

DROP TABLE IF EXISTS `institutecourse`;
CREATE TABLE `institutecourse` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `InstituteCode` varchar(45) NOT NULL default '',
  `CourseCode` varchar(45) NOT NULL default '',
  `AccreditedFrom` varchar(45) NOT NULL default '',
  `Intake` varchar(45) NOT NULL default '',
  `StartYear` varchar(45) NOT NULL default '',
  `CAPSeats` varchar(45) NOT NULL default '',
  `MSSeats` varchar(45) NOT NULL default '',
  `InstituteSeats` varchar(45) NOT NULL default '',
  `MinoritySeats` varchar(45) NOT NULL default '',
  `MKB` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`instituteinfrastructure`
--

DROP TABLE IF EXISTS `instituteinfrastructure`;
CREATE TABLE `instituteinfrastructure` (
  `HostelIntakeBoys` int(10) unsigned NOT NULL auto_increment,
  `HostelIntakeGirls` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`HostelIntakeBoys`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`passdata`
--

DROP TABLE IF EXISTS `passdata`;
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

DROP TABLE IF EXISTS `placementcompanies`;
CREATE TABLE `placementcompanies` (
  `Year` int(10) unsigned NOT NULL auto_increment,
  `NameOfCompany` varchar(45) NOT NULL default '',
  `TotalPlaced` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`Year`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`placementdata`
--

DROP TABLE IF EXISTS `placementdata`;
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

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `CategoryCode` int(10) unsigned NOT NULL auto_increment,
  `Category` varchar(45) NOT NULL default '',
  `ReservationPercentage` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`CategoryCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`seatdistribution`
--

DROP TABLE IF EXISTS `seatdistribution`;
CREATE TABLE `seatdistribution` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `CategoryCode` varchar(45) NOT NULL default '',
  `HUorOHU` varchar(45) NOT NULL default '',
  `GeneralOrLadies` varchar(45) NOT NULL default '',
  `Intake` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`universities`
--

DROP TABLE IF EXISTS `universities`;
CREATE TABLE `universities` (
  `UniversityCode` int(10) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL default '',
  `City` varchar(45) NOT NULL default '',
  `DistrictsUnderControl` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`UniversityCode`)
) ENGINE=InnoDB;

--
-- Table structure for table `collegekhabri`.`vacancyposition`
--

DROP TABLE IF EXISTS `vacancyposition`;
CREATE TABLE `vacancyposition` (
  `ChoiceCode` int(10) unsigned NOT NULL auto_increment,
  `Round` varchar(45) NOT NULL default '',
  `Vacancy` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`ChoiceCode`)
) ENGINE=InnoDB;
