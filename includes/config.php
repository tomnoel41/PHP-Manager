<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'manager');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
// For PHPMailer (not available)
define('MAIL_HOST', '');
define('MAIL_PORT', '');
define('MAIL_NAME', '');
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');


try {
    $bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USERNAME, DB_PASSWORD);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $_SESSION['alert_message'] = "Database Connection Error";
    header('Location: ../../errorPage.php');
    die();
}

$getSettings=$bdd->prepare("SELECT * FROM `settings` WHERE id = 1");
$getSettings->execute();
$settings=$getSettings->fetch();
?>


