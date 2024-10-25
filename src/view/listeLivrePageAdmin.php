<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOLivre;
use MonApp\model\DTO\MotCleLivre;
use MonApp\model\DAO\DAOMotCleLivre;
use MonApp\model\DAO\DAOMotCle;
use MonApp\model\DTO\Livre;

if (isset($_SESSION['userLog'])){
$DaoMotCleLivre = new DAOMotCleLivre();
$daomoclef = new DAOMotCle();
$monLivre = new Livre();
$motcleflivre = new MotCleLivre();

$DaoLivre = new DAOLivre();
$repoLivres = $DaoLivre->getAllLivre();

if($repoLivres == null)
    $repoLivres = [];
$NbLivre = count($repoLivres);


if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

$NbrLivreParPage = 2;
$pages = ceil($NbLivre / $NbrLivreParPage);
$premier = ($currentPage * $NbrLivreParPage) - $NbrLivreParPage;
$Livres = $DaoLivre->getLivrePagination($NbrLivreParPage, $premier);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion Livres</title>
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
                <span class="mr-md-3">Nombre de Livre (<?php echo $NbLivre ?>) </span>
            </div>
            <div class="col-md-auto mb-2">
                <a href="#" onclick="openForm()" class="btn btn-primary" style="background-color: #4682B4;">Ajouter un Livre</a>
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

        <div class="login-popup">
            <div class="form-popup" id="popupForm">
                <form action="../../src/controller/TraitLivre.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titreLivre">Titre du Livre</label>
                        <input type="text" class="form-control" id="titreLivre" name="titreLivre" required>
                    </div>
                    <div class="form-group">
                        <label for="resumeLivre">Resume du Livre</label>
                        <input type="text" class="form-control" id="resumeLivre" name="resumeLivre" required>
                    </div>
                    <div class="form-group">
                        <label for="anneePublication">Anne de Publication</label>
                        <input type="date" class="form-control" id="anneePublication" name="anneePublication" required>
                    </div>
                    <div class="form-group">
                        <label for="nombreExemplaires">Nombre d'exemplaire</label>
                        <input type="number" class="form-control" id="nombreExemplaires" name="nombreExemplaires" required>
                    </div>
                    <div class="form-group">
                        <label for="isbn">Isbn</label>
                        <input type="number" class="form-control" id="isbn" name="isbn" required>
                    </div>
                    <div class="form-group">
                        <label for="imageCouverture">Image de Couverture</label>
                        <input type="file" class="form-control" id="imageCouverture" name="imageCouverture" required>
                    </div>

                    <button name="addLivre" type="submit" class="btn btn-primary">Ajouter le Livre</button>
                    <button type="button" class="btn btn-light" onclick="closeForm()">Fermer</button>
                </form>
            </div>
        </div>

        <script>
            function openForm() {
                document.getElementById("popupForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("popupForm").style.display = "none";
            }
        </script>

        <div class="card  mt-3 mb-2 ">
            <div class="card-header py-3">
                <h6 style="color: #4682B4 "  class="m-0 font-weight-bold text-primary">Liste des Livres</h6>
            </div>

            <div class="card-body" >
                <div class="table-responsive">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                            <th>Id Livre</th>
                            <th>Titre du Livre</th>
                            <th>Resume du Livre</th>
                            <th>Annee de Publication</th>
                            <th>Nombre d'exemplaires</th>
                            <th>Isbn</th>
                            <th>Mot(s) Clef(s)</th>
                            <th>Image de couverture</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Livres as $livre): ?>
                            <tr >
                                <td><?php echo $livre->getIdLivre(); ?></td>
                                <td><?php echo $livre->getTitreLivre(); ?></td>
                                <td><?php echo $livre->getResumeLivre(); ?></td>
                                <td><?php echo $livre->getAnneePublication("Y-m-d"); ?></td>
                                <td><?php echo $livre->getNombreExemplaires(); ?></td>
                                <td><?php echo $livre->getIsbn(); ?></td>
                                <td><?php
                                    $motcleflivre->setLivre($DaoLivre->getLivreById($livre->getIdLivre()));
                                    $repoMotCleLivre = $DaoMotCleLivre->getMotCleLivreByLivre($motcleflivre);
                                    if ($repoMotCleLivre == null){
                                        $repoMotCleLivre = [];
                                    }
                                    foreach ($repoMotCleLivre as $motClef):
                                            echo'<span style=" background-color: #4682B4" class="badge ">'.$motClef->getMotCle()->getMotCle().'</span>';
                                    endforeach
                                    ?></td>
                                <td style="text-align: center;">
                                    <img style="height: 200px;object-fit: fill; width: 100px;" src="../../public/img/<?php echo $livre->getImageCouverture() ?>" alt="Image">
                                </td>

                                <td style="text-align: center;">
                                    <form method="post" action="../controller/TraitLivre.php">
                                        <button  class="btn btn-secondary" name="UpdateButton" value="<?php echo $livre->getIdLivre()?>" type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <!--https://getbootstrap.com/docs/4.2/components/tooltips/-->
                                    <form method="post" action="../controller/TraitLivre.php">
                                        <button data-toggle="tooltip" data-placement="bottom" title="Attention !! La pression de ce button va supprimer définitivement le livre." class="btn btn-danger" name="DeleteButton" value="<?php echo $livre->getIdLivre()?>" type="submit">Supprimer</button>

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
                                <a href="../view/listeLivrePageAdmin.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="../view/listeLivrePageAdmin.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="../view/listeLivrePageAdmin.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
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

