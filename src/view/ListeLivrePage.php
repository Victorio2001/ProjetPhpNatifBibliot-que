<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOLivre;
use MonApp\model\DTO\Livre;

// Comment faire une pagination en php :https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php

$MonLivre = new Livre();
$MonDaoLivre = new DAOLivre();
if (isset($_SESSION['userLog'])){
$AllLivres = $MonDaoLivre->getAllLivre();

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
if($AllLivres == null)
    $AllLivres = [];
$nbLivre = count($AllLivres);

$NbrLivreParPage = 4;
$pages = ceil($nbLivre / $NbrLivreParPage);
$premier = ($currentPage * $NbrLivreParPage) - $NbrLivreParPage;
$livres = $MonDaoLivre->getLivrePagination($NbrLivreParPage, $premier);

if (isset($_SESSION['Books'])) {
    $livres = $_SESSION['Books'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../public/css/DefaultStyle.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/ListePage.css">
    <style>
        .container {
            padding-bottom: 60px;
        }
    </style>
</head>
<body id="page-top">
            <?php include '../../public/inc/topBar.php' ?>
            <div class="container mt-5">

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-4">
                            <h5 class="mb-3">Filtre</h5>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Décroissant (Z-A)
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Croissant (A-Z)
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <h5 class="mb-3">Tous les livres disponibles dans nôtre Bibliothèque</h5>
                        <div class="form-outline mb-4">
                            <form action="../../src/controller/TraitLivre.php" method="post">

                                <input type="search" name="IamLookingForABookPlsSir" placeholder="Rechercher Votre livre"  class="form-control  mb-1">

                                <div class="d-flex flex-column flex-md-row justify-content-start align-items-center text-center">
                                    <input  type="submit" name="SearchBook" value="rechercher" class="form-control m-1">
                                    <input type="submit" name="CancelSearchBook" value="Annuler La recherche" class="form-control m-1">
                                </div>

                            </form>
                        </div>


                        <div class="row">
                            <?php foreach ($livres as $livre): ?>
                                <div class="col-sm-6 col-md-3 mb-4 ">
                                    <div class="card h-100" >
                                        <img src="../../public/img/<?php echo $livre->getImageCouverture() ?>" style="height: 350px;" class="card-img-top" alt="Skyscrapers"/>
                                        <div class="card-body  d-flex flex-column ">
                                            <h5 class="card-title"><?php echo $livre->getTitreLivre(); ?></h5>
                                            <?php
                                            //recup du resume du livre (ps: penser à en faire un fonction plus tard pas très propre ici).
                                            $resume = $livre->getResumeLivre();
                                            //definnition de la taille max qu texte.
                                            $maxTaille = 75;

                                            //check taille texte
                                            if (strlen($resume) > $maxTaille) {
                                                //troncate si trop long
                                                $resumeTronque = substr($resume, 0, $maxTaille) . '...';
                                            } else {
                                                //Renvoie normal
                                                $resumeTronque = $resume;
                                            }
                                            ?>
                                            <p class="card-text"><?php echo $resumeTronque; ?></p>
                                            <div class="mt-auto">
                                                <form class="w-100 mb-0" action="../../src/view/LivreDetailsPage.php?idLivre=<?php echo $livre->getIdLivre(); ?>" method="post">
                                                    <button type="submit" value="<?php echo $livre->getIdLivre(); ?>" style="background-color: #4682B4;" class="btn btn-primary w-100 mb-1">Voir plus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted"><?php echo 'Nombre d\'exemplaire: '.$livre->getNombreExemplaires(); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <nav>
                                <ul class="pagination">
                                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                        <a href="../view/ListeLivrePage.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                    </li>
                                    <?php for($page = 1; $page <= $pages; $page++): ?>
                                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                            <a href="../view/ListeLivrePage.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                        </li>
                                    <?php endfor ?>
                                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                        <a href="../view/ListeLivrePage.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
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

