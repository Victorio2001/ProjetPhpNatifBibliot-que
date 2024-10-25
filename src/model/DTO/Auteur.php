<?php

namespace MonApp\model\DTO;


class Auteur 
{
    private ?int $idAuteur = null;
    private ?string $nomAuteur;
    private ?string $prenomAuteur;

    /**
     * @param int|null $idAuteur
     * @param string|null $nomAuteur
     * @param string|null $prenomAuteur
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idauteur'])) ? $this->setIdAuteur($datas['idauteur']) : $this->idAuteur = null;
            (isset($datas['nomauteur'])) ? $this->setNomAuteur($datas['nomauteur']) : $this->setNomAuteur('null');
            (isset($datas['prenomauteur'])) ? $this->setPrenomAuteur($datas['prenomauteur']) : $this->setPrenomAuteur('null');
        }
    }

    public function getIdAuteur(): ?int
    {
        return $this->idAuteur;
    }

    public function setIdAuteur(?int $idAuteur): void
    {
        $this->idAuteur = $idAuteur;
    }

    public function getNomAuteur(): ?string
    {
        return $this->nomAuteur;
    }

    public function setNomAuteur(?string $nomAuteur): void
    {
        if (is_null($nomAuteur)) {
            throw new \TypeError("Le Nom est null.");
        }
        if ($nomAuteur == "") {
            throw new \TypeError("Le Nom est vide.");
        }
        if (strlen($nomAuteur) > 50) {
            $nomAuteur = substr($nomAuteur, 0, 50);
        }
        $this->nomAuteur = $nomAuteur;
    }

    public function getPrenomAuteur(): ?string
    {
        return $this->prenomAuteur;
    }

    public function setPrenomAuteur(?string $prenomAuteur): static
    {
        if (is_null($prenomAuteur)) {
            throw new \TypeError("Le Prenom est null.");
        }
        if ($prenomAuteur == "") {
            throw new \TypeError("Le Prenom est vide.");
        }
        if (strlen($prenomAuteur) > 50) {
            $prenomAuteur = substr($prenomAuteur, 0, 50);
        }
        $this->prenomAuteur = $prenomAuteur;
        return $this;

    }

}