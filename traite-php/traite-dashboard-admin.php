<?php
session_start();
include_once('../cnx.inc.php');

if(!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$action = $_POST['action'] ?? '';
$type = $_POST['type'] ?? '';
$id = $_POST['id'] ?? '';

if($action === 'delete') {
    if($type === 'user') {
        $stmt = $cnx->prepare("DELETE FROM utilisateurs WHERE id_user = ?");
    } elseif($type === 'comment') {
        $stmt = $cnx->prepare("DELETE FROM commentaires WHERE id_commentaire = ?");
    }
    $stmt->execute([$id]);
    header("Location: ../dashboard.php");
    exit();
}

if($action === 'edit') {
    if($type === 'user') {
        $username = $_POST['username'] ?? '';
        if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['tmp_name']) {
            $target_dir = "images/profile/";
            $filename = uniqid() . "_" . basename($_FILES['profile_photo']['name']);
            move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_dir . $filename);
            $stmt = $cnx->prepare("UPDATE utilisateurs SET username = ?, profile_photo = ? WHERE id_user = ?");
            $stmt->execute([$username, $target_dir.$filename, $id]);
        } else {
            $stmt = $cnx->prepare("UPDATE utilisateurs SET username = ? WHERE id_user = ?");
            $stmt->execute([$username, $id]);
        }
    } elseif($type === 'comment') {
        $comment = $_POST['commentaire'] ?? '';
        $stmt = $cnx->prepare("UPDATE commentaires SET commentaire = ? WHERE id_commentaire = ?");
        $stmt->execute([$comment, $id]);
    }
    header("Location: ../dashboard.php");
    exit();
}
