-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2017 at 05:52 PM
-- Server version: 5.6.33-0ubuntu0.14.04.1
-- PHP Version: 5.6.30-7+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', NULL),
('admin', '67', '2017-03-28'),
('admin', '85', '2017-04-05'),
('admin', '89', '2017-04-05'),
('user', '66', '2017-03-28'),
('user', '78', '2017-04-04'),
('user', '79', '2017-04-04'),
('user', '81', '2017-04-04'),
('user', '82', '2017-04-04'),
('user', '91', '2017-09-04'),
('user', '92', '2017-09-04'),
('user', '93', '2017-09-04'),
('user', '94', '2017-09-04'),
('user', '95', '2017-09-04'),
('user', '96', '2017-09-04');

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `role_alias` varchar(255) NOT NULL,
  `allow_registration` tinyint(1) DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` varchar(11) DEFAULT NULL,
  `updated_at` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `role_alias`, `allow_registration`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, 'Admin', 1, NULL, NULL, '2015-07-31 ', '1445239497'),
('backend:site:Index', 2, 'Allow call to Site Index', '', NULL, NULL, NULL, NULL, NULL),
('backend:site:Login', 2, 'Allow call to Site Login', '', NULL, NULL, NULL, NULL, NULL),
('backend:site:Logout', 2, 'Allow call to Site Logout', '', NULL, NULL, NULL, NULL, NULL),
('frontend:holiday:Create', 2, 'Allow call to Holiday Create', '', NULL, NULL, NULL, NULL, NULL),
('frontend:holiday:Delete', 2, 'Allow call to Holiday Delete', '', NULL, NULL, NULL, NULL, NULL),
('frontend:holiday:Index', 2, 'Allow call to Holiday Index', '', NULL, NULL, NULL, NULL, NULL),
('frontend:holiday:Update', 2, 'Allow call to Holiday Update', '', NULL, NULL, NULL, NULL, NULL),
('frontend:holiday:View', 2, 'Allow call to Holiday View', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Bulkdelete', 2, 'Allow call to Leave Bulkdelete', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Create', 2, 'Allow call to Leave Create', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Delete', 2, 'Allow call to Leave Delete', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Index', 2, 'Allow call to Leave Index', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Reject', 2, 'Allow call to Leave Reject', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Update', 2, 'Allow call to Leave Update', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:View', 2, 'Allow call to Leave View', '', NULL, NULL, NULL, NULL, NULL),
('frontend:leave:Viewleaves', 2, 'Allow call to Leave Viewleaves', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Accept', 2, 'Allow call to OhrmAttendanceRecord Accept', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Create', 2, 'Allow call to OhrmAttendanceRecord Create', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Creater', 2, 'Allow call to OhrmAttendanceRecord Creater', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Delete', 2, 'Allow call to OhrmAttendanceRecord Delete', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Index', 2, 'Allow call to OhrmAttendanceRecord Index', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Joining', 2, 'Allow call to OhrmAttendanceRecord Joining', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Panding', 2, 'Allow call to OhrmAttendanceRecord Panding', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Reject', 2, 'Allow call to OhrmAttendanceRecord Reject', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Report', 2, 'Allow call to OhrmAttendanceRecord Report', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:Update', 2, 'Allow call to OhrmAttendanceRecord Update', '', NULL, NULL, NULL, NULL, NULL),
('frontend:ohrm-attendance-record:View', 2, 'Allow call to OhrmAttendanceRecord View', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:About', 2, 'Allow call to Site About', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:Contact', 2, 'Allow call to Site Contact', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:Index', 2, 'Allow call to Site Index', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:Login', 2, 'Allow call to Site Login', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:Logout', 2, 'Allow call to Site Logout', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:RequestPasswordReset', 2, 'Allow call to Site RequestPasswordReset', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:ResetPassword', 2, 'Allow call to Site ResetPassword', '', NULL, NULL, NULL, NULL, NULL),
('frontend:site:Signup', 2, 'Allow call to Site Signup', '', NULL, NULL, NULL, NULL, NULL),
('frontend:workdays:Create', 2, 'Allow call to Workdays Create', '', NULL, NULL, NULL, NULL, NULL),
('frontend:workdays:Delete', 2, 'Allow call to Workdays Delete', '', NULL, NULL, NULL, NULL, NULL),
('frontend:workdays:Index', 2, 'Allow call to Workdays Index', '', NULL, NULL, NULL, NULL, NULL),
('frontend:workdays:Update', 2, 'Allow call to Workdays Update', '', NULL, NULL, NULL, NULL, NULL),
('frontend:workdays:View', 2, 'Allow call to Workdays View', '', NULL, NULL, NULL, NULL, NULL),
('guest', 1, NULL, 'Guest', 0, NULL, NULL, '2015-07-31 ', '1445239486'),
('superadmin', 1, NULL, 'Super Admin', 1, NULL, NULL, '2015-07-31 ', '1445239433'),
('user', 1, NULL, 'User', 1, NULL, NULL, '1441872891', '1445239438'),
('usermgmt:group-permission:GetChild', 2, 'Allow call to GroupPermission GetChild', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:GetChildRole', 2, 'Allow call to GroupPermission GetChildRole', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:GetParent', 2, 'Allow call to GroupPermission GetParent', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:GetRolePermission', 2, 'Allow call to GroupPermission GetRolePermission', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:Index', 2, 'Allow call to GroupPermission Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:Load', 2, 'Allow call to GroupPermission Load', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:group-permission:UpdateControllerList', 2, 'Allow call to GroupPermission UpdateControllerList', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:message:Create', 2, 'Allow call to Message Create', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:message:Delete', 2, 'Allow call to Message Delete', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:message:Index', 2, 'Allow call to Message Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:message:Update', 2, 'Allow call to Message Update', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:message:View', 2, 'Allow call to Message View', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:rbac:Init', 2, 'Allow call to Rbac Init', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:role-and-permission:DeleteRole', 2, 'Allow call to RoleAndPermission DeleteRole', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:role-and-permission:Edit', 2, 'Allow call to RoleAndPermission Edit', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:role-and-permission:Index', 2, 'Allow call to RoleAndPermission Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:role-and-permission:Save', 2, 'Allow call to RoleAndPermission Save', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:role-and-permission:View', 2, 'Allow call to RoleAndPermission View', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:setting:Edit', 2, 'Allow call to Setting Edit', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:setting:Index', 2, 'Allow call to Setting Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:site:Dashboard', 2, 'Allow call to Site Dashboard', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:site:Index', 2, 'Allow call to Site Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:site:Login', 2, 'Allow call to Site Login', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:site:Logout', 2, 'Allow call to Site Logout', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:site:ShowName', 2, 'Allow call to Site ShowName', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:source-message:Create', 2, 'Allow call to SourceMessage Create', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:source-message:Delete', 2, 'Allow call to SourceMessage Delete', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:source-message:Index', 2, 'Allow call to SourceMessage Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:source-message:Update', 2, 'Allow call to SourceMessage Update', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:source-message:View', 2, 'Allow call to SourceMessage View', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Approve', 2, 'Allow call to User Approve', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Birth', 2, 'Allow call to User Birth', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:ChangePassword', 2, 'Allow call to User ChangePassword', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:ChangeUserPassword', 2, 'Allow call to User ChangeUserPassword', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:ClearCache', 2, 'Allow call to User ClearCache', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Dashboard', 2, 'Allow call to User Dashboard', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Delete', 2, 'Allow call to User Delete', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Edit', 2, 'Allow call to User Edit', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:EditProfile', 2, 'Allow call to User EditProfile', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Index', 2, 'Allow call to User Index', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Login', 2, 'Allow call to User Login', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Logout', 2, 'Allow call to User Logout', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:LogoutUser', 2, 'Allow call to User LogoutUser', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:MyProfile', 2, 'Allow call to User MyProfile', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Online', 2, 'Allow call to User Online', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:PermissionDenied', 2, 'Allow call to User PermissionDenied', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Register', 2, 'Allow call to User Register', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:RequestPasswordReset', 2, 'Allow call to User RequestPasswordReset', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:ResetFilter', 2, 'Allow call to User ResetFilter', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:ResetPassword', 2, 'Allow call to User ResetPassword', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Review', 2, 'Allow call to User Review', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Save', 2, 'Allow call to User Save', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:SendVerifyEmail', 2, 'Allow call to User SendVerifyEmail', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:Status', 2, 'Allow call to User Status', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:StatusUser', 2, 'Allow call to User StatusUser', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:TwitterCallBack', 2, 'Allow call to User TwitterCallBack', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:VerifyEmail', 2, 'Allow call to User VerifyEmail', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:VerifySms', 2, 'Allow call to User VerifySms', '', NULL, NULL, NULL, NULL, NULL),
('usermgmt:user:View', 2, 'Allow call to User View', '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superadmin', 'admin'),
('user', 'frontend:holiday:Index'),
('user', 'frontend:leave:Create'),
('user', 'frontend:leave:Index'),
('user', 'frontend:ohrm-attendance-record:Index'),
('guest', 'frontend:site:Index'),
('user', 'frontend:workdays:Index'),
('user', 'usermgmt:user:Birth'),
('user', 'usermgmt:user:ChangePassword'),
('user', 'usermgmt:user:Dashboard'),
('user', 'usermgmt:user:EditProfile'),
('guest', 'usermgmt:user:Login'),
('guest', 'usermgmt:user:Logout'),
('user', 'usermgmt:user:Logout'),
('user', 'usermgmt:user:MyProfile'),
('guest', 'usermgmt:user:PermissionDenied'),
('guest', 'usermgmt:user:Register'),
('guest', 'usermgmt:user:RequestPasswordReset'),
('guest', 'usermgmt:user:ResetPassword'),
('guest', 'usermgmt:user:SendVerifyEmail'),
('user', 'usermgmt:user:SendVerifyEmail'),
('guest', 'usermgmt:user:VerifyEmail'),
('user', 'usermgmt:user:VerifyEmail'),
('user', 'usermgmt:user:VerifySms');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_timing`
--

