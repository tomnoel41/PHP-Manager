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

    $node = $bdd->query("SELECT * FROM `nodes` WHERE 1");
    $allNode = $node->fetchAll();
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
										<h4 class="mb-0 font-size-18">Liste des nodes</h4>
										<div class="page-title-right">
											<ol class="breadcrumb m-0">
												<li class="breadcrumb-item"><a href="index.php">Administration</a></li>
												<li class="breadcrumb-item active">Nodes</li>
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
											<button data-toggle="modal" data-target="#nodenew" class="btn btn-outline-success float-right">Ajouter une node</button>
										</div>
										<div class="col-12 mt-2">
											<div class="table-responsive">
												<table class="table table-hover align-middle mb-0 text-center">
													<thead class="table-borderless">
														<tr>
															<th>
																#
															</th>
															<th>
																Pays
															</th>
															<th>
																IP/FQDN
															</th>
															<th>
																Bridge
															</th>
															<th>
																Status
															</th>
															<th>
																Stockage / Template
															</th>
															<th>
																Note
															</th>
															<th>
																Action
															</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($allNode as $key =>
														 $node) { ?>
														<?php if ($node['status'] == 1) {$etat = "<span class='badge-pill badge badge-success p-2'>Active</span>";} else $etat = "<span class='badge-pill badge badge-danger p-2'>Désactivé</span>";?>
															<tr>
																<td>
																	<?= $key ?>
																</td>
																<td>
																	<?= $node['pays'] ?>
																	 / 
																	<?= $node['name'] ?>
																</td>
																<td>
																	<?= $node['ip'] . " / <a target='_blank' href='" . $node['FQDN'] . "'>" . $node['FQDN'] . "</a>" ?></td>
																	<td>
																		<?= $node['bridge'] ?>
																	</td>
																	<td>
																		<?= $etat ?>
																	</td>
																	<td>
																		<?= $node['disk'] ?>
																		 / 
																		<?= $node['templateDisk'] ?>
																	</td>
																	<td>
																		<?= $node['note'] ?>
																	</td>
																	<td>
																		<?php if ($node['status'] == 0) { ?>
																		<button data-toggle="modal" data-target="#nodestart<?= $key ?>" class="btn"><i class='bx bx-power-off' style="color: green; font-size: 20px"></i></button>
																		<?php } else if ($node['status'] == 1) { ?>
																		<button data-toggle="modal" data-target="#nodestop<?= $key ?>" class="btn"><i class='bx bx-power-off' style="color: red; font-size: 20px"></i></button>
																		<?php } ?>
																		<button data-toggle="modal" data-target="#nodeedit<?= $key ?>" class="btn"><i class='bx bxs-pencil' style="font-size: 20px"></i></button>
																		<button data-toggle="modal" data-target="#nodedelete<?= $key ?>" class="btn"><i class='bx bx-trash' style="color: red; font-size: 20px"></i></button>
																	</td>
																</tr>
																<div class="modal fade" id="nodestart<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="nodestart<?= $key ?>" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title">
																					Remettre en service le node 
																					<?= $key ?>
																					 ?
																				</h5>
																				<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																			</div>
																			<div class="modal-body">
																				Souhaitez vous réellement remettre en service la node 
																				<?= $key ?>
																				 ?
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Non</button>
																				<form action="../includes/admin/nodes/manageNodes.php" method="POST">
																					<input name="start" value="<?= $node['id'] ?>" hidden>
																					<button type="submit" class="btn btn-outline-success">Oui</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal fade" id="nodestop<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="nodestop<?= $key ?>" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title">
																					Mettre hors service le node 
																					<?= $key ?>
																					 ?
																				</h5>
																				<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																			</div>
																			<div class="modal-body">
																				Souhaitez vous réellement mettre hors service la node 
																				<?= $key ?>
																				 ?
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Non</button>
																				<form action="../includes/admin/nodes/manageNodes.php" method="POST">
																					<input name="stop" value="<?= $node['id'] ?>" hidden>
																					<button type="submit" class="btn btn-outline-success">Oui</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal fade" id="nodedelete<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="nodedelete<?= $key ?>" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title">
																					Supprimer la node 
																					<?= $key ?>
																					 ?
																				</h5>
																				<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																			</div>
																			<div class="modal-body">
																				Souhaitez vous réellement supprimer la node 
																				<?= $key ?>
																				 ?
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Non</button>
																				<form action="../includes/admin/nodes/manageNodes.php" method="POST">
																					<input name="delete" value="<?= $node['id'] ?>" hidden>
																					<button type="submit" class="btn btn-outline-success">Oui</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal fade" id="nodeedit<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="nodeedit<?= $key ?>" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title">
																					Modifier la node 
																					<?= $key ?>
																					 ?
																				</h5>
																				<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																			</div>
																			<form action="../includes/admin/nodes/manageNodes.php" method="POST">
																				<div class="modal-body">
																					<div class="form-group form-row">
																						<div class="col">
																							<label for="pays">Pays</label>
																							<select class="form-control" name="pays" id="pays">
																								<option value="France">France</option>
																								<option value="Belgique">Belgique</option>
																								<option value="Allemagne">Allemagne</option>
																								<option value="Amérique">Amérique</option>
																								<option value="Angleterre">Angleterre</option>
																								<option value="Chine">Chine</option>
																								<option value="Suisse">Suisse</option>
																								<option value="Espagne">Espagne</option>
																							</select>
																						</div>
																						<div class="col">
																							<label for="nom">Nom</label>
																							<input class="form-control" name="name" type="text" id="nom" value="<?= $node['name'] ?>" required>
																						</div>
																					</div>
																					<hr>
																					<div class="form-group form-row">
																						<div class="col">
																							<label for="fqdn">FQDN</label>
																							<input class="form-control" name="fqdn" type="text" id="fqdn" value="<?= $node['FQDN'] ?>" required>
																						</div>
																						<div class="col">
																							<label for="ip">IP</label>
																							<input class="form-control" name="ip" type="text" id="ip" value="<?= $node['ip'] ?>" required>
																						</div>
																						<hr>
																						<div class="col">
																							<label for="user">Utilisateur</label>
																							<input class="form-control" name="user" type="text" id="user" value="<?= $node['user'] ?>" required>
																						</div>
																						<div class="col">
																							<label for="pwd">Mot de passe</label>
																							<input class="form-control" name="pwd" type="text" id="pwd" value="<?= $node['pwd'] ?>" required>
																						</div>
																					</div>
																					<hr>
																					<div class="form-group form-row">
																						<div class="col">
																							<label for="bridge">Bridge</label>
																							<input class="form-control" name="bridge" type="text" id="bridge" value="<?= $node['bridge'] ?>" required>
																						</div>
																					</div>
																					<div class="form-group form-row">
																						<div class="col">
																							<label for="disk">Disque (Stockage)</label>
																							<input class="form-control" name="disk" type="text" id="disk" value="<?= $node['disk'] ?>" required>
																						</div>
																						<div class="col">
																							<label for="templateDisk">Disque (OS)</label>
																							<input class="form-control" name="templateDisk" type="text" id="templateDisk" value="<?= $node['templateDisk'] ?>" required>
																						</div>
																					</div>
																					<hr>
																					<div class="form-group form-row">
																						<div class="col">
																							<label for="note">Note</label>
																							<input class="form-control" name="note" type="text" id="note" value="<?= $node['note'] ?>">
																						</div>
																					</div>
																				</div>
																				<div class="modal-footer">
																					<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Annuler</button>
																					<input name="edit" value="<?= $node['id'] ?>" hidden>
																					<button type="submit" class="btn btn-outline-success">Enregistrer</button>
																				</div>
																			</form>
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
									<div class="modal fade" id="nodenew" tabindex="-1" role="dialog" aria-labelledby="nodenew" aria-hidden="true" style="display: none;">
										<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">
														Ajout d'une node
													</h5>
													<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												</div>
												<form action="../includes/admin/nodes/manageNodes.php" method="POST">
													<div class="modal-body">
														<div class="form-group form-row">
															<div class="col">
																<label for="pays">Pays</label>
																<select class="form-control" name="pays" id="pays">
																	<option value="France">France</option>
																	<option value="Belgique">Belgique</option>
																	<option value="Allemagne">Allemagne</option>
																	<option value="Amérique">Amérique</option>
																	<option value="Angleterre">Angleterre</option>
																	<option value="Chine">Chine</option>
																	<option value="Suisse">Suisse</option>
																	<option value="Espagne">Espagne</option>
																</select>
															</div>
															<div class="col">
																<label for="nom">Nom</label>
																<input class="form-control" name="name" type="text" id="nom" placeholder="PVE1" required>
															</div>
														</div>
														<hr>
														<div class="form-group form-row">
															<div class="col">
																<label for="fqdn">FQDN</label>
																<input class="form-control" name="fqdn" type="text" id="fqdn" placeholder="https://pve.dev.fr" required>
															</div>
															<div class="col">
																<label for="ip">IP</label>
																<input class="form-control" name="ip" type="text" id="ip" placeholder="1.1.1.1" required>
															</div>
															<hr>
															<div class="col">
																<label for="user">Utilisateur</label>
																<input class="form-control" name="user" type="text" id="user" placeholder="root" required>
															</div>
															<div class="col">
																<label for="pwd">Mot de passe</label>
																<input class="form-control" name="pwd" type="text" id="pwd" placeholder="password" required>
															</div>
														</div>
														<hr>
														<div class="form-group form-row">
															<div class="col">
																<label for="bridge">Bridge</label>
																<input class="form-control" name="bridge" type="text" id="bridge" placeholder="vmbr0" required>
															</div>
														</div>
														<div class="form-group form-row">
															<div class="col">
																<label for="disk">Disque (Stockage)</label>
																<input class="form-control" name="disk" type="text" id="disk" placeholder="local-ssd" required>
															</div>
															<div class="col">
																<label for="templateDisk">Disque (OS)</label>
																<input class="form-control" name="templateDisk" type="text" id="templateDisk" placeholder="local" required>
															</div>
														</div>
														<hr>
														<div class="form-group form-row">
															<div class="col">
																<label for="note">Note</label>
																<input class="form-control" name="note" type="text" id="note" placeholder="Description...">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-label="Close">Annuler</button>
														<input name="new" value="ajout" hidden>
														<button type="submit" class="btn btn-outline-success">Valier</button>
													</div>
												</form>
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
				<script src="/assets/js/custom.js"></script>
				<script src="/assets/js/app.js"></script>
				<!-- App js -->
				<script src="/assets/js/theme.js"></script>
	</body>
</html>