<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM evenements WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'événement : " . $e->getMessage();
    }
}
