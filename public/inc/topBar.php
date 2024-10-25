<?php require_once("../../config/localConfig.php");

if (isset($_SESSION['userLog'])){
    $user = $_SESSION['userLog'];
    $nomUser = $user->getNomUtilisateur();
}


?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid" >
        <a href="#" class="navbar-brand">
            <img src="../../public/img/logo.png"  style=" margin: 0; max-width: 90px; max-height: 90px" class="card-img-top" alt="Logo">
            <span style="font-size: 26px; color: #4682B4;">Bibli'Olen</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <?php
                if(isset($user)) {
                    echo '
                <li class="nav-item" >
                    <a class="nav-link" href="../../src/view/Accueil.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../src/view/ListeLivrePage.php">Nos Livres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../src/view/listeReservationPage.php">Vos Réservations</a>
                </li>
                ';
                }
                ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php
                if(isset($user)) {
                    echo '
                    <li class="nav-item dropdown" style="margin-right: 50px">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong>Utilisateur:</strong> ' . $nomUser . '
                        </a>
                        <ul class="dropdown-menu">                      
                            <li><a class="dropdown-item" href="../../src/view/Disconnect.php">Déconnexion</a></li>
                        </ul>
                    </li>
                ';
                }
                ?>
                <?php
                if(!isset($user))
                echo'
                 <li class="nav-item">
                    <a class="nav-link" href="../../src/view/Connection.php">Connexion</a>
                </li>
                '
                ?>

            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        color: #4682B4;
        font-size: 16px;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #000;
    }

    .navbar-brand img {
        margin-right: 10px;
    }
    .active{
        background-color: #000;
    }
</style>
