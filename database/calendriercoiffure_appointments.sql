
CREATE TABLE `appointments` (
  `id_appointment` int NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `id_client` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `id_haircut` int DEFAULT NULL,
  `gender` enum('femme','homme') DEFAULT NULL,
  PRIMARY KEY (`id_appointment`),
  KEY `fk_client` (`id_client`),
  KEY `fk_user` (`id_user`),
  KEY `fk_haircut` (`id_haircut`),
  CONSTRAINT `fk_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`),
  CONSTRAINT `fk_haircut` FOREIGN KEY (`id_haircut`) REFERENCES `haircuts` (`id_haircut`),
  CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);
