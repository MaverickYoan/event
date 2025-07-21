<?php
require_once 'database.php';
session_start();

// Create contact table if it doesn't exist
try {
    $pdo->query("SELECT 1 FROM contact LIMIT 1");
} catch (PDOException $e) {
    if ($e->getCode() === '42P01') {
        try {
            $pdo->exec(file_get_contents('../data/contact.sql'));
        } catch (PDOException $init_e) {
            die("Erreur lors de la création de la table contact : " . $init_e->getMessage());
        }
    } else {
        die("Erreur de base de données : " . $e->getMessage());
    }
}

$success_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        $sql = "INSERT INTO contact (nom, email, message) VALUES (:nom, :email, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nom, 'email' => $email, 'message' => $message]);
        $success_message = "Votre message a bien été envoyé !";
    } catch (PDOException $e) {
        $error_message = "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../data/favicon.ico">
    <link rel="stylesheet" href="css/contact.css">
    <title>Contact</title>
    <style>
        body {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="hamburger-menu" id="hamburgerMenu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="http://localhost:8003/index.php">Accueil</a></li>
            <li><a href="http://localhost:8003/voir.php">Voir Dans la région</a></li>
            <li><a href="http://localhost:8003/contact.php">Contact</a></li>
            <?php if (isset($_SESSION['id_utilisateur'])): ?>
                <li><a href="deconnexion.php">Déconnexion</a></li>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <li><a href="admin.php">Administration</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="animated-bg"></div>

    <section>
        <div class="container">
            <div class="contact-form">
                <h1>Contactez-nous</h1>
                <?php if (!empty($success_message)): ?>
                    <p class="success-message"><?= $success_message ?></p>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                    <p class="error-message"><?= $error_message ?></p>
                <?php endif; ?>
                <form action="contact.php" method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Votre email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Votre message" required></textarea>
                    </div>
                    <button type="submit" class="btn">Envoyer</button>
                </form>
            </div>
        </div>
    </section>


    <a href="/">Back to home</a>

    <!-- * Section - Footer -->
    <footer> <br>

        <!-- Droits Section : Informations sur les droits réservés et le créateur -->

        <div class="droits">
            <img src="https://www.onlineformapro.com/wp-content/uploads/2020/01/logo-03.svg"
                alt="Logo Onlineformationpro" width="100px" id="forma" class="logo-oblineformationpro">
            <h6 style="display: flex; justify-content:center;">&copy; 2025 Projet_event | <a
                    href=https://www.onlineformapro.com/ target=_blank> @onlineformapro</a></h6>
        </div>
    </footer>
    <script>
        document.getElementById('hamburgerMenu').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>
</body>

</html>