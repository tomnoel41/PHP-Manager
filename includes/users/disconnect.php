<?php
session_start();
if(isset($_SESSION['user'])){
    session_destroy();
    header('Location: ../../connexion.php');
    die();
} else {
    header('Location: ../../connexion.php');
    die();
}
?>