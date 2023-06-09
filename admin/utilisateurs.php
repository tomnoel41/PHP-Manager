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

    if (!isset($_GET['user'])) {
        $allUsers = $bdd->prepare("SELECT * FROM `utilisateurs` ORDER BY id LIMIT 50;");
        $allUsers->execute();
        $users = $allUsers->fetchAll();
    } else {
        $allUsers = $bdd->prepare("SELECT * FROM `utilisateurs` WHERE `email` LIKE ?");
        $allUsers->execute(["%" . trim(strip_tags($_GET['user'])) . "%"]);
        $users = $allUsers->fetchAll();
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
						<div class="row">
							<div class="col-12">
								<div class="page-title-box d-flex align-items-center justify-content-between">
									<h4 class="mb-0 font-size-18">Liste des utilisateurs</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
											<li class="breadcrumb-item active">Utilisateurs</li>
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
								<div class="row">
									<div class="col-12">
										<form>
											<div class="input-group mb-3">
												<input type="text" class="form-control" placeholder="Recherchez par email" name="user" aria-describedby="button-addon2">
												<div class="input-group-append">
													<button class="btn btn-outline-secondary" type="submit" id="button-addon2">Rechercher</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="card col-12">
								<div class="card-body table-responsive">
									<table class="table align-middle table-hover table-borderless mb-0">
										<thead>
											<tr>
												<th>
													ID
												</th>
												<th>
													Identité
												</th>
												<th>
													Email
												</th>
												<th>
													IP
												</th>
												<th>
													Status
												</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($users as $id =>
											 $user) { ?>
											<tr>
												<td>
													<?= $id ?>
												</td>
												<td>
													<?php if ($user['admin']) {echo ("<i class='bx bxs-star' style='color: #36939b;'></i>");} ?><?= $user['first_name'] . " " . $user['last_name'] ?></td>
													<td>
														<?= $user['email'] ?>
													</td>
													<td>
														<?= $user['ip'] ?>
													</td>
													<td>
														<?php if ($user['verified'] == 0) {echo "<span class='badge badge-pill badge-warning'>Compte non vérifié</span>";} elseif ($user['verified'] == 1) {echo "<span class='badge badge-pill badge-success' style='background-color: #36939b;'>Compte vérifié</span>";}?></td>
														<td>
															<button data-toggle="modal" data-target="#usersedit<?= $id ?>" class="btn"><i class='bx bxs-pencil' style="font-size: 20px"></i></button>
															<button data-toggle="modal" data-target="#userdelete<?= $id ?>" class="btn"><i class='bx bx-trash' style="color: red; font-size: 20px"></i></button>
														</td>
													</tr>
													<div class="modal fade" id="userdelete<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="userdelete<?= $id ?>" aria-hidden="true" style="display: none;">
														<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title">
																		Supprimer l'utilisateur 
																		<?= $id ?>
																		 ?
																	</h5>
																	<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																</div>
																<div class="modal-body">
																	Souhaitez vous réellement supprimer l'utilisateur 
																	<?= $id ?>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Non</button>
																	<form action="../includes/admin/users/manageUsers.php" method="POST">
																		<input name="delete" value="<?= $user['id'] ?>" hidden>
																		<button type="submit" class="btn btn-outline-success">Oui</button>
																	</form>
																</div>
															</div>
														</div>
													</div>
													<div class="modal fade" id="usersedit<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="usersedit<?= $id ?>" aria-hidden="true" style="display: none;">
														<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title">
																		Modification de l'utilisateur 
																		<?= $id ?>
																	</h5>
																	<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																</div>
																<div class="modal-body">
																	<form action="../includes/admin/users/manageUsers.php" method="POST">
																		<div class="form-row align-items-center mb-2">
																			<div class="col-6">
																				<label for="prenom">Prénom</label>
																				<input type="text" class="form-control mb-2" id="first_name" name="first_name" placeholder="Prénom" value="<?= $user['first_name'] ?>">
																			</div>
																			<div class="col-6">
																				<label for="nom">Nom de famille</label>
																				<input type="text" class="form-control mb-2" id="last_name" name="last_name" placeholder="Nom de famille" value="<?= $user['last_name'] ?>">
																			</div>
																			<div class="col-12">
																				<label for="mail">Adresse email</label>
																				<input type="text" class="form-control mb-2" id="email" name="email" placeholder="E-mail" value="<?= $user['email'] ?>">
																			</div>
																		</div>
																		<hr>
                                                    					<hr>
                                                    					<div class="form-row align-items-center mb-2">
                                                        					<div class="col-6">
                                                            					<label for="status">Verifié</label>
                                                            					<select class="form-control" name="verified" id="verified">
                                                                					<option value="1" <?php if ($user['verified'] == 1) echo "selected"; ?>>Vérifier</option>
                                                                					<option value="0" <?php if ($user['verified'] == 0) echo "selected"; ?>>Non vérifier</option>
                                                            					</select>
                                                        					</div>
                                                        					<div class="col-6">
                                                            					<label for="role">Rôle</label>
                                                            					<select class="form-control" name="role" id="role">
                                                                					<option value="0" <?php if ($user['admin'] == 0) echo "selected"; ?>>Utilisateur</option>
                                                                					<option value="1" <?php if ($user['admin'] == 1) echo "selected"; ?>>Administrateur</option>
                                                            					</select>
                                                        					</div>
                                                    					</div>
                                                    					<hr>
                                                    					<input name="edit" value="<?= $user['id'] ?>" hidden>
																			<button type="submit" class="btn btn-primary btn-block">Modifier</button>
																		</form>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								</tbody>
							</table>
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