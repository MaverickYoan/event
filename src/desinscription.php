<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$id_evenement = $_GET['id'];

// Unregister user from the event
try {
    $sql = "DELETE FROM inscriptions WHERE id_utilisateur = :id_utilisateur AND id_evenement = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $id_utilisateur, 'id_evenement' => $id_evenement]);

    // Increment available places
    $sql = "UPDATE evenements SET places_disponibles = places_disponibles + 1 WHERE id = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_evenement' => $id_evenement]);

    header("Location: evenement.php?id=$id_evenement");
} catch (PDOException $e) {
    echo "Erreur lors de la désinscription : " . $e->getMessage();
}
