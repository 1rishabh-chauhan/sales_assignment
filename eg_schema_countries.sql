CREATE DATABASE IF NOT EXISTS world_countries;
USE world_countries;

CREATE TABLE `cities` (
  `ID` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `CITY_NAME` VARCHAR(50) NOT NULL,
  `STATE_ID` INT(11) NOT NULL
);

INSERT INTO `cities` (`CITY_NAME`, `STATE_ID`) VALUES
('Kanpur', 1),
('Varanasi', 1),
('Bangalore', 2),
('Kolar', 2),
('Jabalpur', 3),
('Gwalior', 3),
('Anchorage', 4),
('Fair Banks', 4),
('Denver', 5),
('Aurora', 5),
('Dowar', 6),
('Newark', 6),
('Newport', 7),
('St.Davids', 7),
('Melbourne', 8),
('Geelong', 8),
('Hobart', 9),
('Strahan', 9);

CREATE TABLE `countries` (
  `ID` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `NAME` VARCHAR(255) NOT NULL
);

INSERT INTO `countries` (`NAME`) VALUES
('India'),
('USA'),
('Australia');

CREATE TABLE `states` (
  `ID` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `STATE_NAME` VARCHAR(100) NOT NULL,
  `COUNTRY_ID` INT(11) NOT NULL
);

INSERT INTO `states` (`STATE_NAME`, `COUNTRY_ID`) VALUES
('Uttar Pradesh', 1),
('Karnataka', 1),
('Madhya Pradesh', 1),
('Alaska', 2),
('Colorado', 2),
('Delaware', 2),
('Wales', 3),
('Victoria', 3),
('Tasmania', 3);
