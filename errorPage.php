<!DOCTYPE html>
<html lang="fr-FR">
	<?php 
	require 'includes/config.php';
	require 'includes/header.php'; 
	?>
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
												<div class="text-center mb-4 mt-3">
													<a href="index.php"><h2><?= $settings['name'] ?></h2></a>
												</div>
												<div class="mt-4 pt-3 text-center">
													<div class="row justify-content-center">
														<div class="col-6 my-4">
															<img src="assets/images/500-error.svg" title="invite.svg">
														</div>
													</div>
													<h3 class="expired-title mb-4 mt-3">Internal Server Error</h3>
													<p class="text-muted mb-4 w-75 m-auto">
														Nous rencontrons un problème de serveur interne, veuillez réessayer plus tard..
													</p>
													</br>
													<?php if (isset($_SESSION['alert_message'])) {?>
													<p class="text-muted mb-4 w-75 m-auto">
														Error: <?= $_SESSION['alert_message']?>
													</p>
													<?php unset($_SESSION['alert_message']);}?>
												</div>
												<div class="mb-3 mt-4 text-center">
													<a href="index.php" class="btn btn-primary btn-block">Retourner à l'accueil</a>
												</div>
											</div>
											<!-- end card-body -->
										</div>
										<!-- end card -->
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
