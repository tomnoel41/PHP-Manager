<?php
$email = $data['email']; // Adresse email de l'utilisateur
$hash = md5(strtolower(trim($email))); // Convertir l'adresse email en identifiant Gravatar
$avatar_url = "https://www.gravatar.com/avatar/{$hash}?s=200&d=mp"; // Construire l'URL de l'avatar
?>