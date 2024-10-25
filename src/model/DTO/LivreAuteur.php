<?php

namespace MonApp\model\DTO;

class LivreAuteur
{
    private ?Livre $Livre;
    private ?Auteur $Auteur;

    /**
     * @param Livre|null $Livre
     * @param Auteur|null $Auteur
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['Livre'])) ? $this->setLivre($datas['Livre']) : $this->setLivre(null);
            (isset($datas['Auteur'])) ? $this->setAuteur($datas['Auteur']) : $this->setAuteur(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getLivre(): ?Livre
    {
        return $this->Livre;
    }

    public function setLivre(?Livre $Livre): void
    {
        $this->Livre = $Livre;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->Auteur;
    }

    public function setAuteur(?Auteur $Auteur): void
    {
        $this->Auteur = $Auteur;
    }

}