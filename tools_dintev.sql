/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

CREATE TABLE `wp_td_Categories` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Long_Name` VARCHAR(100) NOT NULL,
	`Name` VARCHAR(50) NOT NULL);

CREATE TABLE `wp_td_Licenses` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_td_Plataforms` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_td_Tools` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL,
	`link` VARCHAR(120) NOT NULL,
	`Description` VARCHAR(5000) NULL,
	`Need_connect` bool NOT NULL,
	`Details` VARCHAR(5000) NULL,
	`link_video` VARCHAR(120) NULL,
	`research` VARCHAR(5000) NULL,
	`comunicate` VARCHAR(5000) NULL,
	`evaluate` VARCHAR(5000) NULL,
	`colaborate` VARCHAR(5000) NULL,
	`design` VARCHAR(5000) NULL,
	`path_image` VARCHAR(1000) NOT NULL
	);

CREATE TABLE `wp_td_tools_category` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Category` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Category) REFERENCES wp_td_Categories(id),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(id)
	);

CREATE TABLE `wp_td_tools_license` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`License` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (License) REFERENCES wp_td_Licenses(id),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(id)
	);

CREATE TABLE `wp_td_tools_plataform` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Plataform` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Plataform) REFERENCES wp_td_Plataforms(id),
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(id)
	);

CREATE TABLE `wp_td_comments` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Comment` VARCHAR(5000) NOT NULL,
	`Name` VARCHAR(120) NOT NULL,
	`Email` VARCHAR(120) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Tool) REFERENCES wp_td_Tools(id)
	);

INSERT INTO `wp_td_Categories` (Long_Name,Name) VALUES ('Gamificacion','Gamificacion');
INSERT INTO `wp_td_Categories` (Long_Name,Name) VALUES ('Escolaridad','Escolaridad');
INSERT INTO `wp_td_Categories` (Long_Name,Name) VALUES ('Investigación','Escolaridad');
INSERT INTO `wp_td_Licenses` (Name) VALUES ('Gratuita');
INSERT INTO `wp_td_Licenses` (Name) VALUES ('Pago');
INSERT INTO `wp_td_Licenses` (Name) VALUES ('Freemium');
INSERT INTO `wp_td_Plataforms` (Name) VALUES ('iOS');
INSERT INTO `wp_td_Plataforms` (Name) VALUES ('Android');
INSERT INTO `wp_td_Plataforms` (Name) VALUES ('PC(Escritorio)');