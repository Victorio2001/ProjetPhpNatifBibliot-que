<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\Editeur;
use MonApp\model\DAO\DAOEditeur;
$DaoEditeur = new DAOEditeur();

echo 'getAllEditeur';
$repoEditeur = $DaoEditeur->getAllEditeur();
var_dump($repoEditeur);

echo 'getEditeurById';
$repoEditeur = $DaoEditeur->getEditeurById(-1);
var_dump($repoEditeur);

echo 'getnomediteur';
$repoEditeurTitle = $DaoEditeur->getnomediteur("kaze");
var_dump($repoEditeurTitle);



echo 'InserEditeur';
$monEditeur = new \MonApp\model\DTO\Editeur();
try{
    $monEditeur->setNomEditeur("Nom Editeur");
    $insertEditeur= $DaoEditeur->insertediteur($monEditeur);
    var_dump("L'editeur est normalement bien inséré.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe");
}

echo 'UpdateAuteur';
$monEditeur = new \MonApp\model\DTO\Editeur();
    $monEditeur->setIdEditeur(-1);
    $monEditeur->setNomEditeur("testNom");
   
    $updateEditeur = $DaoEditeur->updateediteur($monEditeur);
    var_dump("L'editeur est normalement bien mis à jour.");


echo 'DeleteEditeur';
try {
    $Editeurdeleted = $DaoEditeur->deleteediteur(0);
    var_dump("L'editeur est normalement bien Supprimé.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}