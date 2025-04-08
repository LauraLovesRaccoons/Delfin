
-- Database: `delfin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `allocation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adresse1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `adresse2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `allocationSpeciale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nomCouponReponse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  
  `letter_required` tinyint NOT NULL,
  `duplicate` tinyint NOT NULL,
  `list_A` tinyint NOT NULL,
  `list_B` tinyint NOT NULL,
  `list_C` tinyint NOT NULL,
  `list_D` tinyint NOT NULL,
  `list_E` tinyint NOT NULL,
  `list_F` tinyint NOT NULL,
  `nouvel_an` tinyint NOT NULL,
  `fete_nationale` tinyint NOT NULL,
  `tennis` tinyint NOT NULL,
  `guerre` tinyint NOT NULL,
  `temp` tinyint NOT NULL,
  `temp_temp` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `allocation`, `nom`, `nom2`, `fonction`, `adresse1`, `adresse2`, `allocationSpeciale`, `nomCouponReponse`, `email`, `letter_required`, `duplicate`, `list_A`, `list_B`, `list_C`, `list_D`, `list_E`, `list_F`, `nouvel_an`, `fete_nationale`, `tennis`, `guerre`, `temp`, `temp_temp`) VALUES
(1, 'allocation', 'nom', 'nom2', 'fonction', 'adresse1', 'adresse2', 'allocationSpeciale', 'nomCouponReponse', 'laura.hornick@petange.lu', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1);

--

COMMIT;
