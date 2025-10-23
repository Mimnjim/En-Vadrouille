<?php
    session_start();
    include_once('../cnx.inc.php');

    $id_billet = $_POST['id_billet'];
    
    // Récupérer l'auteur à partir de la session
    $auteur = $_SESSION['username'];
    $stmtIdAutor = $cnx->prepare("SELECT id_user FROM utilisateurs WHERE username = :auteur");
    $stmtIdAutor->execute([':auteur' => $auteur]);
    $idAutor = $stmtIdAutor->fetch(PDO::FETCH_ASSOC);

    $commentaire = $_POST['comment'];
    $date_commentaire = date('Y-m-d H:i:s');
    if(isset($id_billet) && isset($idAutor) && isset($commentaire)) {

        $stmt = $cnx->prepare("INSERT INTO commentaires (fk_auteur, date, fk_comment_billet, commentaire) VALUES (:idAutor, :date_commentaire, :id_billet, :commentaire)");
        $stmt->execute([
            ':idAutor'=>$idAutor['id_user'],
            ':date_commentaire'=>$date_commentaire,
            ':id_billet'=>$id_billet,
            ':commentaire'=>$commentaire,
        ]);

        if($stmt->rowCount() > 0) {
            header("Location: ../billet.php?id=" . $id_billet);
            exit();
        } else {
            echo "Erreur lors de l'ajout du commentaire. Veuillez réessayer.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
    


?>