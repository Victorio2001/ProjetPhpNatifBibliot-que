<?php
require_once '../../config/localConfig.php';
use MonApp\model\DTO\Transaction;
use MonApp\model\DAO\DAOTransaction;
use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAOLivre;

$DaoTransac = new DAOTransaction();
$DaoLivre = new DAOLivre();
$DaoUtilisateur = new DAOUtilisateur();

$transaction = new Transaction();


echo 'getAllTransaction';
$repoTransaction = $DaoTransac->getAllTransaction();
var_dump($repoTransaction);


echo 'InserTransaction';
try{
    $transaction->setNbLivreAjoute(150);
    $transaction->setNbLivreEnlever(150);
    $transaction->setUtilisateur($DaoUtilisateur->getUtilisateurById(-1));
    $transaction->setLivre($DaoLivre->getLivreById(-1));

    $insertLivreUtilisateur = $DaoTransac->insertTransaction($transaction);
} catch(Exception $e ){
    var_dump($e);
}