<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $image_path_url = $_POST['image_path_url'];

    try {
        $sql = "INSERT INTO evenements (nom, date, lieu, description, image_path, image_path_url) VALUES (:nom, :date, :lieu, :description, :image_path, :image_path_url)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'image_path' => $image_path, 'image_path_url' => $image_path_url]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'événement : " . $e->getMessage();
    }
}
