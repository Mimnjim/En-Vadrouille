<?php
    session_start();
    include_once('../cnx.inc.php');

    $nom_utilisateur = $_POST['username'];
    $mot_de_passe = $_POST['password'];

    if(isset($nom_utilisateur) && isset($mot_de_passe)) {
        $stmt = $cnx->prepare("SELECT * FROM utilisateurs WHERE username = :nom_utilisateur");
        $stmt->execute([
            ':nom_utilisateur'=>$nom_utilisateur
        ]);

        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($mot_de_passe, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: ../index.php");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Nom d'utilisateur non trouvé.";
        }


    }


?>