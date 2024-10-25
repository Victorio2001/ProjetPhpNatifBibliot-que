<?php
require_once("../../config/localConfig.php");

use MonApp\model\DTO\LivreUtilisateur;
use MonApp\model\DAO\DAOLivreUtilisateur;
use MonApp\model\DTO\Utilisateur;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DTO\Livre;
use MonApp\model\DAO\DAOLivre;

$DAOLivre= new DAOLivre();
$Livre = new Livre();

$DAOUtilisateur = new DAOUtilisateur();
$Utilisateur = new Utilisateur();

$DAOLivreUtilisateur = new DAOLivreUtilisateur();
$LivreUtilisateur = new LivreUtilisateur();



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addRes'])) {

    $filters = [
        'dateReservation' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'dateEmprunt' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'dateRendu' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'nombreExemplaires' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'idUtilisateur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'IdLivre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];

    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $LivreUtilisateur->setDateReservation(date("Y-m-d"));
    $LivreUtilisateur->setEtatRes('En-attente');
    $LivreUtilisateur->setDateEmprunt(date("8000-08-08"));
    $LivreUtilisateur->setDateRendu(date("8000-08-08"));
    $LivreUtilisateur->setNbExemplaire((int)$nombreExemplaires);
    $LivreUtilisateur->setUtilisateur($DAOUtilisateur->getUtilisateurById((int)$idUtilisateur));
    $LivreUtilisateur->setLivre($DAOLivre->getLivreById((int)$IdLivre));

    $result = $DAOLivreUtilisateur->insertLivreUtilisateur($LivreUtilisateur);
    if($result !== null){
        $message = "Réservation effectuée avec succès";
        header('location: ../../src/view/ListeLivrePage.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Réservation erronée";
        header('location: ../../src/view/ListeLivrePage.php?error=AddFalse&message=' .$message);
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ValiderRes'])) {

    $filters = [
        'DateRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'LivreRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'User' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);
    $ChangStatRes = new \MonApp\model\DTO\LivreUtilisateur();
    $ChangStatRes->setDateReservation($DateRes);
    $ChangStatRes->setEtatRes("En-Cours");
    $ChangStatRes->setDateEmprunt(date('Y-m-d'));
    $ChangStatRes->setUtilisateur($DAOUtilisateur->getUtilisateurById((int)$User));
    $ChangStatRes->setLivre($DAOLivre->getLivreById((int)$LivreRes));

    $result = $DAOLivreUtilisateur->UpdateStatutEnCours($ChangStatRes);
    if($result !== null){
        $message = "Changement du statut de la réservation pour 'En-cours'";
        header('location: ../../src/view/ListeLivreUtilisateurPageAdmin.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Changement statut erronée";
        header('location: ../../src/view/ListeLivreUtilisateurPageAdmin.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['RendreRes'])) {

    $filters = [
        'DateRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'LivreRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'User' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);

    $RenduLivre = new \MonApp\model\DTO\LivreUtilisateur();
    $RenduLivre->setDateRendu(date("Y-m-d"));
    $RenduLivre->setEtatRes("Terminer");
    $RenduLivre->setDateReservation($DateRes);
    $RenduLivre->setUtilisateur($DAOUtilisateur->getUtilisateurById((int)$User));
    $RenduLivre->setLivre($DAOLivre->getLivreById((int)$LivreRes));

    $result = $DAOLivreUtilisateur->UpdateToRendu($RenduLivre);
    if($result !== null){
        $message = "Merci Pour le rendu du livre à bientôt";
        header('location: ../../src/view/listeReservationPage.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Rendu erronée";
        header('location: ../../src/view/listeReservationPage.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ArchiRes'])) {
    $filters = [
        'DateRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'User' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'livre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'NbRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);
    $monLivreUserUpdate = new \MonApp\model\DTO\LivreUtilisateur();
    $monLivreUserUpdate->setDateReservation($DateRes);
    $monLivreUserUpdate->setUtilisateur($DAOUtilisateur->getUtilisateurById((int)$User));
    $monLivreUserUpdate->setLivre($DAOLivre->getLivreById((int)$livre));
    $monLivreUserUpdate->setNbExemplaire($NbRes);

    $result = $DAOLivreUtilisateur->ArchivageLivreUtilisateur($monLivreUserUpdate);
    if($result !== null){
        $message = "Archivage effectuée avec succès";
        header('location: ../../src/view/ListeLivreUtilisateurPageAdmin.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Archivage erronée";
        header('location: ../../src/view/ListeLivreUtilisateurPageAdmin.php?error=AddFalse&message=' .$message);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['AnnulationRes'])) {

    $filters = [
        'DateRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'LivreRes' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'User' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $sanitized_data = filter_input_array(INPUT_POST, $filters);
    extract($sanitized_data, EXTR_SKIP);
    $maResAnnuler = new \MonApp\model\DTO\LivreUtilisateur();
    $maResAnnuler->setDateReservation($DateRes);
    $maResAnnuler->setUtilisateur($DAOUtilisateur->getUtilisateurById((int)$User));
    $maResAnnuler->setLivre($DAOLivre->getLivreById((int)$LivreRes));

    $result = $DAOLivreUtilisateur->DeleteReservation($maResAnnuler);
    if($result !== null){
        $message = "Anulation Effectuée Avec Succès";
        header('location: ../../src/view/ListeReservationPage.php?succes=AddTrue&message=' .$message);
    }else{
        $message = "Anulation erronée";
        header('location: ../../src/view/ListeReservationPage.php?error=AddFalse&message=' .$message);
    }
}