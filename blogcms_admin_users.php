<?php
// admin/users.php - Manage users
require_once '../config.php';
require_once '../functions.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$error = '';
$success = '';

// Handle user creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $estAdmin = isset($_POST['estAdmin']) ? 1 : 0;
    
    if (empty($nom) || empty($prenom) || empty($user_name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        $existing_user = getUserByUsername($pdo, $user_name);
        if ($existing_user) {
            $error = "Username already exists";
        } else {
            if (createUser($pdo, $nom, $prenom, $user_name, $email, $password, $estAdmin)) {
                $success = "User created successfully!";
            } else {
                $error = "Failed to create user";
            }
        }
    }
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $user_name = $_POST['user_name'];
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $estAdmin = isset($_POST['estAdmin']) ? 1 : 0;
    
    if (empty($nom) || empty($prenom) || empty($email)) {
        $error = "All fields are required";
    } else {
        if (updateUser($pdo, $user_name, $nom, $prenom, $email, $estAdmin)) {
            $success = "User updated successfully!";
        } else {
            $error = "Failed to update user";
        }
    }
}

// Handle user deletion
if (isset($_GET['delete'])) {
    // Don't allow deleting self
    if ($_GET['delete'] === $_SESSION['user_name']) {
        $error = "You cannot delete your own account";
    } else {
        // Check if user has articles
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM article WHERE nom_createur = ?");
        $stmt->execute([$_GET['delete']]);
        $count = $stmt->fetch()['count'];
        
        if ($count > 0) {
            $error = "Cannot delete user with existing articles";
        } else {
            if (deleteUser($pdo, $_GET['delete'])) {
                $success = "User deleted successfully!";
            } else {
                $error = "Failed to delete user";
            }
        }
    }
}

// Get all users
$users = getAllUsers($pdo);

// Get user for editing
$edit_user = null;
if (isset($_GET['edit'])) {
    $edit_user = getUserByUsername($pdo, $_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - BlogCMS Admin</title>
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
                            <a class="nav-link" href="dashboard.php">
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
                            <a class="nav-link active" href="users.php">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 py-4">
                <h1 class="h2 mb-4">Manage Users</h1>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= escape($error) ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= escape($success) ?></div>
                <?php endif; ?>

                <!-- Create User Button -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal">
                    Add New User
                </button>

                <!-- Users Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= escape($user['user_name']) ?></td>
                                    <td><?= escape($user['prenom']) ?> <?= escape($user['nom']) ?></td>
                                    <td><?= escape($user['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['estAdmin'] ? 'danger' : 'info' ?>">
                                            <?= $user['estAdmin'] ? 'Admin' : 'User' ?>
                                        </span>
                                    </td>
                                    <td><?= escape($user['date_inscricption']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editUser('<?= escape($user['user_name']) ?>', '<?= escape($user['nom']) ?>', '<?= escape($user['prenom']) ?>', '<?= escape($user['email']) ?>', <?= $user['estAdmin'] ?>)">Edit</button>
                                        <?php if ($user['user_name'] !== $_SESSION['user_name']): ?>
                                            <a href="?delete=<?= escape($user['user_name']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="userForm">
                    <div class="modal-body">
                        <input type="hidden" name="user_name" id="edit_user_name">
                        <input type="hidden" name="mode" id="mode" value="create">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                        </div>
                        
                        <div class="mb-3" id="username_field">
                            <label for="new_user_name" class="form-label">Username</label>
                            <input type="text" class="form-control" id="new_user_name" name="user_name">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3" id="password_field">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="estAdmin" name="estAdmin">
                            <label class="form-check-label" for="estAdmin">
                                Administrator
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="create" id="submitBtn" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(username, nom, prenom, email, isAdmin) {
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('edit_user_name').value = username;
            document.getElementById('nom').value = nom;
            document.getElementById('prenom').value = prenom;
            document.getElementById('email').value = email;
            document.getElementById('estAdmin').checked = isAdmin == 1;
            
            document.getElementById('username_field').style.display = 'none';
            document.getElementById('password_field').style.display = 'none';
            document.getElementById('submitBtn').name = 'update';
            document.getElementById('submitBtn').textContent = 'Update User';
            
            new bootstrap.Modal(document.getElementById('userModal')).show();
        }
        
        // Reset form when modal closes
        document.getElementById('userModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('modalTitle').textContent = 'Add New User';
            document.getElementById('userForm').reset();
            document.getElementById('username_field').style.display = 'block';
            document.getElementById('password_field').style.display = 'block';
            document.getElementById('submitBtn').name = 'create';
            document.getElementById('submitBtn').textContent = 'Create User';
            document.getElementById('new_user_name').name = 'user_name';
            document.getElementById('password').required = true;
        });
    </script>
</body>
</html>