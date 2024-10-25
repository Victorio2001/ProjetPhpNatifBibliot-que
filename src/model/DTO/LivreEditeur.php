<?php

namespace MonApp\model\DTO;

class LivreEditeur
{
    private ?Editeur $Editeur;
    private ?Livre $Livre;

    /**
     * @param Editeur|null $Editeur
     * @param Livre|null $Livre
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['Livre'])) ? $this->setLivre($datas['Livre']) : $this->setLivre(null);
            (isset($datas['Editeur'])) ? $this->setEditeur($datas['Editeur']) : $this->setEditeur(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getEditeur(): ?Editeur
    {
        return $this->Editeur;
    }

    public function setEditeur(?Editeur $Editeur): void
    {
        $this->Editeur = $Editeur;
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