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

	$reqCountUtilisateurs = $bdd->prepare("SELECT * FROM `utilisateurs` WHERE 1");
	$reqCountUtilisateurs->execute();
	$countUtilisateurs = $reqCountUtilisateurs->rowCount();

    $reqCountTickets = $bdd->prepare("SELECT * FROM `tickets` WHERE status = 1");
	$reqCountTickets->execute();
	$countTickets = $reqCountTickets->rowCount();
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
						<div class="row">
							<div class="col-12">
								<div class="page-title-box d-flex align-items-center justify-content-between">
									<h4 class="mb-0 font-size-18">Administration</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
											<li class="breadcrumb-item active">Accueil</li>
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
						<!-- end page title -->
						<div class="row">
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										Utilisateurs inscrit
									</div>
									<div class="card-body">
										<h4 class="card-title"><?= $countUtilisateurs ?></h4>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										Tickets ouvert
									</div>
									<div class="card-body">
										<h4 class="card-title"><?= $countTickets ?></h4>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										Instances actives
									</div>
									<div class="card-body">
										<h4 class="card-title">N/a</h4>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										Instances suspendues
									</div>
									<div class="card-body">
										<h4 class="card-title">N/a</h4>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										IPv4
									</div>
									<div class="card-body">
										<h4 class="card-title">N/a</h4>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-lg-2">
								<div class="card text-center">
									<div class="card-header">
										IPv6
									</div>
									<div class="card-body">
										<h4 class="card-title">N/a</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- container-fluid -->
				</div>
				<!-- End Page-content -->
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