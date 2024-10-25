<?php

namespace MonApp\model\DTO;

class Formation
{
    private ?int $idFormation = null;
    private ?string $libelleFormation;

    /**
     * @param int|null $idFormation
     * @param string|null $libelleFormation
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idformation'])) ? $this->setIdFormation($datas['idformation']) : $this->idFormation = null;
            (isset($datas['libelleformation'])) ? $this->setLibelleFormation($datas['libelleformation']) : $this->setLibelleFormation(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }


    public function getIdFormation(): ?int
    {
        return $this->idFormation;
    }

    public function setIdFormation(?int $idFormation): void
    {
        $this->idFormation = $idFormation;
    }

    public function getLibelleFormation(): ?string
    {
        return $this->libelleFormation;
    }

    public function setLibelleFormation(?string $libelleFormation): void
    {
        if (is_null($libelleFormation)) {
            throw new \TypeError("Le LibelleFormation est null.");
        }
        if ($libelleFormation == "") {
            throw new \TypeError("Le LibelleFormation est vide.");
        }
        if (strlen($libelleFormation) > 50) {
            $libelleFormation = substr($libelleFormation, 0, 50);
        }
        $this->libelleFormation = $libelleFormation;
    }

}