<?php

namespace MonApp\model\DTO;

class Role
{
    private ?int $idRole = null;
    private ?string $nomRole;

    /**
     * @param int|null $idRole
     * @param string|null $nomRole
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idrole'])) ? $this->setIdRole($datas['idrole']) : $this->idRole = null;
            (isset($datas['nomrole'])) ? $this->setNomRole($datas['nomrole']) : $this->setNomRole(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }

    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function setIdRole(?int $idRole): void
    {
        $this->idRole = $idRole;
    }

    public function getNomRole(): ?string
    {
        return $this->nomRole;
    }

    public function setNomRole(?string $nomRole): void
    {
        if (is_null($nomRole)) {
            throw new \TypeError("Le nom est null.");
        }
        if ($nomRole == "") {
            throw new \TypeError("Le nom est vide.");
        }
        if (strlen($nomRole) > 100) {
            $nomRole = substr($nomRole, 0, 100);
        }
        $this->nomRole = $nomRole;
    }


}