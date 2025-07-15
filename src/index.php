<?php
require_once 'database.php';

// Fetch events from the database
try {
    $stmt = $pdo->query("SELECT id, nom, TO_CHAR(date, 'DD/MM/YYYY') as date, lieu, description FROM evenements ORDER BY date ASC");
    $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If the table doesn't exist, create it
    if ($e->getCode() === '42P01') {
        try {
            $pdo->exec(file_get_contents('../data/data.sql'));
            // Re-fetch events
            $stmt = $pdo->query("SELECT id, nom, TO_CHAR(date, 'DD/MM/YYYY') as date, lieu, description FROM evenements ORDER BY date ASC");
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
    <title>event</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="content">
    <!-- Navbar section ------------->

    <nav class="navbar">
        <div class="hamburger-menu" id="hamburgerMenu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="http://localhost:8000/index.php">Index</a></li>
            <li><a class="links" href="http://localhost:8000/add_event.php">Ajout events</a></li>
            <li><a class="links" href="http://localhost:8000/contact.php">Contact</a></li>
            <!-- <li><a class="links" href="http://localhost:8000/espace_prive.php">espace_prive</a></li> -->
            <!-- <li><a class="links" href="http://localhost:8000/source_calendrier/calendrier.php">calendrier</a></li> -->            
             <!-- <li><a class="links" href="http://localhost:8000/add.php">Ajout User</a></li> -->
        </ul>
    </nav>
    
    <div class="container">
        <h1>event</h1>

        <div class="form-container">
            <h2>Ajouter un nouvel événement</h2><br>
            <form action="add_event.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom de l'événement</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="lieu">Lieu</label>
                    <input type="text" id="lieu" name="lieu" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="image_path">Image</label>
                    <input type="file" id="image_path" name="image_path" required>
                </div>
                <div class="form-group">
                    <label for="image_path_url">URL</label>
                <button type="submit" class="btn">Ajouter l'événement</button>
            </form>
        </div>

        <div id="event-list">
            <h2>Événements à venir</h2>
            <?php if (empty($evenements)): ?>
                <p>Aucun événement à venir pour le moment.</p>
            <?php else: ?>
                <?php foreach ($evenements as $event): ?>
                    <div class="event">
                        <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                        <h3><?= htmlspecialchars($event['nom']) ?></h3>
                        <p class="date-lieu">Le <?= htmlspecialchars($event['date']) ?> à <?= htmlspecialchars($event['lieu']) ?></p>
                        <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['nom']) ?>">
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <section class="evenements-list">
        <?php foreach ($evenements as $event): ?>
            <div class="jeu-card">
                <h2><?= htmlspecialchars($event['nom']) ?></h2>
                <p><strong>date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                <p><strong>lieu:</strong> <?= htmlspecialchars($event['lieu']) ?></p>
                <p><strong>description:</strong> <?= htmlspecialchars($event['description']) ?></p>
                <p><strong>image_path:</strong> <?= htmlspecialchars($event['image_path']) ?></p>
                <p><strong>image_path_url:</strong> <?= htmlspecialchars($event['image_path_url']) ?></p>

                <img src="<?= htmlspecialchars($event['image_path']) ?>" alt="<?= htmlspecialchars($event['nom']) ?>">
            </div>
        <?php endforeach; ?>
    </section>



    <!-- * script mobile menu -->
    <script src="js/script.js"></script>
</body>
</html>
