<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

if (isset($_GET['delete'])) {
    $username = $_GET['delete'];
    // Prevent deleting self
    if ($username === $_SESSION['user_name']) {
        echo "<script>alert('Cannot delete yourself!'); window.location.href='users.php';</script>";
        exit;
    }
    deleteUser($pdo, $username);
    redirect('users.php');
}

$users = getAllUsers($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - BlogCMS</title>
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
            <h2>Manage Users</h2>
            <a href="user_form.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New User</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= escape($user['user_name']) ?></td>
                                    <td><?= escape($user['prenom'] . ' ' . $user['nom']) ?></td>
                                    <td><?= escape($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['estAdmin'] ? 'danger' : 'secondary' ?>">
                                            <?= $user['estAdmin'] ? 'Admin' : 'User' ?>
                                        </span>
                                    </td>
                                    <td><?= escape($user['date_inscricption']) ?></td>
                                    <td>
                                        <a href="user_form.php?username=<?= $user['user_name'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="users.php?delete=<?= $user['user_name'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')"><i class="bi bi-trash"></i></a>
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
