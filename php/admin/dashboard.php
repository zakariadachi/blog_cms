<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login.php');
    exit;
}

// Statistiques simples
$total_articles = $pdo->query("SELECT COUNT(*) as total FROM article")->fetch()['total'];
$total_users = $pdo->query("SELECT COUNT(*) as total FROM users")->fetch()['total'];
$total_categories = $pdo->query("SELECT COUNT(*) as total FROM categorie")->fetch()['total'];

$page_title = "Tableau de bord";
require_once '../includes/header.php';
?>

<h1 class="mb-4">Tableau de bord Administrateur</h1>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h2><?php echo $total_articles; ?></h2>
                <p>Articles</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h2><?php echo $total_users; ?></h2>
                <p>Utilisateurs</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h2><?php echo $total_categories; ?></h2>
                <p>Catégories</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Actions rapides</h5>
            </div>
            <div class="card-body">
                <a href="articles.php?action=create" class="btn btn-success w-100 mb-2">
                    Nouvel article
                </a>
                <a href="articles.php" class="btn btn-primary w-100 mb-2">
                    Gérer les articles
                </a>
                <a href="categories.php" class="btn btn-warning w-100">
                    Gérer les catégories
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>