<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../config.php';
    
    if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        // Patch XSS
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);
        $check = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();
        $email = strtolower($email);
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if($row == 0){ 
            if(strlen($first_name) <= 100){
                if(strlen($email) <= 100){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if($password === $password_retype){
                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            $insert = $bdd->prepare('INSERT INTO utilisateurs(first_name, last_name, email, password, ip, token) VALUES(:first_name, :last_name, :email, :password, :ip, :token)');
                            $insert->execute(array(
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
                                'password' => $password,
                                'ip' => $ip,
                                'token' => bin2hex(openssl_random_pseudo_bytes(64))
                            ));
                            header('Location: ../../connexion.php');
                            die();
                        }else{ header('Location: ../../inscription.php?error=register'); die();}
                    }else{ header('Location: ../../inscription.php?error=register'); die();}
                }else{ header('Location: ../../inscription.php?error=register'); die();}
            }else{ header('Location: ../../inscription.php?error=register'); die();}
        }else{ header('Location: ../../inscription.php?error=already'); die();}
    }else{header('Location: ../../inscription.php?error=register');}
}else{header('Location: ../../inscription.php');}
?>