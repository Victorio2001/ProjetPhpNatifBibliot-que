<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\MotCle;
use MonApp\model\DAO\DAOMotCle;

$DAOMotCle = new DAOMotCle();
$MotCleEnt = new MotCle();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addMotCle'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'motCle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $MotCleEnt->setMotCle($motCle);

        if (is_null($motCle)) {
            $message = "Aucun mot-clef renseigné";
            header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\d/', $motCle)) {
            $message = "Le mot-clef ne doit pas contenir des chifres";
            header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
        }
        elseif (preg_match('/\W/', $motCle)) {
            $message = "Le mot-clef ne doit pas contenir des caractères spéciaux ";
            header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
        }else{
            if(strlen($motCle) > 49){
                $message = "Nombre de caractères trop élevés pour le mot-clef";
                header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
            }else{
                if($DAOMotCle->insertmotcle($MotCleEnt)) {
                    $message = "Ajout du mot-clef Correct !";
                    header("location: ../../src/view/ListePageMotclef.php?succes=AddTrue&message=" .$message);
                } else {
                    $message = "Echec ajout mot-clef !";
                    header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
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

    $result = $DAOMotCle->deletemotcle((int)$DeleteButton);
    if($result !== null || false){
        $message = "Suppresion effectuée avec succès !";
        header("location: ../../src/view/ListePageMotclef.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Le plan à echouééééé !";
        header('location: ../../src/view/ListePageMotclef.php?error=DeleteFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {
    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);


    $_SESSION['UpdateMotclef'] = $UpdateButton;

    if($_SESSION['UpdateMotclef'] !== null){
        header('location: ../../src/view/FormEditMotCle.php');
    }else{
        $message = "Erreur lors de la redirection";
        header('location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateMotClef'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'idMotCle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'motCle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

    $MotCleEnt->setIdMotCle($idMotCle);
    $MotCleEnt->setMotCle($motCle);

    if (is_null($motCle)) {
        $message = "Aucun nom renseigné";
        header("location: ../../src/view/FormEditMotCle.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\d/', $motCle)) {
        $message = "Le nom ne doit pas contenir des chifres";
        header("location: ../../src/view/FormEditMotCle.php?error=AddFalse&message=" .$message);
    }
    elseif (preg_match('/\W/', $motCle)) {
        $message = "Le nom ne doit pas contenir des caractères spéciaux ";
        header("location: ../../src/view/FormEditMotCle.php?error=AddFalse&message=" .$message);
    }else{
        if(strlen($motCle) > 49 ){
            $message = "Nombre de caractères trop élevés pour le nom de l'editeur";
            header("location: ../../src/view/FormEditMotCle.php?error=AddFalse&message=" .$message);
        }else{
            if($DAOMotCle->updatemotclef($MotCleEnt)) {
                $message = "Modification de l'editeur Correct !";
                header("location: ../../src/view/ListePageMotclef.php?succes=AddTrue&message=" .$message);
            } else {
                $message = "Echec de la modification de l'editeur !";
                header("location: ../../src/view/FormEditMotCle.php?succes=AddTrue&message=" .$message);
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SearchMotClef'])) {

    $filters = [
        'RechercheMotClef' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOMotCle->getMotCle($RechercheMotClef);

    if($result !== null || false){
        unset( $_SESSION['MotClefs']);
        $_SESSION['MotClefs'] = $result;
        if ($_SESSION['MotClefs'] == null)
        {
            $NbrMotClefTrouver = [];
        }
        $NbrMotClefTrouver = count( $_SESSION['MotClefs']);

        $message = $NbrMotClefTrouver." Mot(s)-Clef(s) trouvé(s)";
        header("location: ../../src/view/ListePageMotclef.php?succes=AddTrue&message=" .$message);
    }else{
        $message = "Aucun Mot-Clef trouver";
        header("location: ../../src/view/ListePageMotclef.php?error=AddFalse&message=" .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CancelSearchMotClef'])) {
    if(isset( $_SESSION['MotClefs'])){
        unset( $_SESSION['MotClefs']);
        header("location: ../../src/view/ListePageMotclef.php");
    }else{
        header("location: ../../src/view/ListePageMotclef.php");
    }
}