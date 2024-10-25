<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\Livre;
use MonApp\model\DAO\DAOLivre;
$DaoLivre = new DAOLivre();

echo 'GetAllLivre';
$repoLivres = $DaoLivre->getAllLivre();
var_dump($repoLivres);

echo 'GetLivreById';
$repoLivre = $DaoLivre->getLivreById(-1);
var_dump($repoLivre);

echo 'getLivreByTitle';
$repoLivreTitle = $DaoLivre->getLivreByTitle("e");
var_dump($repoLivreTitle);

echo 'InserLivre';
$monLivre = new \MonApp\model\DTO\Livre();
try{
    $monLivre->setTitreLivre("FriEren");
    $monLivre->setResumeLivre("L'histoire suit l'elfe magicienne Frieren, une ancienne membre du groupe d'aventuriers qui a vaincu le roi des démons et restauré l'harmonie du monde après une quête de 10 ans. Ce groupe comptait : l'elfe magicienne Frieren, le héros humain Himmel, le guerrier nain Eisen et le prêtre humain Heiter.");
    $monLivre->setAnneePublication('2022-02-03');
    $monLivre->setNombreExemplaires(2);
    $monLivre->setIsbn(2765410078);
    $monLivre->setImageCouverture("Frieren.jpg");
    $insertLivre = $DaoLivre->insertLivre($monLivre);
    var_dump("Le livre est normalement bien inséré.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Ps: l'isbn doit etre unique).");
}

echo 'UpdateLivre';
try{
    $monLivre->setIdLivre(1);
    $monLivre->setTitreLivre("FriEren");
    $monLivre->setResumeLivre("L'histoire suit l'elfe magicienne Frieren, une ancienne membre du groupe d'aventuriers qui a vaincu le roi des démons et restauré l'harmonie du monde après une quête de 10 ans. Ce groupe comptait : l'elfe magicienne Frieren, le héros humain Himmel, le guerrier nain Eisen et le prêtre humain Heiter.");
    $monLivre->setAnneePublication('2022-02-03');
    $monLivre->setNombreExemplaires(2);
    $monLivre->setIsbn(2765410071);
    $monLivre->setImageCouverture("Frieren.jpg");
    $updateLivre = $DaoLivre->updateLivre($monLivre);
    var_dump("Le livre est normalement bien mis à jour.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Ps: l'isbn doit etre unique).");
}

echo 'DeleteUtilisateur';
try {
    $Livredeleted = $DaoLivre->deleteLivre(4);
    var_dump("Le livre est normalement bien Supprimé.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}