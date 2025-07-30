
CREATE TABLE `haircuts` (
  `id_haircut` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `size` varchar(25) DEFAULT NULL,
  `duration` int NOT NULL,
  `break` int DEFAULT '0',
  `color` varchar(7) DEFAULT '#3788d8',
  PRIMARY KEY (`id_haircut`)
);

INSERT INTO `haircuts` VALUES (1,'Coupe','court',30,0,'#417dff'),(2,'Coupe','milongs',45,0,'#fdfb6d'),(3,'Coupe','longs',60,0,'#fdfb6d'),(4,'Coloration','',30,30,'#ff88d7'),(5,'Balayage/mèche','',90,45,'#c988ff'),(6,'Brushing','court',30,0,'#fdcb6d'),(7,'Brushing','milongs',45,0,'#fdcb6d'),(8,'Brushing','longs',60,0,'#fdcb6d'),(9,'Séchage naturel','court',30,0,'#fdcb6d'),(10,'Séchage naturel','milongs',30,0,'#fdcb6d'),(11,'Séchage naturel','longs',30,0,'#fdcb6d');
