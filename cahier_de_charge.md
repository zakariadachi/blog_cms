# Cahier de Charge – BlogCMS

## 1️⃣ Contexte du projet

BlogCMS est un système de gestion de blog simple mais sécurisé.  
Le projet vise à fournir une interface opérationnelle permettant aux utilisateurs de gérer le contenu du blog selon leur rôle (administrateur, auteur ou visiteur).

---

## 2️⃣ Objectifs du projet

### Objectifs fonctionnels

#### Pour tous les utilisateurs

- Page de login sécurisée
- Système de rôles (administrateur, auteur, visiteur)
- Navigation et lecture des articles publiés
- Poster des commentaires

#### Pour les auteurs

- Voir les articles publiés
- Créer de nouveaux articles
- Modifier et supprimer leurs propres articles
- Poster des commentaires

#### Pour les administrateurs

- Tableau de bord avec statistiques
- Gestion complète des articles (CRUD)
- Gestion des catégories (CRUD)
- Modération des commentaires
- Gestion des utilisateurs (CRUD)

### Objectifs non-fonctionnels

- Sécurité : protection contre XSS, SQL Injection, CSRF
- Performance : chargement rapide
- Maintenance : code structuré et commenté
- Compatibilité : responsive design via Bootstrap 5

---

## 3️⃣ Technologies

### Backend

- PHP 8 (procédural)
- MySQL
- PDO avec requêtes préparées

### Frontend

- HTML5 / CSS3
- Bootstrap 5.3
- JavaScript basique

### Sécurité

- Sessions PHP sécurisées
- Hashage bcrypt des mots de passe
- Validation des formulaires
- Protection XSS via `htmlspecialchars()`

---

## 4️⃣ Structure du projet

Blogcms/
├── config.php
├── functions.php
├── login.php
├── logout.php
├── index.php
├── article.php
├── category.php
├── my_articles.php
├── edit_article.php
└── admin/
├── dashboard.php
├── articles.php
├── categories.php
├── comments.php
└── users.php

---

## 5️⃣ Base de données

- **users** : gestion des utilisateurs
- **article** : articles du blog
- **categorie** : catégories des articles
- **commentaire** : commentaires

**Relations clés**

- Articles → Catégories
- Articles → Utilisateurs (auteurs)
- Commentaires → Articles
- Commentaires → Utilisateurs

---

## 6️⃣ Modalités pédagogiques

- Durée : 5 jours
- Mode de travail : individuel
- Pré-requis : base de données fonctionnelle (Brief précédent)

---

## 7️⃣ Livrables

### Premier livrable (Jour 2)

- Planification du projet (Trello/Notion/Jira)
- Structure initiale des fichiers
- README.md initial avec explications

### Deuxième livrable (Jour 3)

- Planification mise à jour
- Dashboard administrateur fonctionnel
- CRUD articles
- CRUD catégories
- Interface utilisateur améliorée
- README.md mis à jour

### Troisième livrable (Jour 5)

- Planification finale
- Application complète et fonctionnelle
- Système de commentaires
- Gestion des utilisateurs
- Sécurité implémentée
- README.md final complet

---

## 8️⃣ Critères d’évaluation

- Fonctionnalité CRUD : toutes les opérations implémentées et fonctionnelles
- Sécurité et robustesse : validation, protection contre injections SQL, gestion d’erreurs
- Qualité du code : clair, organisé, commenté, réutilisable
- Interface utilisateur : cohérente et utilisable

---

## 9️⃣ Situation professionnelle

Concevoir et développer la partie backend d’une application web permettant la gestion complète d’un blog pour différents types d’utilisateurs.

---

## 10️⃣ Besoin visé

Développer un CMS sécurisé avec authentification administrateur pour créer, éditer et supprimer les articles d’un site web.
