<?php
require_once '../../config/localConfig.php';

use MonApp\model\DAO\DAOLivreUtilisateur;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DTO\LivreUtilisateur;

use MonApp\model\DAO\DAOLivre;
if (isset($_SESSION['userLog'])){
$DaoLivre = new DAOLivre();
$repoLivres = $DaoLivre->getAllLivre();

$user = $_SESSION['userLog'];
$userRole = $user->getRole()->getNomRole();
$nomUser = $user->getNomUtilisateur();

$userId = $user->getIdUtilisateur();

$MonDaoUtilisateur = new DAOUtilisateur();
$UtilisateurLivre = new LivreUtilisateur();
$DaoLivreUtilisateur = new DAOLivreUtilisateur();


$repoLivreUtilisateursEnattente= $DaoLivreUtilisateur->getAllLivreUtilisateurEnAttente();
if($repoLivreUtilisateursEnattente == null)
    $repoLivreUtilisateursEnattente = [];
$nbrLivreEnAttente = count($repoLivreUtilisateursEnattente);


$MonUser = $MonDaoUtilisateur->getUtilisateurById($userId);
$UtilisateurLivre->setUtilisateur($MonUser);
$repoLivreUtilisateur = $DaoLivreUtilisateur->getReservationByIdUser($UtilisateurLivre);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../public/css/DefaultStyle.css">
    <style>
        .container {
            padding-bottom: 60px;
        }
    </style>
</head>
<body id="page-top">
<?php include '../../public/inc/topBar.php' ?>
<div class="container mt-5">
    <div class="row ">

        <?php
        //https://getbootstrap.com/docs/4.0/components/alerts/
        //https://openclassrooms.com/forum/sujet/afficher-l-erreur-en-get
        if (isset($_GET['succes'])) {
            $error = $_GET['succes'];
            if ($error == 'login') {
                echo ' <div style="text-align: center" class="alert alert-success" role="alert">
                                  Bienvenue Sur Bibli\'olen !!
                               </div>';
            }
        }
        ?>
        <div class="d-flex flex-column flex-md-row justify-content-start align-items-center text-center">
            <h5 class="mx-md-2">Bienvenue : <a style="color: #4682B4 "><?php echo $nomUser?></a></h5>
            <h5 class="mx-md-2">Role : <a style="color: #4682B4 "><?php echo $userRole?></a></h5>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 m-3">
            <div class="col">
                <div class="card h-100 shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #4682B4;">Vos Réservations</h5>
                        <p class="card-text">Consultez et gérez vos livres préalablement réservés.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 mt-auto">
                        <a href="../../src/view/listeReservationPage.php" style="background-color: #4682B4;" class="btn btn-primary w-100" >Accès Réservations</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #4682B4;">Nos Livres</h5>
                        <p class="card-text">Consultez les livres disponibles dans notre bibliothèque.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 mt-auto">
                        <a href="../../src/view/ListeLivrePage.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Livres</a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="hr mt-2 mb-0 " />

        <div class="row row-cols-1 row-cols-md-3 g-4 m-3">
            <?php
            switch ($userRole) {
                case "gestionnaire":
                    echo '
                           <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion Livres <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les livres disponibles dans notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/listeLivrePageAdmin.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Livres</a>
                        </div>
                    </div>
                </div>
    
                <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion Utilisateurs <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les Utilisateurs de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="listeUserPageAdmin.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Utilisateurs</a>
                        </div>
                    </div>
                </div>
    
              <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column position-relative">
                        <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-success">
                            '.$nbrLivreEnAttente.' en attente
                            <span class="visually-hidden">réservations en attente</span>
                        </span>
                         <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-success">
                            '.$nbrLivreEnAttente.' en attente
                            <span class="visually-hidden">réservations en attente</span>
                        </span>
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">
                                Gestion Réservation <strong>(Admin)</strong>
                            </h5>
                            <p class="card-text">Consultez les Réservations de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/listeLivreUtilisateurPageAdmin.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Réservations</a>
                        </div>
                    </div>
                </div>
    
    
                
                <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion Transaction <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les Transactions de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/listeTransactionPageAdmin.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Transactions</a>
                        </div>
                    </div>
                </div>
                  <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion Auteur <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les Auteurs de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/ListePageAuteur.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Auteurs</a>
                        </div>
                    </div>
                   </div>
                   <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion Editeur <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les Editeurs de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/ListePageEditeur.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès Editeurs</a>
                        </div>
                    </div>
                   </div>
                   <div class="col">
                    <div class="card h-100 shadow-sm d-flex flex-column">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #4682B4;">Gestion MotClef <strong>(Admin)</strong></h5>
                            <p class="card-text">Consultez les MotClef de notre bibliothèque.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mt-auto">
                            <a href="../../src/view/ListePageMotclef.php" style="background-color: #4682B4;" class="btn btn-primary w-100">Accès MotClef</a>
                        </div>
                    </div>
                   </div>
                        ';
                    break;
            }
            ?>
        </div>
    </div>


    <section class="mt-2" style="display: flex; justify-content: center;">
        <div class="col-md-9">
            <img style="object-fit: fill; width: 100%;" src="../../public/img/Ort.jpg" alt="">
        </div>
    </section>
</div>

<?php include '../../public/inc/footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
<?php
}else{
    $message = "Erreur (re-)connectez-vous";
    header('location: ../../src/view/Connection.php?error=AddFalse&message=' .$message);
}