CREATE TABLE IF NOT EXISTS `emp_timing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(15) NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `modified_by` varchar(20) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `modified_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `emp_timing`
--

INSERT INTO `emp_timing` (`id`, `emp_id`, `date`, `time`, `created_by`, `modified_by`, `created_date`, `modified_date`) VALUES
(14, 66, '2017-01-31', '10:30 AM', '1', NULL, '2017-03-28', NULL),
(15, 1, '2017-01-01', '10:00 AM', '1', NULL, '2017-01-01', NULL),
(16, 67, '2016-01-01', '10:00 AM', '1', NULL, '2017-03-28', NULL),
(35, 78, '2016-11-10', '09:30 AM', '1', NULL, '2017-04-04', NULL),
(36, 78, '2016-11-22', '10:30 AM', '1', NULL, '2017-04-04', NULL),
(37, 79, '2017-04-02', '01:00 PM', '1', NULL, '2017-04-04', NULL),
(38, 81, '2017-04-02', '01:00 PM', '1', NULL, '2017-04-04', NULL),
(40, 83, '2017-04-02', '03:00 PM', '1', NULL, '2017-04-04', NULL),
(42, 78, '2016-11-25', '11:30 AM', '1', NULL, '2017-04-04', NULL),
(43, 91, '2017-09-03', '04:15 PM', '1', NULL, '2017-09-04', NULL),
(44, 92, '2017-09-03', '04:15 PM', '1', NULL, '2017-09-04', NULL),
(45, 93, '2017-09-01', '04:30 PM', '1', NULL, '2017-09-04', NULL),
(47, 95, '2013-01-01', '11:00 AM', '1', NULL, '2017-09-04', NULL),
(48, 96, '2016-09-01', '07:30 PM', '1', NULL, '2017-09-04', NULL),
(50, 94, '2017-09-01', '10:30 AM', '1', NULL, '2017-09-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `createdby` varchar(20) DEFAULT NULL,
  `createddate` date DEFAULT NULL,
  `modifiedby` varchar(20) DEFAULT NULL,
  `modifieddate` date DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `date`, `description`, `createdby`, `createddate`, `modifiedby`, `modifieddate`, `deleted`) VALUES
