CREATE TABLE `hotel_chain` (
  `chain_id` integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `chain_addressline1` text,
  `chain_addressline2` text
);

CREATE TABLE `chain_phone_numbers` (
  `chain_id` integer PRIMARY KEY,
  `chain_phone` varchar(255)
);

CREATE TABLE `chain_emails` (
  `chain_id` integer PRIMARY KEY,
  `chain_email` varchar(255)
);

CREATE TABLE `hotels` (
  `hotel_id` integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `chain_id` integer,
  `h_name` varchar(255),
  `hotel_addressline1` text,
  `hotel_addressline2` text,
  `totalRooms` integer,
  `hotel_email` varchar(255),
  `hotel_score` integer,
  `manager_id` integer
);

CREATE TABLE `hotel_phone_numbers` (
  `hotel_id` integer PRIMARY KEY,
  `hotel_phone` varchar(255)
);

CREATE TABLE `rooms` (
  `room_id` integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `hotel_id` integer,
  `price` integer,
  `amenities` text,
  `capacity` integer,
  `view_type` varchar(255),
  `canExtend` boolean,
  `damange_notes` text,
  PRIMARY KEY (`room_id`, `hotel_id`)
);

CREATE TABLE `customers` (
  `cust_id` integer PRIMARY KEY AUTO INCREMENT NOT NULL,
  `cust_fname` varchar(255),
  `cust_addressline1` text,
  `cust_addressline2` text,
  `id_type` varchar(255),
  `registration_date` datetime
);

CREATE TABLE `employees` (
  `employ_id` integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `hotel_id` integer,
  `employ_fname` varchar(255),
  `employ_addressline1` text,
  `employ_addressline2` text,
  `id_type` varchar(255),
  `position_name` varchar(255)
);

CREATE TABLE `booking` (
  `book_id` integer PRIMARY KEY,
  `hotel_id` integer,
  `room_id` integer,
  `cust_id` integer,
  `fromDate` datetime,
  `toDate` datetime,
  `duration` integer
);

CREATE TABLE `renting` (
  `rent_id` integer PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `hotel_id` integer,
  `room_id` integer,
  `cust_id` integer,
  `employ_id` integer,
  `fromDate` datetime,
  `toDate` datetime,
  `duration` integer
  `paid` boolean,
);

CREATE TABLE `archive` (
  `archive_id` integer,
  `a_rent_id` integer,
  `a_book_id` integer,
  `a_fromDate` datetime,
  `a_toDate` datetime,
  `a_roomId` integer,
  `a_custId` integer
);

ALTER TABLE `chain_phone_numbers` ADD FOREIGN KEY (`chain_id`) REFERENCES `hotel_chain` (`chain_id`);

ALTER TABLE `chain_emails` ADD FOREIGN KEY (`chain_id`) REFERENCES `hotel_chain` (`chain_id`);

ALTER TABLE `hotel_phone_numbers` ADD FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

ALTER TABLE `employees` ADD FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

ALTER TABLE `rooms` ADD FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

ALTER TABLE `hotels` ADD FOREIGN KEY (`chain_id`) REFERENCES `hotel_chain` (`chain_id`);

ALTER TABLE `hotels` ADD FOREIGN KEY (`manager_id`) REFERENCES `employees` (`employ_id`);

ALTER TABLE `renting` ADD FOREIGN KEY (`employ_id`) REFERENCES `employees` (`employ_id`);

ALTER TABLE `renting` ADD FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

ALTER TABLE `renting` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

ALTER TABLE `renting` ADD FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

ALTER TABLE `booking` ADD FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

ALTER TABLE `booking` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

ALTER TABLE `booking` ADD FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);
