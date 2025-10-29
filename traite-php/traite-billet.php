<?php
session_start();
include_once('../cnx.inc.php');

// Vérifie que seul l'admin peut accéder à ces actions
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- AJOUT D’UN BILLET ---
    if (isset($_POST['titre_billet']) && isset($_POST['description_billet']) && isset($_FILES['image_billet'])) {

        $titre_billet = $_POST['titre_billet'];
        $description_billet = $_POST['description_billet'];
        $date_billet = date('Y-m-d H:i:s');

        $target_dir = "../images/sorties-img/";
        $image_billet = uniqid() . "_" . basename($_FILES["image_billet"]["name"]);
        $target_file = $target_dir . $image_billet;

        move_uploaded_file($_FILES["image_billet"]["tmp_name"], $target_file);
        $image_path = "images/sorties-img/" . $image_billet;

        $stmt = $cnx->prepare("INSERT INTO billets (fk_proprietaire, titre, description, date, image) VALUES (1, :titre_billet, :description_billet, :date_billet, :image_path)");
        $stmt->execute([
            ':titre_billet'=>$titre_billet,
            ':description_billet'=>$description_billet,
            ':date_billet'=>$date_billet,
            ':image_path'=>$image_path
        ]);

        header("Location: ../index.php");
        exit();
    }

    // --- SUPPRESSION D’UN BILLET ---
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id_billet = $_POST['id_billet'];

        // On supprime aussi l’image du serveur
        $stmt = $cnx->prepare("SELECT image FROM billets WHERE id_billet = ?");
        $stmt->execute([$id_billet]);
        $billet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($billet && file_exists("../" . $billet['image'])) {
            unlink("../" . $billet['image']);
        }

        $stmt = $cnx->prepare("DELETE FROM billets WHERE id_billet = ?");
        $stmt->execute([$id_billet]);

        header("Location: ../archive.php");
        exit();
    }

    // --- MODIFICATION D’UN BILLET ---
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id_billet = $_POST['id_billet'];
        $titre = $_POST['titre_edit'];
        $description = $_POST['description_edit'];

        // Vérifie si une nouvelle image a été envoyée
        if (!empty($_FILES['image_edit']['name'])) {
            $target_dir = "../images/sorties-img/";
            $image_edit = uniqid() . "_" . basename($_FILES["image_edit"]["name"]);
            $target_file = $target_dir . $image_edit;

            move_uploaded_file($_FILES["image_edit"]["tmp_name"], $target_file);
            $image_path = "images/sorties-img/" . $image_edit;

            $stmt = $cnx->prepare("UPDATE billets SET titre = ?, description = ?, image = ? WHERE id_billet = ?");
            $stmt->execute([$titre, $description, $image_path, $id_billet]);
        } else {
            $stmt = $cnx->prepare("UPDATE billets SET titre = ?, description = ? WHERE id_billet = ?");
            $stmt->execute([$titre, $description, $id_billet]);
        }

        header("Location: ../billet.php?id=" . $id_billet);
        exit();
    }

} else {
    echo "Aucune action reçue.";
}
?>
