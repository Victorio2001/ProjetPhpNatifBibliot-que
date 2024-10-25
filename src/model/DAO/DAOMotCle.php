<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\MotCle;
use MonApp\Utilities\BDD;
use PDO;
class DAOMotCle
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "motcle";

    }
    public function getAllMotCle(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet[] = new MotCle($row);
            }
        }
        return $resultSet;
    }
    public function getIdMotCle(int $id): ?MotCle {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idmotcle = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new MotCle($row);
            }
        }
        return $resultSet;
    }
    public function getMotCle(string $Nom): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE motcle ILIKE :motcle";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['motcle' => '%' . $Nom . '%']);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new MotCle($row);
            }
        }
        return $resultSet;
    }
    

    public function insertmotcle(MotCle $motcle): ?MotCle {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (motcle)
                  VALUES (:motcle)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'motcle' => $motcle->getMotCle(),
            
        ]);

        if ($res !== FALSE) {
            //Si la requête s'est bien exécuté on récupère l'id généré en BDD et on met à jour l'id dans $entity
            $motcle->setIdMotCle($this->pdoObject->lastInsertId());
            $resultSet = $motcle;
        }
        return $resultSet;
    }


    public function deletemotcle(int $id): bool {

        $query = "DELETE FROM motcle WHERE idmotcle = :idmotcle";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['idmotcle' => $id]);

        return $reqPrep !== false;
    }

    public function getMotClefPagination(int $NbrUserParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY motcle DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrUserParPage,
            'premier' => $premier ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new MotCle($row);
            }
        }
        return $resultSet;
    }

    public function updatemotclef(MotCle $motcle): ?MotCle
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET motcle=:motcle"
            . " WHERE idmotcle = :idmotcle";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idmotcle' => $motcle->getIdMotCle(),
            'motcle' => $motcle->getMotCle(),

        ]);

        if ($res !== false) {
            $resultSet = $motcle;
        }
        return $resultSet;
    }


}