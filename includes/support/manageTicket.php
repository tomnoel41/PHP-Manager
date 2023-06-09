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

    if (isset($_POST['accessTicket'])) {
        if(isset($_POST['ticket_id']) && isset($_POST['user_id'])) {
            $ticket_id = htmlspecialchars($_POST['ticket_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            if ($user_id == $data['id']) {
                header('Location: ../../ticketManage.php?id=' . $ticket_id);
                die();
            }
        }else{
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jours de votre ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    } else if (isset($_POST['reopenTicket'])) {
        if(isset($_POST['ticket_id']) && isset($_POST['user_id'])) {
            $ticket_id = htmlspecialchars($_POST['ticket_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            if ($user_id == $data['id']) {
                $update = $bdd->prepare('UPDATE tickets SET status = ? WHERE id = ?');
                $update->execute([1, $ticket_id]);
                header('Location: ../../support.php');
                $_SESSION['flash_message'] = "Le status de votre ticket à été mis à jours avec succès !";
                $_SESSION['flash_alert'] = "success";
                die();
            }
        }else{
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jours de votre ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    } else if (isset($_POST['closeTicket'])) {
        if(isset($_POST['ticket_id']) && isset($_POST['user_id'])) {
            $ticket_id = htmlspecialchars($_POST['ticket_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            if ($user_id == $data['id']) {
                $update = $bdd->prepare('UPDATE tickets SET status = ? WHERE id = ?');
                $update->execute([0, $ticket_id]);
                header('Location: ../../support.php');
                $_SESSION['flash_message'] = "Votre ticket à été fermé avec succès !";
                $_SESSION['flash_alert'] = "success";
                die();
            }
        }else{
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jours de votre ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    } else if (isset($_POST['deleteTicket'])) {
        if(isset($_POST['ticket_id']) && isset($_POST['user_id'])) {
            $ticket_id = htmlspecialchars($_POST['ticket_id']);
            $user_id = htmlspecialchars($_POST['user_id']);
            if ($user_id == $data['id']) {
                $update = $bdd->prepare('DELETE FROM tickets WHERE id = ?');
                $update->execute([$ticket_id]);
                header('Location: ../../support.php');
                $_SESSION['flash_message'] = "Votre ticket à été supprimé avec succès !";
                $_SESSION['flash_alert'] = "success";
                die();
            }
        }else{
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jours de votre ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    }
}else{header('Location: ../../support.php');}
?>