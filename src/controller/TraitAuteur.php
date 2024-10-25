<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\Auteur;
use MonApp\model\DAO\DAOAuteur;

$DAOAuteur = new DAOAuteur();
$Auteur = new Auteur();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addAuteur'])) {
        //Filtrage des données percues par le formulaire
        $filters = [
            'nomAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'prenomAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $Auteur->setNomAuteur($nomAuteur);
        $Auteur->setPrenomAuteur($prenomAuteur);

        if (is_null($prenomAuteur) || is_null($nomAuteur)) {
            $message = "Aucun prénom/nom renseigné";
            header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\d/', $prenomAuteur) || preg_match('/\d/', $nomAuteur)) {
            $message = "Le nom ou prenom ne doit pas contenir des chifres";
            header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\W/', $prenomAuteur) || preg_match('/\W/', $nomAuteur)) {
            $message = "Le nom ou prenom ne doit pas contenir des caractères spéciaux ";
            header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
        }else{
            if(strlen($nomAuteur) > 49 || strlen($prenomAuteur) > 49){
                $message = "Nombre de caractères trop élevés pour le nom/prénom de l'auteur";
                header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
            }else{
                if($DAOAuteur->insertAuteur($Auteur)) {
                    $message = "Ajout de l'auteur Correct !";
                    header("location: ../../src/view/ListePageAuteur.php?succes=AddTrue&message=" .$message);
                } else {
                    $message = "Echec de l'ajout de l'auteur !";
                    header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
                }
            }
        }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteButton'])) {

    $filters = [
        'DeleteButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOAuteur->deleteauteur((int)$DeleteButton);
    if($result !== null || false){
        $message = "Suppresion effectuée avec succès !";
        header("location: ../../src/view/ListePageAuteur.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Le plan à echouééééé !";
        header('location: ../../src/view/ListePageAuteur.php?error=DeleteFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {
    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);


    $_SESSION['UpdateAuteur'] = $UpdateButton;

    if($_SESSION['UpdateAuteur'] !== null){
        header('location: ../../src/view/FormEditAuteur.php');
    }else{
        $message = "Erreur lors de la redirection";
        header('location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateAuteur'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'idAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nomAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'prenomAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $Auteur->setIdAuteur($idAuteur);
        $Auteur->setNomAuteur($nomAuteur);
        $Auteur->setPrenomAuteur($prenomAuteur);





    if (is_null($prenomAuteur) || is_null($nomAuteur)) {
        $message = "Aucun prénom/nom renseigné";
        header("location: ../../src/view/FormEditAuteur.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\d/', $prenomAuteur) || preg_match('/\d/', $nomAuteur)) {
        $message = "Le nom ou prenom ne doit pas contenir des chifres";
        header("location: ../../src/view/FormEditAuteur.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\W/', $prenomAuteur) || preg_match('/\W/', $nomAuteur)) {
        $message = "Le nom ou prenom ne doit pas contenir des caractères spéciaux ";
        header("location: ../../src/view/FormEditAuteur.php?error=AddFalse&message=" .$message);
    }else{
        if(strlen($nomAuteur) > 49 || strlen($prenomAuteur) > 49){
            $message = "Nombre de caractères trop élevés pour le nom/prénom de l'auteur";
            header("location: ../../src/view/FormEditAuteur.php?error=AddFalse&message=" .$message);
        }else{
            if($DAOAuteur->updateauteur($Auteur)) {
                $message = "Modification de l'auteur Correct !";
                header("location: ../../src/view/ListePageAuteur.php?succes=AddTrue&message=" .$message);
            } else {
                $message = "Echec de la modification de l'auteur !";
                header("location: ../../src/view/FormEditAuteur.php?succes=AddTrue&message=" .$message);
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SearchAuteur'])) {

    $filters = [
        'RechercheAuteur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOAuteur->getnomauteur($RechercheAuteur);

    if($result !== null || false){
        unset( $_SESSION['Auteurs']);
        $_SESSION['Auteurs'] = $result;
        if ($_SESSION['Auteurs'] == null)
        {
            $NbrLivreTrouver = [];
        }
        $NbrLivreTrouver = count( $_SESSION['Auteurs']);

        $message = $NbrLivreTrouver." livre(s) trouvé(s)";
        header("location: ../../src/view/ListePageAuteur.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Aucun Livre trouver";
        header("location: ../../src/view/ListePageAuteur.php?error=AddFalse&message=" .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CancelSearchAuteur'])) {
    if(isset( $_SESSION['Auteurs'])){
        unset( $_SESSION['Auteurs']);
        header("location: ../../src/view/ListePageAuteur.php");
    }else{
        header("location: ../../src/view/ListePageAuteur.php");
    }
}