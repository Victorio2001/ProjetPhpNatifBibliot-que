<?php
declare(strict_types=1);
namespace MonApp\TestPhpUnits;

require_once __DIR__ . '/../../config/localConfig.php';

use DateTime;
use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\Livre;
use MonApp\model\DAO\DAOLivre;

class LivreTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property

    public function testCheckIdUser()
    {
        $livre = new Livre();
        $livre->setIdLivre(3);
        $this->assertTrue($livre->getIdLivre() === 3);
    }

    public function testcreationLivreBad(): void
    {

        $this->expectException(\TypeError::class);

        $DAOLivre = new DAOLivre();
        $livre = new Livre();

        $livre->setIdLivre("hehehehe");
        $livre->setTitreLivre("Naruto");
        $livre->setResumeLivre("Super manga vraiment cool et naruto meurt à la fin.");
        $livre->setAnneePublication(date("Y-m-d"));
        $livre->setNombreExemplaires(50);
        $livre->setIsbn(8522);
        $livre->setImageCouverture("Naruto.jpeg");

    }

    public function testcreationLivreGood(): void
    {
        $DAOLivre = new DAOLivre();
        $livre = new Livre();
        //Pour tester les dates https://stackoverflow.com/questions/7091396/phpunit-equalto-on-dates-with-delta
        $date1 = new DateTime('2011-01-01');


        $livre->setIdLivre(200);
        $livre->setTitreLivre("Naruto");
        $livre->setResumeLivre("Super manga vraiment cool et naruto meurt à la fin.");
        $livre->setAnneePublication($date1);
        $livre->setNombreExemplaires(50);
        $livre->setIsbn(8522);
        $livre->setImageCouverture("Naruto.jpeg");


        $this->assertTrue($livre->getIdLivre() === 200);
        $this->assertTrue($livre->getTitreLivre() === "Naruto");
        $this->assertTrue($livre->getResumeLivre() === "Super manga vraiment cool et naruto meurt à la fin.");

        /*Explication trouver sur le forum ci dessous
        * assertEquals is better because it gives the unit test framework more
        information about what you're actually interested in.
        That allows it to provide better error information when the test fails.*/
        //https://stackoverflow.com/questions/41974209/what-is-the-actual-difference-between-assertequals-vs-asserttrue-in-testng

        $this->assertEquals($date1, $livre->getAnneePublication(), "Dates incorrect");


        $this->assertTrue($livre->getNombreExemplaires() === 50);
        $this->assertTrue($livre->getIsbn() === 8522);
        $this->assertTrue($livre->getImageCouverture() === "Naruto.jpeg");
    }

}