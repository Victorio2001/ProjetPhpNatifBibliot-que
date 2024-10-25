<?php

namespace MonApp\model\DTO;

class LivreUtilisateur
{
    private ?\DateTime $dateReservation;
    private ?\DateTime $dateRendu;
    private ?\DateTime $dateEmprunt;
    private ?string $etatRes;
    private ?bool $archiver = false;
    private ?int $nbExemplaire;
    private ?Utilisateur $Utilisateur;
    private ?Livre $Livre;

    /**
     * @param \DateTime|null $dateReservation
     * @param \DateTime|null $dateRendu
     * @param \DateTime|null $dateEmprunt
     * @param bool|null $archiver
     * @param string|null $etatRes
     * @param int|null $nbExemplaire
     * @param Utilisateur|null $Utilisateur
     * @param Livre|null $Livre
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['datereservation'])) ? $this->setDateReservation($datas['datereservation']) : $this->setDateReservation(null);
            (isset($datas['daterendu'])) ? $this->setDateRendu($datas['daterendu']) : $this->setDateRendu(null);
            (isset($datas['dateemprunt'])) ? $this->setDateEmprunt($datas['dateemprunt']) : $this->setDateEmprunt(null);
            (isset($datas['archiver'])) ? $this->setArchiver($datas['archiver']) : $this->setArchiver(null);
            (isset($datas['etatres'])) ? $this->setEtatRes($datas['etatres']) : $this->setEtatRes(null);
            (isset($datas['nbexemplaire'])) ? $this->setNbExemplaire($datas['nbexemplaire']) : $this->setNbExemplaire(null);
            (isset($datas['Utilisateur'])) ? $this->setUtilisateur($datas['Utilisateur']) : $this->setUtilisateur(null);
            (isset($datas['Livre'])) ? $this->setLivre($datas['Livre']) : $this->setLivre(null);
        }
    }

    public function getEtatRes(): ?string
    {
        return $this->etatRes;
    }

    public function setEtatRes(?string $etatRes): void
    {
        $this->etatRes = $etatRes;
    }
    public function getDateReservation(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->dateReservation:$this->dateReservation->format($format);
    }
    public function setDateReservation(\DateTime|string|null $dateReservation = null) : static {
        if (is_null($dateReservation)) {
            $this->dateReservation = new \DateTime();
        } else if(is_string($dateReservation)) {
            $this->dateReservation = new \DateTime($dateReservation);
        } else {
            $this->dateReservation = $dateReservation;
        }
        return $this;
    }
    public function getDateRendu(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->dateRendu:$this->dateRendu->format($format);
    }
    public function setDateRendu(\DateTime|string|null $dateRendu = null) : static {
        if (is_null($dateRendu)) {
            $this->dateRendu = new \DateTime();
        } else if(is_string($dateRendu)) {
            $this->dateRendu = new \DateTime($dateRendu);
        } else {
            $this->dateRendu = $dateRendu;
        }
        return $this;
    }
    public function getDateEmprunt(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->dateEmprunt:$this->dateEmprunt->format($format);
    }
    public function setDateEmprunt(\DateTime|string|null $dateEmprunt = null) : static {
        if (is_null($dateEmprunt)) {
            $this->dateEmprunt = new \DateTime();
        } else if(is_string($dateEmprunt)) {
            $this->dateEmprunt = new \DateTime($dateEmprunt);
        } else {
            $this->dateEmprunt = $dateEmprunt;
        }
        return $this;
    }
    public function getArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(?bool $archiver): void
    {
        $this->archiver = $archiver;
    }

    public function getNbExemplaire(): ?int
    {
        return $this->nbExemplaire;
    }

    public function setNbExemplaire(?int $nbExemplaire): void
    {
        $this->nbExemplaire = $nbExemplaire;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): void
    {
        $this->Utilisateur = $Utilisateur;
    }

    public function getLivre(): ?Livre
    {
        return $this->Livre;
    }

    public function setLivre(?Livre $Livre): void
    {
        $this->Livre = $Livre;
    }

}