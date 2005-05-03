-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: May 03, 2005 at 12:34 PM
-- Server version: 4.1.10
-- PHP Version: 4.3.10
-- 
-- Database: `clearhealth`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `category`
-- 

CREATE TABLE `category` (
  `id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `parent` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rght` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`),
  KEY `lft` (`lft`,`rght`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='STARTWITHDATA';

-- 
-- Dumping data for table `category`
-- 

INSERT INTO `category` VALUES (1, 'ClearHealth', '', 0, 0, 6);
        
