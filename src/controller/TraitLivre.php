<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\Livre;
use MonApp\model\DAO\DAOLivre;

$DAOLivre = new DAOLivre();
$Livre = new Livre();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addLivre'])) {
    if(!empty($_FILES['imageCouverture']['name'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'titreLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'resumeLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'anneePublication' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nombreExemplaires' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'isbn' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'imageCouverture' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $img_nom = $_FILES['imageCouverture']['name'];
        $tmp_nom = $_FILES['imageCouverture']['tmp_name'];
        //prendre le temps actuel afin de le fusionner avec le nom de l'image et rendre celui-ci presque Unique.
        $time = time();
        $nouveau_nom_img = $time . '_' . $img_nom;
        $target_dir = "../../public/img/";
        //Chemin ou stocker l'image
        $target_file = $target_dir . $nouveau_nom_img;

        //Check taille image
        if ($_FILES['imageCouverture']['size'] > 1000000) {
            $message = "Veuillez choisir une image avec une taille inférieure à 1Mo !";
            header("location: ../../src/view/listeLivrePageAdmin.php?error=AddFalse&message=" .$message);
        } else {
            if (move_uploaded_file($tmp_nom, $target_file)) {

                $Livre->setTitreLivre($titreLivre);
                $Livre->setResumeLivre($resumeLivre);
                $Livre->setAnneePublication($anneePublication);
                $Livre->setNombreExemplaires($nombreExemplaires);
                $Livre->setIsbn((int)$isbn);
                $Livre->setImageCouverture($nouveau_nom_img);

                if($DAOLivre->insertLivre($Livre)) {
                    $message = "Ajout du Livre Correct !";
                    header("location: ../../src/view/listeLivrePageAdmin.php?succes=AddTrue&message=" .$message);
                } else {
                    $message = "Echec de l'ajout du Livre !";
                    header("location: ../../src/view/listeLivrePageAdmin.php?error=AddFalse&message=" .$message);
                }
            } else {
                $message = "Erreur lors du déplacement de l'image.";
                header("location: ../../src/view/listeLivrePageAdmin.php?error=AddFalse&message=" .$message);
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs y compris l'image !";
        header("location: ../../src/view/listeLivrePageAdmin.php?error=AddFalse&message=" .$message);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateLivre'])) {
    if(!empty($_FILES['imageCouverture']['name'])) {

        //Filtrage des données percues par le formulaire
        $filters = [
            'idLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'titreLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'resumeLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'anneePublication' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nombreExemplaires' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'isbn' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'imageCouverture' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        //Filtrage + Convertion en variables des champs percues.
        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $img_nom = $_FILES['imageCouverture']['name'];
        $tmp_nom = $_FILES['imageCouverture']['tmp_name'];
        //prendre le temps actuel afin de le fusionner avec le nom de l'image et rendre celui-ci presque Unique.
        $time = time();
        $nouveau_nom_img = $time . '_' . $img_nom;
        $target_dir = "../../public/img/";
        //Chemin ou stocker l'image
        $target_file = $target_dir . $nouveau_nom_img;

        //Check taille image
        if ($_FILES['imageCouverture']['size'] > 1000000) {
            $message = "Veuillez choisir une image avec une taille inférieure à 1Mo !";
            header("location: ../../src/view/FormEditLivre.php?error=AddFalse&message=" .$message);
        } else {
            if (move_uploaded_file($tmp_nom, $target_file)) {

                $Livre->setIdLivre($idLivre);
                $Livre->setTitreLivre($titreLivre);
                $Livre->setResumeLivre($resumeLivre);
                $Livre->setAnneePublication($anneePublication);
                $Livre->setNombreExemplaires($nombreExemplaires);
                $Livre->setIsbn((int)$isbn);
                $Livre->setImageCouverture($nouveau_nom_img);

                if($DAOLivre->updateLivre($Livre)) {
                    $message = "Modification du Livre Correct !";
                    header("location: ../../src/view/listeLivrePageAdmin?succes=AddTrue&message=" .$message);
                } else {
                    $message = "Echec de la modification du livre !";
                    header("location: ../../src/view/FormEditLivre.php?error=AddFalse&message=" .$message);
                }
            } else {
                $message = "Erreur lors du déplacement de l'image.";
                header("location: ../../src/view/FormEditLivre.php?error=AddFalse&message=" .$message);
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs y compris l'image !";
        header("location: ../../src/view/FormEditLivre.php?error=AddFalse&message=" .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {
    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $_SESSION['UpdateLivre'] = $UpdateButton;

    if($_SESSION['UpdateLivre'] !== null){
        header('location: ../../src/view/FormEditLivre.php');
    }else{
        header('location: ../../src/view/listeUserPage.php');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteButton'])) {

    $filters = [
        'DeleteButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOLivre->deleteLivre((int)$DeleteButton);
    if($result !== null || false){
        $message = "Suppresion effectuée avec succès !";
        header("location: ../../src/view/listeLivrePageAdmin.php?succes=AddTrue&message=" .$message);
    }else{
        header('location: ../../src/view/listeUserPage.php?error=DeleteFalse');
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SearchBook'])) {

    $filters = [
        'IamLookingForABookPlsSir' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $result = $DAOLivre->getLivreByTitle($IamLookingForABookPlsSir);

    if($result !== null || false){
        unset( $_SESSION['Books']);
        $_SESSION['Books'] = $result;

        header("location: ../../src/view/ListeLivrePage.php?book=" .$book);
    }else{
        $message = "Aucun Livre trouver";
        header("location: ../../src/view/ListeLivrePage.php?message=" .$message);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CancelSearchBook'])) {
    if(isset( $_SESSION['Books'])){
        unset( $_SESSION['Books']);
        header("location: ../../src/view/ListeLivrePage.php");
    }else{
        header("location: ../../src/view/ListeLivrePage.php");
    }
}