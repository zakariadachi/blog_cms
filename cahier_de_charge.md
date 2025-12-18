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
