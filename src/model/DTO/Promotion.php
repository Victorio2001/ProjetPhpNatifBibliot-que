<?php

namespace MonApp\model\DTO;

class Promotion
{
    private ?int $idPromotion = null;
    private ?string  $nomPromotion;
    private ?\DateTime $debutFormation;
    private ?\DateTime $finFormation;
    private ?Utilisateur $Utilisateur;

    /**
     * @param int|null $idPromotion
     * @param string|null $nomPromotion
     * @param \DateTime|null $debutFormation
     * @param \DateTime|null $finFormation
     * @param Utilisateur|null $Utilisateur
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idpromotion'])) ? $this->setIdPromotion($datas['idpromotion']) : $this->idPromotion = null;
            (isset($datas['nompromotion'])) ? $this->setNomPromotion($datas['nompromotion']) : $this->setNomPromotion(null);
            (isset($datas['debutformation'])) ? $this->setDebutFormation($datas['debutformation']) : $this->setDebutFormation(null);
            (isset($datas['finformation'])) ? $this->setFinFormation($datas['finformation']) : $this->setFinFormation(null);
            (isset($datas['Utilisateur'])) ? $this->setUtilisateur($datas['Utilisateur']) : $this->setUtilisateur(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getIdPromotion(): ?int
    {
        return $this->idPromotion;
    }

    public function setIdPromotion(?int $idPromotion): void
    {
        $this->idPromotion = $idPromotion;
    }

    public function getNomPromotion(): ?string
    {
        return $this->nomPromotion;
    }

    public function setNomPromotion(?string $nomPromotion): void
    {
        if (is_null($nomPromotion)) {
            throw new \TypeError("Le NomPromotion est null.");
        }
        if ($nomPromotion == "") {
            throw new \TypeError("Le NomPromotion est vide.");
        }
        if (strlen($nomPromotion) > 50) {
            $nomPromotion = substr($nomPromotion, 0, 50);
        }
        $this->nomPromotion = $nomPromotion;
    }
    public function getDebutFormation(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->debutFormation:$this->debutFormation->format($format);
    }
    public function setDebutFormation(\DateTime|string|null $debutFormation = null) : static {
        if (is_null($debutFormation)) {
            $this->debutFormation = new \DateTime();
        } else if(is_string($debutFormation)) {
            $this->debutFormation = new \DateTime($debutFormation);
        } else {
            $this->debutFormation = $debutFormation;
        }
        return $this;
    }
    public function getFinFormation(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->finFormation:$this->finFormation->format($format);
    }
    public function setFinFormation(\DateTime|string|null $finFormation = null) : static {
        if (is_null($finFormation)) {
            $this->finFormation = new \DateTime();
        } else if(is_string($finFormation)) {
            $this->finFormation = new \DateTime($finFormation);
        } else {
            $this->finFormation = $finFormation;
        }
        return $this;
    }
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): void
    {
        $this->Utilisateur = $Utilisateur;
    }


}