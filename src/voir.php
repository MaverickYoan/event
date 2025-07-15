<?php
require_once 'database.php';
session_start();


// Check if user is registered for the event
$est_inscrit = false;
if (isset($_SESSION['id_utilisateur'])) {
    $sql = "SELECT 1 FROM inscriptions WHERE id_utilisateur = :id_utilisateur AND id_evenement = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur'], 'id_evenement' => $id_evenement]);
    $est_inscrit = $stmt->fetchColumn();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($evenement['nom']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div></div>
    </header>
<nav class="navbar">
        <div class="hamburger-menu" id="hamburgerMenu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
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


<div class="container">
        <div class="quick-links">
            <h1>Check un peu</h1>
            <a href="https://www.nevers.fr/vivre-a-nevers" target="_blank">Vivre à Nevers</a>
            <a href="https://www.nevers.fr/vivre-a-nevers">Vivre à Nevers</a>
            <a href="https://www.nevers.fr/vivre-a-nevers">Vivre à Nevers</a>
            <a href="https://www.nevers.fr/vivre-a-nevers">Vivre à Nevers</a>
            <a href="https://www.nevers.fr/vivre-a-nevers">Vivre à Nevers</a>
            <a href="https://www.nevers.fr/vivre-a-nevers">Vivre à Nevers</a>
            
        </div>
</div>

<script src="js/script.js"></script>

</body>
</html>