<?php
require_once 'database.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_evenement = $_GET['id'];

// Fetch event details
$sql = "SELECT *, TO_CHAR(date, 'DD/MM/YYYY HH24:MI') as date_heure FROM evenements WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_evenement]);
$evenement = $stmt->fetch();

if (!$evenement) {
    header("Location: index.php");
    exit();
}

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
        <div class="event-detail">
            <h1><?= htmlspecialchars($evenement['nom']) ?></h1>
            <?php if (!empty($evenement['image'])): ?>
            <img src="<?= htmlspecialchars($evenement['image']) ?>"
                alt="Image de <?= htmlspecialchars($evenement['nom']) ?>" style="max-width: 100%; margin-bottom: 1em;">
            <?php endif; ?>
            <p><strong>Date et heure :</strong> <?= htmlspecialchars($evenement['date_heure']) ?></p>
            <p><strong>Lieu :</strong> <?= htmlspecialchars($evenement['lieu']) ?></p>
            <p><strong>Description :</strong></p>
            <p><?= nl2br(htmlspecialchars($evenement['description'])) ?></p>
            <p><strong>Places disponibles :</strong> <?= htmlspecialchars($evenement['places_disponibles']) ?></p>

            <?php if (isset($_SESSION['id_utilisateur'])): ?>
            <?php if ($est_inscrit): ?><br><br>
            <a href="desinscription.php?id=<?= $id_evenement ?>" class="btn">Se désinscrire</a>
            <?php else: ?><br><br>
            <a href="inscription_evenement.php?id=<?= $id_evenement ?>" class="btn">S'inscrire</a>
            <?php endif; ?>
            <?php else: ?>
            <p>Vous devez être connecté pour vous inscrire à cet événement.</p>
            <?php endif; ?>
        </div>
    </div>

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
    <script src="js/script.js"></script>

</body>

</html>