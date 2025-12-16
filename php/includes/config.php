<?php
session_start();

// Configuration de la base de données
$host = 'localhost';
$dbname = 'blog_cms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonctions utiles
// function isLoggedIn() {
//     return isset($_SESSION['user_id']);
// }

// function isAdmin() {
//     return isset($_SESSION['estAdmin']) && $_SESSION['estAdmin'] == 1;
// }

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
