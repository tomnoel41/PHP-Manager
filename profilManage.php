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
									<h4 class="mb-0 font-size-18">Profil</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Tableau de Bord</a></li>
											<li class="breadcrumb-item active">Profil</li>
										</ol>
									</div>
								</div>
								<?php if (isset($_SESSION['flash_message'])) {?>
								<div class="alert alert-<?= $_SESSION['flash_alert'] ?> alert-dismissible fade show mb-0" role="alert">
									<?= $_SESSION['flash_message'] ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								</br>
								<?php unset($_SESSION['flash_message']);}?>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="card card-body">
									<h4 class="card-title text-center">Informations personelles</h4>
									<form action="includes/users/editProfile.php" method="POST">
										<div class="form-group">
											<label for="first_name">Prénom</label>
											<input type="text" name="first_name" class="form-control" id="first_name" placeholder="<?= $data['first_name'] ?>" value="<?= $data['first_name'] ?>">
										</div>
										<div class="form-group">
											<label for="last_name">Nom de famille</label>
											<input type="text" name="last_name" class="form-control" id="last_name" placeholder="<?= $data['last_name'] ?>" value="<?= $data['last_name'] ?>">
										</div>
										<div class="form-group">
											<label for="email">Adresse email</label>
											<input type="text" name="email" class="form-control" id="email" placeholder="<?= $data['email'] ?>" value="<?= $data['email'] ?>">
										</div>
										<button type="submit" class="btn btn-primary btn-block">Modifier vos informations personelles</button>
									</form>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="card card-body">
									<h4 class="card-title text-center">Modifier votre mot de passe</h4>
									<form action="includes/users/editPassword.php" method="POST">
										<div class="form-group">
											<label for="current_password">Mot de passe actuel</label>
											<input type="password" name="current_password" class="form-control" id="current_password" placeholder="***************" value="">
										</div>
										<div class="form-group">
											<label for="new_password">Nouveau mot de passe</label>
											<input type="password" name="new_password" class="form-control" id="new_password" placeholder="***************" value="">
										</div>
										<div class="form-group">
											<label for="new_password_retype">Confirmation du nouveau mot de passe</label>
											<input type="password" name="new_password_retype" class="form-control" id="new_password_retype" placeholder="***************" value="">
										</div>
										<button type="submit" class="btn btn-primary btn-block">Modifier votre mot de passe</button>
									</form>
								</div>
							</div>
							<div class="col-sm-3 col-lg-6">
								<div class="card card-body">
									<h4 class="card-title text-center">Status du compte</h4>
									<?php
									// 1 = Vérifié, 0 = Non vérifié
									if($data['verified'] == 1){?>
									<div class="alert alert-success mb-0" role="alert">
										<h5 class="alert-heading">
											Yeahhh!
										</h5>
										<p>
											Vous êtes vérifié par l'équipe, vous avez désormais accès aux commandes d'instances.
										</p>
										<hr>
										<p class="mb-0">
											Rendez-vous dans la section des créations des instances pour de nouvelles aventures.
										</p>
									</div>
									<?php } else { ?>
									<div class="alert alert-warning mb-0" role="alert">
										<h5 class="alert-heading">
											Oops!
										</h5>
										<p>
											Vous n'êtes pas encore vérifié par l'équipe, malheureusement, vous ne pouvez pas encore créer d'instances.
										</p>
										<hr>
										<p class="mb-0">
											Pour demander une vérification, veuillez vous rediriger vers le support.
										</p>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
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