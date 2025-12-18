<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();
$stats = getDashboardStats($pdo);
$recent_articles = getAllArticles($pdo, null, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">BlogCMS Admin</a>
            <div class="ms-auto">
                <span class="text-white me-3">Welcome, <?= escape($_SESSION['user_name']) ?></span>
                <a href="../logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block bg-light sidebar py-4" style="min-height: 100vh;">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="articles.php"><i class="bi bi-file-text"></i> Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php"><i class="bi bi-tags"></i> Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="comments.php"><i class="bi bi-chat"></i> Comments</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php"><i class="bi bi-people"></i> Users</a></li>
                </ul>
            </nav>

            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <h1 class="h2 mb-4">Dashboard</h1>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Articles</h5>
                                <p class="display-4"><?= $stats['total_articles'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Published</h5>
                                <p class="display-4"><?= $stats['published_articles'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Comments</h5>
                                <p class="display-4"><?= $stats['total_comments'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="display-4"><?= $stats['total_users'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Recent Articles</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_articles as $article): ?>
                                <tr>
                                    <td><?= escape($article['titre']) ?></td>
                                    <td><?= escape($article['nom_createur']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $article['statu'] == 'published' ? 'success' : 'secondary' ?>">
                                            <?= escape($article['statu']) ?>
                                        </span>
                                    </td>
                                    <td><?= escape($article['date_creation']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
