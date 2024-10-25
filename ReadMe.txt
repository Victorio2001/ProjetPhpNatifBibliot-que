composer dump-autoload => pour actualiser/reload son composer.json
composer install
composer require --dev phpunit/phpunit
composer require phpmailer/phpmailer
yarn install (si packs)
password == "mrar aboe seln ccdt"
npm install -D tailwindcss => installation de tailwind
yarn tailwindcss init => configurer tailwind

//*************Utilisation de php mailer ************/
installation == composer require phpmailer/phpmailer.
password app == mrar aboe seln ccdt.

/*******Utilisation de phpUnit*****************/
composer require --dev phpunit/phpunit => installation de package
/*
<?php
declare(strict_types=1);
namespace MonApp\Test;
use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\Utilisateur;
class UtilisateurTest extends TestCase  //Création du fichier de test
{
    public function testSetEmailUtilisateurWithInvalidValue(): void
    {
        $this->expectException(\TypeError::class);
        $utilisateur = new Utilisateur();
        $utilisateur->setEmailUtilisateur("Victorio@gmail.com");
    }
}
*/
//Exécution du test == ./vendor/bin/phpunit ./src/Test/Auteur.php


