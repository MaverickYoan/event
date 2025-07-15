<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin' || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_evenement = $_GET['id'];

// Fetch event name
$sql = "SELECT nom FROM evenements WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id_evenement]);
$nom_evenement = $stmt->fetchColumn();

// Fetch registered users for the event
$sql = "SELECT u.pseudo, u.email FROM utilisateurs u JOIN inscriptions i ON u.id = i.id_utilisateur WHERE i.id_evenement = :id_evenement";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_evenement' => $id_evenement]);
$inscrits = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrits à <?= htmlspecialchars($nom_evenement) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Inscrits à "<?= htmlspecialchars($nom_evenement) ?>"</h1>
        <a href="admin.php">Retour à l'administration</a>
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscrits as $inscrit): ?>
                    <tr>
                        <td><?= htmlspecialchars($inscrit['pseudo']) ?></td>
                        <td><?= htmlspecialchars($inscrit['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
