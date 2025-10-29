<?php
include_once('cnx.inc.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SharingBlog</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/connexion-inscription.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">

</head>

<body>
    <?php
        include_once('header.inc.php'); 
    ?>

    <main>
        <h1>Connectez-vous pour ajouter des commentaires</h1>
        <form action="traite-php/traite-connexion.php" method="post">
            <div class="username">
                <label for="username">Votre nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="password">
                <label for="password">Votre mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button>Se connecter</button>

            <div class="account">
                <a href="inscription.php" class="center">Vous n'avez pas encore de compte?</a>
            </div>
        </form>

    </main>
    <?php
        include_once('footer.inc.php');
    ?>
</body>

</html>