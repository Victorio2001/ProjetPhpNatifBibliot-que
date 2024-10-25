<?php
declare(strict_types=1);
namespace MonApp\Test;

require_once __DIR__ . '/../../config/localConfig.php';

use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\Utilisateur;
use MonApp\model\DAO\DAORole;

class UtilisateurTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property


    public function testCheckIdUser()
    {
        $user = new Utilisateur();
        $user->setIdUtilisateur(3);
        $this->assertTrue($user->getIdUtilisateur() === 3);
    }

    public function testcreationUserBad(): void
    {

        $this->expectException(\TypeError::class);

        $DAORole = new DAORole();
        $utilisateur = new Utilisateur();

        $utilisateur->setIdUtilisateur(-254);
        $utilisateur->setNomUtilisateur(true);
        $utilisateur->setPrenomUtilisateur("Victorio");
        $utilisateur->setEmailUtilisateur("Victorio@gmail.com");
        $utilisateur->setPasswordUtilisateur("GrosCaca");
        $utilisateur->setCompteActif(true);
        $utilisateur->setRole($DAORole->getRoleById(1));

    }


    public function testcreationUserGood(): void
    {
        $DAORole = new DAORole();
        $utilisateur = new Utilisateur();

        $utilisateur->setIdUtilisateur(-254);
        $utilisateur->setNomUtilisateur("Garcia");
        $utilisateur->setPrenomUtilisateur("Victorio");
        $utilisateur->setEmailUtilisateur("Victorio@gmail.com");
        $utilisateur->setPasswordUtilisateur("GeraltRiv");
        $utilisateur->setCompteActif(false);
        $utilisateur->setRole($DAORole->getRoleById(-1));

        $this->assertTrue($utilisateur->getIdUtilisateur() === -254);
        $this->assertTrue($utilisateur->getNomUtilisateur() === "Garcia");
        $this->assertTrue($utilisateur->getPrenomUtilisateur() === "Victorio");
        $this->assertTrue($utilisateur->getEmailUtilisateur() === "Victorio@gmail.com");
        $this->assertTrue($utilisateur->getPasswordUtilisateur() === "GeraltRiv");
        $this->assertTrue($utilisateur->getCompteActif() === false);
        $this->assertTrue($utilisateur->getRole()->getIdRole() === -1);
    }
}
