<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

if (isset($_GET['approve'])) {
    approveComment($pdo, (int)$_GET['approve']);
    redirect('comments.php');
}

if (isset($_GET['delete'])) {
    deleteComment($pdo, (int)$_GET['delete']);
    redirect('comments.php');
}

$comments = getAllComments($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments - BlogCMS</title>
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
        <h2>Manage Comments</h2>
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Article</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $cmt): ?>
                                <tr>
                                    <td><?= escape($cmt['user_name'] ?? 'Anonymous') ?></td>
                                    <td><?= escape($cmt['titre']) ?></td>
                                    <td><?= escape(substr($cmt['contenu_cmt'], 0, 50)) ?>...</td>
                                    <td><?= escape($cmt['date_creation_cmt']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $cmt['statu'] == 'approved' ? 'success' : 'warning' ?>">
                                            <?= escape($cmt['statu']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($cmt['statu'] != 'approved'): ?>
                                            <a href="comments.php?approve=<?= $cmt['id_cmt'] ?>" class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i></a>
                                        <?php endif; ?>
                                        <a href="comment_form.php?id=<?= $cmt['id_cmt'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="comments.php?delete=<?= $cmt['id_cmt'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')"><i class="bi bi-trash"></i></a>
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
