<?php
// category.php - View articles by category
require_once 'config.php';
require_once 'functions.php';

// Get category ID
if (!isset($_GET['id'])) {
    redirect('index.php');
}

$category = getCategoryById($pdo, $_GET['id']);
if (!$category) {
    redirect('index.php');
}

// Get articles in this category
$stmt = $pdo->prepare("SELECT * FROM article WHERE id_categorie = ? AND statu = 'published' ORDER BY date_creation DESC");
$stmt->execute([$_GET['id']]);
$articles = $stmt->fetchAll();

$categories = getAllCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($category['nom_categorie']) ?> - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">BlogCMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="my_articles.php">My Articles</a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin/dashboard.php">Admin Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <span class="nav-link">Welcome, <?= escape($_SESSION['prenom']) ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4"><?= escape($category['nom_categorie']) ?></h1>
            <p class="lead">Browse articles in this category</p>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Articles -->
                <div class="col-md-9">
                    <h2 class="mb-4">Articles in <?= escape($category['nom_categorie']) ?></h2>
                    
                    <?php if (empty($articles)): ?>
                        <div class="alert alert-info">No articles found in this category.</div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($articles as $article): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= escape($article['titre']) ?></h5>
                                            <p class="card-text">
                                                <?= escape(substr($article['contenu'], 0, 150)) ?>...
                                            </p>
                                            <p class="text-muted small">
                                                By <?= escape($article['nom_createur']) ?> | 
                                                <?= escape($article['date_creation']) ?>
                                            </p>
                                            <a href="article.php?id=<?= $article['id_article'] ?>" class="btn btn-primary btn-sm">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-md-3">
                    <h4 class="mb-3">Categories</h4>
                    <div class="list-group">
                        <?php foreach ($categories as $cat): ?>
                            <a href="category.php?id=<?= $cat['id_categorie'] ?>" 
                               class="list-group-item list-group-item-action <?= $cat['id_categorie'] == $_GET['id'] ? 'active' : '' ?>">
                                <?= escape($cat['nom_categorie']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-secondary w-100">Back to All Articles</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p>&copy; 2025 BlogCMS. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>