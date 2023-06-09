<header id="page-topbar">
                    <div class="navbar-header">
                        <div class="navbar-brand-box d-flex align-items-left">
                            <a href="index.php" class="logo">
                            <h2 style="color: white;"><?= $settings['name'] ?> - Administration</h2>
                            </a>
                            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                        </div>
        
                        <div class="d-flex align-items-center">          
                            <div class="dropdown d-inline-block ml-2">
                                <button type="button" class="btn header-item waves-effect waves-light"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="<?= $avatar_url ?>"
                                        alt="Header Avatar">
                                    <span class="d-none d-sm-inline-block ml-1"><?= $data['first_name']?> <?= $data['last_name'][0]?>.</span>
                                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="../profilManage.php">
                                        <span>Profil</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="../index.php">
                                        <span>Retourner au site</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="../includes/users/disconnect.php">
                                        <span>Se déconnecter</span>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </header>

                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php">
                                            <i class="bx bx-cloud"></i>Accueil  
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="settings.php">
                                            <i class="bx bx-cog"></i>Paramètres
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="instances.php">
                                            <i class="bx bx-server"></i>Instances
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ticketManage.php">
                                            <i class="bx bx-mail-send"></i>Tickets
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="utilisateurs.php">
                                            <i class="bx bx-user"></i>Utilisateurs
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="nodes.php">
                                        <i class='bx bxs-server' ></i>Nodes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div> 