<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all events
$sql = "SELECT *, (SELECT COUNT(*) FROM inscriptions WHERE id_evenement = evenements.id) as nb_inscrits FROM evenements ORDER BY date ASC";
$stmt = $pdo->query($sql);
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
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
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
            <li><a href="admin.php">Administration</a></li>
        </ul>
    </nav>
    <header>

    
    </header>
    <div class="container-adm">
        <h1>Administration des événements</h1>

        <a href="add_event.php" class="btn-adm">Créer un nouvel événement</a>

        <div id="admin-event-list">
            <h2>Liste des événements</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Places disponibles</th>
                        <th>Inscrits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($evenements as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['nom']) ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td><?= htmlspecialchars($event['lieu']) ?></td>
                            <td><?= htmlspecialchars($event['places_disponibles']) ?></td>
                            <td><a href="inscrits.php?id=<?= $event['id'] ?>"><?= $event['nb_inscrits'] ?></a></td>
                            <td>
                                <a href="edit_event.php?id=<?= $event['id'] ?>">Modifier</a>
                                <a href="delete_event.php?id=<?= $event['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
