<?php
    session_start();
    include_once('cnx.inc.php');    

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id_billet = htmlspecialchars($_GET['id']);
    } else {
        header('Location: index.php');
        exit();
    }
    if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        $admin_loggned_in = true;
    } else {
        $admin_loggned_in = false;
    }

    // Récupérer les informations des billets 
    $stmt_billet = $cnx->prepare("SELECT * FROM billets WHERE id_billet = :id_billet");
    $stmt_billet->execute([':id_billet'=>$id_billet]);
    $billet = $stmt_billet->fetch(PDO::FETCH_ASSOC);
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
    <?php
        include_once('header.inc.php'); 
    ?>

    <?php if ($admin_loggned_in): ?>
        <!-- Popup de suppression -->
        <div class="popup popup-delete">
            <div class="popup-content">
                <span class="close-popup">&times;</span>
                <h2>Supprimer le billet</h2>
                <p>Êtes-vous sûr de vouloir supprimer ce billet ?</p>
                <form action="traite-php/traite-billet.php" method="POST">
                    <input type="hidden" name="id_billet" value="<?= $id_billet ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="confirm">Oui, supprimer</button>
                    <button type="button" class="cancel">Non, annuler</button>
                </form>
            </div>
        </div>

        <!-- Popup de modification -->
        <div class="popup popup-edit">
            <div class="popup-content">
                <span class="close-popup">&times;</span>
                <h2>Modifier le billet</h2>
                <form action="traite-php/traite-billet.php" method="POST">
                    <input type="hidden" name="id_billet" value="<?= $id_billet ?>">
                    <input type="hidden" name="action" value="edit">

                    <div class="form-group">
                        <label for="titre_edit">Titre</label>
                        <input type="text" name="titre_edit" id="titre_edit" value="<?= $billet['titre'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description_edit">Description</label>
                        <textarea name="description_edit" id="description_edit" rows="5" required><?= htmlspecialchars($billet['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image_edit">Image (laisser vide pour ne pas changer)</label>
                        <input type="file" name="image_edit" id="image_edit" accept="image/*">
                    </div>

                    <button type="submit" class="confirm">Enregistrer les modifications</button>
                    <button type="button" class="cancel">Annuler</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <main>
        <a href='archive.php' class='go-to-archive'>Aller aux archives</a>

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
                    <div class='infos'>
                        <span>Publié le " . $billet['date'] . " par Admin</span>
                        <hr>
                        <h1 class='title-section'>" . $billet['titre'] . "</h1>
                    </div>
                    <div class='menu-admin'>
                        <a href='#' class='menu-toggle'><i class='bx bx-dots-vertical-rounded'></i></a>
                        <div class='display-menu-list-admin'>
                            <a href='#' class='delete'><i class='bx bx-trash'></i> Supprimer le billet</a> 
                            <a href='#' class='edit'><i class='bx bx-edit'></i> Modifier le billet</a>
                        </div>
                    </div>
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
                // Requête pour récupérer les commentaires et les infos utilisateur en une seule fois
                $stmt = $cnx->prepare("
                    SELECT c.commentaire, c.date, u.username, u.profile_photo
                    FROM commentaires c
                    JOIN utilisateurs u ON c.fk_auteur = u.id_user
                    WHERE c.fk_comment_billet = ?
                    ORDER BY c.date DESC
                ");
                $stmt->execute([$id_billet]);
                $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($commentaires) > 0) {
                    foreach ($commentaires as $commentaire) {
                        if (!empty($commentaire['profile_photo'])) {
                            $photo = htmlspecialchars($commentaire['profile_photo']);
                        } else {
                            $photo = 'images/profile/default_profile.png';
                        } 
                        $username = htmlspecialchars($commentaire['username']);
                        $date = htmlspecialchars($commentaire['date']);
                        $texte = htmlspecialchars($commentaire['commentaire']);

                        echo "
                        <div class='comment'>
                            <div class='img-user'>
                                <img src='$photo' alt='Photo de profil de $username'>
                                <h3>$username - $date</h3>
                            </div>
                            <p>$texte</p>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>Aucun commentaire pour le moment. Soyez le premier à commenter !</p><br><br>";
                }
                ?>
            </div>

            <!-- Formulaire ajouter commentaire -->
            <?php
                if(isset($_SESSION['username'])) {
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
    <?php
        include_once('footer.inc.php');
    ?>
    <script>
        // Gestion des commentaires (Afficher / Masquer)
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

    <script src="js/popup_delete_edit.js"></script>

</body>
</html>