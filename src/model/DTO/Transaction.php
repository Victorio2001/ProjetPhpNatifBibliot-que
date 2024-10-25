<?php

namespace MonApp\model\DTO;

class Transaction
{
    private ?int $idTransaction;
    private ?int $nbLivreAjoute;
    private ?int $nbLivreEnlever;
    private ?Utilisateur $Utilisateur;
    private ?Livre $Livre;

    /**
     * @param int|null $idTransaction
     * @param int|null $nbLivreAjoute
     * @param int|null $nbLivreEnlever
     * @param Utilisateur|null $Utilisateur
     * @param Livre|null $Livre
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idtransaction'])) ? $this->setIdTransaction($datas['idtransaction']) : $this->idTransaction = null;
            (isset($datas['nblivreajoute'])) ? $this->setNbLivreAjoute($datas['nblivreajoute']) : $this->setNbLivreAjoute(null);
            (isset($datas['nblivreenlever'])) ? $this->setNbLivreEnlever($datas['nblivreenlever']) : $this->setNbLivreEnlever(null);
            (isset($datas['Utilisateur'])) ? $this->setUtilisateur($datas['Utilisateur']) : $this->setUtilisateur(null);
            (isset($datas['Livre'])) ? $this->setLivre($datas['Livre']) : $this->setLivre(null);
        }
    }

    public function getIdTransaction(): ?int
    {
        return $this->idTransaction;
    }

    public function setIdTransaction(?int $idTransaction): void
    {
        $this->idTransaction = $idTransaction;
    }

    public function getNbLivreAjoute(): ?int
    {
        return $this->nbLivreAjoute;
    }

    public function setNbLivreAjoute(?int $nbLivreAjoute): void
    {
        $this->nbLivreAjoute = $nbLivreAjoute;
    }

    public function getNbLivreEnlever(): ?int
    {
        return $this->nbLivreEnlever;
    }

    public function setNbLivreEnlever(?int $nbLivreEnlever): void
    {
        $this->nbLivreEnlever = $nbLivreEnlever;
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