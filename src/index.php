<?php
require_once 'database.php';
session_start();

// Fetch events from the database
try {
    $stmt = $pdo->query("SELECT id, nom, TO_CHAR(date, 'DD/MM/YYYY') as date, lieu, description, image FROM evenements ORDER BY date ASC");
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If the table doesn't exist, create it
    if ($e->getCode() === '42P01') {
        try {
            $pdo->exec(file_get_contents('../data/data.sql'));
            // Re-fetch events
            $stmt = $pdo->query("SELECT id, nom, TO_CHAR(date, 'DD/MM/YYYY') as date, lieu, description, image FROM evenements ORDER BY date ASC");
            $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $init_e) {
            die("Erreur lors de la création de la table : " . $init_e->getMessage());
        }
    } else {
        die("Erreur lors de la récupération des événements : " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
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


<div class="container">
        <h1>Événements à venir</h1>
        <div id="event-list">
            <?php if (empty($evenements)): ?>
                <p>Aucun événement à venir pour le moment.</p>
            <?php else: ?>
                <?php foreach ($evenements as $event): ?>
                    <div class="event">
                        <h3><?= htmlspecialchars($event['nom']) ?></h3>
                        <p class="date-lieu">Le <?= htmlspecialchars($event['date']) ?> à <?= htmlspecialchars($event['lieu']) ?></p>
                        <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        <?php if (!empty($event['image'])): ?>
                            <img src="<?= htmlspecialchars($event['image']) ?>" alt="Image de <?= htmlspecialchars($event['nom']) ?>" style="max-width: 200px; margin-top: 1em;">
                        <?php endif; ?><br><br>
                        <a href="evenement.php?id=<?= $event['id'] ?>" class="btn">Voir l'événement</a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
