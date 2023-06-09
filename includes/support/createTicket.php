<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config.php';
    session_start();
    if(!isset($_SESSION['user'])) {
        header('Location: ../../connexion.php');
        exit;
    }
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = :token');
    $req->execute(['token' => $_SESSION['user']]);
    $data = $req->fetch();
    if (!$data) {
        header('Location: ../../connexion.php');
        exit;
    }
    if (isset($_POST['ticketSubject'], $_POST['ticketDepartment'], $_POST['user_id'])) {
        $user_id = (int) $_POST['user_id'];
        $ticketSubject = trim($_POST['ticketSubject']);
        $ticketDepartment = trim($_POST['ticketDepartment']);

        if ($user_id === $data['id']) {
            $insert = $bdd->prepare('INSERT INTO tickets (user_id, subject, department) VALUES (:user_id, :subject, :department)');
            $insert->execute([
                'user_id' => $user_id,
                'subject' => $ticketSubject,
                'department' => $ticketDepartment
            ]);
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Votre ticket à été créé avec succès !";
            $_SESSION['flash_alert'] = "success";
            die();
        } else {
            header('Location: ../../support.php');
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la création de votre ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    } else {
        header('Location: ../../support.php');
        $_SESSION['flash_message'] = "Une erreur est survenue lors de la création de votre ticket !";
        $_SESSION['flash_alert'] = "danger";
        die();
    }
} else {
    header('Location: ../../support.php');
    exit;
}
?>