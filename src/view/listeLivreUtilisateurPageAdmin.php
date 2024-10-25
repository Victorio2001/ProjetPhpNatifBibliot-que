<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOLivreUtilisateur;
//Récupération de l'user connecter

if (isset($_SESSION['userLog'])){
$user = $_SESSION['userLog'];
$userId = $user->getIdUtilisateur();

$DaoLivreUtilisateur = new DAOLivreUtilisateur();
//Récupération de tout les livres
$repoLivresUtilisateurs = $DaoLivreUtilisateur->getAllLivreUtilisateur();

//Pagination
// Comment faire une pagination en php :https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
//Si Aucune res, assigner un tableau vide à la place, car count ne prend en params que int|array, pas null.
if($repoLivresUtilisateurs == null)
    $repoLivresUtilisateurs = [];
$NombreRes = count($repoLivresUtilisateurs);

$NbrResParPage = 5;
$pages = ceil($NombreRes / $NbrResParPage);
$premier = ($currentPage * $NbrResParPage) - $NbrResParPage;
$Reservations = $DaoLivreUtilisateur->getLivrePaginationAdmin($NbrResParPage, $premier);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../public/css/DefaultStyle.css">
    <style>
        .form-popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            width: 50%;
            max-width: 600px;
            min-width: 300px;
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 100;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-popup {
            position: relative;
            width: 100%;
            justify-content: center;
            align-items: center;
        }

        .form-popup .form-control {
            margin-bottom: 10px;
        }

        .form-popup label {
            margin-bottom: 5px;
            font-weight: bold;
        }
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
                <span class="mr-md-3">Nombre de Réservation (<?php echo $NombreRes ?>) </span>
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
            if ($succes == 'DeleteTrue') {
                echo ' <div style=" text-align: center" class="alert alert-success" role="alert">
                               L\'utilisateur à bien été supprimer.
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
            if ($error == 'DeleteFalse') {
                echo ' <div style="text-align: center" class="alert alert-success" role="alert">
                              L\'utilisateur n\'à pas été supprimer.
                           </div>';
            }
        }
        ?>

        <div class="card  mt-3 mb-2 ">
            <div class="card-header py-3">
                <h6 style="color: #4682B4 "  class="m-0 font-weight-bold text-primary">Liste des Réservations</h6>
            </div>

            <div class="card-body" >
                <div class="table-responsive">
                    <table  class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                            <th>Nom du livre</th>
                            <th>Nom de l'utilisateur</th>
                            <th>Nombre d'exemplaire</th>
                            <th>Date de la réservation</th>
                            <th>Date du rendu</th>
                            <th>Date de l'emprunt</th>
                            <th>Etat Réservation</th>
                            <th>Archivage Réservation</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Reservations as $livreuser): ?>
                            <tr style="white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    max-width: 120px;">
                                <td><?php echo $livreuser->getLivre()->getTitreLivre(); ?></td>
                                <td><?php echo $livreuser->getUtilisateur()->getNomUtilisateur(); ?></td>
                                <td><?php echo $livreuser->getNbExemplaire(); ?></td>

                                <td><?php echo $livreuser->getDateReservation("Y-m-d"); ?></td>
                                <td><?php
                                    $dateRes= $livreuser->getDateRendu("Y-m-d");
                                    if($dateRes == "8000-08-08"){
                                        echo "Date non définit";
                                    }else echo $livreuser->getDateRendu("Y-m-d");
                                ?></td>
                                <td><?php
                                    $dateRendu = $livreuser->getDateEmprunt("Y-m-d");
                                    if($dateRendu == "8000-08-08"){
                                        echo "Date non définit";
                                    }else echo $livreuser->getDateEmprunt("Y-m-d");
                                ?></td>
                                <td><?php
                                    $EtatRes = $livreuser->getEtatRes();
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
                                    $EtatArchi = $livreuser->getArchiver();
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
                                <td style="text-align: center;">
                                    <form method="post" action="../controller/TraitLivreUtilisateur.php">
                                        <button class="btn btn-secondary" name="UpdateButton" value="#" type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <form method="post" action="../controller/TraitLivreUtilisateur.php">
                                        <input name="DateRes" value="<?php echo $livreuser->getDateReservation("Y-m-d")?>" type="hidden">
                                        <input name="LivreRes" value="<?php echo $livreuser->getLivre()->getIdLivre()?>" type="hidden">
                                        <input name="User" value="<?php echo $livreuser->getUtilisateur()->getIdUtilisateur() ?>" type="hidden">
                                        <button class="btn btn-success" name="ValiderRes" value="#" type="submit">Valider-réservation</button>
                                    </form>
                                </td>
                                <td style="text-align: center; justify-content: center">
                                    <form method="post" action="../controller/TraitLivreUtilisateur.php">
                                        <input type="hidden" name="DateRes" value="<?php echo $livreuser->getDateReservation("Y-m-d");  ?>" required>
                                        <input type="hidden" name="User" value="<?php echo $livreuser->getUtilisateur()->getIdUtilisateur(); ?>" required>
                                        <input type="hidden" name="livre" value="<?php echo $livreuser->getLivre()->getIdLivre(); ?>" required>
                                        <input type="hidden" name="NbRes" value="<?php echo $livreuser->getNbExemplaire();  ?>" required>
                                        <button class="btn btn-danger" name="ArchiRes" type="submit">Archiver</button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                <a href="../view/ListeLivreUtilisateurPageAdmin.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="../view/ListeLivreUtilisateurPageAdmin.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="../view/ListeLivreUtilisateurPageAdmin.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
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

