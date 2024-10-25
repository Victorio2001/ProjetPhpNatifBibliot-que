<?php

namespace MonApp\model\DTO;

class Editeur
{
    private ?int $idEditeur = null;
    private ?string $nomEditeur;

    /**
     * @param int|null $idEditeur
     * @param string|null $nomEditeur
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idediteur'])) ? $this->setIdEditeur($datas['idediteur']) : $this->idEditeur = null;
            (isset($datas['nomediteur'])) ? $this->setNomEditeur($datas['nomediteur']) : $this->setNomEditeur(null);
        }
        
    }

    public function getIdEditeur(): ?int
    {
        return $this->idEditeur;
    }

    public function setIdEditeur(?int $idEditeur): void
    {
        $this->idEditeur = $idEditeur;
    }

    public function getNomEditeur(): ?string
    {
        return $this->nomEditeur;
    }

    public function setNomEditeur(?string $nomEditeur): void
    {
        if (is_null($nomEditeur)) {
            throw new \TypeError("Le nom est null.");
        }
        if ($nomEditeur == "") {
            throw new \TypeError("Le nom est vide.");
        }
        if (strlen($nomEditeur) > 100) {
            $nomEditeur = substr($nomEditeur, 0, 100);
        }
        $this->nomEditeur = $nomEditeur;
    }


}