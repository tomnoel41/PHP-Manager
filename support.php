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
									<h4 class="mb-0 font-size-18">Assistance</h4>
									<div class="page-title-right">
										<ol class="breadcrumb m-0">
											<li class="breadcrumb-item"><a href="index.php">Tableau de bord</a></li>
											<li class="breadcrumb-item active">Assistance</li>
										</ol>
									</div>
								</div>
							</div>
						</div>
						<!-- end page title -->
						<?php if (isset($_SESSION['flash_message'])) {?>
							<div class="alert alert-<?= $_SESSION['flash_alert'] ?> alert-dismissible fade show mb-0" role="alert">
								<?= $_SESSION['flash_message'] ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div></br>
						<?php unset($_SESSION['flash_message']);}?>
						<div class="row">
							<div class="col-sm-12 mb-4">
								<div class="text-center mt-4">
									<h4>Demande d'assistance</h4>
									<p class="text-muted mt-3 mb-4">
										Ici vous pouvez ouvrir un ticket en cas de problèmes pour contacter le support.
									</p>
									<button type="button" style="width:50%;margin:auto" class="btn btn-dark waves-effect waves-light" data-toggle="modal" data-target="#createProject">Ouvrir un nouveau ticket</button>
									<div class="modal fade" id="createProject" tabindex="-1" role="dialog" aria-labelledby="createProject" aria-hidden="true" style="display: none;">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">
														Ouvrir un ticket
													</h5>
													<button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
												</div>
												<form action="includes/support/createTicket.php" method="POST">
													<div class="modal-body">
														<div class="form-group">
															<label for="ticketDepartment">Département du support</label>
															<select class="form-control" name="ticketDepartment" id="ticketDepartment">
																<option value="assistance_technique">Assistance technique</option>
																<option value="assistance_commerciale">Assistance commerciale</option>
																<option value="administration">Administration</option>
															</select>
														</div>
														<div class="form-group">
															<label for="ticketSubject">Sujet du ticket</label>
															<input type="text" name="ticketSubject" id="ticketSubject" class="form-control" placeholder="" required>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="user_id" id="user_id" value="<?= $data['id']; ?>">
														<button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Annuler</button>
														<button type="submit" name="createProject" class="btn btn-primary waves-effect waves-light">Créer</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</br>
						<!-- end row -->
						<div class="row">
							<div class="col-12">
								<div class="card ">
									<div class="card-body">
										<h4 class="card-title">Mes tickets</h4>
										<div class="table-responsive">
											<table class="table table-bordered table-striped mb-0">
												<thead>
													<tr>
														<th class="text-center">
															Sujet
															<br>
														</th>
														<th class="text-center">
															Département
															<br>
														</th>
														<th class="text-center">
															Status
															<br>
														</th>
														<th class="text-center">
															Prise en charge
															<br>
														</th>
														<th class="text-center">
															Options
															<br>
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
                                                    $req = $bdd->prepare('SELECT * FROM tickets WHERE user_id = ?');
                                                    $user_id = $data['id'];$req->execute([$user_id]);
                                                    $tickets = $req->fetchAll();
                                                    foreach ($tickets as $ticket) {?>
													<tr>
														<td align="center">
															<?= $ticket['subject']?>
														</td>
														<td align="center">
															<?= $ticket['department']?>
														</td>
														<td align="center">
															<?php if($ticket['status'] == 1) {?>
															<span class="badge badge-soft-success">Ouvert</span>
															<?php } else { ?>
															<span class="badge badge-soft-dark">Clos</span>
															<?php } ?>
														</td>
														<td align="center">
															Pris en charge par Tom Noel.
														</td>
														<td align="center">
															<form action="includes/support/manageTicket.php" method="POST">
																<input type="hidden" name="user_id" id="user_id" value="<?= $data['id']; ?>">
																<input type="hidden" name="ticket_id" id="ticket_id" value="<?= $ticket['id']; ?>">
																<?php if($ticket['status'] == 1): ?>
																<button name="accessTicket" type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Accéder au ticket</button>
																<button name="closeTicket" type="submit" class="btn btn-danger btn-sm waves-effect waves-light">Fermer le ticket</button>
																<?php elseif($ticket['status'] == 0): ?>
																<button name="accessTicket" type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Accéder au ticket</button>
																<button name="reopenTicket" type="submit" class="btn btn-dark btn-sm waves-effect waves-light">Réouvrir le ticket</button>
																<button name="deleteTicket" type="submit" class="btn btn-danger btn-sm waves-effect waves-light">Supprimer le ticket</button>
																<?php endif; ?>
															</form>
														</td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										<!-- end table-responsive-->
									</div>
									<!-- end card-body-->
								</div>
								<!-- end card-->
							</div>
							<!-- end col-->
						</div>
						<!-- end row -->
						</br>
						<div class="row">
							<div class="col-12">
								<div class="card ">
									<div class="card-body">
										<h4 class="card-title">Nos départements de support</h4>
										<p class="card-subtitle mb-4">
											Nous avons plusieurs départements de support pour répondre à tous vos besoins. Voici une brève présentation de chacun de ces départements :
										</p>
										<div class="media mb-3">
											<img class="d-flex align-self-start rounded mr-3" src="assets/images/users/avatar-5.jpg" alt="Generic placeholder image" height="48">
											<div class="media-body">
												<h6 class="mt-0">
													Assistance technique
												</h6>
												<p class="mb-1">
													Notre département d'assistance technique est là pour vous aider à résoudre tous les problèmes techniques que vous pourriez rencontrer avec nos produits ou services. Notre équipe est formée pour répondre rapidement et efficacement à toutes vos demandes, qu'il s'agisse de problèmes liés à l'utilisation de notre site ou à la configuration de votre équipement.
												</p>
											</div>
										</div>
										<div class="media mb-3">
											<img class="d-flex align-self-center rounded mr-3" src="assets/images/users/avatar-3.jpg" alt="Generic placeholder image" height="48">
											<div class="media-body">
												<h6 class="mt-0">
													Assistance commerciale
												</h6>
												<p class="mb-1">
													Notre département d'assistance commerciale est là pour vous accompagner dans toutes les phases du cycle de vente, de la prospection à la vente et au-delà. Nos conseillers commerciaux sont à votre disposition pour répondre à toutes vos questions et vous aider à choisir le produit ou service qui convient le mieux à vos besoins.
												</p>
											</div>
										</div>
										<div class="media">
											<img class="d-flex align-self-end rounded mr-3" src="assets/images/users/avatar-7.jpg" alt="Generic placeholder image" height="48">
											<div class="media-body">
												<h6 class="mt-0">
													Administration
												</h6>
												<p class="mb-1">
													Notre département d'administration est responsable de la gestion de tous les aspects administratifs de notre site. Cela comprend la gestion de votre compte utilisateur, la facturation et la gestion des paiements, ainsi que la gestion des problèmes liés à la sécurité et à la confidentialité des données. Nous sommes là pour vous offrir un service efficace et sécurisé afin que vous puissiez profiter pleinement de tous les avantages de notre site.
												</p>
											</div>
										</div>
									</div>
									<!-- end card-body-->
								</div>
								<!-- end card-->
							</div>
							<!-- end col -->
						</div>
						<!-- end row-->
						</br>
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