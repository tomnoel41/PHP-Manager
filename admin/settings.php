<?php 
    session_start();
    require_once '../includes/config.php';
    if(!isset($_SESSION['user'])){ header('Location: connexion.php'); die(); }
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();
    require '../includes/users/gravatar.php';
    if($data['admin'] == 0){ header('Location: ../../index.php');
        $_SESSION['flash_message'] = "Vous n'êtes pas administrateur, vous n'avez pas accès à cette page !";
        $_SESSION['flash_alert'] = "danger";
        die();
    }
?>


<!DOCTYPE html>
<html lang="fr-FR">
	<?php require '../includes/admin/header.php' ?>
	<body>
		<!-- Begin page -->
		<div id="layout-wrapper">
			<div class="main-content">
				<?php require '../includes/admin/navbar.php'; ?>
				<div class="page-content">
					<div class="container-fluid">
						<div class="container-fluid">
							<div class="row">
								<div class="col-12">
									<div class="page-title-box d-flex align-items-center justify-content-between">
										<h4 class="mb-0 font-size-18">Paramètres</h4>
										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
												<li class="breadcrumb-item active">Paramètres</li>
											</ol>
										</div>
									</div>
								</div>
							</div>
							<?php if (isset($_SESSION['flash_message'])) {?>
								<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
									<?= $_SESSION['flash_message'] ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div></br>
							<?php unset($_SESSION['flash_message']);}?>
							<div class="row">
								<div class="col-12">
									<div class="card">
										<div class="card-body">
											<h4 class="card-title">Paramètres globaux du dashboard</h4>
											<form action="../includes/admin/settings/manageSettings.php" method="POST">
												<div class="form-row">
													<div class="col-md-4 mb-3">
														<label for="validationCustom01">Nom</label>
														<input type="text" name="name" id="name" class="form-control" placeholder="<?= $settings['name'] ?>" value="<?= $settings['name'] ?>" required>
													</div>
													<div class="col-md-4 mb-3">
														<label for="validationCustom02">Description</label>
														<input type="text" name="description" id="description" class="form-control" placeholder="<?= $settings['description'] ?>" value="<?= $settings['description'] ?>" required>
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6 mb-3">
														<label for="validationCustom03">Adresse du logo</label>
														<input type="text" name="logo" id="logo" class="form-control" placeholder="<?= $settings['logo'] ?>" value="<?= $settings['logo'] ?>" required>
													</div>
													<div class="col-md-3 mb-3">
														<label for="validationCustom04">Adresse du favicon</label>
														<input type="text" name="favicon" id="favicon" class="form-control" placeholder="<?= $settings['favicon'] ?>" value="<?= $settings['favicon'] ?>" required>
													</div>
												</div>
												<div class="form-group">
													<button class="btn btn-primary waves-effect waves-light" type="submit">Mettre à jours les informations</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Page-content -->
					<?php require '../includes/admin/footer.php' ?>
				</div>
				<!-- end main content-->
			</div>
			<!-- END layout-wrapper -->
			<!-- jQuery  -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/bootstrap.bundle.min.js"></script>
			<script src="/assets/js/waves.js"></script>
			<script src="/assets/js/simplebar.min.js"></script>
			<!-- Morris Js-->
			<script src="/assets/plugins/morris-js/morris.min.js"></script>
			<!-- Raphael Js-->
			<script src="/assets/plugins/raphael/raphael.min.js"></script>
			<!-- Morris Custom Js-->
			<script src="/assets/pages/dashboard-demo.js"></script>
			<!-- App js -->
			<script src="/assets/js/theme.js"></script>
	</body>
</html>