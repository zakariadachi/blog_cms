<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../login.php');
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// CRUD Catégories
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_categorie = cleanInput($_POST['nom_categorie']);
    
    if ($action === 'create') {
        $stmt = $pdo->prepare("INSERT INTO categorie (nom_categorie) VALUES (?)");
        $stmt->execute([$nom_categorie]);
        header('Location: categories.php?success=Catégorie créée');
        exit;
    } else if ($action === 'edit') {
        $stmt = $pdo->prepare("UPDATE categorie SET nom_categorie = ? WHERE id_categorie = ?");
        $stmt->execute([$nom_categorie, $id]);
        header('Location: categories.php?success=Catégorie modifiée');
        exit;
    }
}

if ($action === 'delete' && $id > 0) {
    // Vérifier si la catégorie est utilisée
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM article WHERE id_categorie = ?");
    $stmt->execute([$id]);
    $count = $stmt->fetch()['total'];
    
    if ($count == 0) {
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = ?");
        $stmt->execute([$id]);
        header('Location: categories.php?success=Catégorie supprimée');
    } else {
        header('Location: categories.php?error=Catégorie utilisée par des articles');
    }
    exit;
}

// Récupérer les catégories
$stmt = $pdo->query("SELECT c.*, COUNT(a.id_article) as article_count 
                     FROM categorie c 
                     LEFT JOIN article a ON c.id_categorie = a.id_categorie 
                     GROUP BY c.id_categorie 
                     ORDER BY c.nom_categorie");
$categories = $stmt->fetchAll();

$page_title = "Gestion des catégories";
require_once '../includes/header.php';
?>

<h1 class="mb-4">Gestion des catégories</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
<?php endif; ?>

<?php if ($action === 'create' || $action === 'edit'): ?>
    
    <?php 
    $categorie = null;
    if ($action === 'edit' && $id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
        $stmt->execute([$id]);
        $categorie = $stmt->fetch();
    }
    ?>
    
    <div class="card">
        <div class="card-body">
            <h3><?php echo $action === 'create' ? 'Créer une catégorie' : 'Modifier la catégorie'; ?></h3>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nom_categorie" class="form-label">Nom de la catégorie</label>
                    <input type="text" class="form-control" id="nom_categorie" name="nom_categorie" 
                           value="<?php echo $categorie ? $categorie['nom_categorie'] : ''; ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <?php echo $action === 'create' ? 'Créer' : 'Modifier'; ?>
                </button>
                <a href="categories.php" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
    
<?php else: ?>
    
    <div class="mb-3">
        <a href="?action=create" class="btn btn-success">Nouvelle catégorie</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $categorie): ?>
                        <tr>
                            <td><?php echo $categorie['id_categorie']; ?></td>
                            <td><?php echo $categorie['nom_categorie']; ?></td>
                            <td><?php echo $categorie['article_count']; ?></td>
                            <td>
                                <a href="?action=edit&id=<?php echo $categorie['id_categorie']; ?>" 
                                   class="btn btn-sm btn-secondary">Modifier</a>
                                <?php if ($categorie['article_count'] == 0): ?>
                                    <a href="?action=delete&id=<?php echo $categorie['id_categorie']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>