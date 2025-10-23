<?php
    session_start();
    include_once('cnx.inc.php');    

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_billet = htmlspecialchars($_GET['id']);
    } else {
        header('Location: index.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/billet.css">

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
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

            } else {
                echo '
                    <nav>
                        <a href="connexion.php">Se connecter</a>
                    </nav>  
                ';
            }
        ?>
    </header>
    <main>

        <?php

            $stmt = $cnx->prepare("SELECT * FROM billets WHERE id_billet = ?");
            $stmt->execute([$id_billet]);
            $billet = $stmt->fetch();
            if(!$billet) {
                echo "<p>Billet non trouvé.</p>";
                exit();
            }

            echo "
            
                <div class='infos-billet'>
                    <h3>Publié le " . $billet['date'] . " par Admin</h3>
                    <hr>
                    <h1 class='title-section'>" . $billet['titre'] . "</h1>
                </div>

                <section class='billet-content'>
                    <img src='" . $billet['image'] . "' alt='Image du billet " . $billet['titre'] . "'>
                    <p>
                        " . $billet['description'] . "
                    </p>
                </section>
            
            
            
            ";



        ?>

        <section class="comments-section">

            <h2>Commentaires</h2>

            <span class="toggleComments">> Afficher les commentaires</span>

            <div class="list-comments">
                
                <?php

                    $stmt = $cnx->prepare("SELECT * FROM commentaires WHERE fk_comment_billet = ? ORDER BY date DESC");
                    $stmt->execute([$id_billet]);
                    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if(count($commentaires) > 0) {
                        foreach($commentaires as $commentaire) {

                            $stmtautorComment = $cnx->prepare("SELECT * FROM utilisateurs WHERE id_user = ?");
                            $stmtautorComment->execute([$commentaire['fk_auteur']]);
                            $autorComment = $stmtautorComment->fetch(PDO::FETCH_ASSOC);

                            echo "
                                <div class='comment'>
                                    <h3>" . htmlspecialchars($autorComment['username']) . " - " . htmlspecialchars($commentaire['date']) . "</h3>
                                    <p>" . htmlspecialchars($commentaire['commentaire']) . "</p>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p>Aucun commentaire pour le moment. Soyez le premier à commenter !</p><br><br>";
                    }
                ?>
                <!-- <div class="comment">
                    <h3>Utilisateur123</h3>
                    <p>Super billet ! Merci pour le partage.</p>
                </div>
                <div class="comment">
                    <h3>Voyageur456</h3>
                    <p>J’ai adoré cette exposition aussi, une vraie découverte !</p>
                </div> -->
            </div>  

            <!-- Formulaire ajouter commentaire -->
             
            <?php

                if(!isset($_SESSION['username'])) {
                    exit();
                }
                else {
                    echo "

                        <div class='add-comment-section'>

                            <h3>Ajouter un commentaire</h3>
                            <form action='traite-php/traite-commentaire.php' method='post' class='comment-form'>
                                <p>Utilisateur : " . $_SESSION['username'] . "</p>
                        
                                <input type='hidden' name='id_billet' value='" . $id_billet . "'>


                                <label for='comment'>Commentaire :</label><br>
                                <textarea id='comment' name='comment' rows='4' required></textarea>
                
                                <button type='submit'>Envoyer</button>
                            </form>
                        </div>
                
                    ";
                }
            
            ?>

        </section>
    </main>

    <script>
        const commentsSection = document.querySelector('.comments-section');
        const commentsList = document.querySelector('.list-comments');
        const toggleComments = commentsSection.querySelector('span');

        toggleComments.addEventListener('click', () => {
            if(commentsList.style.display === 'block') {
                commentsList.style.display = 'none';
                toggleComments.textContent = '> Afficher les commentaires';
            } else {
                commentsList.style.display = 'block';
                toggleComments.textContent = '> Masquer les commentaires';
            }
        });
    </script>
</body>
</html>