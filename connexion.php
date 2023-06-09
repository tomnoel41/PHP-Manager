<?php 
    session_start();
    require_once 'includes/config.php';
    if(isset($_SESSION['user'])){
        header('Location: index.php');
        die();
    }
?>

<!DOCTYPE html>
<html lang="fr-FR">
	<?php require 'includes/header.php' ?>
	<body class="bg-primary">
		<div>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="d-flex align-items-center min-vh-100">
							<div class="w-100 d-block my-5">
								<div class="row justify-content-center">
									<div class="col-md-8 col-lg-5">
										<div class="card ">
											<div class="card-body">
												<?php if (isset($_SESSION['flash_message'])) {?>
												<div class="alert alert-<?= $_SESSION['flash_alert'] ?> alert-dismissible fade show mb-0" role="alert">
													<?= $_SESSION['flash_message'] ?>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												</div>
												<?php unset($_SESSION['flash_message']);}?>
												<div class="text-center mb-4 mt-3">
													<a href="index.php"><h2><?= $settings['name'] ?></h2></a>
												</div>
												<form action="includes/users/login.php" method="POST" class="p-2">
													<div class="form-group">
														<label for="email">Adresse email</label>
														<input class="form-control" type="email" name="email" id="email" required="" placeholder="john@deo.com">
													</div>
													<div class="form-group">
														<a href="pages-recoverpw.html" class="text-muted float-right">Mot de passe oublié?</a>
														<label for="password">Password</label>
														<input class="form-control" type="password" name="password" id="password" required="" placeholder="Entrez votre mot de passe">
													</div>
													<div class="form-group mb-4 pb-3">
														<div class="custom-control custom-checkbox checkbox-primary">
															<input type="checkbox" class="custom-control-input" id="checkbox-signin">
															<label class="custom-control-label" for="checkbox-signin">Se souvenir de moi</label>
														</div>
													</div>
													<div class="mb-3 text-center">
														<button class="btn btn-primary btn-block" type="submit"> Se connecter </button>
													</div>
												</form>
											</div>
											<!-- end card-body -->
										</div>
										<!-- end card -->
										<div class="row mt-4">
											<div class="col-sm-12 text-center">
												<p class="text-white-50 mb-0">
													Vous n'avez pas de compte ? 
													<a href="inscription.php" class="text-white-50 ml-1"><b>Inscription</b></a>
												</p>
											</div>
										</div>
									</div>
									<!-- end col -->
								</div>
								<!-- end row -->
							</div>
							<!-- end .w-100 -->
						</div>
						<!-- end .d-flex -->
					</div>
					<!-- end col-->
				</div>
				<!-- end row -->
			</div>
			<!-- end container -->
		</div>
		<!-- end page -->
		<!-- jQuery  -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/metismenu.min.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/simplebar.min.js"></script>
		<!-- App js -->
		<script src="assets/js/theme.js"></script>
	</body>
</html>