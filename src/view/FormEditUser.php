<?php
require_once("../../config/localConfig.php");
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DTO\Utilisateur;
if (isset($_SESSION['userLog'])){
$Daoutilisateur = new DAOUtilisateur();
$Utilisateur = new Utilisateur();

$MonUser = $Daoutilisateur->getUtilisateurById((int)$_SESSION['UpdateUser']);

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
    <h2 class="mb-4">Modification de l'utilisateur => <?php echo $MonUser->getNomUtilisateur()." ".$MonUser->getPrenomUtilisateur()  ?></h2>

    <form method="post" action="../../src/controller/TraitUser.php">

        <div class="form-group">
            <input type="hidden" value="<?php echo $MonUser->getIdUtilisateur() ?>" class="form-control" id="idUtilisateur" name="idUtilisateur" required>
        </div>

        <div class="form-group">
            <label for="nomUtilisateur">Nom de l'Utilisateur:</label>
            <input type="text" value="<?php echo $MonUser->getNomUtilisateur() ?>" class="form-control" id="nomUtilisateur" name="nomUtilisateur" required>
        </div>

        <div class="form-group">
            <label for="prenomUtilisateur">Prenom de l'Utilisateur:</label>
            <input type="text" value="<?php echo $MonUser->getPrenomUtilisateur() ?>" class="form-control" id="prenomUtilisateur" name="prenomUtilisateur" required>
        </div>

        <div class="form-group">
            <label for="passwordUtilisateur">Mot de passe de l'utilisateur:</label>
            <input type="text"  class="form-control" id="passwordUtilisateur" name="passwordUtilisateur" required>
        </div>

        <div class="form-group">
            <label for="emailUtilisateur">Email de l'Utilisateur:</label>
            <input type="email" class="form-control" value="<?php echo $MonUser->getEmailUtilisateur() ?>" id="emailUtilisateur" name="emailUtilisateur" required>
        </div>

        <div class="form-group">
            <label for="compteActif">Etat du compte :</label>
            <select class="form-control" id="compteActif" name="compteActif" required>
                <option value="<?php echo true ?>" <?php echo  $MonUser->getCompteActif() === true ? 'selected' : true; ?>>Compte Actif</option>
                <option value="<?php echo false ?>" <?php echo  $MonUser->getCompteActif() === false ? 'selected' : false; ?>>Compte Archiver</option>
            </select>
        </div>

        <div class="form-group">
            <label for="idRole">Role Utilisateur :</label>
            <select class="form-control" id="idRole" name="idRole" required>
                <option value="<?php echo -1 ?>" <?php echo  $MonUser->getRole()->getIdRole() == -1 ? 'selected' : ''; ?>>Gestionnaire</option>
                <option value="<?php echo -2 ?>" <?php echo  $MonUser->getRole()->getIdRole() == -2 ? 'selected' : ''; ?>>Formateur</option>
                <option value="<?php echo -3 ?>" <?php echo  $MonUser->getRole()->getIdRole() == -3 ? 'selected' : ''; ?>>Etudiant</option>
                <option value="<?php echo -4 ?>" <?php echo  $MonUser->getRole()->getIdRole() == -4 ? 'selected' : ''; ?>>Lecture Seulement</option>
            </select>
        </div>

        <button name="UpdateUser" type="submit" class="mt-2 btn btn-primary">Valider les modifications</button>
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

