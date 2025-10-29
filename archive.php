<?php
    session_start();
    include_once('cnx.inc.php');    

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
    <title>Document</title>

    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/archive.css">

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include_once('header.inc.php');
    ?>

    <?php
        if($admin_loggned_in) {
            echo "
                <div class='add-billet'>
                    <span><i class='bx bx-plus-circle'></i></span>
                </div>

                <div class='popup-add-billet'>
                    <div class='popup-content'>
                        <span class='close-popup'>&times;</span>
                        <h2>Ajouter un nouveau billet</h2>
                        <form action='traite-php/traite-billet.php' method='post' enctype='multipart/form-data'>
                            <div class='form-group'>
                                <label for='titre_billet'>Titre du billet</label>
                                <input type='text' name='titre_billet' id='titre_billet' required>
                            </div>
                            <div class='form-group'>
                                <label for='description_billet'>Description</label>
                                <textarea name='description_billet' id='description_billet' rows='5' required></textarea>
                            </div>
                            <div class='form-group'>
                                <label for='image_billet'>Image du billet</label>
                                <input type='file' name='image_billet' id='image_billet' accept='image/*' required>
                            </div>
                            <button type='submit'>Ajouter le billet</button>
                        </form>
                    </div>
                </div>
            ";
        }
    ?>

    <main>
        <h1>Tous les billets des sorties</h1>
        <section class="list-billets">
            <?php
                $query = "SELECT * FROM billets ORDER BY date DESC";
                $stmt = $cnx->query($query);
                $billets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($billets as $billet) {
                    echo "
                        <a href='billet.php?id=" . htmlspecialchars($billet['id_billet']) . "'>
                            <div class='billet-item'>
                                <img src='" . $billet['image'] . "' alt='Image du billet " . $billet['titre'] . "'>
                                <h2>" . substr($billet['titre'], 0, 150) . "</h2>
                                <p>" . substr($billet['description'], 0, 150) . "...</p>
                            </div>
                        </a>
                    ";
                }
            ?>
        </section>
    </main>
    <?php
        include_once('footer.inc.php');
    ?>
    <script src="js/popup_addBillet.js"></script>
</body>
</html>