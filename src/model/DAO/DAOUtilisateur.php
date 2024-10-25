<?php
namespace MonApp\model\DAO;
use MonApp\model\DTO\Role;
use MonApp\model\DTO\Utilisateur;
use MonApp\Utilities\BDD;
use PDO;
class DAOUtilisateur
{
    protected PDO $pdoObject;
    private ?string $nomTable = null;

    public function __construct() {
        $this->pdoObject = BDD::getBdd()->getConnect();
        $this->nomTable = "utilisateur";

    }
    public function getAllUtilisateur(): ?array {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY nomutilisateur";
        $rqtResult = $this->pdoObject->query($query);
        if ($rqtResult) {
            $rqtResult->setFetchMode(\PDO::FETCH_ASSOC);
            foreach ($rqtResult as $row) {
                $Menage = (new DAORole())->getRoleById($row['idrole']);
                $row['Role'] = $Menage;
                $resultSet[] = new Utilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getUserPagination(int $NbrUserParPage, int $premier): ?array {
        /*
         * https://nouvelle-techno.fr/articles/mettre-en-place-une-pagination-en-php
         */
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} ORDER BY idUtilisateur DESC LIMIT :parpage OFFSET :premier;";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['parpage' => $NbrUserParPage,
            'premier' => $premier ]);
        if ($res) {
            $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $reqPrep->fetch()) {
                $Menage = (new DAORole())->getRoleById($row['idrole']);
                $row['Role'] = $Menage;
                $resultSet[] = new Utilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getUtilisateurById(int $id): ?Utilisateur {
        $resultSet = NULL;
        $query = "SELECT * FROM {$this->nomTable} WHERE idutilisateur = :id";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['id' => $id]);

        if ($res !== FALSE) {
            $row = ($tmp = $reqPrep->fetch(\PDO::FETCH_ASSOC)) ? $tmp : null;
            if (!is_null($row)) {
                $Menage = (new DAORole())->getRoleById($row['idrole']);
                $row['Role'] = $Menage;
                $resultSet = new Utilisateur($row);
            }
        }
        return $resultSet;
    }

    public function getUtilisateurByName(string $Name): ?array {
        $resultSet = [];
        $query = "SELECT * FROM {$this->nomTable} WHERE nomutilisateur ILIKE :nomutilisateur";
            $reqPrep = $this->pdoObject->prepare($query);
            $res = $reqPrep->execute(['nomutilisateur' => '%' . $Name . '%']);
            if ($res) {
                $reqPrep->setFetchMode(\PDO::FETCH_ASSOC);
                while ($row = $reqPrep->fetch()) {
                    $role = (new DAORole())->getRoleById($row['idrole']);
                    $row['Role'] = $role;
                    $resultSet[] = new Utilisateur($row);
                }
            }
        return $resultSet;
    }


    public function insertutilisateur(Utilisateur $user): ?Utilisateur {
        $resultSet = NULL;
        $query = "INSERT INTO
                  {$this->nomTable} (nomutilisateur, prenomutilisateur, passwordutilisateur, emailutilisateur, compteactif, idrole )
                  VALUES (:nomutilisateur, :prenomutilisateur, :passwordutilisateur, :emailutilisateur, :compteactif, :idrole)";
        // On prépare la rêquete
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nomutilisateur' => $user->getNomUtilisateur(),
            'prenomutilisateur' => $user->getPrenomUtilisateur(),
            'passwordutilisateur' => $user->getPasswordUtilisateur(),
            'emailutilisateur' => $user->getEmailUtilisateur(),
            'compteactif' => $user->getCompteActif(),
            'idrole' => $user->getRole()->getIdRole()]);

        if ($res !== FALSE) {
            //Si la requête s'est bien exécuté on récupère l'id généré en BDD et on met à jour l'id dans $entity
            $user->setIdUtilisateur($this->pdoObject->lastInsertId());
            $resultSet = $user;
        }
        return $resultSet;
    }

    public function updateUtilisateur(Utilisateur $user): ?Utilisateur
    {
        $resultSet = null;
        $query = "UPDATE {$this->nomTable}"
            . " SET nomutilisateur=:nomutilisateur, "
            . " prenomutilisateur=:prenomutilisateur, "
            . " passwordutilisateur=:passwordutilisateur, "
            . " emailutilisateur=:emailutilisateur,"
            . " compteactif=:compteactif,"
            . " idrole=:idrole"
            . " WHERE idutilisateur = :idutilisateur";

        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute([
            'nomutilisateur' => $user->getNomUtilisateur(),
            'prenomutilisateur' => $user->getPrenomUtilisateur(),
            'passwordutilisateur' => $user->getPasswordUtilisateur(),
            'emailutilisateur' => $user->getEmailUtilisateur(),
            'compteactif' => $user->getCompteActif() ? 'true' : 'false',
            'idrole' => $user->getRole()->getIdRole(),
            'idutilisateur' => $user->getIdUtilisateur(),
        ]);

        if ($res !== false) {
            $resultSet = $user;
        }
        return $resultSet;
    }

    public function getByEmailAndPassword(Utilisateur $user): ?Utilisateur
    {
        $resultSet = null;
        $query = "SELECT utilisateur.*, role.nomRole 
              FROM {$this->nomTable}
              INNER JOIN role ON utilisateur.idrole = role.idrole 
              WHERE emailutilisateur = :email";
        $reqPrep = $this->pdoObject->prepare($query);
        $res = $reqPrep->execute(['email' => $user->getEmailUtilisateur()]);

        if ($res !== false) {
            $row = $reqPrep->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($user->getPasswordUtilisateur(), $row['passwordutilisateur'])) {
                $role = new Role($row);
                $role->setNomRole($row['nomrole']);
                $utilisateur = new Utilisateur($row);
                $utilisateur->setRole($role);
                $resultSet = $utilisateur;
            }else {
                return null;
            }
        }
        return $resultSet;
    }

    public function deleteUtilisateur(int $id): bool {

        $query = "DELETE FROM livreutilisateur WHERE idutilisateur = :id";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['id' => $id]);

        $query = "DELETE FROM transaction WHERE idutilisateur = :id";
        $reqPrep = $this->pdoObject->prepare($query);
        $reqPrep->execute(['id' => $id]);

        $query2 = "DELETE FROM utilisateur WHERE idutilisateur = :id";
        $reqPrep = $this->pdoObject->prepare($query2);
        $res = $reqPrep->execute(['id' => $id]);

        return $res !== false;
    }
}