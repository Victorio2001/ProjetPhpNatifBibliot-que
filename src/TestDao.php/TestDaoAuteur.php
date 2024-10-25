<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\Auteur;
use MonApp\model\DAO\DAOAuteur;
$DaoAuteur = new DAOAuteur();


echo 'getAllAuteur';
$repoAuteur = $DaoAuteur->getAllAuteur();
var_dump($repoAuteur);

echo 'getAuteurById';
$repoAuteur = $DaoAuteur->getAuteurById(-1);
var_dump($repoAuteur);

echo 'getnomauteur';
$repoAuteurTitle = $DaoAuteur->getnomauteur("kentaro");
var_dump($repoAuteurTitle);

echo 'getprenomauteur';
$repoAuteurTitle = $DaoAuteur->getprenomauteur("mizuno");
var_dump($repoAuteurTitle);

// echo 'InserAuteur';
// $monAuteur = new \MonApp\model\DTO\Auteur();
// try{
//     $monAuteur->setNomAuteur("Nom Auteur");
//     $monAuteur->setPrenomAuteur("Prénom Auteur");
//     $insertAuteur = $DaoAuteur->insertAuteur($monAuteur);
//     var_dump("L'auteur est normalement bien inséré.");
// } catch(Exception $e){
//     var_dump("Miiiiiiince sa marche pas hehehehehhe");
// }

echo 'UpdateAuteur';
$monAuteur = new \MonApp\model\DTO\Auteur();
    $monAuteur->setIdAuteur(1);
    $monAuteur->setNomAuteur("testNom");
    $monAuteur->setPrenomAuteur("testPrénom");
    $updateAuteur = $DaoAuteur->updateAuteur($monAuteur);
    var_dump("L'auteur est normalement bien mis à jour.");


echo 'DeleteAuteur';
try {
    $Auteurdeleted = $DaoAuteur->deleteAuteur(13);
    var_dump("L'auteur est normalement bien Supprimé.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}