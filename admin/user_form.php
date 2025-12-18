<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

$user = null;
$username = '';
$firstname = '';
$lastname = '';
$email = '';
$isAdmin = 0;
$error = '';

$isEdit = false;

if (isset($_GET['username'])) {
    $isEdit = true;
    $user = getUser($pdo, $_GET['username']);
    if (!$user) {
        redirect('users.php');
    }
    $username = $user['user_name'];
    $firstname = $user['prenom'];
    $lastname = $user['nom'];
    $email = $user['email'];
    $isAdmin = $user['estAdmin'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;

    if (empty($usernameInput) || empty($email)) {
        $error = "Username and Email are required.";
    } elseif (!$isEdit && empty($password)) {
         $error = "Password is required for new users.";
    } else {
        if ($isEdit) {
            // Update
            if (updateUser($pdo, $username, $firstname, $lastname, $email, $isAdmin, !empty($password) ? $password : null)) {
                redirect('users.php');
            } else {
                $error = "Error updating user.";
            }
        } else {
            // Create
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user_name = ?");
            $stmt->execute([$usernameInput]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Username already exists.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (user_name, nom, prenom, email, passwords, estAdmin, date_inscricption) VALUES (?, ?, ?, ?, ?, ?, CURDATE())");
                if ($stmt->execute([$usernameInput, $lastname, $firstname, $email, $hashed_password, $isAdmin])) {
                    redirect('users.php');
                } else {
                    $error = "Error adding user.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit' : 'Add' ?> User - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?= $isEdit ? 'Edit' : 'Add New' ?> User</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= escape($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= escape($username) ?>" <?= $isEdit ? 'readonly' : 'required' ?>>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="firstname" class="form-control" value="<?= escape($firstname) ?>">
                                </div>
                                <div class="col">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" value="<?= escape($lastname) ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= escape($email) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <?= $isEdit ? '(Leave blank to keep current)' : '' ?></label>
                                <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?>>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="isAdmin" name="isAdmin" <?= $isAdmin ? 'checked' : '' ?>>
                                <label class="form-check-label" for="isAdmin">Is Admin?</label>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Add' ?> User</button>
                            <a href="users.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
