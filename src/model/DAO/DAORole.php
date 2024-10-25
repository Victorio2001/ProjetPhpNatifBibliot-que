<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\Role;
use MonApp\Utilities\BDD;
use PDO;

class DAORole
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "role";

    }
    public function getAllRole(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet[] = new Role($row);
            }
        }
        return $resultSet;
    }

    public function getRoleById(int $id): ?Role {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idrole = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new Role($row);
            }
        }
        return $resultSet;
    }
}