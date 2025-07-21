<?php
require_once 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        $_SESSION['id_utilisateur'] = $utilisateur['id'];
        $_SESSION['pseudo'] = $utilisateur['pseudo'];
        $_SESSION['role'] = $utilisateur['role'];
        header("Location: index.php");
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="connexion.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>
    <a href="/">Back to index</a>

    <div class="img-connex"><img src="uploads/alien_by_tek2ouf_01_dk2ytmg.jpg" width="30%" alt="alien_by_tek2ouf_01">
    </div>
</body>

</html>