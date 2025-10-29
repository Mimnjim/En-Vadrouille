<?php
    session_start();
    include_once('cnx.inc.php');
    
    if(!isset($_SESSION['username'])) {
        header("Location: connexion.php");
        exit();
    }

    if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        $admin_loggned_in = true;
    } else {
        $admin_loggned_in = false;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profil.css">
    <link rel="stylesheet" href="styles/global.css">

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
    
    <title>Document</title>
</head>
<body>
    <?php
        include_once('header.inc.php'); 
    ?>

    <main>
        <div class="image-profile">

            <?php
                $stmt = $cnx->prepare("SELECT profile_photo FROM utilisateurs WHERE username = ?");
                $stmt->execute([$_SESSION['username']]);
                $user = $stmt->fetch();
                if(!empty($user['profile_photo'])) {
                    echo '<img src="' . htmlspecialchars($user['profile_photo']) . '" alt="Photo de profil">';
                } else {
                    echo '<img src="images/profile/default_profile.png" alt="Photo de profil par défaut">';
                }
            ?>

            <span>Modifier ma photo de profil</span>
        </div>

        <h1>Bienvenue sur votre profil !</h1>
        <p>Nom d'utilisateur : <?= htmlspecialchars($_SESSION['username']); ?> </p>
        <br>
        <a href="log-out">Se déconnecter</a>
    </main>
    <?php
        include_once('footer.inc.php');
    ?>
    <script>
        let spanModifierPhoto = document.querySelector('main span');
        spanModifierPhoto.addEventListener('click', () => {
            let popup = document.createElement('div');
            popup.classList.add('popup-modify-photo');
            popup.innerHTML = `
                <div class="popup-content">
                    <h2>Modifier ma photo de profil</h2>
                    <form action="traite-php/traite-profile.php" method="post" enctype="multipart/form-data">
                        <div class="file-input">
                            <label for="profile_photo">Choisir une photo</label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
                        </div>
                        <button type="submit">Enregistrer</button>
                        <button type="button" class="close-popup">Annuler</button>
                    </form>
                </div>
            `;

            document.body.appendChild(popup);

            let closePopupBtn = popup.querySelector('.close-popup');
            closePopupBtn.addEventListener('click', () => {
                document.body.removeChild(popup);
            });

        });


    </script>
</body>
</html>