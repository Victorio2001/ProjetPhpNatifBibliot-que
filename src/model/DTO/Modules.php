<?php

namespace MonApp\model\DTO;

class Modules
{
    private ?int $idModules = null;
    private ?string $nomModules;

    /**
     * @param int|null $idModules
     * @param string|null $nomModules
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idmodules'])) ? $this->setIdModules($datas['idmodules']) : $this->idModules = null;
            (isset($datas['nommodules'])) ? $this->setNomModules($datas['nommodules']) : $this->setNomModules(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getIdModules(): ?int
    {
        return $this->idModules;
    }

    public function setIdModules(?int $idModules): void
    {
        $this->idModules = $idModules;
    }

    public function getNomModules(): ?string
    {
        return $this->nomModules;
    }

    public function setNomModules(?string $nomModules): void
    {
        if (is_null($nomModules)) {
            throw new \TypeError("Le NomModules est null.");
        }
        if ($nomModules == "") {
            throw new \TypeError("Le NomModules est vide.");
        }
        if (strlen($nomModules) > 50) {
            $nomModules = substr($nomModules, 0, 50);
        }
        $this->nomModules = $nomModules;
    }

}