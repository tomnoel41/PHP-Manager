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
	$instances = $bdd->query("SELECT * FROM `instances` WHERE 1");
	$allInstance = $instances->fetchAll();
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
										<h4 class="mb-0 font-size-18">Liste des instances</h4>

										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="index.php">Tableau de Bord</a></li>
												<li class="breadcrumb-item active">Instances</li>
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

							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-12">

										</div>
										<div class="col-12">
											<div class="table-responsive">
												<table class="table table-hover align-middle mb-0 text-center">
													<thead class="table-borderless">
														<tr>
															<th>#</th>
															<th>CLIENT</th>
															<th>VMID</th>
															<th>HOSTNAME</th>
															<th>IP</th>
															<th>OS</th>
															<th>NODE</th>
															<th>STATUS</th>
															<th>VOIR</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach($allInstance as $server){ ?>
															<?php 
																$reqUser = $bdd->prepare("SELECT * FROM `utilisateurs` WHERE `id`=? LIMIT 1");
																$reqUser->execute([$server['owner']]);
																$user = $reqUser->fetch();

																$status=array("color"=>"success","name"=>"Actif");
																if($server['status'] == 0 || $server['status'] == 10){ $status=array("color"=>"warning","name"=>"Suspendu"); }
															?>
															<tr>
																<td><?= $server['id'] ?></td>
																<td><a href="/admin/utilisateurs.php?email=<?= $user['email'] ?>"><?= $user['first_name']." ".$user['last_name'] ?></a></td>
																<td><?= $server['vmid'] ?></td>
																<td><?= $server['hostname'] ?></td>
																<td><?= $server['ip'] ?></td>
																<td><?= $server['os'] ?></td>
																<td><?= $server['node'] ?></td>
																<td><span class="badge badge-<?= $status['color'] ?> p-2"><?= $status['name'] ?></span></td>
																<td>
																	<a href="/instance.php?id=<?= $server['id'] ?>" class="btn btn-outline-primary">Accèder</a>
																</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
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