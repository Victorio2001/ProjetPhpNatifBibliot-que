<?php
declare(strict_types=1);
namespace MonApp\TestPhpUnits;

require_once __DIR__ . '/../../config/localConfig.php';

use PHPUnit\Framework\TestCase;
use MonApp\model\DTO\MotCle;
use MonApp\model\DAO\DAOMotCle;

class MotCleTest extends TestCase
{
    //https://phpunit.de/getting-started/phpunit-11.html
    //https://stackoverflow.com/questions/12536111/phpunit-test-a-method-that-returns-an-objects-property


    public function testCheckIdMotCle()
    {
        $user = new MotCle();
        $user->setIdMotCle(1);
        $this->assertTrue($user->getIdMotCle() === 1);
    }

    public function testcreationMotCleBad(): void
    {

        $this->expectException(\TypeError::class);

        $motcle = new MotCle();

        $motcle->setIdMotCle(-76);
        $motcle->setMotCle("");

    }


    public function testcreationMotCleGood(): void
    {
        
        $motcle = new MotCle();

        $motcle->setIdMotCle(5);
        $motcle->setMotCle("PHP");
        

        $this->assertTrue($motcle->getIdMotCle() === 5);
        $this->assertTrue($motcle->getMotCle() === "PHP");
    }
}
