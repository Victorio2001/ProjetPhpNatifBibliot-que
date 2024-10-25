<?php
declare(strict_types=1);
namespace MonApp\Test;

require_once __DIR__ . '/../../config/localConfig.php';

use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\Editeur;
use MonApp\model\DAO\DAOEditeur;

class EditeurTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property


    public function testCheckIdEditeur()
    {
        $user = new Editeur();
        $user->setIdEditeur(1);
        $this->assertTrue($user->getIdEditeur() === 1);
    }

    public function testcreationEditeurBad(): void
    {

        $this->expectException(\TypeError::class);

        $editeur = new Editeur();

        $editeur->setIdEditeur(-76);
        $editeur->setNomEditeur(32);

    }


    public function testcreationEditeurGood(): void
    {
        
        $editeur = new Editeur();

        $editeur->setIdEditeur(5);
        $editeur->setNomEditeur("Ankama");
        

        $this->assertTrue($editeur->getIdEditeur() === 5);
        $this->assertTrue($editeur->getNomEditeur() === "Ankama");

    }
}
