<?php

namespace MonApp\model\DAO;

use MonApp\model\DTO\LivreUtilisateur;
use MonApp\Utilities\BDD;
use PDO;
class DAOLivreUtilisateur
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "livreutilisateur";

    }
    public function getAllLivreUtilisateur(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new LivreUtilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getLivrePagination(int $NbrLivreParPage, int $premier, int $id): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} where idutilisateur = :idutilisateur ORDER BY datereservation DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrLivreParPage,
            'premier' => $premier,
            'idutilisateur' => $id]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new LivreUtilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getLivrePaginationAdmin(int $NbrLivreParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY Idlivre DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrLivreParPage,
            'premier' => $premier]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new LivreUtilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getAllLivreUtilisateurEnAttente(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} where etatRes = 'En-attente'";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new LivreUtilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getNombreLivreUtilisateur(): ?int {
        $resultSet = NULL;
        $query = "SELECT count(*) FROM {$this->nomTable}";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $resultSet = $row;
            }
        }
        return $resultSet;
    }

    public function getReservationById(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}
         WHERE idutilisateur = :idutilisateur AND idlivre = :idlivre AND datereservation = :datereservation";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d")
        ]);
        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet = new LivreUtilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getReservationByIdUser(LivreUtilisateur $livreUtilisateur): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable}
         WHERE idutilisateur = :idutilisateur";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur()
        ]);

        if ($reqPrep !== FALSE) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($reqPrep as $row) {
                $user = (new DAOUtilisateur())->getUtilisateurById($row['idutilisateur']);
                $row['Utilisateur'] = $user;
                $livre = (new DAOLivre())->getLivreById($row['idlivre']);
                $row['Livre'] = $livre;
                $resultSet[] = new LivreUtilisateur($row);
            }
        }

        return $resultSet;
    }

    public function insertLivreUtilisateur(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur {
        /*
         * Ici il faut modifier quelques trucs, l'update du stock ne doit pas se faire ici
         * mais plus tard quand le gestionnaire va valider la res.
         */

        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (datereservation, daterendu, dateemprunt, nbexemplaire, etatres, idutilisateur, idlivre )
                  VALUES (:datereservation, :daterendu, :dateemprunt, :nbexemplaire, :etatres, :idutilisateur, :idlivre)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d"),
            'daterendu' => $livreUtilisateur->getDateRendu("Y-m-d"),
            'nbexemplaire' => $livreUtilisateur->getNbExemplaire(),
            'etatres' => $livreUtilisateur->getEtatRes(),
            'dateemprunt' => $livreUtilisateur->getDateEmprunt("Y-m-d"),
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre()
        ]);

        $MiseAJourNbLivre = "UPDATE livre SET nombreexemplaires = nombreexemplaires - :nbexemplaire WHERE idlivre = :idlivre";
        $updateReqPrep = $this->pdoObject->prepare($MiseAJourNbLivre);
        $updateRes = $updateReqPrep->execute([
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
            'nbexemplaire' => $livreUtilisateur->getNbExemplaire()
        ]);

        if ($res !== false and $updateRes !== false ) {

            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }

    public function DeleteReservation (LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur {
        /*
         * Ici cette function aura pour role de supprimer les reservation qui ne sont pas encore "confirmé"
         */
        $resultset = null;
        $Marequete = "DELETE FROM {$this->nomTable} WHERE idutilisateur = :idutilisateur and datereservation = :datereservation and idlivre = :idlivre ";
        $Marequeteprepared = $this->pdoObject->prepare($Marequete);
        $DelResArgs = $Marequeteprepared->execute([
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d")
        ]);
        if ($DelResArgs !== false) {

            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }


    public function ArchivageLivreUtilisateur(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur {
        /********************/
        /*
         * Liste des choses à call pour faire fonctionner cette fonction:
         * -> premierement pour la premiere requete [l'id utilisateur, l'id Livre et la date de res].
         * -> ensuite pour la deuxieme concernant le rajout des livre préalablement reserver dans le stock il faut:
         * [ le nombre exemplaire, et l'id livre ( deja recuperer pour req du dessus).
         * Et hop let's go.
         */
        /********************/
        $resultSet = NULL;
        $MiseAJourEtatRes = "UPDATE {$this->nomTable} SET archiver = true  WHERE idutilisateur = :idutilisateur AND idlivre = :idlivre AND datereservation = :datereservation";

        $updateResUserReqPrep = $this->pdoObject->prepare($MiseAJourEtatRes);
        $updateRes = $updateResUserReqPrep->execute([
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d")
        ]);

        $MiseAJourNbLivre = "UPDATE livre SET nombreexemplaires = nombreexemplaires + :nbexemplaire WHERE idlivre = :idlivre";
        $updateReqPrep = $this->pdoObject->prepare($MiseAJourNbLivre);
        $updateNbLibre = $updateReqPrep->execute([
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
            'nbexemplaire' => $livreUtilisateur->getNbExemplaire()
        ]);

        if ($updateRes !== false and $updateNbLibre !== false ) {

            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }



    public function updateLivreUtilisateur(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET daterendu=:daterendu,"
            . " nbexemplaire=:nbexemplaire, "
            . " archiver=:archiver, "
            . " dateemprunt=:dateemprunt "
            . " WHERE datereservation = :datereservation and idutilisateur = :idutilisateur and idlivre = :idlivre ";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'daterendu' => $livreUtilisateur->getDateRendu("Y-m-d"),
            'nbexemplaire' => $livreUtilisateur->getNbExemplaire(),
            'archiver' => $livreUtilisateur->getArchiver(),
            'dateemprunt' => $livreUtilisateur->getDateEmprunt("Y-m-d"),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d"),
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
        ]);

        if ($res !== false) {
            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }

    public function UpdateStatutEnCours(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET etatres=:etatres,"
            . " dateemprunt=:dateemprunt "
            . " WHERE datereservation = :datereservation and idutilisateur = :idutilisateur and idlivre = :idlivre ";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'dateemprunt' => $livreUtilisateur->getDateEmprunt("Y-m-d"),
            'etatres' => $livreUtilisateur->getEtatRes(),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d"),
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
        ]);

        if ($res !== false) {
            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }

    public function UpdateToRendu(LivreUtilisateur $livreUtilisateur): ?LivreUtilisateur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET etatres=:etatres,"
            . " daterendu=:daterendu "
            . " WHERE datereservation = :datereservation and idutilisateur = :idutilisateur and idlivre = :idlivre ";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'daterendu' => $livreUtilisateur->getDateRendu("Y-m-d"),
            'etatres' => $livreUtilisateur->getEtatRes(),
            'datereservation' => $livreUtilisateur->getDateReservation("Y-m-d"),
            'idutilisateur' => $livreUtilisateur->getUtilisateur()->getIdUtilisateur(),
            'idlivre' => $livreUtilisateur->getLivre()->getIdLivre(),
        ]);

        if ($res !== false) {
            $resultSet = $livreUtilisateur;
        }
        return $resultSet;
    }
}