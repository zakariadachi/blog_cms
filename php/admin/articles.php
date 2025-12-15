<?php
require_once '../includes/config.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// CRUD Articles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create' || $action === 'edit') {
        $titre = cleanInput($_POST['titre']);
        $contenu = cleanInput($_POST['contenu']);
        $id_categorie = (int)$_POST['id_categorie'];
        $statu = cleanInput($_POST['statu']);
        
        if ($action === 'create') {
            $stmt = $pdo->prepare("
                INSERT INTO article (titre, contenu, date_creation, date_modification, nom_createur, id_categorie, statu)
                VALUES (?, ?, CURDATE(), CURDATE(), ?, ?, ?)
            ");
            $stmt->execute([$titre, $contenu, $_SESSION['user_name'], $id_categorie, $statu]);
            header('Location: articles.php?success=Article créé');
            exit;
        } else {
            $stmt = $pdo->prepare("
                UPDATE article 
                SET titre = ?, contenu = ?, date_modification = CURDATE(), id_categorie = ?, statu = ?
                WHERE id_article = ?
            ");
            $stmt->execute([$titre, $contenu, $id_categorie, $statu, $id]);
            header('Location: articles.php?success=Article modifié');
            exit;
        }
    }
}

if ($action === 'delete' && $id > 0) {
    $stmt = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
    $stmt->execute([$id]);
    header('Location: articles.php?success=Article supprimé');
    exit;
}

// Récupérer les articles
if (isAdmin()) {
    $stmt = $pdo->query("
        SELECT a.*, c.nom_categorie 
        FROM article a 
        LEFT JOIN categorie c ON a.id_categorie = c.id_categorie 
        ORDER BY a.date_creation DESC
    ");
} else {
    $stmt = $pdo->prepare("
        SELECT a.*, c.nom_categorie 
        FROM article a 
        LEFT JOIN categorie c ON a.id_categorie = c.id_categorie 
        WHERE a.nom_createur = ?
        ORDER BY a.date_creation DESC
    ");
    $stmt->execute([$_SESSION['user_name']]);
}
$articles = $stmt->fetchAll();

// Récupérer les catégories
$categories = $pdo->query("SELECT * FROM categorie ORDER BY nom_categorie")->fetchAll();

$page_title = "Gestion des articles";
require_once '../includes/header.php';
?>

<h1 class="mb-4">Gestion des articles</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
<?php endif; ?>

<?php if ($action === 'create' || $action === 'edit'): ?>
    
    <?php 
    $article = null;
    if ($action === 'edit' && $id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch();
    }
    ?>
    
    <div class="card">
        <div class="card-body">
            <h3><?php echo $action === 'create' ? 'Créer un article' : 'Modifier l\'article'; ?></h3>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" 
                           value="<?php echo $article ? $article['titre'] : ''; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="contenu" class="form-label">Contenu</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="10" required><?php 
                        echo $article ? $article['contenu'] : ''; 
                    ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_categorie" class="form-label">Catégorie</label>
                        <select class="form-control" id="id_categorie" name="id_categorie">
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id_categorie']; ?>"
                                    <?php if ($article && $article['id_categorie'] == $categorie['id_categorie']) echo 'selected'; ?>>
                                    <?php echo $categorie['nom_categorie']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="statu" class="form-label">Statut</label>
                        <select class="form-control" id="statu" name="statu">
                            <option value="published" <?php if ($article && $article['statu'] == 'published') echo 'selected'; ?>>Publié</option>
                            <option value="draft" <?php if ($article && $article['statu'] == 'draft') echo 'selected'; ?>>Brouillon</option>
                            <option value="archive" <?php if ($article && $article['statu'] == 'archive') echo 'selected'; ?>>Archivé</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <?php echo $action === 'create' ? 'Créer' : 'Modifier'; ?>
                </button>
                <a href="articles.php" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
    
<?php else: ?>
    
    <div class="mb-3">
        <a href="?action=create" class="btn btn-success">Nouvel article</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?php echo $article['titre']; ?></td>
                            <td><?php echo $article['nom_categorie']; ?></td>
                            <td><?php echo $article['nom_createur']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($article['date_creation'])); ?></td>
                            <td>
                                <?php 
                                $status_badges = [
                                    'published' => 'success',
                                    'draft' => 'warning',
                                    'archive' => 'secondary'
                                ];
                                ?>
                                <span class="badge bg-<?php echo $status_badges[$article['statu']]; ?>">
                                    <?php echo $article['statu']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="../article.php?id=<?php echo $article['id_article']; ?>" 
                                   class="btn btn-sm btn-primary" target="_blank">Voir</a>
                                <a href="?action=edit&id=<?php echo $article['id_article']; ?>" 
                                   class="btn btn-sm btn-secondary">Modifier</a>
                                <a href="?action=delete&id=<?php echo $article['id_article']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>