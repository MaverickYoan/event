<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin' || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_evenement = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $description = $_POST['description'];
    $places_disponibles = $_POST['places_disponibles'];
    // $lien = $_POST['lien'];

    try {
        // $sql = "UPDATE evenements SET nom = :nom, date = :date, lieu = :lieu, description = :description, places_disponibles = :places_disponibles, lien = :lien WHERE id = :id";
        $sql = "UPDATE evenements SET nom = :nom, date = :date, lieu = :lieu, description = :description, places_disponibles = :places_disponibles WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        // $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'places_disponibles' => $places_disponibles, 'lien' => $lien, 'id' => $id_evenement]);
        $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'places_disponibles' => $places_disponibles, 'id' => $id_evenement]);
        header("Location: admin.php");
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la modification de l'événement : " . $e->getMessage();
    }
} else {
    $sql = "SELECT * FROM evenements WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_evenement]);
    $evenement = $stmt->fetch();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <h1>Modifier un événement</h1>
        <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
        <form action="edit_event.php?id=<?= $id_evenement ?>" method="post">
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
            <button type="submit" class="btn">Modifier</button>
        </form>
    </div>

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
</body>

</html>