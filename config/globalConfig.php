<?php

// Affichage des erreurs pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Utilisation de l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Définition des chemins de base
define('BASE_DIR', dirname(__FILE__, 2));
define('PUBLIC_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
define('CONFIG_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR);
define('LOG_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR);

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fonction permettant de se connecter à la base de données
 * @param array $infoBdd Informations de connexion à la base de données
 * @return PDO|null Une connexion à la base de données
 */
