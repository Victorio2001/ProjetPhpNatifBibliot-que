<?php

namespace MonApp\model\DAO;
use MonApp\model\DTO\Editeur;
use MonApp\Utilities\BDD;
use PDO;
class DAOEditeur
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "editeur";

    }
    public function getAllEditeur(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet[] = new Editeur($row);
            }
        }
        return $resultSet;
    }
    public function getEditeurById(int $id): ?Editeur {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idediteur = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new Editeur($row);
            }
        }
        return $resultSet;
    }
    public function getnomediteur(string $Nom): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE nomediteur ILIKE :nomediteur";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['nomediteur' => '%' . $Nom . '%']);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Editeur($row);
            }
        }
        return $resultSet;
    }
    

    public function insertediteur(Editeur $editeur): ?Editeur {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (nomediteur)
                  VALUES (:nomediteur)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nomediteur' => $editeur->getnomediteur(),
            
        ]);

        if ($res !== FALSE) {
            //Si la requête s'est bien exécuté on récupère l'id généré en BDD et on met à jour l'id dans $entity
            $editeur->setIdediteur($this->pdoObject->lastInsertId());
            $resultSet = $editeur;
        }
        return $resultSet;
    }


    public function updateediteur(Editeur $editeur): ?Editeur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET nomediteur=:nomediteur"
        
            . " WHERE idediteur = :idediteur";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idediteur' => $editeur->getIdediteur(),
            'nomediteur' => $editeur->getnomediteur(),
            
        ]);

        if ($res !== false) {
            $resultSet = $editeur;
        }
        return $resultSet;
    }

    public function deleteediteur(int $id): bool {

        $query = "DELETE FROM editeur WHERE idediteur = :idediteur";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['idediteur' => $id]);

        return $reqPrep !== false;
    }

    public function getEditeurPagination(int $NbrUserParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY nomediteur DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrUserParPage,
            'premier' => $premier ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Editeur($row);
            }
        }
        return $resultSet;
    }


}