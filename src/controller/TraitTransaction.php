<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\Transaction;
use MonApp\model\DAO\DAOTransaction;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAOLivre;

$DAOTransaction = new DAOTransaction();
$daoLivre = new DAOLivre();
$daoUtilisateur = new DAOUtilisateur();
$Transaction = new Transaction();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addTransaction'])) {
        //Filtrage des données percues par le formulaire
        $filters = [
            'nbLivreAjoute' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nbLivreEnlever' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'idUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'IdLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ];

        $sanitized_data = filter_input_array(INPUT_POST, $filters);
        extract($sanitized_data, EXTR_SKIP);

        $Transaction->setNbLivreEnlever($nbLivreEnlever);
        $Transaction->setNbLivreAjoute($nbLivreAjoute);
        $Transaction->setUtilisateur($daoUtilisateur->getUtilisateurById((int)$idUtilisateur));
        $Transaction->setLivre($daoLivre->getLivreById((int)$IdLivre));

        if($DAOTransaction->insertTransaction($Transaction)) {
            $message = "Ajout de la transaction Correct !";
            header("location: ../../src/view/listeTransactionPageAdmin.php?succes=AddTrue&message=" .$message);
        } else {
            $message = "Echec de l'ajout de la transaction !";
            header("location: ../../src/view/listeTransactionPageAdmin.php?error=AddFalse&message=" .$message);
        }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteButton'])) {

    //Filtrage des données percues par le formulaire
    $filters = [
        'DeleteButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $Transaction->setIdTransaction((int)$DeleteButton);

    if($DAOTransaction->deleteTransaction($Transaction)) {
        $message = "Suppression de la transaction Correct !";
        header("location: ../../src/view/listeTransactionPageAdmin.php?succes=AddTrue&message=" .$message);
    } else {
        $message = "Echec de la Suppression!";
        header("location: ../../src/view/listeTransactionPageAdmin.php?error=AddFalse&message=" .$message);
    }
}

/**************************************************/
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateButton'])) {

    $filters = [
        'UpdateButton' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);
    unset($_SESSION['UpdateTransaction']);
    $_SESSION['UpdateTransaction'] = $UpdateButton;

    if($_SESSION['UpdateTransaction'] !== null){
        header('location: ../../src/view/FormEditTransaction.php');
    }else{
        $message = "Echec lors de la redirection !!";
        header('location: ../../src/view/FormEditTransaction.php?error=AddFalse&message=' .$message);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['UpdateTransaction'])) {


    $filters = [
        'nbLivreAjoute' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'nbLivreEnlever' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'idTransaction' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'IdLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'idUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $Transaction->setNbLivreEnlever($nbLivreEnlever);
    $Transaction->setNbLivreAjoute($nbLivreAjoute);
    $Transaction->setIdTransaction($idTransaction);
    $Transaction->setUtilisateur($daoUtilisateur->getUtilisateurById((int)$idUtilisateur));
    $Transaction->setLivre($daoLivre->getLivreById((int)$IdLivre));

    $result = $DAOTransaction->UpdateTransaction($Transaction);
    if($result !== null){
        $message = "Modification effectuée avec succès.";
        header('location: ../../src/view/listeTransactionPageAdmin.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Modification erronée.";
        header('location: ../../src/view/listeTransactionPageAdmin.php?error=AddFalse&message=' .$message);
    }

}

