<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOMotCle;
$monDaoMotClef = new DAOMotCle();

if (isset($_SESSION['userLog'])){
$allMotClef = $monDaoMotClef->getAllMotCle();

if ($allMotClef == null)
    $allMotClef = [];
$NbMotClef = count($allMotClef);

// Comment faire une pagination en php :https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

$NbrMotClefParPage = 5;
$pages = ceil($NbMotClef / $NbrMotClefParPage);
$premier = ($currentPage * $NbrMotClefParPage) - $NbrMotClefParPage;
$motclefs = $monDaoMotClef->getMotClefPagination($NbrMotClefParPage, $premier);

if (isset($_SESSION['MotClefs'])){
    $motclefs = $_SESSION['MotClefs'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion Auteurs</title>
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
    <div class="container mt-5">

        <div class="row justify-content-center mt-4 align-items-center text-center">
            <div class="col-md-auto mb-2 ">
                <span class="mr-md-3">Nombre de mot-clef (<?php echo $NbMotClef ?>) </span>
            </div>
            <div class="col-md-auto mb-2">
                <a href="#" onclick="openForm()" class="btn btn-primary" style="background-color: #4682B4;">Ajouter un mot-clef</a>
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
                echo ' <div style="text-align: center" class="alert alert-danger" role="alert">
                              '.$message.'
                           </div>';
            }
        }
        ?>

        <div class="login-popup">
            <div class="form-popup" id="popupForm">
                <form action="../../src/controller/TraitMotClef.php" method="post">
                    <div class="form-group">
                        <label for="motCle">Mot-Clef</label>
                        <input type="text" class="form-control" id="motCle" name="motCle" required>
                    </div>

                    <button name="addMotCle" type="submit" class="btn btn-primary">Ajouter mot-clef</button>
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
        <h5 class="mb-3 mt-2">Tous les Mot-Clef répertorié dans nôtre Bibliothèque</h5>
        <div class="form-outline mb-4">
            <form action="../../src/controller/TraitMotClef.php" method="post">

                <input type="search" name="RechercheMotClef" placeholder="Rechercher un Mot-Clef"  class="form-control  mb-1">

                <div class="d-flex flex-column flex-md-row justify-content-start align-items-center text-center">
                    <input  type="submit" name="SearchMotClef" value="rechercher" class="form-control m-1">
                    <input type="submit" name="CancelSearchMotClef" value="Annuler La recherche" class="form-control m-1">
                </div>

            </form>
        </div>
        <div class="card  mt-3 mb-2">
            <div class="card-header py-3">
                <h6 style="color: #4682B4 "  class="m-0 font-weight-bold text-primary">Liste des Mot-Clef</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                            <th>Id Mot-Clef</th>
                            <th>Mot-Clef</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($motclefs as $mc): ?>
                            <tr>
                                <td><?php echo $mc->getIdMotCle(); ?></td>
                                <td><?php echo $mc->getMotCle(); ?></td>
                                <td style="text-align: center;">
                                    <form method="post" action="../../src/controller/TraitMotClef.php">
                                        <button class="btn btn-secondary" name="UpdateButton" value="<?php echo $mc->getIdMotCle()?>" type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <form method="post" action="../../src/controller/TraitMotClef.php">
                                        <button class="btn btn-danger" name="DeleteButton" value="<?php echo $mc->getIdMotCle()?>" type="submit">Supprimer</button>
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
                                <a href="../view/ListePageMotclef.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="../view/ListePageMotclef.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="../view/ListePageMotclef.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <hr class="hr mx-2 " />

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

