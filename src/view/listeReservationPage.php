<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOLivreUtilisateur;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DTO\LivreUtilisateur;
//Récupération de l'user connecter

if (isset($_SESSION['userLog'])){
$user = $_SESSION['userLog'];
$userId = $user->getIdUtilisateur();

//Nos Repo/Entities
$MonDaoUtilisateur = new DAOUtilisateur();
$UtilisateurLivre = new LivreUtilisateur();
$DaoLivreUtilisateur = new DAOLivreUtilisateur();

//Récupération des réservations de l'user connecter
$MonUser = $MonDaoUtilisateur->getUtilisateurById($userId);
$UtilisateurLivre->setUtilisateur($MonUser);
$repoLivreUtilisateur = $DaoLivreUtilisateur->getReservationByIdUser($UtilisateurLivre);

//Pagination
// Comment faire une pagination en php :https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

//Si Aucune res, assigner un tableau vide à la place, car count ne prend en params que int|array, pas null.
if($repoLivreUtilisateur == null)
    $repoLivreUtilisateur = [];
$Nbres = count($repoLivreUtilisateur);


$NbrResParPage = 5;
$pages = ceil($Nbres / $NbrResParPage);
$premier = ($currentPage * $NbrResParPage) - $NbrResParPage;
$Reservations = $DaoLivreUtilisateur->getLivrePagination($NbrResParPage, $premier, $userId);
if ($Reservations == null)
    $Reservations = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vos Réservations</title>
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
    <div class="container mt-5 w-100" >

        <div class="row justify-content-center mt-4 align-items-center text-center">
            <div class="col-md-auto mb-2 ">
                <span class="mr-md-3">Nombre de Livre Réservé (<?php echo $Nbres ?>) </span>
            </div>
        </div>

        <?php
        //https://getbootstrap.com/docs/4.0/components/alerts/
        //https://openclassrooms.com/forum/sujet/afficher-l-erreur-en-get
        if (isset($_GET['succes'])) {
            $succes = $_GET['succes'];
            if ($succes == 'AddTrue') {
                $message = $_GET['message'];
                echo ' <div style=" text-align: center" class="alert alert-success" role="alert">
                               '.$message.'
                           </div>';
            }
        }
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'AddFalse') {
                $message = $_GET['message'];
                echo ' <div style="text-align: center" class="alert alert-success" role="alert">
                              '.$message.'
                           </div>';
            }
        }
        ?>
        <div class="card  mt-3 mb-2 ">
            <div class="card-header py-3">
                <h6 style="color: #4682B4 "  class="m-0 font-weight-bold text-primary">Liste de vos réservations</h6>
            </div>
            <div class="card-body" >
                <div class="table-responsive">

                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                            <th>Nom du livre</th>
                            <th>Nombre d'exemplaire</th>
                            <th>Date de la réservation</th>
                            <th>Date du rendu</th>
                            <th>Date de l'emprunt</th>
                            <th>Etat Réservation</th>
                            <th>Archivage Réservation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Reservations as $res): ?>
                            <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                                <td><?php echo $res->getLivre()->getTitreLivre(); ?></td>
                                <td><?php echo $res->getNbExemplaire(); ?></td>
                                <td><?php echo $res->getDateReservation("Y-m-d"); ?></td>
                                <td><?php
                                    $dateRendu = $res->getDateRendu("Y-m-d");
                                    if($dateRendu == "8000-08-08"){
                                        echo "Date non définit";
                                    }else echo $res->getDateRendu("Y-m-d");
                                    ?></td>
                                <td><?php
                                    $dateRendu = $res->getDateEmprunt("Y-m-d");
                                    if($dateRendu == "8000-08-08"){
                                        echo "Date non définit";
                                    }else echo $res->getDateEmprunt("Y-m-d");
                                    ?></td>
                                <td><?php
                                    $EtatRes = $res->getEtatRes();
                                    switch ($EtatRes) {
                                        case "En-attente":
                                            echo "<a style='color: orange'>Réservation En-attente</a>";
                                            break;
                                        case "En-Cours":
                                            echo "<a style='color: green'>Réservation En-Cours</a>";
                                            break;
                                        case "Terminer":
                                            echo "<a style='color: red'>Réservation Terminer</a>";
                                            break;
                                        default:
                                            echo "Non spécifié";
                                            break;
                                    }
                                ?></td>
                                <td><?php
                                    $EtatArchi = $res->getArchiver();
                                    switch ($EtatArchi) {
                                        case false:
                                            echo "<a style='color: green'>Réservation Non-Archiver</a>";
                                            break;
                                        case true:
                                            echo "<a style='color: red'>Réservation Archiver</a>";
                                            break;
                                        default:
                                            echo "Non spécifié / Valeur incorrect";
                                            break;
                                    }
                                    ?></td>
                                <?php
                                    $EtatRes = $res->getEtatRes();
                                    if($EtatRes == "En-attente"){
                                        echo '
                                              <td>
                                             <form action="../../src/controller/TraitLivreUtilisateur.php" method="post">
                                                <div class="col-md-auto mb-2">
                                                    <input name="DateRes" value="' . $res->getDateReservation("Y-m-d") . '" type="hidden">
                                                    <input name="LivreRes" value="' . $res->getLivre()->getIdLivre() . '" type="hidden">
                                                    <input name="User" value="' . $userId . '" type="hidden">
                                                    <button type="submit" name="AnnulationRes" class="btn btn-danger w-100 mb-1">Annuler la réservation</button>
                                                </div>
                                            </form>
                                              </td>
                                            ';
                                    }elseif ($EtatRes == "En-Cours"){
                                        echo '
                                              <td>
                                             <form action="../../src/controller/TraitLivreUtilisateur.php" method="post">
                                                <div class="col-md-auto mb-2">
                                                    <input name="DateRes" value="' . $res->getDateReservation("Y-m-d") . '" type="hidden">
                                                    <input name="LivreRes" value="' . $res->getLivre()->getIdLivre() . '" type="hidden">
                                                    <input name="User" value="' . $userId . '" type="hidden">
                                                    <button type="submit" style="background-color: #4682B4;" name="RendreRes" class="btn btn-primary w-100 mb-1">Rendre Le Livre</button>
                                                </div>
                                            </form>
                                            </td>
                                            ';
                                    }
                                    ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                <a href="../view/ListeReservationPage.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="../view/ListeReservationPage.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="../view/ListeReservationPage.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
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

