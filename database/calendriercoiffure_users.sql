
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
);

INSERT INTO `users` VALUES (1,'Prenom','Nom','test1@mail.fr','$2y$12$YsTJS8ZEpJ420.VyFD/VteDVAlVoX955ThS0HN3.06/86WAooazpC','2025-07-14 15:50:02',1,'2025-07-19 10:15:29');
/*password  = 12345678*/