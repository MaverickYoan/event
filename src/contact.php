<?php
require_once 'database.php';

// Create contact table if it doesn't exist
try {
    $pdo->query("SELECT 1 FROM contact LIMIT 1");
} catch (PDOException $e) {
    if ($e->getCode() === '42P01') {
        try {
            $pdo->exec(file_get_contents('../data/contact.sql'));
        } catch (PDOException $init_e) {
            die("Erreur lors de la création de la table contact : " . $init_e->getMessage());
        }
    } else {
        die("Erreur de base de données : " . $e->getMessage());
    }
}

$success_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        $sql = "INSERT INTO contact (nom, email, message) VALUES (:nom, :email, :message)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nom, 'email' => $email, 'message' => $message]);
        $success_message = "Votre message a bien été envoyé !";
    } catch (PDOException $e) {
        $error_message = "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../data/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <title>Contact</title>
    <style>
        .animated-bg,
        .container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, rgb(61, 236, 13), rgba(187, 27, 27, 1), rgb(21, 142, 31), rgba(137, 8, 189, 1));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            padding: 2em;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        h1 {
            color: white;
            text-align: center;
        }

        .form-group {
            margin-bottom: 0.5em;
        }

        .form-group label {
            display: block;
            color: white;
            margin-bottom: .5em;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: .8em;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-sizing: border-box;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(102, 118, 104, 0.7);
        }

        .btn {
            width: 100%;
            padding: 1em;
            background-color: #fff;
            color: rgb(7, 87, 4);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #f0f0f0;
        }

        .success-message {
            color: rgb(69, 225, 17);
            text-align: center;
            margin-top: 1em;
        }

        .error-message {
            color: rgb(190, 135, 15);
            text-align: center;
            margin-top: 1em;
        }

        @media screen and (max-width: 768px) {
            body {
                overflow: auto;
            }

            .contact-form {
                width: 90%;
                max-width: 400px;
            }

            .animated-bg,
            .contact-form {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: ;
                background: linear-gradient(45deg, rgba(13, 28, 236, 1), rgba(131, 187, 27, 1), rgb(21, 142, 31), rgba(137, 8, 189, 1));
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="hamburger-menu" id="hamburgerMenu">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="http://localhost:8003/index.php">Accueil</a></li>
            <li><a href="http://localhost:8003/voir.php">Voir Dans la région</a></li>
            <li><a href="http://localhost:8003/contact.php">Contact</a></li>
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

    <div class="animated-bg"></div>
    <div class="container">
        <div class="contact-form">
            <h1>Contactez-nous</h1>
            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?= $success_message ?></p>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message ?></p>
            <?php endif; ?>
            <form action="contact.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Votre email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Votre message" required></textarea>
                </div>
                <button type="submit" class="btn">Envoyer</button>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>