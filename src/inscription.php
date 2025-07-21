<?php
require_once 'database.php';
session_start();

// Create utilisateurs table if it doesn't exist
try {
    $pdo->query("SELECT 1 FROM utilisateurs LIMIT 1");
} catch (PDOException $e) {
    if ($e->getCode() === '42P01') {
        try {
            $pdo->exec(file_get_contents('../data/utilisateurs.sql'));
        } catch (PDOException $init_e) {
            die("Erreur lors de la création de la table utilisateurs : " . $init_e->getMessage());
        }
    } else {
        die("Erreur de base de données : " . $e->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES (:pseudo, :email, :mot_de_passe)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['pseudo' => $pseudo, 'email' => $email, 'mot_de_passe' => $mot_de_passe]);
        header("Location: connexion.php");
    } catch (PDOException $e) {
        $error_message = "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <a href="/">Back to index</a>
        <h1>Inscription</h1>
        <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="inscription.php" method="post">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit" class="btn-go">Vous serez inscrits<br><br><br><img src="uploads/ob_aea8c1_thanks.gif"
                    width="50%" alt="retro gaming"> après le click</button>
        </form>


    </div>

</body>

</html>