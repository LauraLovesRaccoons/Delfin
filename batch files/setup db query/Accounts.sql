
-- Database: `delfin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accounts`
--

CREATE TABLE `Accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Accounts`
--

INSERT INTO `Accounts` (`id`, `username`, `password`, `email`) VALUES
(1, 'My password is Super', '$2y$10$Lcxu.ACsR17dQof5hiHT7OpJmU8c6MDnS2KqxXX6/miNNdhA9TsQm', 'laura.hornick@petange.lu');

--

COMMIT;
