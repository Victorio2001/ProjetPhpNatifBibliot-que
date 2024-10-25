<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOTransaction;
use MonApp\model\DAO\DAOLivre;
if (isset($_SESSION['userLog'])){
$user = $_SESSION['userLog'];
$DaoTransaction = new DAOTransaction();
$userRole = $user->getRole()->getNomRole();
$nomUser = $user->getNomUtilisateur();

// Comment faire une pagination en php :https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}
$repoTrans = $DaoTransaction->getAllTransaction();
if($repoTrans == null)
    $repoTrans = [];
$nbTrans = count($repoTrans);

$NbrTransParPage = 5;
$pages = ceil($nbTrans / $NbrTransParPage);
$premier = ($currentPage * $NbrTransParPage) - $NbrTransParPage;
$Transactions = $DaoTransaction->getTransactionPagination($NbrTransParPage, $premier);

//récuperation des Livres
$DAOLivre= new DAOLivre();
$LIvres = $DAOLivre->getAllLivre();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestion Transactions</title>
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
                <span class="mr-md-3">Nombre de transactions (<?php echo $nbTrans ?>) </span>
            </div>
            <div class="col-md-auto mb-2">
                <a href="#" onclick="openForm()" class="btn btn-primary" style="background-color: #4682B4;">Ajouter une transaction</a>
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

        <div class="login-popup">
            <div class="form-popup" id="popupForm">
                <form action="../../src/controller/TraitTransaction.php" method="post">
                    <div class="form-group">
                        <label for="nbLivreAjoute">Nombre de livre à ajouter</label>
                        <input type="text" class="form-control" id="nbLivreAjoute" name="nbLivreAjoute" required>
                    </div>
                    <div class="form-group">
                        <label for="nbLivreEnlever">Nombre de livre à enlever</label>
                        <input type="text" class="form-control" id="nbLivreEnlever" name="nbLivreEnlever" required>
                    </div>
                    <div class="form-group">
                        <input name="idUtilisateur" id="idUtilisateur" value="<?php echo $user->getIdUtilisateur() ?>" type="hidden">
                    </div>
                    <div class="form-group">
                        <label for="IdLivre">Livre :</label>
                        <select class="form-control" id="IdLivre" name="IdLivre" required>
                            <?php foreach ($LIvres as $livre): ?>
                                <option value="<?php echo $livre->getIdLivre() ?>"><?php echo $livre->getTitreLivre() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button name="addTransaction" type="submit" class="btn btn-primary">Effectuer Transaction</button>
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

        <div class="card  mt-3 mb-2">
            <div class="card-header py-3">
                <h6 style="color: #4682B4 "  class="m-0 font-weight-bold text-primary">Liste des transactions</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr style="white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 120px;">
                            <th>Id Transaction</th>
                            <th>Nombre de livre ajouter</th>
                            <th>Nombre de livre enlever</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Transactions as $trans): ?>
                            <tr>
                                <td><?php echo $trans->getIdTransaction(); ?></td>
                                <td><?php echo $trans->getNbLivreAjoute(); ?></td>
                                <td><?php echo $trans->getNbLivreEnlever(); ?></td>
                                <td>
                                <?php
                                $user = $trans->getUtilisateur()->getNomUtilisateur();
                                if ($user === null)
                                    echo "Utilisateur null";
                                else
                                    echo $user;
                                ?></td>
                                <td><?php echo $trans->getLivre()->getTitreLivre() ?></td>
                                <td style="text-align: center;">
                                    <form method="post" action="../../src/controller/TraitTransaction.php">
                                        <button class="btn btn-secondary" name="UpdateButton" value="<?php echo $trans->getIdTransaction(); ?>" type="submit">Modifier</button>
                                    </form>
                                </td>
                                <td style="text-align: center;">
                                    <form method="post" action="../../src/controller/TraitTransaction.php">
                                        <button class="btn btn-danger" name="DeleteButton" value="<?php echo $trans->getIdTransaction(); ?>" type="submit">Supprimer</button>
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
                                <a href="../view/listeTransactionPageAdmin.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                            </li>
                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                    <a href="../view/listeTransactionPageAdmin.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                </li>
                            <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                <a href="../view/listeTransactionPageAdmin.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
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

