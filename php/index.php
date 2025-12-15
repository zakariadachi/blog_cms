<?php
require_once 'includes/config.php';

// Récupérer les articles publiés
$stmt = $pdo->query("
    SELECT a.*, c.nom_categorie 
    FROM article a 
    LEFT JOIN categorie c ON a.id_categorie = c.id_categorie 
    WHERE a.statu = 'published' 
    ORDER BY a.date_creation DESC
");
$articles = $stmt->fetchAll();

// Récupérer les catégories
$categories = $pdo->query("SELECT * FROM categorie ORDER BY nom_categorie")->fetchAll();

$page_title = "Accueil";
require_once 'includes/header.php';
?>

<div class="row">
    <div class="col-lg-8">
        <h1 class="mb-4">Derniers articles</h1>
        
        <?php if (empty($articles)): ?>
            <div class="alert alert-info">Aucun article publié pour le moment.</div>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">
                            <a href="article.php?id=<?php echo $article['id_article']; ?>" class="text-decoration-none">
                                <?php echo $article['titre']; ?>
                            </a>
                        </h2>
                        <p class="card-text">
                            <small class="text-muted">
                                Publié le <?php echo date('d/m/Y', strtotime($article['date_creation'])); ?>
                                par <?php echo $article['nom_createur']; ?>
                                dans <span class="badge bg-primary"><?php echo $article['nom_categorie']; ?></span>
                            </small>
                        </p>
                        <p class="card-text">
                            <?php 
                            echo strlen($article['contenu']) > 200 ? 
                                substr($article['contenu'], 0, 200) . '...' : 
                                $article['contenu'];
                            ?>
                        </p>
                        <a href="article.php?id=<?php echo $article['id_article']; ?>" class="btn btn-primary">
                            Lire la suite
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Catégories</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php foreach ($categories as $category): ?>
                        <li class="mb-2">
                            <a href="category.php?id=<?php echo $category['id_categorie']; ?>" class="text-decoration-none">
                                <?php echo $category['nom_categorie']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <?php if (isLoggedIn()): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    <a href="admin/articles.php?action=create" class="btn btn-success w-100 mb-2">
                        Nouvel article
                    </a>
                    <?php if (isAdmin()): ?>
                        <a href="admin/dashboard.php" class="btn btn-secondary w-100">
                            Tableau de bord
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>