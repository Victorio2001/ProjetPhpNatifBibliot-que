<?php
require_once("../../config/localConfig.php");
use MonApp\model\DAO\DAOEditeur;
use MonApp\model\DTO\Editeur;
if (isset($_SESSION['userLog'])){
$DaoEditeur = new DAOEditeur();
$Editeur = new Editeur();

$MonEditeur = $DaoEditeur->getEditeurById((int)$_SESSION['UpdateEditeur']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formulaire Auteur</title>
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
    <h2 class="mb-4">Modification de l'editeur || "<?php echo $MonEditeur->getNomEditeur()?>"</h2>

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
    <form method="post" action="../../src/controller/TraitEditeur.php" enctype="multipart/form-data">

        <div class="form-group">
            <input type="hidden" value="<?php echo $MonEditeur->getIdEditeur() ?>" class="form-control" id="idEditeur" name="idEditeur" required>
        </div>

        <div class="form-group">
            <label for="nomEditeur">Nom Editeur:</label>
            <input type="text" value="<?php echo $MonEditeur->getNomEditeur() ?>" class="form-control" id="nomEditeur" name="nomEditeur" required>
        </div>

        <button name="UpdateEditeur" type="submit" class="mt-2 btn btn-primary">Valider les modifications</button>
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

