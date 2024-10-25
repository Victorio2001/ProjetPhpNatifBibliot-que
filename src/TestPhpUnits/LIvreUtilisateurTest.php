<?php
declare(strict_types=1);
namespace MonApp\TestPhpUnits;

require_once __DIR__ . '/../../config/localConfig.php';

use DateTime;
use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\LivreUtilisateur;
use MonApp\model\DAO\DAOLivreUtilisateur;

use MonApp\model\DAO\DAOUtilisateur;
use MonApp\model\DAO\DAOLivre;

class LIvreUtilisateurTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property

    public function testCheckIdRes()
    {
        $daoLivre = new DAOLivre();
        $daoUser = new DAOUtilisateur();
        //Pour tester les dates https://stackoverflow.com/questions/7091396/phpunit-equalto-on-dates-with-delta
        $date1 = new DateTime('2011-01-01');

        $Res = new LivreUtilisateur();
        $Res->setDateReservation($date1);
        $Res->setLivre($daoLivre->getLivreById(-1));
        $Res->setUtilisateur($daoUser->getUtilisateurById(-1));

        /*assertEquals is better because it gives the unit test framework more
        information about what you're actually interested in.
        That allows it to provide better error information when the test fails.*/
        //https://stackoverflow.com/questions/41974209/what-is-the-actual-difference-between-assertequals-vs-asserttrue-in-testng

        $this->assertEquals($date1, $Res->getDateReservation(), "Dates incorrect");
        $this->assertEquals(-1, $Res->getUtilisateur()->getIdUtilisateur(), "Id User incorrect");
        $this->assertEquals(-1, $Res->getLivre()->getIdLivre(), "Id Livre incorrect");

    }

    public function testResFalse()
    {
        $this->expectException(\TypeError::class);

        $daoLivre = new DAOLivre();
        $daoUser = new DAOUtilisateur();
        //Pour tester les dates https://stackoverflow.com/questions/7091396/phpunit-equalto-on-dates-with-delta
        $date1 = new DateTime('2011-01-01');
        $date2 = new DateTime('2011-02-01');
        $date3 = new DateTime('2011-03-01');

        $Res = new LivreUtilisateur();
        $Res->setDateReservation($date1);
        $Res->setDateEmprunt($date2);
        $Res->setDateRendu($date3);
        $Res->setNbExemplaire();
        $Res->setEtatRes("En-attente");
        $Res->setArchiver(false);
        $Res->setLivre($daoLivre->getLivreById(-1));
        $Res->setUtilisateur($daoUser->getUtilisateurById(-1));

        /*assertEquals is better because it gives the unit test framework more
        information about what you're actually interested in.
        That allows it to provide better error information when the test fails.*/
        //https://stackoverflow.com/questions/41974209/what-is-the-actual-difference-between-assertequals-vs-asserttrue-in-testng

        $this->assertEquals($date1, $Res->getDateReservation(), "Dates res incorrect");
        $this->assertEquals($date2, $Res->getDateEmprunt(), "Dates Emprunt incorrect");
        $this->assertEquals($date3, $Res->getDateRendu(), "Dates Rendu incorrect");
        $this->assertEquals(20, $Res->getNbExemplaire(), "Nbr livre incorrect");
        $this->assertEquals("En-attente", $Res->getEtatRes(), "Etat Livre incorrect");
        $this->assertEquals(false, $Res->getArchiver(), "Etat Archivage Incorrect");
        $this->assertEquals(-1, $Res->getUtilisateur()->getIdUtilisateur(), "Id User Incorrect");
        $this->assertEquals(-1, $Res->getLivre()->getIdLivre(), "Id Livre Incorrect");
    }

    public function testResGood()
    {

        /*
         * Première étape == affecter valeurs à notre Entities
         * Deuxième étape comparer ces la valeur stocker dans notre objet à la valeur sortie de celui-ci.
         * Trois.. non que deux.
         * */

        $daoLivre = new DAOLivre();
        $daoUser = new DAOUtilisateur();
        //Pour tester les dates https://stackoverflow.com/questions/7091396/phpunit-equalto-on-dates-with-delta
        $date1 = new DateTime('2011-01-01');
        $date2 = new DateTime('2011-02-01');
        $date3 = new DateTime('2011-03-01');

        $Res = new LivreUtilisateur();
        $Res->setDateReservation($date1);
        $Res->setDateEmprunt($date2);
        $Res->setDateRendu($date3);
        $Res->setNbExemplaire(20);
        $Res->setEtatRes("En-attente");
        $Res->setArchiver(false);
        $Res->setLivre($daoLivre->getLivreById(-1));
        $Res->setUtilisateur($daoUser->getUtilisateurById(-1));

        /*Explication trouver sur le forum ci dessous
         * assertEquals is better because it gives the unit test framework more
        information about what you're actually interested in.
        That allows it to provide better error information when the test fails.*/
        //https://stackoverflow.com/questions/41974209/what-is-the-actual-difference-between-assertequals-vs-asserttrue-in-testng

        $this->assertEquals($date1, $Res->getDateReservation(), "Dates res incorrect");
        $this->assertEquals($date2, $Res->getDateEmprunt(), "Dates Emprunt incorrect");
        $this->assertEquals($date3, $Res->getDateRendu(), "Dates Rendu incorrect");
        $this->assertEquals(20, $Res->getNbExemplaire(), "Nbr livre incorrect");
        $this->assertEquals("En-attente", $Res->getEtatRes(), "Etat Livre incorrect");
        $this->assertEquals(false, $Res->getArchiver(), "Etat Archivage Incorrect");
        $this->assertEquals(-1, $Res->getUtilisateur()->getIdUtilisateur(), "Id User Incorrect");
        $this->assertEquals(-1, $Res->getLivre()->getIdLivre(), "Id Livre Incorrect");
    }
}