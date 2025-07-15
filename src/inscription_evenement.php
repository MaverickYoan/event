<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];
$id_evenement = $_GET['id'];

// Check if user is already registered
$sql = "SELECT 1 FROM inscriptions WHERE id_utilisateur = :id_utilisateur AND id_evenement = :id_evenement";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_utilisateur' => $id_utilisateur, 'id_evenement' => $id_evenement]);
if ($stmt->fetchColumn()) {
    header("Location: evenement.php?id=$id_evenement");
    exit();
}

// Register user for the event
try {
    $sql = "INSERT INTO inscriptions (id_utilisateur, id_evenement) VALUES (:id_utilisateur, :id_evenement)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $id_utilisateur, 'id_evenement' => $id_evenement]);

    // Decrement available places
    $sql = "UPDATE evenements SET places_disponibles = places_disponibles - 1 WHERE id = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_evenement' => $id_evenement]);

    header("Location: evenement.php?id=$id_evenement");
} catch (PDOException $e) {
    echo "Erreur lors de l'inscription : " . $e->getMessage();
}
