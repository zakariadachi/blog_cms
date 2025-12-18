<?php
require_once 'db.php';
require_once 'functions.php';

$articles = getPublishedArticles($pdo);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BlogCMS - Home</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="startbootstrap-agency-gh-pages/assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="startbootstrap-agency-gh-pages/css/styles.css" rel="stylesheet" />
        <style>
            /* Position the portfolio-link container */
            .portfolio-link {
                position: relative !important;
                display: block !important;
            }
            
            /* Overlay the + icon on top of the image using z-index */
            .portfolio-link .portfolio-hover {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                z-index: 10 !important;
            }
            
            .portfolio-link .portfolio-hover .portfolio-hover-content {
                position: static !important;
                transform: none !important;
                margin: 0 !important;
            }
        </style>
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="startbootstrap-agency-gh-pages/assets/img/navbar-logo.svg" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#articles">Articles</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <?php if (isLoggedIn()): ?>
                            <?php if (!isAdmin()): ?>
                                <li class="nav-item"><a class="nav-link" href="author/my_articles.php">My Articles</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?= escape($_SESSION['user_name']) ?>)</a></li>
                            <?php if (isAdmin()): ?>
                                <li class="nav-item"><a class="nav-link" href="admin/dashboard.php">Dashboard</a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead" style="background-image: url('startbootstrap-agency-gh-pages/assets/img/header-bg.jpg');">
            <div class="container">
                <div class="masthead-subheading">Welcome To BlogCMS!</div>
                <div class="masthead-heading text-uppercase">Explore Our Latest Stories</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#articles">Read More</a>
            </div>
        </header>
        
        <!-- Articles Grid-->
        <section class="page-section bg-light" id="articles">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Latest Articles</h2>
                    <h3 class="section-subheading text-muted">Discover our most recent publications.</h3>
                </div>
                <div class="row">
                    <?php if (empty($articles)): ?>
                        <div class="col-12 text-center"><p>No articles found.</p></div>
                    <?php else: ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="col-lg-4 col-sm-6 mb-4">
                                <div class="portfolio-item">
                                    <a class="portfolio-link" href="article.php?id=<?= $article['id_article'] ?>">
                                        <div class="portfolio-hover">
                                            <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                        </div>
                                        <!-- Article image -->
                                        <img class="img-fluid" src="picture.jpg" alt="<?= escape($article['titre']) ?>" style="width: 100%; height: 250px; object-fit: cover;" />
                                    </a>
                                    <div class="portfolio-caption">
                                        <div class="portfolio-caption-heading"><?= escape($article['titre']) ?></div>
                                        <div class="portfolio-caption-subheading text-muted">
                                            By <?= escape($article['nom_createur']) ?> on <?= escape($article['date_creation']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- About-->
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">About</h2>
                    <p class="text-muted">Simple Blog CMS built with Native PHP.</p>
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
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="startbootstrap-agency-gh-pages/js/scripts.js"></script>
    </body>
</html>
