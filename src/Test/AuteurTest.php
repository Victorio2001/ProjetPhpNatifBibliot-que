<?php
declare(strict_types=1);
namespace MonApp\Test;

require_once __DIR__ . '/../../config/localConfig.php';

use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\Auteur;
use MonApp\model\DAO\DAOAuteur;

class AuteurTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property


    public function testCheckIdAuteur()
    {
        $user = new Auteur();
        $user->setIdAuteur(1);
        $this->assertTrue($user->getIdAuteur() === 1);
    }

    public function testcreationAuteurBad(): void
    {

        $this->expectException(\TypeError::class);

        $auteur = new Auteur();

        $auteur->setIdAuteur(-76);
        $auteur->setNomAuteur(32);
        $auteur->setPrenomAuteur("Ankama");

    }


    public function testcreationAuteurGood(): void
    {
        
        $auteur = new Auteur();

        $auteur->setIdAuteur(5);
        $auteur->setNomAuteur("GINESTE");
        $auteur->setPrenomAuteur("Michel");
        

        $this->assertTrue($auteur->getIdAuteur() === 5);
        $this->assertTrue($auteur->getNomAuteur() === "GINESTE");
        $this->assertTrue($auteur->getPrenomAuteur() === "Michel");
    }
}
