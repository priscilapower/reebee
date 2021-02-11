CREATE TABLE IF NOT EXISTS `user` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(50) NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `flyer` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(100) NOT NULL,
    `store_name` varchar(255) NOT NULL,
    `date_valid` date NOT NULL,
    `date_expired` date NOT NULL,
    `page_count` int NOT NULL
);

CREATE TABLE IF NOT EXISTS `page` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date_valid` date NOT NULL,
    `date_expired` date NOT NULL,
    `page_number` int NOT NULL,
    `flyer_id` int NOT NULL,
    FOREIGN KEY (flyer_id) REFERENCES flyer(id) ON UPDATE CASCADE ON DELETE CASCADE
);
