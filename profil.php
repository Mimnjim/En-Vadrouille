<?php
    session_start();
    
    if(!isset($_SESSION['username'])) {
        header("Location: connexion.php");
        exit();
    }


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/profil.css">
    <link rel="stylesheet" href="styles/global.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
    
    <title>Document</title>
</head>
<body>
    <header>
        <a href="index.php">En Vadrouille</a>

        <?php
            if(isset($_SESSION['username'])) {
                echo '
                    <nav>
                        <a href="profil.php"><i class="bx bx-user-circle"></i></a>
                    </nav>
                ';
            }
        ?>
    </header>

    <main>
        <p>main du profil de <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <br>
        <a href="log-out">Se déconnecter</a>
    </main>
</body>
</html>