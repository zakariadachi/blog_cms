<?php
require_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && $password === $user['passwords']) { // Simplifié pour le test
        $_SESSION['user_id'] = $user['user_name'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['estAdmin'] = $user['estAdmin'];
        
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}

$page_title = "Connexion";
require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Connexion</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
                
                <div class="mt-3 text-center">
                    <p>Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>