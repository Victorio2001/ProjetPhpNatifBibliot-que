<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\MotCleLivre;
use MonApp\model\DTO\Transaction;
use MonApp\Utilities\BDD;
use PDO;
class DAOMotCleLivre
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "motclelivre";

    }
    public function getAllMotCleLivre(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $Livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $Livre;
                $MotClef = (new DAOMotCle())->getIdMotCle($row['idmotcle']);
                $row['MotCle'] = $MotClef;
                $resultSet[] = new MotCleLivre($row);
            }
        }
        return $resultSet;
    }


    public function getMotCleLivreByLivre(MotCleLivre $motclelivre): ?array {

        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idlivre = :idlivre";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idlivre' => $motclelivre->getLivre()->getIdLivre()
        ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $Livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $Livre;
                $MotClef = (new DAOMotCle())->getIdMotCle($row['idmotcle']);
                $row['MotCle'] = $MotClef;
                $resultSet[] = new MotCleLivre($row);
            }
        }
        return $resultSet;
    }


    public function getIdMotCleLivre(MotCleLivre $motclelivre): ?MotCleLivre {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idmotcle = :idmotcle and idlivre = :idlivre";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idmotcle' => $motclelivre->getMotCle()->getIdMotCle(),
            'idlivre' => $motclelivre->getLivre()->getIdLivre()
        ]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new MotCleLivre($row);
            }
        }
        return $resultSet;
    }
    public function insertmotclelivre(MotCleLivre $motclelivre): ?MotCleLivre {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (idmotcle, idlivre)
                  VALUES (:idmotcle, :idlivre)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idmotcle' => $motclelivre->getMotCle()->getIdMotCle(),
            'idlivre' => $motclelivre->getLivre()->getIdLivre(),
        ]);
        if ($res !== FALSE) {
            $resultSet = $motclelivre;
        }
        return $resultSet;
    }

    public function deletemotcleLivre(MotCleLivre $motclelivre): ?MotCleLivre {

        $query = "DELETE FROM motclelivre WHERE idmotcle = :idmotcle and idlivre = :idlivre";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute([
            'idmotcle' => $motclelivre->getMotCle()->getIdMotCle(),
            'idlivre' => $motclelivre->getLivre()->getIdLivre(),
        ]);
        if ($reqPrep !== FALSE) {
            $resultSet = $motclelivre;
        }
        return $resultSet;
    }

}