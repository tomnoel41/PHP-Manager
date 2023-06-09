<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../../config.php';
    session_start();
    if(!isset($_SESSION['user'])){header('Location:../../connexion.php'); die();}
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();
    if($data['admin'] == 0){header('Location: ../../index.php'); die();}

    /**
    * Remise à l'affichage de la node
    */
    if (isset($_POST['start'])) {
        $reqNode = $bdd->prepare("UPDATE `nodes` SET `status`= ? WHERE `id`= ?");
        $reqNode->execute([1, $_POST['start']]);
        header('Location: ../../../admin/nodes.php');
        $_SESSION['flash_message'] = "La node vient d'être mise à jours avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }

    /**
     * Arrêt d'affichage de la node 
    */
    if (isset($_POST['stop'])) {
        $reqNode = $bdd->prepare("UPDATE `nodes` SET `status`= ? WHERE `id`=?");
        $reqNode->execute([0, $_POST['stop']]);
        header('Location: ../../../admin/nodes.php');
        $_SESSION['flash_message'] = "La node vient d'être mise à jours avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }

    /**
    * Edition de la node
    */
    if (isset($_POST['edit'])) {
        $id = $_POST['edit'];
        $conditions = [];
        $values = [];
        if (!empty($_POST['name'])) {
            $conditions[] = "`name`=?";
            $values[] = $_POST['name'];
        }
        if (!empty($_POST['pays'])) {
            $conditions[] = "`pays`=?";
            $values[] = $_POST['pays'];
        }
        $query = "UPDATE `nodes` SET " . implode(",", $conditions) . " WHERE `id`=?";
        $values[] = $id;
        $stmt = $bdd->prepare($query);
        $stmt->execute($values);
        header('Location: ../../../admin/nodes.php');
        $_SESSION['flash_message'] = "La node vient d'être mise à jours avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }
    

    /**
     * Ajout d'une node
     */
    if (isset($_POST['new'])) {
        if (empty($_POST['name']) && empty($_POST['pays']) && empty($_POST['ip']) && empty($_POST['fqdn']) && empty($_POST['user']) & empty($_POST['pwd']) & empty($_POST['bridge']) && empty($_POST['disk']) && empty($_POST['templateDisk']) && empty($_POST['note'])) {
            header('Location: ../../../admin/nodes.php');
            $_SESSION['flash_message'] = "Il manque des informations pour la création de la node !";
            $_SESSION['flash_alert'] = "warning";
            die();
        }
        $name = $_POST['name'];
        $pays = $_POST['pays'];
        $ip = $_POST['ip'];
        $fqdn = $_POST['fqdn'];
        $user = $_POST['user'];
        $pwd = $_POST['pwd'];
        $bridge = $_POST['bridge'];
        $disk = $_POST['disk'];
        $templateDisk = $_POST['templateDisk'];
        $note = $_POST['note'];
    
        $query = "INSERT INTO `nodes` (name, pays, ip, FQDN, user, pwd, bridge, disk, templateDisk, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $bdd->prepare($query);
        $stmt->execute([$name, $pays, $ip, $fqdn, $user, $pwd, $bridge, $disk, $templateDisk, $note]);
    
        header('Location: ../../../admin/nodes.php');
        $_SESSION['flash_message'] = "La node vient d'être créée avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }
    

    /**
     * Suppression d'une node
     */
    if (isset($_POST['delete'])) {
        $reqNode = $bdd->prepare("DELETE FROM `nodes` WHERE `id`= ?");
        $reqNode->execute([$_POST['delete']]);
        header('Location: ../../../admin/nodes.php');
        $_SESSION['flash_message'] = "La node vient d'être supprimée avec succès !";
        $_SESSION['flash_alert'] = "success";
        die();
    }
} else {
    header('Location: ../../../admin/nodes.php');
}
