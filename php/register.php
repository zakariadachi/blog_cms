<?php
require_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom']);
    $prenom = cleanInput($_POST['prenom']);
    $username = cleanInput($_POST['username']);
    $email = cleanInput($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($password)) {
        $error = "Tous les champs sont requis";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            $error = "Ce nom d'utilisateur ou email est déjà utilisé";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, user_name, email, passwords, estAdmin) 
                                   VALUES (?, ?, ?, ?, ?, 0)");
            
            if ($stmt->execute([$nom, $prenom, $username, $email, $password])) {
                $_SESSION['user_id'] = $username;
                $_SESSION['user_name'] = $username;
                $_SESSION['estAdmin'] = 0;
                
                header('Location: index.php');
                exit;
            } else {
                $error = "Une erreur est survenue";
            }
        }
    }
}

$page_title = "Inscription";
require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Créer un compte</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
                
                <div class="mt-3 text-center">
                    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>