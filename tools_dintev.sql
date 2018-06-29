/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

CREATE TABLE `wp_f6ytd_Categories` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Long_Name` VARCHAR(100) NOT NULL,
	`Name` VARCHAR(50) NOT NULL);

CREATE TABLE `wp_f6ytd_Licenses` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_f6ytd_Plataforms` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL);

CREATE TABLE `wp_f6ytd_Tools` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Name` VARCHAR(120) NOT NULL,
	`link` VARCHAR(120) NOT NULL,
	`Description` VARCHAR(5000) NULL,
	`Need_connect` bool NOT NULL,
	`Description_Connect` VARCHAR(5000) NULL,
	`Details` VARCHAR(5000) NULL,
	`link_video` VARCHAR(120) NULL,
	`bool_research` bool NOT NULL DEFAULT 0,
	`research` VARCHAR(5000) NULL,
	`bool_comunicate` bool NOT NULL DEFAULT 0,
	`comunicate` VARCHAR(5000) NULL,
	`bool_evaluate` bool NOT NULL DEFAULT 0,
	`evaluate` VARCHAR(5000) NULL,
	`bool_colaborate` bool NOT NULL DEFAULT 0,
	`colaborate` VARCHAR(5000) NULL,
	`bool_design` bool NOT NULL DEFAULT 0,
	`design` VARCHAR(5000) NULL,
	`path_image` VARCHAR(1000) NOT NULL
	);

CREATE TABLE `wp_f6ytd_tools_category` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Category` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Category) REFERENCES wp_f6ytd_Categories(id),
	FOREIGN KEY (Tool) REFERENCES wp_f6ytd_Tools(id)
	);

CREATE TABLE `wp_f6ytd_tools_license` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`License` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (License) REFERENCES wp_f6ytd_Licenses(id),
	FOREIGN KEY (Tool) REFERENCES wp_f6ytd_Tools(id)
	);

CREATE TABLE `wp_f6ytd_tools_plataform` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Plataform` int(6) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Plataform) REFERENCES wp_f6ytd_Plataforms(id),
	FOREIGN KEY (Tool) REFERENCES wp_f6ytd_Tools(id)
	);

CREATE TABLE `wp_f6ytd_comments` (
	`id` int(6) AUTO_INCREMENT PRIMARY KEY,
	`Comment` VARCHAR(5000) NOT NULL,
	`Name` VARCHAR(120) NOT NULL,
	`Email` VARCHAR(120) NOT NULL,
	`Tool` int(6) NOT NULL,
	FOREIGN KEY (Tool) REFERENCES wp_f6ytd_Tools(id)
	);

INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Creación multimedia','multimedia');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Organizadores gráficos','graficos');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Evaluación del aprendizaje','aprendizaje');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Gamificación','gamificación');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Herramienta especializada','especializada');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Investigación académica','academica');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Comunicación','comunicación');
INSERT INTO `wp_f6ytd_Categories` (Long_Name,Name) VALUES ('Trabajo colaborativo','colaborativo');

INSERT INTO `wp_f6ytd_Licenses` (Name) VALUES ('Gratuita');
INSERT INTO `wp_f6ytd_Licenses` (Name) VALUES ('Pago');
INSERT INTO `wp_f6ytd_Licenses` (Name) VALUES ('Freemium');

INSERT INTO `wp_f6ytd_Plataforms` (Name) VALUES ('iOS');
INSERT INTO `wp_f6ytd_Plataforms` (Name) VALUES ('Android');
INSERT INTO `wp_f6ytd_Plataforms` (Name) VALUES ('PC(Escritorio)');
INSERT INTO `wp_f6ytd_Plataforms` (Name) VALUES ('Web');
