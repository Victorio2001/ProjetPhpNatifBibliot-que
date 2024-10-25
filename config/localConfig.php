<?php
require_once 'globalConfig.php';

use MonApp\Utilities\BDD;

define('URL_BASE', "http://localhost/application-web");

if(!defined('DUMP')) {
    define('DUMP', true);
}
    $infoBdd = array(
        'type' => 'pgsql',
        'host' => 'localhost',
        'port' => 5433,
        'dbname' => 'livre',
        'user' => 'postgres',
        'pass' => 'ort'
    );

    $dsn = "pgsql:host={$infoBdd['host']};port={$infoBdd['port']};dbname={$infoBdd['dbname']};user={$infoBdd['user']};password={$infoBdd['pass']}";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /*----------------------------*/
    $query = "SELECT * FROM livreutilisateur";
    $result = $pdo->query($query);
    /*----------------------------*/
//    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//        var_dump($row);
//    }
    /*----------------------------*/


if (class_exists(BDD::class))
{
    BDD::$infoBdd = $infoBdd;
}


