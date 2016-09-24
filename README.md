# BusinessCompanionBeta
Open sourced my Business Companion CRM Web Application written in PHP/HTML/CSS/JQuery.

BC was built with the intention of managing customers in a very fast and simple manner. BC was built for speed, efficiency (fuzzy search/filter as you type) and stability. I use PDO for all SQL queries (SQL Injections are a thing of the past!) and try to minimize page refreshes.

Going forward I'm rewriting the whole application with AngularJS so this old PHP is basically antiquated code intended for learning and historical purposes. Feel free to use any of it!

MySQL database connection string is kept in the file novaprospect/combine in the following format:

DSN
db user
db password
db schema

If you want to replicate my database use the following SQL:

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bc_customers`
--

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMERS`
--

CREATE TABLE `CUSTOMERS` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `PHONE` bigint(10) DEFAULT NULL,
  `COMPANY` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `NOTES` varchar(255) DEFAULT NULL,
  `CUSTOMER_SINCE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LINKEDIN` varchar(255) DEFAULT NULL,
  `FACEBOOK` varchar(255) DEFAULT NULL,
  `REMOVED` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'logical delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Example of an insert statement just so you can start off with me as a customer :)

INSERT INTO `CUSTOMERS` (`CUSTOMER_ID`, `NAME`, `PHONE`, `COMPANY`, `EMAIL`, `ADDRESS`, `NOTES`, `CUSTOMER_SINCE`, `LINKEDIN`, `FACEBOOK`, `REMOVED`) VALUES
(6, 'Boris Bershadsky', 6478867260, 'Company Name', 'b@borisb.ca', 'Admin Address', 'Database Administrator', '2016-06-23 19:15:04', 'https://ca.linkedin.com/in/bbershadsky', 'http://facebook.com/tehboriz', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CUSTOMERS`
--
ALTER TABLE `CUSTOMERS`
  ADD PRIMARY KEY (`CUSTOMER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CUSTOMERS`
--
ALTER TABLE `CUSTOMERS`
  MODIFY `CUSTOMER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;