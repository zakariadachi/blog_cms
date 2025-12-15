<?php
require_once 'includes/config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Récupérer la catégorie
$stmt = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
$stmt->execute([$id]);
$category = $stmt->fetch();

if (!$category) {
    header('Location: index.php');
    exit;
}

// Récupérer les articles de la catégorie
$stmt = $pdo->prepare("
    SELECT a.*, c.nom_categorie 
    FROM article a 
    LEFT JOIN categorie c ON a.id_categorie = c.id_categorie 
    WHERE a.id_categorie = ? AND a.statu = 'published' 
    ORDER BY a.date_creation DESC
");
$stmt->execute([$id]);
$articles = $stmt->fetchAll();

$page_title = "Catégorie : " . $category['nom_categorie'];
require_once 'includes/header.php';
?>

<h1 class="mb-4">Catégorie : <?php echo $category['nom_categorie']; ?></h1>

<?php if (empty($articles)): ?>
    <div class="alert alert-info">Aucun article dans cette catégorie.</div>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <div class="card mb-3">
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

<?php require_once 'includes/footer.php'; ?>