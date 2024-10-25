<?php

namespace MonApp\model\DAO;

use MonApp\model\DTO\Livre;
use MonApp\model\DTO\Utilisateur;
use MonApp\Utilities\BDD;
use pdo;
class DAOLivre
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "livre";

    }
    public function getAllLivre(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet[] = new Livre($row);
            }
        }
        return $resultSet;
    }






    public function getLivreById(int $id): ?Livre {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idlivre = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $resultSet = new Livre($row);
            }
        }
        return $resultSet;
    }


    public function getLivrePagination(int $NbrLivreParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY anneepublication DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrLivreParPage,
                                  'premier' => $premier ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Livre($row);
            }
        }
        return $resultSet;
    }

    public function getLivreByTitle(string $Title): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE titrelivre ILIKE :titrelivre";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['titrelivre' => '%' . $Title . '%']);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $resultSet[] = new Livre($row);
            }
        }
        return $resultSet;
    }


    public function insertLivre(Livre $livre): ?Livre {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (titrelivre, resumelivre, anneepublication, nombreexemplaires, isbn, imagecouverture )
                  VALUES (:titreLivre, :resumeLivre, :anneePublication, :nombreExemplaires, :isbn, :imageCouverture)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'titreLivre' => $livre->getTitreLivre(),
            'resumeLivre' => $livre->getResumeLivre(),
            'anneePublication' => $livre->getAnneePublication("Y-m-d"),
            'nombreExemplaires' => $livre->getNombreExemplaires(),
            'isbn' => $livre->getIsbn(),
            'imageCouverture' => $livre->getImageCouverture()
        ]);

        if ($res !== FALSE) {
            //Si la requête s'est bien exécuté on récupère l'id généré en BDD et on met à jour l'id dans $entity
            $livre->setIdLivre($this->pdoObject->lastInsertId());
            $resultSet = $livre;
        }
        return $resultSet;
    }


    public function updateLivre(Livre $livre): ?Livre
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET titrelivre=:titrelivre, "
            . " resumelivre=:resumelivre, "
            . " anneepublication=:anneepublication, "
            . " nombreexemplaires=:nombreexemplaires,"
            . " isbn=:isbn,"
            . " imagecouverture=:imagecouverture"
            . " WHERE idlivre = :idlivre";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'titrelivre' => $livre->getTitreLivre(),
            'resumelivre' => $livre->getResumeLivre(),
            'anneepublication' => $livre->getAnneePublication("Y-m-d"),
            'nombreexemplaires' => $livre->getNombreExemplaires(),
            'isbn' => $livre->getIsbn(),
            'imagecouverture' => $livre->getImageCouverture(),
            'idlivre' => $livre->getIdLivre(),
        ]);

        if ($res !== false) {
            $resultSet = $livre;
        }
        return $resultSet;
    }

    public function deleteLivre(int $id): bool {

//        $query = "DELETE FROM livreutilisateur WHERE idutilisateur = :id";
//        $reqPrep = $this->pdoObject->prepare($query);
//        $reqPrep->execute(['id' => $id]);
//
//        $query = "DELETE FROM transaction WHERE idutilisateur = :id";
//        $reqPrep = $this->pdoObject->prepare($query);
//        $reqPrep->execute(['id' => $id]);

//        $query2 = "DELETE FROM {$this->nomTable} WHERE idlivre = :idlivre";
//        $reqPrep = $this->pdoObject->prepare($query2);
//        $res = $reqPrep->execute(['idlivre' => $id]);


        $query = "DELETE FROM livre WHERE idlivre = :idlivre";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['idlivre' => $id]);

        return $reqPrep !== false;
    }

}