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
    <header>
        <nav>
            <a href="index.php">En Vadrouille</a>
        </nav>
    </header>    

    <main>
        <h1>Inscrivez-vous et créez votre compte</h1>
        <form action="traite-php/traite-inscription.php" method="post">
            <div class="username">
                <label for="username">Votre nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="password">
                <label for="password">Votre mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="password">
                <label for="password">Confirmer votre mot de passe</label>
                <input type="password" name="password2" id="password2" required>
            </div>
            
            <button>S'inscrire</button>

            <div class="account">
                <a href="connexion.php" class="center">Vous avez déjà un compte?</a>
            </div>
        </form>
    </main>


</body>
</html>