<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $description = $_POST['description'];
    $image = '';

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
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nom, 'date' => $date, 'lieu' => $lieu, 'description' => $description, 'image' => $image]);

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'événement : " . $e->getMessage();
    }
}

