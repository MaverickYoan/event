<?php
require_once 'database.php';
session_start();


// Check if user is registered for the event
$est_inscrit = false;
if (isset($_SESSION['id_utilisateur'])) {
    $sql = "SELECT 1 FROM inscriptions WHERE id_utilisateur = :id_utilisateur AND id_evenement = :id_evenement";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_utilisateur' => $_SESSION['id_utilisateur'], 'id_evenement' => $id_evenement]);
    $est_inscrit = $stmt->fetchColumn();
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quelques évènements</title>
    <link rel="stylesheet" href="css/voir1.css">
    <!-- <link rel="stylesheet" href="css/voir.css"> -->
    <link rel="stylesheet" href="css/style.css">
</head>

<!-- Arrière-plan animé -->
<div class="animated-bg"></div>
<div class="camo-overlay"></div>
<div class="neon-grid"></div>

<!-- Effets lumineux -->
<div class="laser-lines">
    <div class="laser"></div>
    <div class="laser"></div>
    <div class="laser"></div>
</div>

<!-- Pluie digitale -->
<div class="digital-rain" id="digital-rain"></div>

<!-- Formes flottantes -->
<div class="floating-shapes" id="floating-shapes"></div>

<!-- Section - Body -->

<body id="content"
    style="background-image: url(img/b3b48a35785465ed53f20d332f191a5c.gif); alt:'gif d'ajout d'un jeu vidéo';">

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
        <div class="quick-links">
            <img src="uploads/comparaison-animation-gif-transparent.gif" alt="">

        </div>
    </div>

    <div id="quick" class="quick-links">
        <h3>Quelques évènements dans l'coin</h3>
        <div class="quick-buttons">
            <a href="https://www.nevers.fr/vivre-a-nevers" target="_blank" class="quick-btn">Vivre à Nevers</a>
            <a href="https://www.koikispass.com/lagenda/16422/visite-guidee-tour-de-place-place-carnot-autres-idees-de-sorties/"
                target="_blank" class="quick-btn">Visite guidée Tour de Place</a>
            <a href="https://www.nevers.fr/" target="_blank" class="quick-btn">Nevers</a>
        </div>
    </div>
    <br>
    <hr>

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

    <!-- * home section -->
    <section class="home">
        <!-- home / h1 / id home / img -->
        <h1 id="home">Event</h1>
    </section>

    <!-- * animation plane -->

    <style type="text/css">
    .home,
    #home {
        background: url(images/.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        overflow: hidden;
    }

    .sky {
        position: absolute;
        top: 10%;
        right: 2px;
        animation: sky 30s linear 0s infinite reverse;
        z-index: 99;
    }

    .sky img {
        width: 100px;
    }

    /* trajectoire de l'oiseau */
    @keyframes sky {
        from {
            top: 50px;
            right: -10px;
        }

        to {
            top: 50px;
            right: 100%;
        }
    }
    </style>

    <!-- * fond d'écran -->
    <div class="sky">
        <!-- <img src="img/tHi.gif" alt="Image d'un oiseau qui vole"> -->
        <img id="thirdBird" src="uploads/tHi.gif" alt="Image troisième oiseau qui vole">
        <img id="secondBird" src="uploads/05cd33059a006bf49006097af4ccba98-plane-in-flight.webp"
            alt="Image secondZ oiseau qui vole">
    </div>



    <script src="js/script.js"></script>

</body>

</html>