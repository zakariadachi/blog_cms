<?php
require_once '../db.php';
require_once '../functions.php';

requireAdmin();

$comment = null;
$content = '';
$status = '';
$error = '';

if (isset($_GET['id'])) {
    $comment = getComment($pdo, $_GET['id']);
    if (!$comment) {
        redirect('comments.php');
    }
    $content = $comment['contenu_cmt'];
    $status = $comment['statu'];
} else {
    redirect('comments.php'); // No create comment from admin
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    $status = $_POST['status'];

    if (empty($content)) {
        $error = "Content is required.";
    } else {
        if (updateComment($pdo, $comment['id_cmt'], $content, $status)) {
            redirect('comments.php');
        } else {
            $error = "Error updating comment.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment - BlogCMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Comment</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= escape($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="approved" <?= $status == 'approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="spam" <?= $status == 'spam' ? 'selected' : '' ?>>Spam</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control" rows="5" required><?= escape($content) ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Comment</button>
                            <a href="comments.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
