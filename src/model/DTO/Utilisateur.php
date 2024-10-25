<?php

namespace MonApp\model\DTO;

class Utilisateur
{
    private ?int $idUtilisateur = null;
    private ?string $nomUtilisateur;
    private ?string $prenomUtilisateur;
    private ?string $passwordUtilisateur;
    private ?string $emailUtilisateur;
    private ?bool $compteActif = true;
    private ?Role $Role;

    /**
     * @param int|null $idUtilisateur
     * @param string|null $nomUtilisateur
     * @param string|null $prenomUtilisateur
     * @param string|null $passwordUtilisateur
     * @param string|null $emailUtilisateur
     * @param bool|null $compteActif
     * @param Role|null $Role
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idutilisateur'])) ? $this->setIdUtilisateur($datas['idutilisateur']) : $this->idUtilisateur = null;
            (isset($datas['nomutilisateur'])) ? $this->setNomUtilisateur($datas['nomutilisateur']) : $this->setNomUtilisateur(null);
            (isset($datas['prenomutilisateur'])) ? $this->setPrenomUtilisateur($datas['prenomutilisateur']) : $this->setPrenomUtilisateur(null);
            (isset($datas['passwordutilisateur'])) ? $this->setPasswordUtilisateur($datas['passwordutilisateur']) : $this->setPasswordUtilisateur(null);
            (isset($datas['emailutilisateur'])) ? $this->setEmailUtilisateur($datas['emailutilisateur']) : $this->setEmailUtilisateur(null);
            (isset($datas['compteactif'])) ? $this->setCompteActif($datas['compteactif']) : $this->setCompteActif(null);
            (isset($datas['Role'])) ? $this->setRole($datas['Role']) : $this->setRole(null);
        }

    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?int $idUtilisateur): void
    {
        $this->idUtilisateur = $idUtilisateur;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(?string $nomUtilisateur): void
    {
        if (is_null($nomUtilisateur)) {
            throw new \TypeError("Le NomUtilisateur est null.");
        }
        if ($nomUtilisateur == "") {
            throw new \TypeError("Le NomUtilisateur est vide.");
        }
        if (strlen($nomUtilisateur) > 50) {
            $nomUtilisateur = substr($nomUtilisateur, 0, 50);
        }
        $this->nomUtilisateur = $nomUtilisateur;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(?string $prenomUtilisateur): void
    {
        if (is_null($prenomUtilisateur)) {
            throw new \TypeError("Le PrenomUtilisateur est null.");
        }
        if ($prenomUtilisateur == "") {
            throw new \TypeError("Le PrenomUtilisateur est vide.");
        }
        if (strlen($prenomUtilisateur) > 50) {
            $prenomUtilisateur = substr($prenomUtilisateur, 0, 50);
        }
        $this->prenomUtilisateur = $prenomUtilisateur;
    }

    public function getPasswordUtilisateur(): ?string
    {
        return $this->passwordUtilisateur;
    }

    public function setPasswordUtilisateur(?string $passwordUtilisateur): void
    {
        if (is_null($passwordUtilisateur)) {
            throw new \TypeError("Le PrenomUtilisateur est null.");
        }
        if ($passwordUtilisateur == "") {
            throw new \TypeError("Le PrenomUtilisateur est vide.");
        }
        $this->passwordUtilisateur = $passwordUtilisateur;
    }

    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    public function setEmailUtilisateur(?string $emailUtilisateur): void
    {
        $this->emailUtilisateur = $emailUtilisateur;
    }

    public function getCompteActif(): ?bool
    {
        return $this->compteActif;
    }

    public function setCompteActif(?bool $compteActif): void
    {
        $this->compteActif = $compteActif;
    }

    public function getRole(): ?Role
    {
        return $this->Role;
    }

    public function setRole(?Role $Role): void
    {
        $this->Role = $Role;
    }


}