<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require '../config.php';
    if(!empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = strtolower($_POST['email']); 
        $password = $_POST['password'];
        $check = $bdd->prepare('SELECT token, password FROM utilisateurs WHERE email = :email');
        $check->execute([
            "email" => $email
        ]);
        $data = $check->fetch();
        $row = $check->rowCount();
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if($row > 0)
        {
            if(password_verify($password, $data['password']))
            {
                $_SESSION['user'] = $data['token'];

                header('Location: ../../index.php');
                die();
            }else{
                header('Location: ../../connexion.php');
                $_SESSION['flash_message'] = "Le mot de passe n'est pas correct !";
                $_SESSION['flash_alert'] = "warning";
                die();
            }
        }else{
            header('Location: ../../connexion.php');
            $_SESSION['flash_message'] = "L'adresse email n'est associée à un aucun compte";
            $_SESSION['flash_alert'] = "warning";
            die();
        }
    }else{ 
        header('Location: ../../connexion.php');
        $_SESSION['flash_message'] = "Il manque des informations !";
        $_SESSION['flash_alert'] = "warning";
        die();
    }  
} else { 
    header('Location: ../../connexion.php');
}
?>