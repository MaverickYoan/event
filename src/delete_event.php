<?php
require_once 'database.php';
session_start();

if (!isset($_SESSION['id_utilisateur']) || $_SESSION['role'] != 'admin' || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_evenement = $_GET['id'];

try {
    // First, delete related inscriptions
    $sql = "DELETE FROM inscriptions WHERE id_evenement = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_evenement' => $id_evenement]);

    // Then, delete the event
    $sql = "DELETE FROM evenements WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_evenement]);

    header("Location: admin.php");
} catch (PDOException $e) {
    echo "Erreur lors de la suppression de l'événement : " . $e->getMessage();
}
