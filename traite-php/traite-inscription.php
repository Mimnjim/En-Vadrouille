<?php
    include_once('../cnx.inc.php');

    $nom_utilisateur = $_POST['username'];
    $mot_de_passe = $_POST['password']; 
    $mot_de_passe2 = $_POST['password2']; 

    if(isset($nom_utilisateur) && isset($mot_de_passe) && isset($mot_de_passe2)) {

        if($mot_de_passe !== $mot_de_passe2) {
            echo "Les mots de passe ne correspondent pas.";
            exit();
        }

        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        $stmt = $cnx->prepare("INSERT INTO utilisateurs (username, password) VALUES (:nom_utilisateur, :mot_de_passe)");
        $stmt->execute([
            ':nom_utilisateur'=>$nom_utilisateur, 
            ':mot_de_passe'=>$hashed_password
        ]);

        if($stmt->rowCount() > 0) {
            header("Location: ../connexion.php");
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }

    // admin
    // admin123#

?>