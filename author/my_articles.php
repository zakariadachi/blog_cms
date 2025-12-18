<?php
require_once '../db.php';
require_once '../functions.php';

requireLogin(); // Authors must be logged in

$author = $_SESSION['user_name'];

// Get author's articles
$stmt = $pdo->prepare("SELECT a.*, c.nom_categorie FROM article a LEFT JOIN categorie c ON a.id_categorie = c.id_categorie WHERE a.nom_createur = :author ORDER BY a.date_creation DESC");
$stmt->execute([':author' => $author]);
$myArticles = $stmt->fetchAll();

// Get stats for this author
$stmt = $pdo->prepare("SELECT 
    COUNT(*) as total_articles,
    SUM(CASE WHEN statu = 'published' THEN 1 ELSE 0 END) as published_articles,
    SUM(CASE WHEN statu = 'draft' THEN 1 ELSE 0 END) as draft_articles
    FROM article WHERE nom_createur = :author");
$stmt->execute([':author' => $author]);
$stats = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Articles - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">BlogCMS</a>
            <div class="ms-auto">
                <a href="../index.php" class="btn btn-outline-light btn-sm me-2">Home</a>
                <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>My Articles Dashboard</h2>
        <p class="text-muted">Welcome, <?= escape($_SESSION['prenom'] ?? $_SESSION['user_name']) ?>!</p>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['total_articles'] ?></h5>
                        <p class="card-text">Total Articles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['published_articles'] ?></h5>
                        <p class="card-text">Published</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title"><?= $stats['draft_articles'] ?></h5>
                        <p class="card-text">Drafts</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>My Articles</h3>
            <a href="my_article_form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Article</a>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if (empty($myArticles)): ?>
                    <p class="text-center text-muted">You haven't created any articles yet. Click "New Article" to get started!</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($myArticles as $article): ?>
                                    <tr>
                                        <td><?= escape($article['titre']) ?></td>
                                        <td><?= escape($article['nom_categorie']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $article['statu'] == 'published' ? 'success' : 'secondary' ?>">
                                                <?= escape($article['statu']) ?>
                                            </span>
                                        </td>
                                        <td><?= escape($article['date_creation']) ?></td>
                                        <td>
                                            <a href="my_article_form.php?id=<?= $article['id_article'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                            <a href="my_articles.php?delete=<?= $article['id_article'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this article?')"><i class="bi bi-trash"></i></a>
                                            <a href="../article.php?id=<?= $article['id_article'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // IMPORTANT: Verify this article belongs to the current user
    $stmt = $pdo->prepare("SELECT nom_createur FROM article WHERE id_article = :id");
    $stmt->execute([':id' => $id]);
    $article = $stmt->fetch();
    
    if ($article && $article['nom_createur'] === $_SESSION['user_name']) {
        deleteArticle($pdo, $id);
    }
    redirect('my_articles.php');
}
?>
