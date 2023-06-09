<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config.php';
    session_start();
    if(!isset($_SESSION['user']))
    {
        header('Location:../../connexion.php');
        die();
    }
    if(!empty($_POST['first_name']) || !empty($_POST['last_name']) || !empty($_POST['email'])){
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $check_email = $bdd->prepare('SELECT email FROM utilisateurs WHERE email = :email AND token != :token');
        $check_email->execute([
            "email" => $email,
            "token" => $_SESSION['user']
        ]);
        $email_exists = $check_email->fetch();
        if(!$email_exists){
            $update_fields = "";
            $update_values = ["token" => $_SESSION['user']];

            if(!empty($first_name)){
                $update_fields .= "first_name = :first_name, ";
                $update_values["first_name"] = $first_name;
            }
            if(!empty($last_name)){
                $update_fields .= "last_name = :last_name, ";
                $update_values["last_name"] = $last_name;
            }
            if(!empty($email)){
                $update_fields .= "email = :email, ";
                $update_values["email"] = $email;
            }
            if(!empty($update_fields)){
                $update_fields = substr($update_fields, 0, -2)." WHERE token = :token";
                $update = $bdd->prepare('UPDATE utilisateurs SET '.$update_fields);
                $update->execute($update_values);
            }
            header('Location: ../../profilManage.php');
            $_SESSION['flash_message'] = "Votre profil vient d'être mis à jours avec succès !";
            $_SESSION['flash_alert'] = "success";
            die();
        } else {
            header('Location: ../../profilManage.php');
            $_SESSION['flash_message'] = "L'adresse email que vous avez renseigné est déjà utilisée !";
            $_SESSION['flash_alert'] = "wafrning";
            die();
        }
    } else {
        header('Location: ../../profilManage.php');
        $_SESSION['flash_message'] = "Votre profil vient d'être mis à jours avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }
} else {
    header('Location: ../../profilManage.php');
    $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jours de votre profil !";
    $_SESSION['flash_alert'] = "warning";
    die();
}
?>    