(56, '2017-03-29', 'Navratri', '1', '2017-03-28', NULL, NULL, 0),
(57, '2017-09-05', 'Teachere''s Day', '1', '2017-09-05', '1', '2017-09-08', 0),
(58, '2017-10-19', 'Dipawali', '1', '2017-09-05', '1', '2017-09-05', 1),
(59, '2017-07-27', 'Nag Panchami', '1', '2017-09-09', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE IF NOT EXISTS `leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `type` int(10) NOT NULL COMMENT '1=> Full day, 2=> First half, 3=> second half',
  `remark` varchar(200) NOT NULL,
  `status` int(10) NOT NULL COMMENT '1 => Pending, 2 => Rejected, 3 => Accepted',
  `created_id` varchar(20) NOT NULL,
  `modify_id` varchar(20) NOT NULL,
  `created_date` date NOT NULL,
  `modify_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `leave`
--

INSERT INTO `leave` (`id`, `user_id`, `from_date`, `to_date`, `type`, `remark`, `status`, `created_id`, `modify_id`, `created_date`, `modify_date`) VALUES
(1, 1, '2017-04-12', '2017-04-12', 2, 'Some Urgent Work', 1, '', '', '0000-00-00', '0000-00-00'),
(3, 1, '2017-04-15', '2017-04-15', 3, 'Some Personal Work', 3, '', '', '0000-00-00', '0000-00-00'),
(5, 78, '2017-04-20', '2017-04-20', 2, 'Some urgent work', 3, '', '', '0000-00-00', '0000-00-00'),
(6, 66, '2017-04-07', '2017-04-07', 1, 'mnk', 3, '', '', '0000-00-00', '0000-00-00'),
(7, 1, '2017-09-01', '2017-09-30', 1, 'CL', 1, '', '', '0000-00-00', '0000-00-00'),
(28, 94, '2017-07-05', '2017-07-05', 1, '15-SH', 3, '', '', '0000-00-00', '0000-00-00'),
(29, 94, '2017-09-17', '2017-09-20', 1, '16-20', 1, '', '', '0000-00-00', '0000-00-00'),
(30, 94, '2017-09-26', '2017-09-30', 1, '26-30', 1, '', '', '0000-00-00', '0000-00-00'),
(31, 94, '2017-09-23', '2017-09-24', 1, '23-24', 1, '', '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE IF NOT EXISTS `login_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` char(32) NOT NULL,
  `duration` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1487057118),
('m130524_201442_init', 1487057124);

-- --------------------------------------------------------

--
-- Table structure for table `ohrm_attendance_record`
--

CREATE TABLE IF NOT EXISTS `ohrm_attendance_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `verify` int(11) NOT NULL DEFAULT '1',
  `employee_id` bigint(20) NOT NULL,
  `punch_in_date` date DEFAULT NULL,
  `punch_in_note` varchar(255) DEFAULT NULL,
  `punch_in_user_time` datetime DEFAULT NULL,
  `punch_out_note` varchar(255) DEFAULT NULL,
  `punch_out_user_time` datetime DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id_state` (`employee_id`,`state`),
  KEY `emp_id_time` (`employee_id`,`punch_in_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=562 ;

--
-- Dumping data for table `ohrm_attendance_record`
--

INSERT INTO `ohrm_attendance_record` (`id`, `verify`, `employee_id`, `punch_in_date`, `punch_in_note`, `punch_in_user_time`, `punch_out_note`, `punch_out_user_time`, `state`) VALUES
(426, 1, 94, '2017-07-03', 'In', '2017-07-03 10:21:00', 'Out', '2017-07-03 20:50:00', 'PUNCHED OUT'),
(427, 1, 94, '2017-07-04', 'In', '2017-07-04 10:19:00', 'Out', '2017-07-04 20:00:00', 'PUNCHED OUT'),
(429, 1, 94, '2017-07-06', 'In', '2017-07-06 10:24:00', 'Out', '2017-07-06 19:54:00', 'PUNCHED OUT'),
(430, 1, 94, '2017-07-07', 'In', '2017-07-07 10:22:00', 'Out', '2017-07-07 20:30:00', 'PUNCHED OUT'),
(431, 1, 94, '2017-07-08', 'In', '2017-07-08 10:20:00', 'Out', '2017-07-08 19:35:00', 'PUNCHED OUT'),
(432, 1, 94, '2017-07-10', 'In', '2017-07-10 10:21:00', 'Out', '2017-07-10 20:00:00', 'PUNCHED OUT'),
(433, 1, 94, '2017-07-11', 'In', '2017-07-11 10:43:00', 'Out', '2017-07-11 20:11:00', 'PUNCHED OUT'),
(434, 1, 94, '2017-07-12', 'In', '2017-07-12 10:23:00', 'Out', '2017-07-12 19:52:00', 'PUNCHED OUT'),
(435, 1, 94, '2017-07-13', 'In', '2017-07-13 10:19:00', 'Out', '2017-07-13 19:57:00', 'PUNCHED OUT'),
(436, 1, 94, '2017-07-14', 'In', '2017-07-14 10:20:00', 'Out', '2017-07-14 19:53:00', 'PUNCHED OUT'),
(437, 1, 94, '2017-07-17', 'In', '2017-07-17 10:23:00', 'Out', '2017-07-17 19:58:00', 'PUNCHED OUT'),
(438, 1, 94, '2017-07-18', 'In', '2017-07-18 10:26:00', 'Out', '2017-07-18 19:43:00', 'PUNCHED OUT'),
(439, 1, 94, '2017-07-19', 'In', '2017-07-19 11:31:00', 'Out', '2017-07-19 19:58:00', 'PUNCHED OUT'),
(440, 1, 94, '2017-07-20', 'In', '2017-07-20 10:39:00', 'Out', '2017-07-20 20:08:00', 'PUNCHED OUT'),
(441, 1, 94, '2017-07-21', 'In', '2017-07-21 10:08:00', 'Out', '2017-07-21 20:06:00', 'PUNCHED OUT'),
(442, 1, 94, '2017-07-22', 'In', '2017-07-22 10:15:00', 'Out', '2017-07-22 19:40:00', 'PUNCHED OUT'),
(443, 1, 94, '2017-07-24', 'In', '2017-07-24 10:23:00', 'Out', '2017-07-24 20:14:00', 'PUNCHED OUT'),
(444, 1, 94, '2017-07-25', 'In', '2017-07-25 10:23:00', 'Out', '2017-07-25 20:08:00', 'PUNCHED OUT'),
(445, 1, 94, '2017-07-26', 'In', '2017-07-26 10:18:00', 'Out', '2017-07-26 19:51:00', 'PUNCHED OUT'),
(447, 1, 94, '2017-07-28', 'In', '2017-07-28 10:24:00', 'Out', '2017-07-28 19:53:00', 'PUNCHED OUT'),
(448, 1, 94, '2017-07-31', 'In', '2017-07-31 10:21:00', 'Out', '2017-07-31 19:57:00', 'PUNCHED OUT'),
(449, 1, 96, '2017-07-03', 'In', '2017-07-03 10:21:00', 'Out', '2017-07-03 20:50:00', 'PUNCHED OUT'),
(450, 1, 96, '2017-07-04', 'In', '2017-07-04 10:19:00', 'Out', '2017-07-04 20:00:00', 'PUNCHED OUT'),
(451, 1, 96, '2017-07-05', 'In', '2017-07-05 10:24:00', 'Out', '2017-07-05 20:17:00', 'PUNCHED OUT'),
(452, 1, 96, '2017-07-06', 'In', '2017-07-06 10:24:00', 'Out', '2017-07-06 19:54:00', 'PUNCHED OUT'),
(453, 1, 96, '2017-07-07', 'In', '2017-07-07 10:22:00', 'Out', '2017-07-07 20:30:00', 'PUNCHED OUT'),
(454, 1, 96, '2017-07-08', 'In', '2017-07-08 10:20:00', 'Out', '2017-07-08 19:35:00', 'PUNCHED OUT'),
(455, 1, 96, '2017-07-10', 'In', '2017-07-10 10:21:00', 'Out', '2017-07-10 20:00:00', 'PUNCHED OUT'),
(456, 1, 96, '2017-07-11', 'In', '2017-07-11 10:43:00', 'Out', '2017-07-11 20:11:00', 'PUNCHED OUT'),
(457, 1, 96, '2017-07-12', 'In', '2017-07-12 10:23:00', 'Out', '2017-07-12 19:52:00', 'PUNCHED OUT'),
(458, 1, 96, '2017-07-13', 'In', '2017-07-13 10:19:00', 'Out', '2017-07-13 19:57:00', 'PUNCHED OUT'),
(459, 1, 96, '2017-07-14', 'In', '2017-07-14 10:20:00', 'Out', '2017-07-14 19:53:00', 'PUNCHED OUT'),
(460, 1, 96, '2017-07-17', 'In', '2017-07-17 10:23:00', 'Out', '2017-07-17 19:58:00', 'PUNCHED OUT'),
(461, 1, 96, '2017-07-18', 'In', '2017-07-18 10:26:00', 'Out', '2017-07-18 19:43:00', 'PUNCHED OUT'),
(462, 1, 96, '2017-07-19', 'In', '2017-07-19 10:31:00', 'Out', '2017-07-19 19:58:00', 'PUNCHED OUT'),
(463, 1, 96, '2017-07-20', 'In', '2017-07-20 12:01:00', 'Out', '2017-07-20 20:08:00', 'PUNCHED OUT'),
(464, 1, 96, '2017-07-21', 'In', '2017-07-21 10:08:00', 'Out', '2017-07-21 20:06:00', 'PUNCHED OUT'),
(465, 1, 96, '2017-07-22', 'In', '2017-07-22 10:15:00', 'Out', '2017-07-22 19:40:00', 'PUNCHED OUT'),
(466, 1, 96, '2017-07-24', 'In', '2017-07-24 10:23:00', 'Out', '2017-07-24 20:14:00', 'PUNCHED OUT'),
(467, 1, 96, '2017-07-25', 'In', '2017-07-25 10:23:00', 'Out', '2017-07-25 20:08:00', 'PUNCHED OUT'),
(468, 1, 96, '2017-07-26', 'In', '2017-07-26 10:18:00', 'Out', '2017-07-26 19:51:00', 'PUNCHED OUT'),
(469, 1, 96, '2017-07-27', 'In', '2017-07-27 10:22:00', 'Out', '2017-07-27 19:41:00', 'PUNCHED OUT'),
(470, 1, 96, '2017-07-28', 'In', '2017-07-28 10:24:00', 'Out', '2017-07-28 19:53:00', 'PUNCHED OUT'),
(471, 1, 96, '2017-07-31', 'In', '2017-07-31 10:21:00', 'Out', '2017-07-31 19:57:00', 'PUNCHED OUT'),
(472, 1, 81, '2017-07-03', 'In', '2017-07-03 10:21:00', 'Out', '2017-07-03 20:50:00', 'PUNCHED OUT'),
(473, 1, 81, '2017-07-04', 'In', '2017-07-04 10:19:00', 'Out', '2017-07-04 20:00:00', 'PUNCHED OUT'),
(474, 1, 81, '2017-07-05', 'In', '2017-07-05 10:24:00', 'Out', '2017-07-05 20:17:00', 'PUNCHED OUT'),
(475, 1, 81, '2017-07-06', 'In', '2017-07-06 10:24:00', 'Out', '2017-07-06 19:54:00', 'PUNCHED OUT'),
(476, 1, 81, '2017-07-07', 'In', '2017-07-07 10:22:00', 'Out', '2017-07-07 20:30:00', 'PUNCHED OUT'),
(477, 1, 81, '2017-07-08', 'In', '2017-07-08 10:20:00', 'Out', '2017-07-08 19:35:00', 'PUNCHED OUT'),
(478, 1, 81, '2017-07-10', 'In', '2017-07-10 10:21:00', 'Out', '2017-07-10 20:00:00', 'PUNCHED OUT'),
(479, 1, 81, '2017-07-11', 'In', '2017-07-11 10:43:00', 'Out', '2017-07-11 20:11:00', 'PUNCHED OUT'),
(480, 1, 81, '2017-07-12', 'In', '2017-07-12 10:23:00', 'Out', '2017-07-12 19:52:00', 'PUNCHED OUT'),
(481, 1, 81, '2017-07-13', 'In', '2017-07-13 10:19:00', 'Out', '2017-07-13 19:57:00', 'PUNCHED OUT'),
(482, 1, 81, '2017-07-14', 'In', '2017-07-14 10:20:00', 'Out', '2017-07-14 19:53:00', 'PUNCHED OUT'),
(483, 1, 81, '2017-07-17', 'In', '2017-07-17 10:23:00', 'Out', '2017-07-17 19:58:00', 'PUNCHED OUT'),
(484, 1, 81, '2017-07-18', 'In', '2017-07-18 10:26:00', 'Out', '2017-07-18 19:43:00', 'PUNCHED OUT'),
(485, 1, 81, '2017-07-19', 'In', '2017-07-19 10:31:00', 'Out', '2017-07-19 19:58:00', 'PUNCHED OUT'),
(486, 1, 81, '2017-07-20', 'In', '2017-07-20 12:01:00', 'Out', '2017-07-20 20:08:00', 'PUNCHED OUT'),
(487, 1, 81, '2017-07-21', 'In', '2017-07-21 10:08:00', 'Out', '2017-07-21 20:06:00', 'PUNCHED OUT'),
(488, 1, 81, '2017-07-22', 'In', '2017-07-22 10:15:00', 'Out', '2017-07-22 19:40:00', 'PUNCHED OUT'),
(489, 1, 81, '2017-07-24', 'In', '2017-07-24 10:23:00', 'Out', '2017-07-24 20:14:00', 'PUNCHED OUT'),
(490, 1, 81, '2017-07-25', 'In', '2017-07-25 10:23:00', 'Out', '2017-07-25 20:08:00', 'PUNCHED OUT'),
(491, 1, 81, '2017-07-26', 'In', '2017-07-26 10:18:00', 'Out', '2017-07-26 19:51:00', 'PUNCHED OUT'),
(492, 1, 81, '2017-07-27', 'In', '2017-07-27 10:22:00', 'Out', '2017-07-27 19:41:00', 'PUNCHED OUT'),
(493, 1, 81, '2017-07-28', 'In', '2017-07-28 10:24:00', 'Out', '2017-07-28 19:53:00', 'PUNCHED OUT'),
(494, 1, 81, '2017-07-31', 'In', '2017-07-31 10:21:00', 'Out', '2017-07-31 19:57:00', 'PUNCHED OUT'),
(495, 1, 95, '2017-07-03', 'In', '2017-07-03 10:21:00', 'Out', '2017-07-03 20:50:00', 'PUNCHED OUT'),
(496, 1, 95, '2017-07-04', 'In', '2017-07-04 10:19:00', 'Out', '2017-07-04 20:00:00', 'PUNCHED OUT'),
(497, 1, 95, '2017-07-05', 'In', '2017-07-05 10:24:00', 'Out', '2017-07-05 20:17:00', 'PUNCHED OUT'),
(498, 1, 95, '2017-07-06', 'In', '2017-07-06 10:24:00', 'Out', '2017-07-06 19:54:00', 'PUNCHED OUT'),
(499, 1, 95, '2017-07-07', 'In', '2017-07-07 10:22:00', 'Out', '2017-07-07 20:30:00', 'PUNCHED OUT'),
(500, 1, 95, '2017-07-08', 'In', '2017-07-08 10:20:00', 'Out', '2017-07-08 19:35:00', 'PUNCHED OUT'),
(501, 1, 95, '2017-07-10', 'In', '2017-07-10 10:21:00', 'Out', '2017-07-10 20:00:00', 'PUNCHED OUT'),
(502, 1, 95, '2017-07-11', 'In', '2017-07-11 10:43:00', 'Out', '2017-07-11 20:11:00', 'PUNCHED OUT'),
(503, 1, 95, '2017-07-12', 'In', '2017-07-12 10:23:00', 'Out', '2017-07-12 19:52:00', 'PUNCHED OUT'),
(504, 1, 95, '2017-07-13', 'In', '2017-07-13 10:19:00', 'Out', '2017-07-13 19:57:00', 'PUNCHED OUT'),
(505, 1, 95, '2017-07-14', 'In', '2017-07-14 10:20:00', 'Out', '2017-07-14 19:53:00', 'PUNCHED OUT'),
(506, 1, 95, '2017-07-17', 'In', '2017-07-17 10:23:00', 'Out', '2017-07-17 19:58:00', 'PUNCHED OUT'),
(507, 1, 95, '2017-07-18', 'In', '2017-07-18 10:26:00', 'Out', '2017-07-18 19:43:00', 'PUNCHED OUT'),
(508, 1, 95, '2017-07-19', 'In', '2017-07-19 10:31:00', 'Out', '2017-07-19 19:58:00', 'PUNCHED OUT'),
(509, 1, 95, '2017-07-20', 'In', '2017-07-20 12:01:00', 'Out', '2017-07-20 20:08:00', 'PUNCHED OUT'),
(510, 1, 95, '2017-07-21', 'In', '2017-07-21 10:08:00', 'Out', '2017-07-21 20:06:00', 'PUNCHED OUT'),
(511, 1, 95, '2017-07-22', 'In', '2017-07-22 10:15:00', 'Out', '2017-07-22 19:40:00', 'PUNCHED OUT'),
(512, 1, 95, '2017-07-24', 'In', '2017-07-24 10:23:00', 'Out', '2017-07-24 20:14:00', 'PUNCHED OUT'),
(513, 1, 95, '2017-07-25', 'In', '2017-07-25 10:23:00', 'Out', '2017-07-25 20:08:00', 'PUNCHED OUT'),
(514, 1, 95, '2017-07-26', 'In', '2017-07-26 10:18:00', 'Out', '2017-07-26 19:51:00', 'PUNCHED OUT'),
(515, 1, 95, '2017-07-27', 'In', '2017-07-27 10:22:00', 'Out', '2017-07-27 19:41:00', 'PUNCHED OUT'),
(516, 1, 95, '2017-07-28', 'In', '2017-07-28 10:24:00', 'Out', '2017-07-28 19:53:00', 'PUNCHED OUT'),
(517, 1, 95, '2017-07-31', 'In', '2017-07-31 10:21:00', 'Out', '2017-07-31 19:57:00', 'PUNCHED OUT'),
(518, 1, 78, '2017-07-03', 'In', '2017-07-03 10:21:00', 'Out', '2017-07-03 20:50:00', 'PUNCHED OUT'),
(519, 1, 78, '2017-07-04', 'In', '2017-07-04 10:19:00', 'Out', '2017-07-04 20:00:00', 'PUNCHED OUT'),
(520, 1, 78, '2017-07-05', 'In', '2017-07-05 10:24:00', 'Out', '2017-07-05 20:17:00', 'PUNCHED OUT'),
(521, 1, 78, '2017-07-06', 'In', '2017-07-06 10:24:00', 'Out', '2017-07-06 19:54:00', 'PUNCHED OUT'),
(522, 1, 78, '2017-07-07', 'In', '2017-07-07 10:22:00', 'Out', '2017-07-07 20:30:00', 'PUNCHED OUT'),
(523, 1, 78, '2017-07-08', 'In', '2017-07-08 10:20:00', 'Out', '2017-07-08 19:35:00', 'PUNCHED OUT'),
(524, 1, 78, '2017-07-10', 'In', '2017-07-10 10:21:00', 'Out', '2017-07-10 20:00:00', 'PUNCHED OUT'),
(525, 1, 78, '2017-07-11', 'In', '2017-07-11 10:43:00', 'Out', '2017-07-11 20:11:00', 'PUNCHED OUT'),
(526, 1, 78, '2017-07-12', 'In', '2017-07-12 10:23:00', 'Out', '2017-07-12 19:52:00', 'PUNCHED OUT'),
(527, 1, 78, '2017-07-13', 'In', '2017-07-13 10:19:00', 'Out', '2017-07-13 19:57:00', 'PUNCHED OUT'),
(528, 1, 78, '2017-07-14', 'In', '2017-07-14 10:20:00', 'Out', '2017-07-14 19:53:00', 'PUNCHED OUT'),
(529, 1, 78, '2017-07-17', 'In', '2017-07-17 10:23:00', 'Out', '2017-07-17 19:58:00', 'PUNCHED OUT'),
(530, 1, 78, '2017-07-18', 'In', '2017-07-18 10:26:00', 'Out', '2017-07-18 19:43:00', 'PUNCHED OUT'),
(531, 1, 78, '2017-07-19', 'In', '2017-07-19 10:31:00', 'Out', '2017-07-19 19:58:00', 'PUNCHED OUT'),
(532, 1, 78, '2017-07-20', 'In', '2017-07-20 12:01:00', 'Out', '2017-07-20 20:08:00', 'PUNCHED OUT'),
(533, 1, 78, '2017-07-21', 'In', '2017-07-21 10:08:00', 'Out', '2017-07-21 20:06:00', 'PUNCHED OUT'),
(534, 1, 78, '2017-07-22', 'In', '2017-07-22 10:15:00', 'Out', '2017-07-22 19:40:00', 'PUNCHED OUT'),
(535, 1, 78, '2017-07-24', 'In', '2017-07-24 10:23:00', 'Out', '2017-07-24 20:14:00', 'PUNCHED OUT'),
(536, 1, 78, '2017-07-25', 'In', '2017-07-25 10:23:00', 'Out', '2017-07-25 20:08:00', 'PUNCHED OUT'),
(537, 1, 78, '2017-07-26', 'In', '2017-07-26 10:18:00', 'Out', '2017-07-26 19:51:00', 'PUNCHED OUT'),
(538, 1, 78, '2017-07-27', 'In', '2017-07-27 10:22:00', 'Out', '2017-07-27 19:41:00', 'PUNCHED OUT'),
(539, 1, 78, '2017-07-28', 'In', '2017-07-28 10:24:00', 'Out', '2017-07-28 19:53:00', 'PUNCHED OUT'),
(540, 1, 78, '2017-07-31', 'In', '2017-07-31 10:21:00', 'Out', '2017-07-31 19:57:00', 'PUNCHED OUT'),
(561, 1, 94, '2017-09-01', NULL, '2017-09-01 10:07:50', NULL, '2017-09-01 20:06:50', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `name_public` text,
  `value` varchar(256) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `name_public`, `value`, `type`) VALUES
(1, 'defaultTimeZone', 'Enter default time zone identifier', 'Asia/Calcutta', 'input'),
(2, 'siteName', 'Enter Your Site Name', 'Rupaiya Exchange', 'input'),
(3, 'siteRegistration', 'New Registration is allowed or not', '1', 'checkbox'),
(4, 'allowDeleteAccount', 'Allow user to inactivate their account', '1', 'checkbox'),
(5, 'sendRegistrationMail', 'Send Registration Mail After User Registered', '1', 'checkbox'),
(6, 'sendPasswordChangeMail', 'Send Password Change Mail After User changed password', '1', 'checkbox'),
(7, 'emailVerification', 'Enable email verification', '1', 'checkbox'),
(8, 'emailFromAddress', 'Enter email by which emails will be send.', 'rxexchnage@rupaiyaexchange.com', 'input'),
(9, 'emailFromName', 'Enter Email From Name', 'Rosh', 'input'),
(10, 'bannedUsernames', 'Set banned usernames comma separated(no space, no quotes)', 'Administrator, SuperAdmin', 'input'),
(11, 'allowChangeUsername', 'Do you want to allow users to change their username?', '0', 'checkbox'),
(12, 'viewOnlineUserTime', 'You can view online users and guest from last few minutes, set time in minutes ', '30', 'input'),
(13, 'useHttps', 'Do you want to HTTPS for whole site?', '0', 'checkbox'),
(14, 'httpsUrls', 'You can set selected urls for HTTPS (e.g. users/login, users/register)', NULL, 'input'),
(15, 'loginRedirectUrlForAdmin', 'Enter URL where ADMIN will be redirected after login ', 'user/dashboard', 'input'),
(16, 'logoutRedirectUrlForAdmin', 'Enter URL where ADMIN will be redirected after logout\r\n(Warning: It should be a public action)', 'user/login', 'input'),
(17, 'loginRedirectUrlForUser', 'Enter URL where USER will be redirected after login', 'user/dashboard', 'input'),
(18, 'logoutRedirectUrlForUser', 'Enter URL where USER will be redirected after logout \r\n(Warning: It should be a public action)', 'user/index', 'input'),
(19, 'default_status_for_new_user', 'The new registering user will be registered as by default. For ACTIVE(Checked) or INACTIVE(Unchecked) ', '1', 'checkbox'),
(20, 'defaultRoleName', 'Enter default Role name for user registration and it will only apply when no other role for registration is applied or When user login with social media(Warning: This role should exist in the Roles of your application(if you are using permisssions))', 'user', 'input'),
(21, 'adminRoleName', 'Enter Admin Role Name \r\n(Warning:By deafult ''Superadmin'' is the super admin on application roles(user roles) and this can never be deleted. If you want to specify other user role as admin, you can do that here)', 'admin', 'input'),
(22, 'permissions', 'Do you Want to enable permissions for users?', '1', 'checkbox'),
(23, 'adminPermissions', 'Do you want to check permissions for Admin?', '0', 'checkbox'),
(24, 'app_images_directory', 'Directory for application images ', 'app_images', 'input'),
(25, 'user_profile_images_directory', 'Enter Image directory name where users profile photos will be uploaded. This directory should be in (frontend or backend respectively)/web/images directory', 'user_photos', 'input'),
(26, 'user_profile_default_image', 'Default image for profile image not found', 'user-default.jpg', 'input'),
(27, 'default_page_size', 'No. of results to show per page in listing ', '10', 'input'),
(28, 'date_format', 'Date Format to show the dates in application', 'F jS, Y', 'input'),
(29, 'useRecaptcha', 'Do you want to captcha support on registration form?', '0', 'checkbox'),
(30, 'privateKeyFromRecaptcha', 'Enter private key for Recaptcha from google', 'currently not in use', 'input'),
(31, 'publicKeyFromRecaptcha', 'Enter public key for recaptcha from google', 'currently not in use', 'input'),
(32, 'useFacebookLogin', 'Want to use Facebook Connect on your site?', '1', 'checkbox'),
(33, 'facebookAppId', 'Facebook Application Id', '1464750547126278', 'input'),
(34, 'facebookSecret', 'Facebook Application Secret Code', '3141a99cdf0f8a24408d2534cf4e3fba', 'input'),
(35, 'facebookScope', 'Facebook Permissions', 'user_status, publish_stream, email', 'input'),
(36, 'useTwitterLogin', 'Want to use Twitter Connect on your site?', '0', 'checkbox'),
(37, 'twitterConsumerKey', 'Twitter Consumer Key', '', 'input'),
(38, 'twitterConsumerSecret', 'Twitter Consumer Secret', '', 'input'),
(39, 'useGmailLogin', 'Want to use Gmail Connect on your site?', '1', 'checkbox'),
(40, 'gmailAppId', 'GMail Application Id', '', 'input'),
(41, 'gmailSecretId', 'GMail Application Secret Code', '', 'input'),
(42, 'useLinkedinLogin', 'Want to use Linkedin Connect on your site?', '1', 'checkbox'),
(43, 'linkedinApiKey', 'Linkedin Api Key', '75oo9jthtx1w8n', 'input'),
(44, 'linkedinSecretKey', 'Linkedin Secret Key', 'sEl8yYy3pnlTE04i', 'input'),
(45, 'useFoursquareLogin', 'Want to use Foursquare Connect on your site?', '0', 'checkbox'),
(46, 'foursquareClientId', 'Foursquare Client Id', '', 'input'),
(47, 'foursquareClientSecret', 'Foursquare Client Secret', '', 'input'),
(48, 'not_found_text', 'The text to show when results not found for a particular attribute', '<span style="color:red;">Not Found</span>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `source_message`
--

CREATE TABLE IF NOT EXISTS `source_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_emails`
--

CREATE TABLE IF NOT EXISTS `tmp_emails` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(256) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `attendance_id` int(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `city_id` int(10) DEFAULT NULL,
  `state_id` int(10) DEFAULT NULL,
  `zipcode` int(6) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `img_path` varchar(256) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `about` text,
  `accept_tnc` tinyint(1) NOT NULL COMMENT 'Accept Terms and conditions',
  `group_id` tinyint(3) DEFAULT '0',
  `role` tinyint(1) DEFAULT '0',
  `fb_id` bigint(100) DEFAULT NULL,
  `fb_access_token` text,
  `twt_id` bigint(100) DEFAULT NULL,
  `twt_access_token` text,
  `fb_email` varchar(100) DEFAULT NULL,
  `friends` text,
  `totalFriends` int(11) NOT NULL DEFAULT '0',
  `twt_access_secret` text,
  `ldn_id` varchar(100) DEFAULT NULL,
  `profile_updated` tinyint(1) NOT NULL DEFAULT '0',
  `documents_updated` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `email_recieved` tinyint(4) NOT NULL DEFAULT '1',
  `email_verified` tinyint(1) DEFAULT '0',
  `sms_token` varchar(6) DEFAULT NULL,
  `sms_verified` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  `by_admin` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `new_user` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendance_id` (`attendance_id`),
  KEY `user` (`username`),
  KEY `mail` (`email`),
  KEY `users_FKIndex1` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `attendance_id`, `email`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `gender`, `address`, `city_id`, `state_id`, `zipcode`, `phone_number`, `img_path`, `birth`, `about`, `accept_tnc`, `group_id`, `role`, `fb_id`, `fb_access_token`, `twt_id`, `twt_access_token`, `fb_email`, `friends`, `totalFriends`, `twt_access_secret`, `ldn_id`, `profile_updated`, `documents_updated`, `status`, `approved`, `email_recieved`, `email_verified`, `sms_token`, `sms_verified`, `last_login`, `by_admin`, `created`, `modified`, `new_user`) VALUES
(1, 'admin', 'admin', 104, 'admin@admin.com', 'admin', 'FNN9dYCQtulTz4-7g_3BrEtp7IrlFIG9', '$2y$13$toit3Y1D2rKA01GeGixvbeOu9jhA9uDpeCeKKbX2WUa4q728wmpFK', NULL, '', NULL, 276354, 781495, 324234, '8237482736', NULL, '1997-09-05', 'sdfsdf', 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 1, 1, 1, NULL, 0, '2015-09-10 04:59:42', 0, '2015-07-31 06:56:05', '2017-04-06 11:56:21', 0),
(67, 'Neha', 'Tiwari', 78, 'neha001@gmail.com', 'neha001', 'Q0KOVPwuJA76CWdCYYBPo2GxqcFM_0oK', '$2y$13$rxdp17KWSOUHptx6vev7WOEzMeTOXGcoaQ7GIfhD0.purLXwYnomW', NULL, 'F', NULL, NULL, NULL, NULL, '9874563214', '1491491297415ice_screenshot_20170218-110226.png', '1985-09-04', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-03-28 00:00:00', '2017-09-06 11:01:34', 1),
(66, 'Shubham', 'Saraswat', 101, 'shubhamsaraswat41@gmail.com', '35', 'Db8-oESIymnMs0jPDCrwxGrHgAOTeOaF', '$2y$13$55GP.VUbDScyKCzmq2x73uwMwYxSrrH3nR3xdYqeGqqWYSlXdA5Ye', NULL, 'M', NULL, NULL, NULL, NULL, '9808080370', '', '1995-08-15', 'hiiiiiiiiiii', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-03-28 00:00:00', '2017-04-04 11:42:19', 1),
(79, 'Rohit', 'Gupta', 1254, 'rohit@gmail.com', '15129', 'IyGbxoZlbOXNdpS2jX_C-shz7QBMUcr3', '$2y$13$qqfxeYt.OR6jOTFKCF6/C.aJLwnR4e92DkRepEKkeW1OXYMOl5rMe', NULL, 'M', NULL, NULL, NULL, NULL, '8285845639', '7391491300884rohit.jpg', '1994-09-03', 'don''t know', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 0, 0, 1, 1, NULL, 0, NULL, 1, '2017-04-04 01:03:44', '2017-09-02 12:23:54', 1),
(78, 'Khushal', 'Deave', 108, 'khushal@gmail.com', '001', 'k43VP-Ns5EQne_B-424nDZ9SFRTe8dmA', '$2y$13$0UX3S5pI8yEQlrj9TykRL.2w87asjZ842IKbmHrq3CdbKO6LhUKPi', NULL, 'M', NULL, NULL, NULL, NULL, '9865412235', '844149129954883014912899991_wallpaper_starcraft_2_05_1920x1080.jpg', '1995-08-06', 'yoooooooooo', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-04-04 12:27:29', '2017-09-07 06:11:37', 1),
(81, 'Sudhir', 'Yadav', 106, 'dggf@dsg.vom', 'dfgdg', 'RC4ztbeVTYCATJOHXl5afIUpnD1GoPkr', '$2y$13$R2wFUKdSKDjjZ1mQbUqx7.7EFntIUN74UfeTi2hCD42xSGCwjGE.y', NULL, 'M', NULL, NULL, NULL, NULL, '9865986523', '3431491300721Death-wallpaper_1920x1200.jpg', '1989-08-01', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 0, NULL, 0, NULL, 1, '2017-04-04 01:16:38', '2017-09-07 06:09:47', 1),
(83, 'Sonu', 'Singh', 15246, 'sonu@gmail.com', '15624', 'xpmb43b9hHZ_aRyEZPgq4v6_naYZ-9q4', '$2y$13$3DKqe5zCS.NWfFQAOS8zDeLaZ5uE2g2DL5Wt3XLNY9U/7bs3LBlpO', NULL, 'M', NULL, NULL, NULL, NULL, '9632587410', '83514912986792560-1600-174966.jpg', '2017-10-02', 'asd zxcv qwert qwert ', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 0, NULL, 0, NULL, 1, '2017-04-04 03:08:00', NULL, 1),
(94, 'Rajat', 'Singh', 102, 'rajat@codefire.in', 'rajat', 'VLV4kPxOXQVHRDSiaFefruOJX-BM1P9Z', '$2y$13$7lJf.529VtySwUvG6hOQKeEysB8hor/bCK7nfCkD0Pg0fEh2VUBcu', NULL, 'M', NULL, NULL, NULL, NULL, '9795866499', '', '1991-01-15', 'HI ', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-09-04 04:57:43', '2017-09-08 12:59:39', 1),
(95, 'Kapil', 'Sharma', 107, 'kapil@codefire.in', 'kapil', 'BVMXZ-5qcjPqyOB5J-PUDk96-nkR1a-Z', '$2y$13$e1JjP074RIJLxeAPLtPpLO374ofGbgMaCHlWpiCJSQpIy8VI1ovcS', NULL, 'M', NULL, NULL, NULL, NULL, '9795866499', '', '1990-11-05', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-09-04 05:08:40', '2017-09-05 10:44:32', 1),
(96, 'Akhilesh', 'Singh', 103, 'akhilesh@codefire.in', 'akhilesh', 'ttlogqAUuNM6zQpQ1PbhAnZpcEdllhLF', '$2y$13$INAqnRVSS7syVsIrsqGqpeGVXThNhBfbUEjGHolN41xlH9mGmTEg6', NULL, 'M', NULL, NULL, NULL, NULL, '9895652356', '', '1992-09-05', '', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 1, 0, 1, 1, NULL, 0, NULL, 1, '2017-09-04 07:35:13', '2017-09-05 11:48:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `useragent` varchar(256) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `last_action` int(10) DEFAULT NULL,
  `last_url` text,
  `logout_time` int(10) DEFAULT NULL,
  `user_browser` text,
  `ip_address` varchar(50) DEFAULT NULL,
  `logout` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `name`, `username`, `email`, `useragent`, `user_id`, `last_action`, `last_url`, `logout_time`, `user_browser`, `ip_address`, `logout`, `deleted`, `status`, `created`, `modified`) VALUES
(1, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'debug/default/toolbar', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:55.0) Gecko/20100101 Firefox/55.0', '127.0.0.1', 0, 0, 1, '2017-09-02 11:54:44', NULL),
(2, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'debug/default/toolbar', NULL, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.3.2987.98 Safari/537.36', '::1', 0, 0, 1, '2017-04-04 02:08:23', NULL),
(3, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'ohrm-attendance-record/index', NULL, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0', '192.168.1.9', 0, 0, 1, '2017-04-06 07:01:12', NULL),
(4, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'usermgmt/user/edit', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36', '192.168.1.12', 0, 0, 1, '2017-05-01 06:32:55', NULL),
(5, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'usermgmt/user/logout', NULL, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.3.2987.98 Safari/537.36', '192.168.1.114', 0, 0, 1, '2017-03-27 09:40:31', NULL),
(6, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'usermgmt/user/dashboard', NULL, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36', '192.168.1.15', 0, 0, 1, '2017-04-06 11:47:23', NULL),
(7, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'images/app_images/user-default.jpg', NULL, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '192.168.1.13', 0, 0, 1, '2017-03-31 01:03:26', NULL),
(8, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'ohrm-attendance-record', NULL, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36', '192.168.1.17', 0, 0, 1, '2017-04-06 12:44:26', NULL),
(9, 'Pooja Gupta', '001', 'pooja@gmail.com', NULL, 78, NULL, 'usermgmt/user/dashboard', NULL, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.3.2987.98 Safari/537.36', '192.168.1.110', 0, 0, 1, '2017-04-07 02:55:47', NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:55.0) Gecko/20100101 Firefox/55.0', '192.168.1.99', 0, 0, 0, '2017-09-02 11:54:53', NULL),
(11, 'Neha Tiwari', 'neha001', 'neha001@gmail.com', NULL, 67, NULL, 'ohrm-attendance-record/report', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', '192.168.1.26', 0, 0, 1, '2017-09-09 05:51:44', NULL),
(12, 'Rajat Singh', 'rajat', 'rajat@codefire.in', NULL, 94, NULL, 'leave/index', NULL, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36', '192.168.1.33', 0, 0, 1, '2017-09-05 08:04:39', NULL),
(13, 'admin admin', 'admin', 'admin@admin.com', NULL, 1, NULL, 'ohrm-attendance-record/view', NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', '192.168.1.38', 0, 0, 1, '2017-09-09 05:47:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `father_name` varchar(50) DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL COMMENT 'M=>Male, F=>Femaile, O=>Any Other',
  `designation` enum('HRG','HRD','PD','AD','JPD','JST','SST','JD','SJD','SPD','TLP','TLJ','BDA','BDM','PM','SEO','WD','SWD','CEO') DEFAULT NULL COMMENT 'HRG=> Human Resources Generalist, HRD=> Human Resources Director, PD=> PHP Developer, AD=> Android Developer, JPD=> Junior PHP Developer, JST=> Junior Software Tester, SST=> Senior Software Tester, JD=> Java Developer, SJD=> Senior Java Developer, SPD=> Senior PHP Developer, TLP=> Technical Lead PHP, TLJ=> Technical Lead Java, BDA => Business Development Associate, BDM => Business Development Manager, PM => Project Manager, SEO => Search Engine Optimizatio, WD => Web Designer, SWD => Senior Web Designer, CEO => Chief Executive Officer',
  `department` enum('HR','SD','SL','PM','SM') DEFAULT NULL COMMENT 'HR=>Human Resources, SD=>Software Development, SL=>Sales, PM=>Project Management, SM=>Senior Management',
  `photo` text,
  `bday` date DEFAULT NULL,
  `joining_date` date NOT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `adhar_no` varchar(50) DEFAULT NULL,
  `pf_no` varchar(50) DEFAULT NULL,
  `esic_no` varchar(50) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `location` varchar(256) DEFAULT NULL,
  `marital_status` enum('M','U','D','W') DEFAULT NULL COMMENT 'M => Married, U=>Unmarried, D=>Divorced, W=>Widowed',
  `cellphone` varchar(15) DEFAULT NULL,
  `web_page` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `permanent_address` text,
  `residence_address` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `father_name`, `gender`, `designation`, `department`, `photo`, `bday`, `joining_date`, `pan_no`, `adhar_no`, `pf_no`, `esic_no`, `bank_account_no`, `location`, `marital_status`, `cellphone`, `web_page`, `created`, `modified`, `permanent_address`, `residence_address`) VALUES
(1, 1, '', '', '', '', NULL, '1997-07-31', '2017-01-01', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 67, 'Papa', 'F', '', '', '1491491297415ice_screenshot_20170218-110226.png', '1985-03-06', '2016-01-01', '44654', '4654564654', '5465456', '654564', '65465465', NULL, 'M', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 66, 'SitaRam', 'M', NULL, '', NULL, '1995-08-15', '2017-01-31', '4654564654', '514654564654', '564564564', '65456465', '54654564', NULL, 'U', NULL, NULL, NULL, NULL, NULL, NULL),
(63, 79, 'S.C Gupta', 'M', NULL, '', '7391491300884rohit.jpg', '1994-04-16', '2017-04-02', '1234567890', '8529637410', '12365', '6546545', '6546465654216', NULL, 'U', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 78, 'Papa', 'M', 'HRG', 'HR', '844149129954883014912899991_wallpaper_starcraft_2_05_1920x1080.jpg', '1995-08-06', '2017-03-01', 'p123', 'a123', 'p123', 'e123', 'b123', NULL, 'U', NULL, NULL, NULL, NULL, '', ''),
(64, 81, 'dfgfdg', 'M', 'SWD', 'SD', '3431491300721Death-wallpaper_1920x1200.jpg', '1989-08-01', '2017-04-02', '', '', '', '', '', NULL, 'U', NULL, NULL, NULL, NULL, '', ''),
(66, 83, 'Sonu', 'M', NULL, '', '83514912986792560-1600-174966.jpg', '2017-04-02', '2017-04-02', '5874123690', '4563217890', '589632147', '789654123', '2015648896554', NULL, 'U', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 94, 'Jagat Narayan Singh', 'M', 'PD', 'SD', '', '1991-01-15', '2016-09-01', '123456789', '', '', '123456789', '', NULL, 'U', NULL, NULL, NULL, NULL, '', ''),
(78, 95, 'XYZ', 'M', 'SPD', 'SD', '', '1990-01-01', '2013-01-01', '', '', '', '', '', NULL, 'M', NULL, NULL, NULL, NULL, NULL, NULL),
(79, 96, 'XYX', 'M', 'AD', 'SD', '', '1992-01-01', '2016-09-01', '', '', '', '', '', NULL, 'U', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE IF NOT EXISTS `user_document` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `user_document`
--

INSERT INTO `user_document` (`id`, `user_id`, `file_name`, `created_by`, `modified_by`) VALUES
(18, 66, 'adaptive-local-contrast-enhanced.jpg', '2017-04-17 17:39:13', NULL),
(19, 66, 'Documents_Chart.jpg', '2017-04-17 17:39:13', NULL),
(20, 78, 'VCRM Simple DOT.gif', '2017-04-17 17:59:25', NULL),
(22, 66, 'StudyDocuments_ProjectDevelopmentProcedures.jpg', '2017-04-17 18:06:02', NULL),
(23, 66, 'IC354409.jpg', '2017-04-17 22:57:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workdays`
--

CREATE TABLE IF NOT EXISTS `workdays` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `month` varchar(10) DEFAULT NULL,
  `year` int(10) DEFAULT NULL,
  `sun` varchar(20) DEFAULT NULL,
  `mon` varchar(20) DEFAULT NULL,
  `tue` varchar(20) DEFAULT NULL,
  `wed` varchar(20) DEFAULT NULL,
  `thu` varchar(20) DEFAULT NULL,
  `fri` varchar(10) NOT NULL,
  `sat` varchar(10) NOT NULL,
  `createdby` varchar(20) NOT NULL,
  `createddate` date NOT NULL,
  `modifiedby` varchar(20) NOT NULL,
  `modifieddate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `workdays`
--

INSERT INTO `workdays` (`id`, `month`, `year`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `createdby`, `createddate`, `modifiedby`, `modifieddate`) VALUES
(34, 'Apr', 2017, '', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '1,3,5', '1', '2017-04-10', '1', '2017-04-03'),
(35, NULL, NULL, '', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '1,2,3,4,5', '2,4', '1', '2017-04-06', '', '0000-00-00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `source_message` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `leave_taken_status_change` ON SCHEDULE EVERY 1 HOUR STARTS '2017-02-28 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
                        UPDATE hs_hr_leave SET leave_status = 3 WHERE leave_status = 2 AND leave_date < DATE(NOW());
                      END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
