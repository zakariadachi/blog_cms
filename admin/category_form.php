<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

$category = null;
$name = '';
$error = '';

if (isset($_GET['id'])) {
    // We didn't create a specific getCategory function, so let's query directly or add it.
    // For simplicity, I'll query directly here or use a helper if I had one. 
    // I will query directly to avoid editing functions.php again if possible, or I should have added getCategory.
    // Let's check functions.php. I didn't add getCategory($id). 
    // I'll add the query right here.
    $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $category = $stmt->fetch();
    
    if (!$category) {
        redirect('categories.php');
    }
    $name = $category['nom_categorie'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    
    if (empty($name)) {
        $error = "Name is required.";
    } else {
        if ($category) {
            updateCategory($pdo, $category['id_categorie'], $name);
        } else {
            addCategory($pdo, $name);
        }
        redirect('categories.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $category ? 'Edit' : 'Add' ?> Category - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3><?= $category ? 'Edit' : 'Add New' ?> Category</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= escape($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" value="<?= escape($name) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Category</button>
                            <a href="categories.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
