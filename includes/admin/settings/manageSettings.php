<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../config.php';
    session_start();
    if(!isset($_SESSION['user'])){header('Location:../../connexion.php'); die();}
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();
    if($data['admin'] == 0){header('Location: ../../index.php'); die();}

    // Vérifier si les champs ont été envoyés
    if (!empty($_POST['name']) || !empty($_POST['logo']) || !empty($_POST['favicon']) || !empty($_POST['description'])) {
        $name = htmlspecialchars($_POST['name']);
        $logo = htmlspecialchars($_POST['logo']);
        $favicon = htmlspecialchars($_POST['favicon']);
        $description = htmlspecialchars($_POST['description']);

        // Mettre à jour les valeurs dans la table "settings"
        $query = "UPDATE settings SET ";
        $params = array();

        if (!empty($name)) {
            $query .= "name = ?, ";
            $params[] = $name;
        }
        if (!empty($logo)) {
            $query .= "logo = ?, ";
            $params[] = $logo;
        }
        if (!empty($favicon)) {
            $query .= "favicon = ?, ";
            $params[] = $favicon;
        }
        if (!empty($description)) {
            $query .= "description = ?, ";
            $params[] = $description;
        }

        // Vérifier si des valeurs ont été modifiées
        if (!empty($params)) {
            // Supprimer la virgule finale de la requête
            $query = rtrim($query, ", ");
            
            // Exécuter la requête de mise à jour avec les valeurs
            $stmt = $bdd->prepare($query);
            $stmt->execute($params);
        }

        header('Location: /admin/settings.php');
        $_SESSION['flash_message'] = "Les informations ont été mises à jour avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    } else {
        header('Location: /admin/settings.php');
        $_SESSION['flash_message'] = "Aucune information à mettre à jour.";
        $_SESSION['flash_alert'] = "warning";
        die();
    }
} else {
    header('Location: /admin/settings.php');
    $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jour des informations.";
    $_SESSION['flash_alert'] = "danger";
    die();
}
?>    
