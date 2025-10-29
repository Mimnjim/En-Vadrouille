<?php
session_start();
include_once('../cnx.inc.php');

$profile_photo = $_FILES['profile_photo'] ?? null;

if (!isset($_FILES['profile_photo'])) {
    die("Aucun fichier reçu.");
}

if ($_FILES['profile_photo']['error'] !== 0) {
    die("Erreur lors de l'upload : code " . $_FILES['profile_photo']['error']);
}

var_dump($_FILES['profile_photo']);

$username = $_SESSION['username'] ?? null;

if ($profile_photo && $username) {

    // Dossier où l'image sera uploadée (doit exister déjà)
    $target_dir_server = "../images/profile/"; // pour move_uploaded_file
    $target_dir_web = "images/profile/";       // pour affichage HTML

    // Renommer le fichier pour éviter collisions
    $profile_photo_name = uniqid() . "_" . basename($profile_photo['name']);
    $target_file_server = $target_dir_server . $profile_photo_name;
    $target_file_web = $target_dir_web . $profile_photo_name;

    // Déplacement du fichier uploadé
    if (move_uploaded_file($profile_photo['tmp_name'], $target_file_server)) {

        // Mettre à jour la photo dans la base
        $stmt = $cnx->prepare("UPDATE utilisateurs SET profile_photo = :profile_photo WHERE username = :username");
        $stmt->execute([
            ':profile_photo' => $target_file_web,
            ':username' => $username
        ]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['profile_photo'] = $target_file_web;
            header("Location: ../profil.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour de la photo de profil.";
        }

    } else {
        echo "Erreur lors du téléchargement de la photo.";
        var_dump($_FILES['profile_photo']);
    }

} else {
    echo "Veuillez sélectionner une photo de profil.";
}
?>
