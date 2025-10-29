<?php
    session_start();
    include_once('cnx.inc.php');

    // Vérification de l'accès admin
    if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
        header("Location: index.php");
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
    <title>EN VADROUILLE - Tableau de bord</title>

    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/dashboard.css">

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
</head>
<body>
    <?php include_once('header.inc.php'); ?>

    <main>
        <div class="users-managed">
            <h1>Gestion des utilisateurs</h1>
            <?php
            // ✅ On récupère toutes les colonnes utiles
            $stmt_users = $cnx->query("SELECT id_user, username, profile_photo FROM utilisateurs ORDER BY id_user ASC");
            $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
            if (count($users) > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Nom d'utilisateur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($users as $user) {
                    $photo = !empty($user['profile_photo']) ? $user['profile_photo'] : 'images/profile/default_profile.png';
                    echo "
                        <tr>
                            <td>{$user['id_user']}</td>
                            <td><img src='{$photo}' alt='Photo de profil' class='profile-img'></td>
                            <td>" . htmlspecialchars($user['username']) . "</td>
                            <td class='actions'>
                                <a href='#' class='edit'>Modifier</a>
                                <a href='#' class='delete'>Supprimer</a>
                            </td>
                        </tr>
                    ";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Aucun utilisateur enregistré.</p>";
            }
            ?>
        </div>
        <div class="comments-managed">  
            <h1>Gestion des commentaires</h1>

            <?php
            // Requête pour récupérer tous les commentaires avec info sur l'auteur et le billet
            $stmt_comments = $cnx->query("
                SELECT c.id_commentaire, c.commentaire, c.date, u.username, b.titre AS billet_titre
                FROM commentaires c
                JOIN utilisateurs u ON c.fk_auteur = u.id_user
                JOIN billets b ON c.fk_comment_billet = b.id_billet
                ORDER BY c.date DESC
            ");
            $comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);

            if (count($comments) > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Auteur</th>
                                <th>Commentaire</th>
                                <th>Billet</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";

                foreach ($comments as $comment) {
                    echo "
                        <tr>
                            <td>{$comment['id_commentaire']}</td>
                            <td>" . htmlspecialchars($comment['username']) . "</td>
                            <td>" . htmlspecialchars($comment['commentaire']) . "</td>
                            <td>" . htmlspecialchars($comment['billet_titre']) . "</td>
                            <td>" . htmlspecialchars($comment['date']) . "</td>
                            <td class='actions'>
                                <a href='#' class='edit'>Modifier</a>
                                <a href='#' class='delete'>Supprimer</a>
                            </td>
                        </tr>
                    ";
                }

                echo "</tbody></table>";
            } else {
                echo "<p>Aucun commentaire enregistré.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Popup pour supprimer -->
    <div class="popup popup-delete">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <h2>Confirmer la suppression</h2>
            <p id="delete-message">Voulez-vous vraiment supprimer cet élément ?</p>
            <form id="delete-form" method="POST" action="traite-php/traite-dashboard-admin.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete-id" value="">
                <input type="hidden" name="type" id="delete-type" value="">
                <button type="submit" class="confirm">Oui, supprimer</button>
                <button type="button" class="cancel">Annuler</button>
            </form>
        </div>
    </div>

    <!-- Popup pour modifier -->
    <div class="popup popup-edit">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <h2>Modifier</h2>
            <form id="edit-form" method="POST" action="traite-php/traite-dashboard-admin.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit-id" value="">
                <input type="hidden" name="type" id="edit-type" value="">

                <div class="form-group">
                    <label for="edit-username">Nom d'utilisateur</label>
                    <input type="text" name="username" id="edit-username" required>
                </div>

                <div class="form-group" id="edit-comment-section" style="display:none;">
                    <label for="edit-comment">Commentaire</label>
                    <textarea name="commentaire" id="edit-comment" rows="4"></textarea>
                </div>

                <div class="form-group" id="edit-photo-section" style="display:none;">
                    <label for="edit-photo">Photo de profil (laisser vide pour ne pas changer)</label>
                    <input type="file" name="profile_photo" id="edit-photo" accept="image/*">
                </div>

                <button type="submit" class="confirm">Enregistrer les modifications</button>
                <button type="button" class="cancel">Annuler</button>
            </form>
        </div>
    </div>
    <?php include_once('footer.inc.php'); ?>
    <script>
        // Ouvrir le popup de suppression
        document.querySelectorAll('.delete').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const row = e.target.closest('tr');
                const id = row.children[0].textContent; // ID dans la première colonne
                const type = row.closest('table').parentElement.classList.contains('users-managed') ? 'user' : 'comment';

                document.getElementById('delete-id').value = id;
                document.getElementById('delete-type').value = type;
                document.querySelector('#delete-message').textContent =
                    type === 'user' ? "Voulez-vous vraiment supprimer cet utilisateur ?" : "Voulez-vous vraiment supprimer ce commentaire ?";

                document.querySelector('.popup-delete').style.display = 'flex';
            });
        });

        // Ouvrir le popup de modification
        document.querySelectorAll('.edit').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const row = e.target.closest('tr');
                const id = row.children[0].textContent;
                const type = row.closest('table').parentElement.classList.contains('users-managed') ? 'user' : 'comment';

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-type').value = type;

                if(type === 'user') {
                    document.getElementById('edit-username').value = row.children[2].textContent;
                    document.getElementById('edit-comment-section').style.display = 'none';
                    document.getElementById('edit-photo-section').style.display = 'block';
                } else {
                    document.getElementById('edit-username').value = row.children[1].textContent;
                    document.getElementById('edit-comment').value = row.children[2].textContent;
                    document.getElementById('edit-comment-section').style.display = 'block';
                    document.getElementById('edit-photo-section').style.display = 'none';
                }

                document.querySelector('.popup-edit').style.display = 'flex';
            });
        });

        // Fermer les popups
        document.querySelectorAll('.close-popup, .cancel').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.popup').style.display = 'none';
            });
        });

    </script>
</body>
</html>
