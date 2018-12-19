-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2018 at 06:02 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classrecord2`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `assessment_id` int(11) NOT NULL,
  `assessment_name` varchar(64) NOT NULL,
  `assessment_total` float NOT NULL,
  `gradeSys_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`assessment_id`, `assessment_name`, `assessment_total`, `gradeSys_id`) VALUES
(1, 'Laboratory Exercises', 2.5, 1),
(127, 'Midterm', 0, 40),
(128, 'Formative Assessment', 0, 41),
(129, 'Major Assessment', 0, 39),
(132, 'Formative Assessment', 0, 42),
(133, 'Laboratory Exercises', 0, 43),
(134, 'Seatworks', 0, 44);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(24) NOT NULL,
  `course_title` varchar(64) NOT NULL,
  `course_program` varchar(64) NOT NULL,
  `course_prereq` varchar(64) NOT NULL,
  `course_credits` float NOT NULL,
  `course_desc` varchar(255) NOT NULL,
  `course_sched` text NOT NULL,
  `course_perc` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_code`, `course_title`, `course_program`, `course_prereq`, `course_credits`, `course_desc`, `course_sched`, `course_perc`) VALUES
(1, '3101', 'SYSTEMS INTEGRATION AND ARCHITECTURE I', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 'IT 2202', 5, 'EXO!? BTS!? WHAT\"S THAT!?', 'MW 3:00-6:00PM', 60),
(2, '3103', 'INTEGRATIVE PROGRAMMING AND TECHNOLOGY I', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 'IT 2103', 5, 'DO I CONVERT? YES? OR NO?', 'MW 12:00-3:00 PM', 60);

-- --------------------------------------------------------

--
-- Table structure for table `gradesystem`
--

CREATE TABLE `gradesystem` (
  `gradeSys_id` int(11) NOT NULL,
  `gradeSys_name` varchar(64) NOT NULL,
  `gradeSys_percentage` int(11) NOT NULL,
  `gradeSys_type` int(4) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gradesystem`
--

