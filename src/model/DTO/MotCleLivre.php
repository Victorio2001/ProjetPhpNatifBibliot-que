<?php

namespace MonApp\model\DTO;

class MotCleLivre
{
    private ?Livre $Livre;
    private ?MotCle $MotCle;

    /**
     * @param Livre|null $Livre
     * @param MotCle|null $MotCle
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['Livre'])) ? $this->setLivre($datas['Livre']) : $this->setLivre(null);
            (isset($datas['MotCle'])) ? $this->setMotCle($datas['MotCle']) : $this->setMotCle(null);
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

    public function getMotCle(): ?MotCle
    {
        return $this->MotCle;
    }

    public function setMotCle(?MotCle $MotCle): void
    {
        $this->MotCle = $MotCle;
    }


}