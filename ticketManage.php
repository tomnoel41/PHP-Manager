<?php 
    session_start();
    require_once 'includes/config.php';
    if(!isset($_SESSION['user'])){
        header('Location: connexion.php');
        die();
    }
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();

    if(isset($_GET['id'])) {
        $ticket_id = $_GET['id'];
    
        // Rechercher l'ID de l'utilisateur associé à ce ticket dans la base de données
        $stmt = $bdd->prepare('SELECT user_id FROM tickets WHERE id = ?');
        $stmt->execute([$ticket_id]);
        $result = $stmt->fetch();
        if(!$result) {
            // Le ticket n'existe pas dans la base de données
            header('Location: support.php');
            $_SESSION['flash_message'] = "Le ticket n'éxiste pas !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
        $user_id = $result['user_id'];
    
        // Vérifier si l'utilisateur connecté est le propriétaire du projet
        if($data['id'] !== $user_id) {
            // L'utilisateur n'est pas le propriétaire du ticket
            header('Location: support.php');
            $_SESSION['flash_message'] = "Vous n'êtes pas le propriétaire de ce ticket !";
            $_SESSION['flash_alert'] = "danger";
            die();
        }
    
        // L'utilisateur est autorisé à accéder à la page projectManager.php
        // Afficher le contenu de la page ici
        // ...
    }
    else {
        // Le paramètre id n'a pas été transmis dans l'URL
        header('Location: support.php');
        $_SESSION['flash_message'] = "Une erreur est survenu lors du chargement du ticket !";
        $_SESSION['flash_alert'] = "danger";
        die();
    }

    require 'includes/users/gravatar.php';
?>


<!DOCTYPE html>
<html lang="fr-FR">
	<?php require 'includes/header.php' ?>
	<body>
		<!-- Begin page -->
		<div id="layout-wrapper">
			<div class="main-content">
				<?php require 'includes/navbar.php'; ?>
				<div class="page-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="page-title-box d-flex align-items-center justify-content-between">
									<h4 class="mb-0 font-size-18">Gestion de votre ticket</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
											<li class="breadcrumb-item active">Gestion Ticket</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
						<!-- end page title -->
					</div>
					<!-- container-fluid -->
				</div>
				<!-- End Page-content -->
			</div>
		</div>
	</div>
	<!-- End Page-content -->
	<?php require 'includes/footer.php' ?>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/simplebar.min.js"></script>
<!-- Morris Js-->
<script src="assets/plugins/morris-js/morris.min.js"></script>
<!-- Raphael Js-->
<script src="assets/plugins/raphael/raphael.min.js"></script>
<!-- Morris Custom Js-->
<script src="assets/pages/dashboard-demo.js"></script>
<!-- App js -->
<script src="assets/js/theme.js"></script>
</body>
</html>