<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    deleteArticle($pdo, $id);
    redirect('articles.php');
}

$articles = getAllArticles($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Articles - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">BlogCMS Admin</a>
            <div class="ms-auto">
                <a href="dashboard.php" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Articles</h2>
            <a href="article_form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Article</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $article): ?>
                                <tr>
                                    <td><?= escape($article['titre']) ?></td>
                                    <td><?= escape($article['nom_categorie']) ?></td>
                                    <td><?= escape($article['nom_createur']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $article['statu'] == 'published' ? 'success' : 'secondary' ?>">
                                            <?= escape($article['statu']) ?>
                                        </span>
                                    </td>
                                    <td><?= escape($article['date_creation']) ?></td>
                                    <td>
                                        <a href="article_form.php?id=<?= $article['id_article'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="articles.php?delete=<?= $article['id_article'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                                        <a href="../article.php?id=<?= $article['id_article'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
