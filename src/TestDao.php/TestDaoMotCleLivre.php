<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\MotCleLivre;
use MonApp\model\DAO\DAOMotCleLivre;
use MonApp\model\DAO\DAOMotCle;
use MonApp\model\DAO\DAOLivre;
use MonApp\model\DTO\Livre;


$DaoMotCleLivre = new DAOMotCleLivre();
$daolivre = new DAOLivre();
$daomoclef = new DAOMotCle();
$monLivre = new Livre();
$motcleflivre = new MotCleLivre();


echo '<h1>getAllMotCleLivre</h1>';
$repoMotCleLivre = $DaoMotCleLivre->getAllMotCleLivre();
var_dump($repoMotCleLivre);


echo '<h1>getMotCleLivreByLivre</h1>';
$motcleflivre->setLivre($daolivre->getLivreById(-1));
$repoMotCleLivre = $DaoMotCleLivre->getMotCleLivreByLivre($motcleflivre);
var_dump($repoMotCleLivre);


echo '<h1>getMotCleLivreById</h1>';
$monMotclefLivre = new MotCleLivre();
$monMotclefLivre->setLivre($daolivre->getLivreById(-2));
$monMotclefLivre->setMotCle($daomoclef->getIdMotCle(-1));

$repoMotCleLivre = $DaoMotCleLivre->getIdMotCleLivre($monMotclefLivre);
var_dump($monMotclefLivre);



echo '<h1>InserMotCleLivre</h1>';
$monMotclefLivre = new MotCleLivre();

    $monMotclefLivre->setMotCle($daomoclef->getIdMotCle(-2));
    $monMotclefLivre->setLivre($daolivre->getLivreById(-1));

    $insertMotClelivre= $DaoMotCleLivre->insertmotclelivre($monMotclefLivre);
    var_dump("Le Mot Clé est normalement bien inséré.");


echo 'DeleteEditeur';
try {
    $DaoMotCleLivre = $DaoMotCleLivre->deletemotcleLivre(0);
    var_dump("Le Motclelivre est normalement bien Supprimé.");
} catch(Exception $e){
    var_dump("Miiiiiiince sa marche pas hehehehehhe (Delete)");
}


