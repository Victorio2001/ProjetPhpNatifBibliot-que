<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\Auteur;
use MonApp\Utilities\BDD;
use PDO;

class DAOAuteur 
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "auteur";

    }
    public function getAllAuteur(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet[] = new Auteur($row);
            }
        }
        return $resultSet;
    }

    public function getAuteurPagination(int $NbrUserParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY nomauteur DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrUserParPage,
            'premier' => $premier ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Auteur($row);
            }
        }
        return $resultSet;
    }
    public function getAuteurById(int $id): ?Auteur {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idauteur = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new Auteur($row);
            }
        }
        return $resultSet;
    }
    public function getnomauteur(string $Nom): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE nomauteur ILIKE :nomauteur";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['nomauteur' => '%' . $Nom . '%']);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Auteur($row);
            }
        }
        return $resultSet;
    }
    public function getprenomauteur(string $Prenom): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE prenomauteur ILIKE :prenomauteur";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['prenomauteur' => '%' . $Prenom . '%']);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Auteur($row);
            }
        }
        return $resultSet;
    }

    public function insertAuteur(Auteur $auteur): ?Auteur {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (nomauteur, prenomauteur )
                  VALUES (:nomauteur, :prenomauteur)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nomauteur' => $auteur->getnomauteur(),
            'prenomauteur' => $auteur->getprenomauteur(),
        ]);

        if ($res !== FALSE) {
            //Si la requête s'est bien exécuté on récupère l'id généré en BDD et on met à jour l'id dans $entity
            $auteur->setIdAuteur($this->pdoObject->lastInsertId());
            $resultSet = $auteur;
        }
        return $resultSet;
    }


    public function updateauteur(Auteur $auteur): ?Auteur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET nomauteur=:nomauteur, "
            . " prenomauteur=:prenomauteur "
            . " WHERE idauteur = :idauteur";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idauteur' => $auteur->getIdAuteur(),
            'nomauteur' => $auteur->getnomauteur(),
            'prenomauteur' => $auteur->getprenomauteur(),
        ]);

        if ($res !== false) {
            $resultSet = $auteur;
        }
        return $resultSet;
    }

    public function deleteauteur(int $id): bool {

        $query = "DELETE FROM auteur WHERE idauteur = :idauteur";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['idauteur' => $id]);

        return $reqPrep !== false;
    }


}