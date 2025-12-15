<?php
require_once 'includes/config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Récupérer l'article
$stmt = $pdo->prepare("
    SELECT a.*, c.nom_categorie 
    FROM article a 
    LEFT JOIN categorie c ON a.id_categorie = c.id_categorie 
    WHERE a.id_article = ? AND a.statu = 'published'
");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header('Location: index.php');
    exit;
}

// Récupérer les commentaires
$stmt = $pdo->prepare("SELECT * FROM commentaire WHERE id_article = ? ORDER BY date_creation_cmt DESC");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();

$page_title = $article['titre'];
require_once 'includes/header.php';
?>

<div class="row">
    <div class="col-lg-8">
        <article class="card">
            <div class="card-body">
                <h1><?php echo $article['titre']; ?></h1>
                
                <div class="text-muted mb-4">
                    <p>
                        Publié le <?php echo date('d/m/Y', strtotime($article['date_creation'])); ?>
                        par <?php echo $article['nom_createur']; ?>
                        • Catégorie : <span class="badge bg-primary"><?php echo $article['nom_categorie']; ?></span>
                    </p>
                </div>
                
                <div class="mb-4">
                    <?php echo nl2br($article['contenu']); ?>
                </div>
            </div>
        </article>
        
        <!-- Commentaires -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Commentaires (<?php echo count($comments); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($comments)): ?>
                    <p class="text-muted">Aucun commentaire pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><?php echo $comment['user_name']; ?></strong>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y', strtotime($comment['date_creation_cmt'])); ?>
                                </small>
                            </div>
                            <p class="mb-0"><?php echo nl2br($comment['contenu_cmt']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Catégorie -->
        <div class="card mb-4">
            <div class="card-body">
                <h5>Catégorie</h5>
                <p>
                    <a href="category.php?id=<?php echo $article['id_categorie']; ?>">
                        <?php echo $article['nom_categorie']; ?>
                    </a>
                </p>
            </div>
        </div>
        
        <!-- Articles récents -->
        <div class="card">
            <div class="card-body">
                <h5>Articles récents</h5>
                <?php
                $stmt = $pdo->prepare("
                    SELECT id_article, titre 
                    FROM article 
                    WHERE statu = 'published' AND id_article != ? 
                    ORDER BY date_creation DESC 
                    LIMIT 5
                ");
                $stmt->execute([$id]);
                $recent_articles = $stmt->fetchAll();
                ?>
                
                <ul class="list-unstyled">
                    <?php foreach ($recent_articles as $recent): ?>
                        <li class="mb-2">
                            <a href="article.php?id=<?php echo $recent['id_article']; ?>">
                                <?php echo $recent['titre']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>