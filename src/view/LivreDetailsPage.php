<?php
require_once '../../config/localConfig.php';
use MonApp\model\DAO\DAOLivre;
use MonApp\model\DAO\DAOAuteur;
use MonApp\model\DTO\Livre;
use MonApp\model\DTO\MotCleLivre;
use MonApp\model\DAO\DAOMotCleLivre;
use MonApp\model\DAO\DAOMotCle;

if (isset($_SESSION['userLog'])){
$DaoMotCleLivre = new DAOMotCleLivre();
$daomoclef = new DAOMotCle();
$monLivre = new Livre();
$motcleflivre = new MotCleLivre();

if (isset($_GET['idLivre'])) {
    $idLivre = $_GET['idLivre'];
    $user = $_SESSION['userLog'];
    $userId = $user->getIdUtilisateur();
    $userRole = $user->getRole()->getNomRole();
}

$MonLivre = new Livre();
$MonDaoLivre = new DAOLivre();
$MonDAOAuteur = new DAOAuteur();

$Livre = $MonDaoLivre->getLivreById($idLivre);



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
    <!-- PopUpRes-->
    <div class="login-popup">
        <div class="form-popup" id="popupForm">
            <form action="../../src/controller/TraitLivreUtilisateur.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <?php
                    if ($userRole == "gestionnaire" || $userRole == "etudiant") {
                        echo '
                            <p> Votre statut vous permet l\'emprunt d\'un seul livre </p>
                            <div class="form-group">
                                <label for="nombreExemplaires">Nombre d\'exemplaire</label>
                                <input type="number" value=1 class="form-control" id="nombreExemplaires" name="nombreExemplaires" readonly>
                            </div>
                            ';
                    }
                    if ($userRole == "formateur") {
                        echo '
                            <div class="form-group">
                                <label for="nombreExemplaires">Nombre d\'exemplaire</label>
                                <input type="number" class="form-control" id="nombreExemplaires" name="nombreExemplaires" required>
                            </div>
                            ';
                    }
                    ?>
                    <div class="form-group">
                        <input type="hidden" value="<?php echo $userId ?>" class="form-control" id="idUtilisateur" name="idUtilisateur" required>
                        <input type="hidden" value="<?php echo $idLivre ?>" class="form-control" id="IdLivre" name="IdLivre" required>
                    </div>
                    <button name="addRes" type="submit" style="background-color: #4682B4;" class="btn btn-primary">Soumettre Reservation</button>
                    <button type="button" class="btn btn-light" onclick="closeForm()">Fermer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- EndPopUpRes-->

    <div class="p-2">
        <div class="mt-4 mx-2 d-flex flex-column flex-md-row justify-content-center align-items-center ">
            <div class="mx-md-5 mb-3 mb-md-0 mw-50 w-100" >
                <img style="border-radius: 15px; max-height: 450px; width: 350px" class="mt-0 mx-auto" src="../../public/img/<?php echo $Livre->getImageCouverture() ?>" alt="Image">
            </div>
            <div class="d-flex flex-column justify-content-start align-items-start">
                <p class="mt-2">Titre du Livre : <a style="color: #4682B4;"><?php echo $Livre->getTitreLivre() ?></a></p>
                <p class="mt-0.5">Nombres d'exemplaires : <a style="color: #4682B4;"><?php echo $Livre->getNombreExemplaires() ?></a></p>
                <p class="mt-0.5">Isbn : <a style="color: #4682B4;"><?php echo $Livre->getIsbn() ?></a></p>
                <p class="mt-0.5">Editeur : <a style="color: #4682B4;">Glénat (???)</a></p>
                <p class="mt-0.5">Auteur : <a style="color: #4682B4;">Heichiro oda</a></p>
                <p class="mt-0.5">Année de Publication : <a style="color: #4682B4;"><?php echo $Livre->getAnneePublication("Y-m-d") ?></a></p>
                <p class="mt-0.5">Genre(s) :
                    <?php
                    /*C'est pas super propre mais je voyais pas trop comment faire sa vite*/
                        $motcleflivre->setLivre($MonDaoLivre->getLivreById($Livre->getIdLivre()));
                        $repoMotCleLivre = $DaoMotCleLivre->getMotCleLivreByLivre($motcleflivre);
                        if ($repoMotCleLivre == null){
                            $repoMotCleLivre = [];
                        }
                        foreach ($repoMotCleLivre as $motClef):
                            echo '<span style=" background-color: #4682B4" class="badge ">'.$motClef->getMotCle()->getMotCle().'</span>';
                        endforeach
                        ?>
                <p class="mt-0.5">Résumer: <a style="color: #4682B4;"><?php echo $Livre->getResumeLivre() ?></a></p>
                <?php
                $EtatNbLivre = $Livre->getNombreExemplaires();
                if($EtatNbLivre == 0){
                    echo '
                        <div class="col-md-auto mb-2">
                            <button type="submit" onClick="alert(\'Livre non disponible à ce jour\');" style="background-color: #4682B4;" class="btn btn-primary w-100 mb-1">Non disponible</button>
                        </div>
                        ';
                }else{
                    echo '
                        <div class="col-md-auto mb-2  d-flex flex-column flex-md-row justify-content-center align-items-center">
                            <button type="submit" onclick="openForm()" style="background-color: #4682B4;" class="btn btn-primary w-100 mb-1">Réserver ce livre</button>
                        </div>
                        ';
                }
                ?>
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
<script>
    function openForm() {
        document.getElementById("popupForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("popupForm").style.display = "none";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
    <?php
}else{
    $message = "Erreur (re-)connectez-vous";
    header('location: ../../src/view/Connection.php?error=AddFalse&message=' .$message);
}

