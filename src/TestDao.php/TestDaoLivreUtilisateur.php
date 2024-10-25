<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\LivreUtilisateur;
use MonApp\model\DAO\DAOLivreUtilisateur;
use MonApp\model\DTO\Utilisateur;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAOLivre;

$DaoUtilisateur = new DAOUtilisateur();
$DaoLivre = new DAOLivre();
$DaoLivreUtilisateur = new DAOLivreUtilisateur();
$LivreUtilisateur = new LivreUtilisateur();

$MonUser = $DaoUtilisateur->getUtilisateurById(-1);
$MonLivre = $DaoLivre->getLivreById(-1);

echo 'GetAllLivreUtilisateur';
$repoLivreUtilisateurs= $DaoLivreUtilisateur->getAllLivreUtilisateur();
var_dump($repoLivreUtilisateurs);

echo 'GetAllLivreUtilisateurEnAttente';
$repoLivreUtilisateursEnattente= $DaoLivreUtilisateur->getAllLivreUtilisateurEnAttente();
var_dump($repoLivreUtilisateursEnattente);

echo 'GetByIdLivreUtilisateur';
$LivreUtilisateur->setUtilisateur($MonUser);
$LivreUtilisateur->setLivre($MonLivre);
$LivreUtilisateur->setDateReservation('2024-12-12');
$repoLivreUtilisateur= $DaoLivreUtilisateur->getReservationById($LivreUtilisateur);
var_dump($repoLivreUtilisateur);

echo 'GetByIdLivreUtilisateur';
$LivreUtilisateur->setUtilisateur($MonUser);
$repoLivreUtilisateurID= $DaoLivreUtilisateur->getReservationByIdUser($LivreUtilisateur);
var_dump($repoLivreUtilisateurID);

echo 'InserLivreUtilisateur';
try{
    $LivreUtilisateur->setDateReservation('2025-12-12');
    $LivreUtilisateur->setDateRendu('2027-12-12');
    $LivreUtilisateur->setNbExemplaire(1);
    $LivreUtilisateur->setDateEmprunt('2023-12-12');
    $LivreUtilisateur->setUtilisateur($DaoUtilisateur->getUtilisateurById((int)-1));
    $LivreUtilisateur->setLivre($DaoLivre->getLivreById((int)-1));

    $insertLivreUtilisateur = $DaoLivreUtilisateur->insertLivreUtilisateur($LivreUtilisateur);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe");
}

echo 'UpdateLivreUtilisateur';
$monLivreUserUpdate = new \MonApp\model\DTO\LivreUtilisateur();
try{
    $monLivreUserUpdate->setDateReservation('2025-12-12');
    $monLivreUserUpdate->setUtilisateur($DaoUtilisateur->getUtilisateurById((int)-1));
    $monLivreUserUpdate->setLivre($DaoLivre->getLivreById((int)-1));

    $monLivreUserUpdate->setArchiver((bool)true);
    $monLivreUserUpdate->setDateRendu('2027-12-12');
    $monLivreUserUpdate->setNbExemplaire(180);
    $monLivreUserUpdate->setDateEmprunt('2023-12-12');

    $updateLivreUtilisateur = $DaoLivreUtilisateur->updateLivreUtilisateur($monLivreUserUpdate);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Update)");
}


echo 'ArchivageLivreUtilisateur';
$monLivreUserUpdate = new \MonApp\model\DTO\LivreUtilisateur();
try{
    $monLivreUserUpdate->setDateReservation('2024-01-03');
    $monLivreUserUpdate->setUtilisateur($DaoUtilisateur->getUtilisateurById((int)112));
    $monLivreUserUpdate->setLivre($DaoLivre->getLivreById((int)-3));
    $monLivreUserUpdate->setNbExemplaire(1);

    var_dump($monLivreUserUpdate);

    $updateLivreUtilisateur = $DaoLivreUtilisateur->ArchivageLivreUtilisateur($monLivreUserUpdate);
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Archivage)");
}