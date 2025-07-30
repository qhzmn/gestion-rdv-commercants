# 💇‍♀️ Calendrier Coiffeuse – Application de gestion de rendez-vous

Ce projet est une application web conçue pour permettre à un commerçant de gérer ses rendez-vous de manière simple et visuelle via une interface calendrier.  
Elle peut facilement planifier ses prestations, gérer sa clientèle , et visualiser son emploi du temps selon différents modes (jour, semaine, mois).

> 📌 Ce projet a été développé en prenant **l'exemple d'un(e) coiffeur/coiffeuse**, mais peut facilement être adapté à d'autres commerçants ou indépendants (esthéticiennes, thérapeutes, barbiers, etc.)

---

## ✨ Fonctionnalités principales

- **Vue calendrier interactive** avec FullCalendar (vue jour, semaine, mois)  
- **Ajout d’un rendez-vous** avec sélection de la prestation  
- **Base de données clients** intégrée (ajout/modification d’un client avec ses coordonnées)  
- **Modification et suppression** de rendez-vous existants  
- **Calcul automatique de la durée** selon la prestation sélectionnée  
- **Interface fluide et responsive** (utilisable sur mobile/tablette)  

---

## 🧱 Architecture du projet

Ce projet suit le **modèle MVC (Modèle-Vue-Contrôleur)** en PHP, pour une meilleure séparation des responsabilités :

- **Modèles** : interaction avec la base de données (clients, prestations, rendez-vous)  
- **Vues** : templates Twig affichant les données (HTML/CSS)  
- **Contrôleurs** : logique métier (gestion des requêtes, traitement des actions)  

---

## 🛠️ Technologies utilisées

| Type            | Outils/Librairies utilisés           |
|-----------------|------------------------------------|
| Frontend        | HTML, CSS, JavaScript, FullCalendar |
| Backend         | PHP                                |
| Template Engine | Twig                               |
| Base de données | MySQL                              |
| Structure       | MVC                                |

---

## ⚙️ Installation locale

Voici les étapes pour installer et faire fonctionner le projet en local sur votre machine.

---

### 1. Cloner le dépôt

Ouvre un terminal puis exécute :

```bash
git clone https://github.com/TON-UTILISATEUR/gestion-rdv-commercants.git
cd calendrier-coiffeuse
```

### 2. Créer la base de données MySQL

Crée une base de données selon ta configuration. Si tu modifies le nom ou les paramètres, n’oublie pas d’ajuster la configuration du projet.

### 3. Paramétrer la connexion à la base de données

Modifie le fichier suivant avec les informations de ta base de données, il faut le renommer en `database.php` :

```bash
/config/database_exemple.php
```

### 4. Configurer le serveur Apache

Assure-toi que ton serveur Apache est configuré pour que le dossier `public/` soit la racine du site, et que `index.php` soit le fichier d’entrée par défaut. 
Cela permettra d’accéder correctement à l’application via l’URL : `http://localhost/calendrier/public`.














