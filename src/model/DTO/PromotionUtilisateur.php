<?php

namespace MonApp\model\DTO;

class PromotionUtilisateur
{
    private ?Utilisateur $Utilisateur;
    private ?Promotion $Promotion;

    /**
     * @param Utilisateur|null $Utilisateur
     * @param Promotion|null $Promotion
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['Utilisateur'])) ? $this->setUtilisateur($datas['Utilisateur']) : $this->setUtilisateur(null);
            (isset($datas['Promotion'])) ? $this->setPromotion($datas['Promotion']) : $this->setPromotion(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): void
    {
        $this->Utilisateur = $Utilisateur;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->Promotion;
    }

    public function setPromotion(?Promotion $Promotion): void
    {
        $this->Promotion = $Promotion;
    }

}