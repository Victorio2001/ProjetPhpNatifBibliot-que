<?php

namespace MonApp\model\DTO;

class MotCle
{
    private ?int $idMotCle = null;
    private ?string $motCle;

    /**
     * @param int|null $idMotCle
     * @param string|null $motCle
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idmotcle'])) ? $this->setIdMotCle($datas['idmotcle']) : $this->idMotCle = null;
            (isset($datas['motcle'])) ? $this->setMotCle($datas['motcle']) : $this->setMotCle(null);
        }
        
    }

    public function getIdMotCle(): ?int
    {
        return $this->idMotCle;
    }

    public function setIdMotCle(?int $idMotCle): void
    {
        $this->idMotCle = $idMotCle;
    }

    public function getMotCle(): ?string
    {
        return $this->motCle;
    }

    public function setMotCle(?string $motCle): void
    {
        if (is_null($motCle)) {
            throw new \TypeError("Le MotCle est null.");
        }
        if ($motCle == "") {
            throw new \TypeError("Le MotCle est vide.");
        }
        if (strlen($motCle) > 150) {
            $motCle = substr($motCle, 0, 150);
        }
        $this->motCle = $motCle;
    }


}