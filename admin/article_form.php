<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

$article = null;
$title = '';
$content = '';
$categoryId = '';
$status = 'published';
$error = '';

if (isset($_GET['id'])) {
    $article = getArticle($pdo, $_GET['id']);
    if (!$article) {
        redirect('articles.php');
    }
    $title = $article['titre'];
    $content = $article['contenu'];
    $categoryId = $article['id_categorie'];
    $status = $article['statu'];
}

$categories = getAllCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $categoryId = $_POST['category'];
    $status = $_POST['status'];
    $author = $_SESSION['user_name']; // Current logged in admin

    if (empty($title) || empty($content)) {
        $error = "Title and Content are required.";
    } else {
        if ($article) {
            updateArticle($pdo, $article['id_article'], $title, $content, $categoryId, $status);
        } else {
            addArticle($pdo, $title, $content, $categoryId, $author, $status);
        }
        redirect('articles.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article ? 'Edit' : 'Add' ?> Article - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3><?= $article ? 'Edit' : 'Add New' ?> Article</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= escape($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="<?= escape($title) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id_categorie'] ?>" <?= $categoryId == $cat['id_categorie'] ? 'selected' : '' ?>>
                                            <?= escape($cat['nom_categorie']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="published" <?= $status == 'published' ? 'selected' : '' ?>>Published</option>
                                    <option value="archive" <?= $status == 'archive' ? 'selected' : '' ?>>Archived</option>
                                    <option value="draft" <?= $status == 'draft' ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control" rows="10" required><?= escape($content) ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Article</button>
                            <a href="articles.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
