<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../config.php';
    session_start();
    if(!isset($_SESSION['user'])){header('Location:../../connexion.php'); die();}
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();
    if($data['admin'] == 0){header('Location: ../../index.php'); die();}
/**
 * Modification d'un utilisateur
 */
if (isset($_POST['edit'])) {
    $reqEdit = $bdd->prepare("UPDATE `utilisateurs` SET `first_name`=?, `last_name`=?, `verified`=?, `email`=?, `admin`=? WHERE `id`=?");
    if ($reqEdit->execute([$_POST['first_name'], $_POST['last_name'], $_POST['verified'], $_POST['email'], $_POST['role'], $_POST['edit']])) {
        $_SESSION['success'] = "Les informations ont bien était prise en compte !";
        header("Location: ../../../admin/utilisateurs.php");
        die();
    } else $_SESSION['error'] = "Une erreur interne c'est produite";
}

/**
 * Suppression d'un utilisateur
 */
if (isset($_POST['delete'])) {
    $reqDelete = $bdd->prepare("DELETE FROM `utilisateurs` WHERE `id`=?");
    if ($reqDelete->execute([$_POST['delete']])) {
        header('Location: ../../../admin/utilisateurs.php');
        $_SESSION['flash_message'] = "L'utilisateur à été supprimer avec succès.";
        $_SESSION['flash_alert'] = "success";
        die();
    } else {
        $_SESSION['flash_message'] = "Une erreur interne c'est produite";
        $_SESSION['flash_alert'] = "error";
    }
}
} else {
    header('Location: ../../../admin/utilisateurs.php');
}

?>