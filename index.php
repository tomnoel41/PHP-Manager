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

	$reqCountProjects = $bdd->prepare("SELECT * FROM `projets` WHERE user_id = ?");
	$reqCountProjects->execute([$data['id']]);
	$countProjects = $reqCountProjects->rowCount();

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
									<h4 class="mb-0 font-size-18">Accueil</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Tableau de Bord</a></li>
											<li class="breadcrumb-item active">Accueil</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
						<?php if (isset($_SESSION['flash_message'])) {?>
							<div class="alert alert-<?= $_SESSION['flash_alert'] ?> alert-dismissible fade show mb-0" role="alert">
								<?= $_SESSION['flash_message'] ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div></br>
						<?php unset($_SESSION['flash_message']);}?>
						<div class="row">
							<div class="col-sm-12 mb-4">
								<div class="text-center mt-4">
									<h4>Créer un nouveau projet</h4>
									<p class="text-muted mt-3 mb-4">
										Ici, vous pouvez voir la liste de vos projets, en créer de nouveau ou supprimer les existants.
										</br>
										Vous êtes limité à 6 projets <b>[<?= $countProjects ?>/6]</b>.
									</p>
									<button type="button" style="width:50%;margin:auto" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createProject">Créer un nouveau projet</button>
									<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="createProject" aria-hidden="true" style="display: none;">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">
														Commander un nouveau service
													</h5>
													<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												</div>
												<form action="includes/projects/create.php" method="POST">
													<div class="modal-body">
														<div class="form-group">
															<label for="projectName">Nom du projet</label>
															<input type="text" name="projectName" id="projectName" class="form-control" placeholder="Ex: TomNoel.cloud" required>
															<input type="hidden" name="user_id" value="<?= $data['id']; ?>">
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Annuler</button>
														<button type="submit" name="createProject" class="btn btn-primary waves-effect waves-light">Créer</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							$req = $bdd->prepare('SELECT * FROM projets WHERE user_id = ?');$user_id = $data['id'];
							$req->execute([$user_id]);
							$projets = $req->fetchAll();
							foreach ($projets as $projet) {?>
							<div class="col-sm-12 col-md-4">
								<div class="card text-center">
									<div class="card-header">
										<p style="float: left; margin-top: 8px; margin-bottom: 0 !important;">
											ID : 
											<?= $projet['id']?>
										</p>
										<form action="includes/projects/delete.php" method="POST" style="float: right;">
											<input name="projectID" value="<?= $projet['id']?>" hidden>
											<input type="hidden" name="user_id" value="<?= $data['id']; ?>">
											<button type="submit" class="btn"><i class="bx bx-trash" style="color: gray; font-size: 15px;"></i></button>
										</form>
									</div>
									<div class="card-body">
										<h4 class="card-title"><?= $projet['projectName']?></h4>
										<a href="projectManager.php?id=<?= $projet['id']?>" class="btn btn-outline-primary waves-effect waves-light">Gérer le projet</a>
									</div>
								</div>
							</div>
							<?php } ?>
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