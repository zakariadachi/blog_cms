<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    deleteCategory($pdo, $id);
    redirect('categories.php');
}

$categories = getAllCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - BlogCMS</title>
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
            <h2>Manage Categories</h2>
            <a href="category_form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Category</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id_categorie'] ?></td>
                                <td><?= escape($cat['nom_categorie']) ?></td>
                                <td>
                                    <a href="category_form.php?id=<?= $cat['id_categorie'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="categories.php?delete=<?= $cat['id_categorie'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category? Articles might be affected.')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
