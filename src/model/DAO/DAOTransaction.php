<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\Transaction;
use MonApp\Utilities\BDD;
use PDO;
class DAOTransaction
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "transaction";

    }

    public function getAllTransaction(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $user = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $user;
                $resultSet[] = new Transaction($row);
            }
        }
        return $resultSet;
    }

    public function getTransactionPagination(int $NbrTransactionParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY idtransaction DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrTransactionParPage,
            'premier' => $premier]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new Transaction($row);
            }
        }
        return $resultSet;
    }

    public function insertTransaction(Transaction $transac): ?Transaction {
        $resultSet = NULL;
        $query = "INSERT INTO
              {$this->nomTable} (nblivreajoute, nblivreenlever, idutilisateur, idlivre )
              VALUES (:nblivreajoute, :nblivreenlever, :idutilisateur, :idlivre)";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nblivreajoute' => $transac->getNbLivreAjoute(),
            'nblivreenlever' => $transac->getNbLivreEnlever(),
            'idutilisateur' => $transac->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $transac->getLivre()->getIdLivre()
        ]);

        if ($res !== FALSE) {
            $transac->setIdTransaction($this->pdoObject->lastInsertId());

            $MiseAJourNbLivre = "UPDATE livre SET nombreexemplaires = nombreexemplaires - :nblivreenlever + :nblivreajoute WHERE idlivre = :idlivre";
            $updateReqPrep = $this->pdoObject->prepare($MiseAJourNbLivre);
            $updateTransac = $updateReqPrep->execute([
                'nblivreajoute' => $transac->getNbLivreAjoute(),
                'nblivreenlever' => $transac->getNbLivreEnlever(),
                'idlivre' => $transac->getLivre()->getIdLivre()
            ]);

            if ($updateTransac === FALSE) {
                $this->pdoObject->rollBack();
                return NULL;
            }
            $resultSet = $transac;
        }

        return $resultSet;
    }

    public function deleteTransaction (Transaction $transac): ?Transaction {

        $resultset = null;
        $Marequete = "DELETE FROM {$this->nomTable} WHERE idtransaction = :idtransaction";
        $Marequeteprepared = $this->pdoObject->prepare($Marequete);
        $DelResArgs = $Marequeteprepared->execute([
            'idtransaction' => $transac->getIdTransaction(),
        ]);
        if ($DelResArgs !== false) {
            $resultset = $transac;
        }
        return $resultset;
    }

    public function getTransactionById(int $id): ?Transaction {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idtransaction = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet = new Transaction($row);
            }
        }
        return $resultSet;
    }

    public function UpdateTransaction(Transaction $trans): ?Transaction
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET nblivreajoute=:nblivreajoute, "
            . " nblivreenlever=:nblivreenlever, "
            . " idutilisateur=:idutilisateur, "
            . " idlivre=:idlivre"
            . " WHERE idtransaction = :idtransaction";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nblivreajoute' => $trans->getNbLivreAjoute(),
            'nblivreenlever' => $trans->getNbLivreEnlever(),
            'idutilisateur' => $trans->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $trans->getLivre()->getIdLivre(),
            'idtransaction' => $trans->getIdTransaction(),

        ]);

        if ($res !== FALSE) {

            $MiseAJourNbLivre = "UPDATE livre SET nombreexemplaires = nombreexemplaires - :nblivreenlever + :nblivreajoute WHERE idlivre = :idlivre";
            $updateReqPrep = $this->pdoObject->prepare($MiseAJourNbLivre);
            $updateTransac = $updateReqPrep->execute([
                'nblivreajoute' => $trans->getNbLivreAjoute(),
                'nblivreenlever' => $trans->getNbLivreEnlever(),
                'idlivre' => $trans->getLivre()->getIdLivre()
            ]);

            if ($updateTransac === FALSE) {
                $this->pdoObject->rollBack();
                return NULL;
            }
            $resultSet = $trans;
        }
        return $resultSet;
    }






}