INSERT INTO `gradesystem` (`gradeSys_id`, `gradeSys_name`, `gradeSys_percentage`, `gradeSys_type`, `course_id`) VALUES
(1, 'Pre-Midterm', 30, 1, 1),
(39, 'Major Assessment', 50, 0, 2),
(40, 'Midterm', 25, 1, 2),
(41, 'Final', 25, 1, 2),
(42, 'Formative Assessment', 50, 0, 2),
(43, 'Laboratory Exercises', 25, 1, 2),
(44, 'Seatworks', 25, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `individual`
--

CREATE TABLE `individual` (
  `individual_id` int(11) NOT NULL,
  `individual_name` varchar(64) NOT NULL,
  `individual_type` enum('rubric','score based','','') NOT NULL,
  `individual_score` int(64) NOT NULL,
  `individual_passing` int(4) NOT NULL,
  `assessment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `individual`
--

INSERT INTO `individual` (`individual_id`, `individual_name`, `individual_type`, `individual_score`, `individual_passing`, `assessment_id`) VALUES
(2, 'Laboratory 1', 'rubric', 0, 0, 133),
(13, 'Laboratory 2', 'score based', 0, 50, 133),
(14, 'Laboratory 3', 'score based', 0, 60, 133),
(15, 'Laboratory 5', 'rubric', 0, 25, 133),
(16, 'Laboratory 4', 'rubric', 0, 60, 133);

-- --------------------------------------------------------

--
-- Table structure for table `rubric`
--

CREATE TABLE `rubric` (
  `rubric_id` int(11) NOT NULL,
  `rubric_name` varchar(64) NOT NULL,
  `rubric_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubric`
--

INSERT INTO `rubric` (`rubric_id`, `rubric_name`, `rubric_desc`) VALUES
(7, 'Expert', 'Algorithm development\r\ntechnique applied\r\nis correct for the given\r\nproblem satisfying all of requirements 1 to 4 \r\n1.	Optimal: Ability to apply technique with optimal (or best known) approach for the given problem.\r\n2.	Clarity: Ability to present clear ideas with detailed and accurate information. \r\n3.	Organization: Ability to present ideas in an organized and a logical order.\r\n4.	Syntax: Ability to understand and follow the rules of the algorithm development.\r\n'),
(9, 'Competent', 'Algorithm is correct  satisfying partially requirement 1 and AT LEAST TWO of requirements 2 to 4'),
(33, 'Beginner', 'Beginner (4.0) '),
(34, 'Failed', 'No algorithm presented.'),
(35, 'Rubric LAB', 'rubric for lab exercises');

-- --------------------------------------------------------

--
-- Table structure for table `rubriccon`
--

CREATE TABLE `rubriccon` (
  `con_id` int(11) NOT NULL,
  `rubric_id` int(11) NOT NULL,
  `individual_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubriccon`
--

INSERT INTO `rubriccon` (`con_id`, `rubric_id`, `individual_id`) VALUES
(2, 35, 16);

-- --------------------------------------------------------

--
-- Table structure for table `rubricdesc`
--

CREATE TABLE `rubricdesc` (
  `rubricDesc_id` int(11) NOT NULL,
  `rubricDesc_name` varchar(64) NOT NULL,
  `rubricDesc_grade` float NOT NULL,
  `rubricDesc_desc` text NOT NULL,
  `rubric_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubricdesc`
--

INSERT INTO `rubricdesc` (`rubricDesc_id`, `rubricDesc_name`, `rubricDesc_grade`, `rubricDesc_desc`, `rubric_id`) VALUES
(7, 'Algorithm Development Rubrics', 1, 'Algorithm Development Rubrics for Laboratory 2 ', 7),
(8, 'Algorithm Development Rubrics', 2, 'Algorithm Development Rubrics for Laboratory 2', 9),
(9, 'Algorithm Development Rubrics', 4, 'Algorithm Development Rubrics for Laboratory 2', 33),
(10, 'Algorithm Development Rubrics', 5, 'Algorithm Development Rubrics for Laboratory 2', 34),
(11, 'Expert', 1, 'Experttt', 35),
(12, 'Competent', 2, 'Competenttt', 35),
(13, 'Fail', 5, 'Failed', 35);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `score_id` int(11) NOT NULL,
  `score_score` float NOT NULL,
  `individual_id` int(11) NOT NULL,
  `scstudent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`score_id`, `score_score`, `individual_id`, `scstudent_id`) VALUES
(1, 2, 2, 15105130),
(2, 5, 2, 15105129),
(21, 30, 13, 15105130),
(22, 45, 13, 15105129),
(23, 80, 14, 15105129),
(24, 75, 14, 15105130),
(25, 45, 15, 15105129),
(26, 40, 15, 15105130),
(27, 80, 16, 15105129),
(28, 70, 16, 15105130);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_fname` varchar(24) NOT NULL,
  `student_lname` varchar(24) NOT NULL,
  `student_program` varchar(64) NOT NULL,
  `student_year` int(11) NOT NULL,
  `cos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_fname`, `student_lname`, `student_program`, `student_year`, `cos_id`) VALUES
(15105127, 'Dominic', 'Arimbay', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 3, 1),
(15105128, 'Alyssa', 'EXO', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 2, 1),
(15105129, 'Alyssa', 'EXO', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 2, 2),
(15105130, 'Reva', 'BTS', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 3, 2),
(15105131, 'Reva', 'BTS', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 3, 1),
(15105132, 'Joshua', 'Edioma', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(24) NOT NULL,
  `user_lname` varchar(24) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_email` varchar(32) NOT NULL,
  `user_dept` varchar(64) NOT NULL,
  `user_type` enum('Full Time','Part Time','Tenured','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_fname`, `user_lname`, `user_password`, `user_email`, `user_dept`, `user_type`) VALUES
(123456, 'Bruce', 'Banner', '76254239879f7ed7d73979f1f7543a7e', 'banner.bruce@gmail.com', 'Physics', 'Full Time'),
(123457, 'Peter', 'Parker', '1fd68a660bdb159cb2412cee00312787', 'peter.spooder@gmail.com', 'Information Technology', 'Full Time');

-- --------------------------------------------------------

--
-- Table structure for table `usercourse`
--

CREATE TABLE `usercourse` (
  `userCourse_id` int(11) NOT NULL,
  `userCourse_year` int(4) NOT NULL,
  `userCourse_term` enum('First','Second','Summer','') NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usercourse`
--

INSERT INTO `usercourse` (`userCourse_id`, `userCourse_year`, `userCourse_term`, `course_id`, `user_id`) VALUES
(1, 2018, 'First', 2, 123456),
(2, 2018, 'First', 2, 123456);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `rubric_relation` (`gradeSys_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `gradesystem`
--
ALTER TABLE `gradesystem`
  ADD PRIMARY KEY (`gradeSys_id`),
  ADD KEY `gradsys_relation` (`course_id`);

--
-- Indexes for table `individual`
--
ALTER TABLE `individual`
  ADD PRIMARY KEY (`individual_id`),
  ADD KEY `criteria_relation` (`assessment_id`);

--
-- Indexes for table `rubric`
--
ALTER TABLE `rubric`
  ADD PRIMARY KEY (`rubric_id`);

--
-- Indexes for table `rubriccon`
--
ALTER TABLE `rubriccon`
  ADD PRIMARY KEY (`con_id`),
  ADD KEY `con_rubric` (`rubric_id`),
  ADD KEY `con_individual` (`individual_id`);

--
-- Indexes for table `rubricdesc`
--
ALTER TABLE `rubricdesc`
  ADD PRIMARY KEY (`rubricDesc_id`),
  ADD KEY `rubricDesc_rubric` (`rubric_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `student_relation` (`scstudent_id`),
  ADD KEY `indev_relation` (`individual_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `course_relationrelation` (`cos_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `usercourse`
--
ALTER TABLE `usercourse`
  ADD PRIMARY KEY (`userCourse_id`),
  ADD KEY `user_course` (`user_id`),
  ADD KEY `course_user` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `gradesystem`
--
ALTER TABLE `gradesystem`
  MODIFY `gradeSys_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `individual`
--
ALTER TABLE `individual`
  MODIFY `individual_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `rubric`
--
ALTER TABLE `rubric`
  MODIFY `rubric_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `rubriccon`
--
ALTER TABLE `rubriccon`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rubricdesc`
--
ALTER TABLE `rubricdesc`
  MODIFY `rubricDesc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15105133;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123458;
--
-- AUTO_INCREMENT for table `usercourse`
--
ALTER TABLE `usercourse`
  MODIFY `userCourse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `assessment_relation` FOREIGN KEY (`gradeSys_id`) REFERENCES `gradesystem` (`gradeSys_id`);

--
-- Constraints for table `gradesystem`
--
ALTER TABLE `gradesystem`
  ADD CONSTRAINT `gradsys_relation` FOREIGN KEY (`course_id`) REFERENCES `usercourse` (`userCourse_id`);

--
-- Constraints for table `individual`
--
ALTER TABLE `individual`
  ADD CONSTRAINT `criteria_relation` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`assessment_id`);

--
-- Constraints for table `rubriccon`
--
ALTER TABLE `rubriccon`
  ADD CONSTRAINT `con_individual` FOREIGN KEY (`individual_id`) REFERENCES `individual` (`individual_id`),
  ADD CONSTRAINT `con_rubric` FOREIGN KEY (`rubric_id`) REFERENCES `rubric` (`rubric_id`);

--
-- Constraints for table `rubricdesc`
--
ALTER TABLE `rubricdesc`
  ADD CONSTRAINT `rubricDesc_rubric` FOREIGN KEY (`rubric_id`) REFERENCES `rubric` (`rubric_id`);

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `individual_relation` FOREIGN KEY (`individual_id`) REFERENCES `individual` (`individual_id`),
  ADD CONSTRAINT `student_relation` FOREIGN KEY (`scstudent_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `course_relationrelation` FOREIGN KEY (`cos_id`) REFERENCES `usercourse` (`userCourse_id`);

--
-- Constraints for table `usercourse`
--
ALTER TABLE `usercourse`
  ADD CONSTRAINT `course_user` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `user_course` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
