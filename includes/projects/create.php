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

    if(!empty($_POST['projectName']) && !empty($_POST['user_id']))
    {
        $user_id = htmlspecialchars($_POST['user_id']);
        $projectName = htmlspecialchars($_POST['projectName']);
        if($user_id == $data['id']) {
            $reqCountProjects = $bdd->prepare("SELECT * FROM `projets` WHERE user_id = ?");
	        $reqCountProjects->execute([$data['id']]);
	        $countProjects = $reqCountProjects->rowCount();
            if ($countProjects > 5) {
                header('Location: ../../index.php');
                $_SESSION['flash_message'] = "Vous avez déjà trop de projets !";
                $_SESSION['flash_alert'] = "warning";
                die();
            }
            $insert = $bdd->prepare('INSERT INTO projets(user_id, projectName) VALUES(:user_id, :projectName)');
            $insert->execute([
                'user_id' => $user_id,
                'projectName' => $projectName
            ]);
            header('Location: ../../index.php');
            $_SESSION['flash_message'] = "Votre projet vient d'être créeé avec succès !";
            $_SESSION['flash_alert'] = "success";
            die();
        } else {header('Location: ../../index.php');}
    }else{
        header('Location: ../../index.php');
        $_SESSION['flash_message'] = "Votre projet vient doit être nommé pour le créer !";
        $_SESSION['flash_alert'] = "warning";
        die();
    }
}else{header('Location: ../../index.php');}
?>