<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\Editeur;
use MonApp\model\DAO\DAOEditeur;

$DAOEditeur = new DAOEditeur();
$Editeur = new Editeur();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addEditeur'])) {
        //Filtrage des données percues par le formulaire
        $filters = [
            'nomEditeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $Editeur->setNomEditeur($nomEditeur);

        if (is_null($nomEditeur)) {
            $message = "Aucun nom renseigné";
            header("location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\d/', $nomEditeur)) {
            $message = "Le nom ne doit pas contenir des chifres";
            header("location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\W/', $nomEditeur)) {
            $message = "Le nom ne doit pas contenir des caractères spéciaux ";
            header("location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=" .$message);
        }else{
            if(strlen($nomEditeur) > 49){
                $message = "Nombre de caractères trop élevés pour le nom l'editeur";
                header("location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=" .$message);
            }else{
                if($DAOEditeur->insertediteur($Editeur)) {
                    $message = "Ajout de l'editeur Correct !";
                    header("location: ../../src/view/ListePageEditeur.php?succes=AddTrue&message=" .$message);
                } else {
                    $message = "Echec de l'ajout de l'editeur !";
                    header("location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=" .$message);
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

    $result = $DAOEditeur->deleteediteur((int)$DeleteButton);
    if($result !== null || false){
        $message = "Suppresion effectuée avec succès !";
        header("location: ../../src/view/ListePageEditeur.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Le plan à echouééééé !";
        header('location: ../../src/view/ListePageEditeur.php?error=DeleteFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {
    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);


    $_SESSION['UpdateEditeur'] = $UpdateButton;

    if($_SESSION['UpdateEditeur'] !== null){
        header('location: ../../src/view/FormEditEditeur.php');
    }else{
        $message = "Erreur lors de la redirection";
        header('location: ../../src/view/ListePageEditeur.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateEditeur'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'idEditeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nomEditeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

    $Editeur->setIdEditeur($idEditeur);
    $Editeur->setNomEditeur($nomEditeur);

    if (is_null($nomEditeur)) {
        $message = "Aucun nom renseigné";
        header("location: ../../src/view/FormEditEditeur.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\d/', $nomEditeur)) {
        $message = "Le nom ne doit pas contenir des chifres";
        header("location: ../../src/view/FormEditEditeur.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\W/', $nomEditeur)) {
        $message = "Le nom ne doit pas contenir des caractères spéciaux ";
        header("location: ../../src/view/FormEditEditeur.php?error=AddFalse&message=" .$message);
    }else{
        if(strlen($nomEditeur) > 49 ){
            $message = "Nombre de caractères trop élevés pour le nom de l'editeur";
            header("location: ../../src/view/FormEditEditeur.php?error=AddFalse&message=" .$message);
        }else{
            if($DAOEditeur->updateediteur($Editeur)) {
                $message = "Modification de l'editeur Correct !";
                header("location: ../../src/view/listePageEditeur.php?succes=AddTrue&message=" .$message);
            } else {
                $message = "Echec de la modification de l'editeur !";
                header("location: ../../src/view/FormEditEditeur.php?succes=AddTrue&message=" .$message);
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SearchEditeur'])) {

    $filters = [
        'RechercheEditeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOEditeur->getnomediteur($RechercheEditeur);

    if($result !== null || false){
        unset( $_SESSION['Editeurs']);
        $_SESSION['Editeurs'] = $result;
        if ($_SESSION['Editeurs'] == null)
        {
            $NbrEditeurTrouver = [];
        }
        $NbrEditeurTrouver = count( $_SESSION['Editeurs']);

        $message = $NbrEditeurTrouver." editeur(s) trouvé(s)";
        header("location: ../../src/view/listePageEditeur.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Aucun Editeur trouver";
        header("location: ../../src/view/listePageEditeur.php?error=AddFalse&message=" .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CancelSearchEditeur'])) {
    if(isset( $_SESSION['Editeurs'])){
        unset( $_SESSION['Editeurs']);
        header("location: ../../src/view/listePageEditeur.php");
    }else{
        header("location: ../../src/view/listePageEditeur.php");
    }
}