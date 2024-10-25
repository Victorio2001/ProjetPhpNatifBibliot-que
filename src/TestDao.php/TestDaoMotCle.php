<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\MotCle;
use MonApp\model\DAO\DAOMotCle;
$DaoMotCle = new DAOMotCle();

echo 'getAllMotCle';
$repoMotCle = $DaoMotCle->getAllMotCle();
var_dump($repoMotCle);

echo 'getMotCleById';
$repoMotCle = $DaoMotCle->getIdMotCle(-1);
var_dump($repoMotCle);

echo 'getMotCle';
$repoMotCleTitle = $DaoMotCle->getMotCle("shojo");
var_dump($repoMotCleTitle);



echo 'InserMotCle';
$monMotCle = new \MonApp\model\DTO\MotCle();
try{
    $monMotCle->setMotCle("Mot Cle");
    $insertMotCle= $DaoMotCle->insertmotcle($monMotCle);
    var_dump("Le Mot Clé est normalement bien inséré.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe");
}

echo 'DeleteEditeur';
try {
    $Editeurdeleted = $DaoMotCle->deletemotcle(0);
    var_dump("Le mot Clé est normalement bien Supprimé.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}