<?php
require_once("../../config/localConfig.php");
use MonApp\model\DAO\DAOLivre;
use MonApp\model\DTO\Livre;
if (isset($_SESSION['userLog'])){
$Daolivre= new DAOLivre();
$Livre = new Livre();

$MonLivre = $Daolivre->getLivreById((int)$_SESSION['UpdateLivre']);
var_dump($MonLivre);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formulaire Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../public/css/DefaultStyle.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/ListePage.css">
    <style>
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
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
    <h2 class="mb-4">Modification du Livre || "<?php echo $MonLivre->getTitreLivre()?>"</h2>

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
    <form method="post" action="../../src/controller/TraitLivre.php" enctype="multipart/form-data">

        <div class="form-group">
            <input type="hidden" value="<?php echo $MonLivre->getIdLivre() ?>" class="form-control" id="idLivre" name="idLivre" required>
        </div>

        <div class="form-group">
            <label for="titreLivre">Titre du Livre:</label>
            <input type="text" value="<?php echo $MonLivre->getTitreLivre() ?>" class="form-control" id="titreLivre" name="titreLivre" required>
        </div>

        <div class="form-group">
            <label for="resumeLivre">Resume du Livre:</label>
<!--            <input type="text" value="--><?php //echo $MonLivre->getResumeLivre() ?><!--"  class="form-control" id="resumeLivre" name="resumeLivre" required>-->
            <textarea class="form-control"  id="resumeLivre" name="resumeLivre" rows="3"><?php echo $MonLivre->getResumeLivre() ?></textarea>
        </div>

        <div class="form-group">
            <label for="anneePublication">Anne de Publication:</label>
            <input type="date" value="<?php echo $MonLivre->getAnneePublication("Y-m-d") ?>"  class="form-control" id="anneePublication" name="anneePublication" required>
        </div>

        <div class="form-group">
            <label for="nombreExemplaires">Nombre d'exemplaire:</label>
            <input type="number" class="form-control" value="<?php echo $MonLivre->getNombreExemplaires() ?>" id="nombreExemplaires" name="nombreExemplaires" required>
        </div>

        <div class="form-group">
            <label for="isbn">Isbn:</label>
            <input type="number" class="form-control" value="<?php echo $MonLivre->getIsbn() ?>" id="isbn" name="isbn" required>
        </div>

        <div class="form-group">
            <label for="imageCouverture">Image de Couverture:</label>
            <div class="d-flex">
                <input type="file" class="form-control"   id="imageCouverture" name="imageCouverture" required>
                <img style="height: 100px;object-fit: fill; width: 100px;" src="../../public/img/<?php echo $MonLivre->getImageCouverture() ?>" alt="Image">
            </div>
        </div>

        <button name="UpdateLivre" type="submit" class="mt-2 btn btn-primary">Valider les modifications</button>
    </form>
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

