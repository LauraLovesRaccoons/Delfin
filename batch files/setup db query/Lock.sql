
-- Database: `delfin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Lock`
--

CREATE TABLE `Lock` (
  `id` int NOT NULL,
  `active` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Lock`
--

INSERT INTO `Lock` (`id`, `active`) VALUES
(1, '0');

--

COMMIT;
