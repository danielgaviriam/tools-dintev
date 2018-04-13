/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

CREATE TABLE wp_td_Categories (
	`Name` VARCHAR(50) NOT NULL,
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY);

CREATE TABLE `wp_td_Licenses` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_td_Plataforms` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_td_Tools` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL,
	`link` VARCHAR(120) NOT NULL,
	`Description` VARCHAR(600) NULL,
	`Need_connect` bool NOT NULL,
	`Details` VARCHAR(600) NULL,
	`path_image` VARCHAR(600) NOT NULL
	);

CREATE TABLE `wp_td_tools_category` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Category` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Category) REFERENCES wp_td_Categories(ID),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(ID)
	);

CREATE TABLE `wp_td_tools_license` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`License` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (License) REFERENCES wp_td_Licenses(ID),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(ID)
	);

CREATE TABLE `wp_td_tools_plataform` (
	`ID` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Plataform` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Plataform) REFERENCES wp_td_Plataforms(ID),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(ID)
	);