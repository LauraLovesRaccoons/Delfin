
-- Database: `delfin_db`
--

-- --------------------------------------------------------

--
-- Drop table if it already exists
DROP TABLE IF EXISTS `Job_Lock`;
--

--
-- Table structure for table `Job_Lock`
--

CREATE TABLE `Job_Lock` (
  `id` int NOT NULL,
  `active` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Job_Lock`
--

INSERT INTO `Job_Lock` (`id`, `active`) VALUES
(1, '0');

--

COMMIT;
