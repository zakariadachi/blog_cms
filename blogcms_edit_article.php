<?php
// edit_article.php - Edit article
require_once 'config.php';
require_once 'functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

// Get article ID
if (!isset($_GET['id'])) {
    redirect('my_articles.php');
}

$article = getArticleById($pdo, $_GET['id']);
if (!$article) {
    redirect('my_articles.php');
}

// Check if user owns this article or is admin
if ($article['nom_createur'] !== $_SESSION['user_name'] && !isAdmin()) {
    redirect('my_articles.php');
}

// Handle article update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $id_categorie = $_POST['id_categorie'];
    $statu = $_POST['statu'];
    
    if (empty($titre) || empty($contenu)) {
        $error = "Title and content are required";
    } else {
        if (updateArticle($pdo, $_GET['id'], $titre, $contenu, $id_categorie, $statu)) {
            $success = "Article updated successfully!";
            // Refresh article data
            $article = getArticleById($pdo, $_GET['id']);
        } else {
            $error = "Failed to update article";
        }
    }
}

$categories = getAllCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - BlogCMS</title>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="mb-4">Edit Article</h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= escape($error) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= escape($success) ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Title</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="<?= escape($article['titre']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_categorie" class="form-label">Category</label>
                            <select class="form-select" id="id_categorie" name="id_categorie" required>
                                <option value="">Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id_categorie'] ?>" <?= $article['id_categorie'] == $category['id_categorie'] ? 'selected' : '' ?>>
                                        <?= escape($category['nom_categorie']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="statu" class="form-label">Status</label>
                            <select class="form-select" id="statu" name="statu" required>
                                <option value="published" <?= $article['statu'] === 'published' ? 'selected' : '' ?>>Published</option>
                                <option value="archive" <?= $article['statu'] === 'archive' ? 'selected' : '' ?>>Archive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="contenu" class="form-label">Content</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="12" required><?= escape($article['contenu']) ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Article</button>
                            <a href="my_articles.php" class="btn btn-secondary">Cancel</a>
                            <a href="article.php?id=<?= $article['id_article'] ?>" class="btn btn-info">View Article</a>
                        </div>
                    </form>
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