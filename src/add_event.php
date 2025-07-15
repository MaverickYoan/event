<?php
require_once 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $description = $_POST['description'];
    $image = '';
    // $lien = $_POST['lien'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Déplacer le fichier uploadé
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        }
    }

    try {
        $sql = "INSERT INTO evenements (nom, date, lieu, description, image) VALUES (:nom, :date, :lieu, :description, :image)";
        // $sql = "INSERT INTO evenements (nom, date, lieu, description, image, lien) VALUES (:nom, :date, :lieu, :description, :image, :lien)";
        $stmt = $pdo->prepare($sql);
        // $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'image' => $image, 'lien' => $lien]);
        $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'image' => $image]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'événement : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer nouvel événement</title>
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
        <h1>Créer un nouvel événement</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($evenement['nom']) ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" id="date" name="date"
                    value="<?= date('Y-m-d\TH:i', strtotime($evenement['date'])) ?>" required>
            </div>
            <div class="form-group">
                <label for="lieu">Lieu</label>
                <input type="text" id="lieu" name="lieu" value="<?= htmlspecialchars($evenement['lieu']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"
                    required><?= htmlspecialchars($evenement['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="places_disponibles">Places disponibles</label>
                <input type="number" id="places_disponibles" name="places_disponibles"
                    value="<?= htmlspecialchars($evenement['places_disponibles']) ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" required>
            </div>

            <button type="submit" class="btn">Créer</button>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>

</html>