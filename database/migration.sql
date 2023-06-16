-- Dumping database structure for database_for_rest
CREATE DATABASE IF NOT EXISTS `database_for_rest` 
USE `database_for_rest`;

-- Dumping structure for table database_for_rest.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- Inserting data for table database_for_rest.users: 1 row inserted.
INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `address`) VALUES
	(1, 'John Doe', 'johndoe', 'john@email.com', '123456', '123 King St');
