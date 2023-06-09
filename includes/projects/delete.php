<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config.php';
    session_start();
    if(!isset($_SESSION['user']))
    {
        header('Location:../../connexion.php');
        die();
    }
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();
    if(!empty($_POST['projectID']) && !empty($_POST['user_id']))
    {
        $user_id = htmlspecialchars($_POST['user_id']);
        $projectID = htmlspecialchars($_POST['projectID']);
        if ($user_id == $data['id']) {
            $delete = $bdd->prepare('DELETE FROM projets WHERE id = ?');
            $delete->execute([$projectID]);
            header('Location: ../../index.php');
            $_SESSION['flash_message'] = "Votre projet vient d'être supprimé avec succès !";
            $_SESSION['flash_alert'] = "success";
            die();
        } else {header('Location: ../../index.php');}
    }else{
        header('Location: ../../index.php');
        $_SESSION['flash_message'] = "Une erreur est survenue lors de la supression de votre projet !";
        $_SESSION['flash_alert'] = "danger";
        die();
    }
}else{header('Location: ../../index.php');}
?>