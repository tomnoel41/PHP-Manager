<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config.php';
    session_start();

    // Si la session n'existe pas 
    if(!isset($_SESSION['user']))
    {
        header('Location:../../connexion.php');
        die();
    }
    if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_retype'])){
        // Patch XSS 
        $current_password = htmlspecialchars($_POST['current_password']);
        $new_password = htmlspecialchars($_POST['new_password']);
        $new_password_retype = htmlspecialchars($_POST['new_password_retype']);

        $check_password  = $bdd->prepare('SELECT password FROM utilisateurs WHERE token = :token');
        $check_password->execute([
            "token" => $_SESSION['user']
        ]);
        $data_password = $check_password->fetch();
        if(password_verify($current_password, $data_password['password']))
        {
            if($new_password === $new_password_retype){
                $cost = ['cost' => 12];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $cost);
                $update = $bdd->prepare('UPDATE utilisateurs SET password = :password WHERE token = :token');
                $update->execute([
                    "password" => $new_password,
                    "token" => $_SESSION['user']
                ]);
                session_destroy();
                header('Location: ../../connexion.php');
                $_SESSION['flash_message'] = "Votre mot de passe vient d'être mis à jours !";
                $_SESSION['flash_alert'] = "success";
                die();
            }
        }
        else{
            header('Location: ../profilManage.php');
            $_SESSION['flash_message'] = "Le mot de passe actuel n'est pas le bon !";
            $_SESSION['flash_alert'] = "warning";
            die();
        }
    }
    else{
        header('Location: ../profilManage.php');
        $_SESSION['flash_message'] = "Il manque des informations pour la mise à jours de votre mot de passe !";
        $_SESSION['flash_alert'] = "warning";
        die();
    }
}else{header('Location: ../../profilManage.php');}
?>    