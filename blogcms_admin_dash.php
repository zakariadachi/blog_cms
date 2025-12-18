<?php
// admin/dashboard.php - Admin Dashboard
require_once '../config.php';
require_once '../functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// Get dashboard statistics
$stats = getDashboardStats($pdo);
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">BlogCMS Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">View Site</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Welcome, <?= escape($_SESSION['prenom']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-light sidebar py-4">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="articles.php">
                                <i class="bi bi-file-text"></i> Articles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php">
                                <i class="bi bi-folder"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="comments.php">
                                <i class="bi bi-chat"></i> Comments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <h1 class="h2 mb-4">Dashboard</h1>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Articles</h5>
                                <p class="card-text display-4"><?= $stats['total_articles'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Published</h5>
                                <p class="card-text display-4"><?= $stats['published_articles'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Categories</h5>
                                <p class="card-text display-4"><?= $stats['total_categories'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text display-4"><?= $stats['total_users'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Comments</h5>
                                <p class="card-text display-4"><?= $stats['total_comments'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 text-white bg-danger">
                            <div class="card-body">
                                <h5 class="card-title">Pending Comments</h5>
                                <p class="card-text display-4"><?= $stats['pending_comments'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h3 class="mb-3">Recent Articles</h3>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $recent_articles = getAllArticles($pdo, 'published', 5);
                                    foreach ($recent_articles as $article): 
                                    ?>
                                        <tr>
                                            <td><?= escape($article['titre']) ?></td>
                                            <td><?= escape($article['nom_createur']) ?></td>
                                            <td>
                                                <span class="badge bg-success"><?= escape($article['statu']) ?></span>
                                            </td>
                                            <td><?= escape($article['date_creation']) ?></td>
                                            <td>
                                                <a href="../article.php?id=<?= $article['id_article'] ?>" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>