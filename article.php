<?php
require_once 'db.php';
require_once 'functions.php';

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$id_article = (int)$_GET['id'];
$article = getArticle($pdo, $id_article);

if (!$article) {
    die("Article not found.");
}

// Handle Comment Submission
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $content = trim($_POST['comment']);
    if (!empty($content)) {
        $user_name = isLoggedIn() ? $_SESSION['user_name'] : null;
        addComment($pdo, $id_article, $content, $user_name);
        $msg = "Comment submitted!";
    }
}

$comments = getComments($pdo, $id_article);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title><?= escape($article['titre']) ?> - BlogCMS</title>
        <link rel="icon" type="image/x-icon" href="startbootstrap-agency-gh-pages/assets/favicon.ico" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <link href="startbootstrap-agency-gh-pages/css/styles.css" rel="stylesheet" />
        <style>
            .article-content { font-size: 1.1rem; line-height: 1.8; }
            .comment-section { margin-top: 50px; }
            .comment-box { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        </style>
    </head>
    <body id="page-top">
         <!-- Navigation-->
         <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark shrink" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="startbootstrap-agency-gh-pages/assets/img/navbar-logo.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <?php if (isLoggedIn()): ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="page-section mt-5">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-lg-12">
                        <h2 class="section-heading text-uppercase"><?= escape($article['titre']) ?></h2>
                        <h4 class="section-subheading text-muted">
                            By <?= escape($article['nom_createur']) ?> | <?= escape($article['date_creation']) ?>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto article-content">
                        <!-- Article image -->
                        <img class="img-fluid d-block mx-auto mb-4 rounded" src="startbootstrap-agency-gh-pages/assets/img/portfolio/1.jpg" alt="<?= escape($article['titre']) ?>" style="width: 100%; max-height: 400px; object-fit: cover;" />
                        
                        <p><?= nl2br(escape($article['contenu'])) ?></p>
                        
                        <hr class="my-5">
                        
                        <!-- Comments Section -->
                        <div class="comment-section">
                            <h3>Comments</h3>
                            
                            <!-- Comment Form -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Leave a comment</h5>
                                    <?php if ($msg): ?>
                                        <div class="alert alert-success"><?= $msg ?></div>
                                    <?php endif; ?>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <textarea class="form-control" name="comment" rows="3" required placeholder="Your comment here..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Post Comment</button>
                                        <?php if (!isLoggedIn()): ?>
                                            <small class="text-muted d-block mt-2">You are commenting as Guest (Anonymous).</small>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>

                            <!-- Comment List -->
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment-box">
                                    <div class="fw-bold"><?= escape($comment['user_name'] ?? 'Anonymous') ?></div>
                                    <small class="text-muted"><?= escape($comment['date_creation_cmt']) ?></small>
                                    <p class="mt-2 mb-0"><?= escape($comment['contenu_cmt']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; BlogCMS 2024</div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="startbootstrap-agency-gh-pages/js/scripts.js"></script>
    </body>
</html>
