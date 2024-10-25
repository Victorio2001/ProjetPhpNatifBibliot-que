<?php

namespace MonApp\model\DTO;

class ModuleUser
{
    private ?Utilisateur $Utilisateur;
    private ?Modules $Modules;

    /**
     * @param Utilisateur|null $Utilisateur
     * @param Modules|null $Modules
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['Utilisateur'])) ? $this->setUtilisateur($datas['Utilisateur']) : $this->setUtilisateur(null);
            (isset($datas['Modules'])) ? $this->setModules($datas['Modules']) : $this->setModules(null);
        }
        if ($datas == "") {
            throw new \TypeError("Données Params == null/vide");
        }
    }


    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): void
    {
        $this->Utilisateur = $Utilisateur;
    }

    public function getModules(): ?Modules
    {
        return $this->Modules;
    }

    public function setModules(?Modules $Modules): void
    {
        $this->Modules = $Modules;
    }

}