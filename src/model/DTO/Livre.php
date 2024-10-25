<?php

namespace MonApp\model\DTO;

class Livre
{
    private ?int $IdLivre = null;
    private ?string $titreLivre;
    private ?string $resumeLivre;
    private ?\DateTime $anneePublication;
    private ?int $nombreExemplaires;
    private ?int $isbn;
    private ?string $imageCouverture;

    /**
     * @param int|null $IdLivre
     * @param string|null $titreLivre
     * @param string|null $resumeLivre
     * @param \DateTime|null $anneePublication
     * @param int|null $nombreExemplaires
     * @param int|null $isbn
     * @param string|null $imageCouverture
     */
    public function __construct(?array $datas = null) {
        if (!is_null($datas)) {
            (isset($datas['idlivre'])) ? $this->setIdLivre($datas['idlivre']) : $this->IdLivre = null;
            (isset($datas['titrelivre'])) ? $this->setTitreLivre($datas['titrelivre']) : $this->setTitreLivre(null);
            (isset($datas['resumelivre'])) ? $this->setResumeLivre($datas['resumelivre']) : $this->setResumeLivre(null);
            (isset($datas['anneepublication'])) ? $this->setAnneePublication($datas['anneepublication']) : $this->setAnneePublication(null);
            (isset($datas['nombreexemplaires'])) ? $this->setNombreExemplaires($datas['nombreexemplaires']) : $this->setNombreExemplaires(null);
            (isset($datas['isbn'])) ? $this->setIsbn($datas['isbn']) : $this->setIsbn(null);
            (isset($datas['imagecouverture'])) ? $this->setImageCouverture($datas['imagecouverture']) : $this->setImageCouverture(null);
        }

    }

    public function getIdLivre(): ?int
    {
        return $this->IdLivre;
    }

    public function setIdLivre(?int $IdLivre): void
    {
        $this->IdLivre = $IdLivre;
    }

    public function getTitreLivre(): ?string
    {
        return $this->titreLivre;
    }

    public function setTitreLivre(?string $titreLivre): void
    {
        if (is_null($titreLivre)) {
            throw new \TypeError("Le Titre est null.");
        }
        if ($titreLivre == "") {
            throw new \TypeError("Le Titre est vide.");
        }
        if (strlen($titreLivre) > 50) {
            $titreLivre = substr($titreLivre, 0, 50);
        }
        $this->titreLivre = $titreLivre;
    }

    public function getResumeLivre(): ?string
    {
        return $this->resumeLivre;
    }

    public function setResumeLivre(?string $resumeLivre): void
    {
        if (is_null($resumeLivre)) {
            throw new \TypeError("Le Resume est null.");
        }
        if ($resumeLivre == "") {
            throw new \TypeError("Le Resume est vide.");
        }
        if (strlen($resumeLivre) > 500) {
            $resumeLivre = substr($resumeLivre, 0, 500);
        }
        $this->resumeLivre = $resumeLivre;
    }

    public function getAnneePublication(string|null $format=null): string|\DateTime {
        return (is_null($format))?$this->anneePublication:$this->anneePublication->format($format);
    }
    public function setAnneePublication(\DateTime|string|null $anneePublication = null) : static {
        if (is_null($anneePublication)) {
            $this->anneePublication = new \DateTime();
        } else if(is_string($anneePublication)) {
            $this->anneePublication = new \DateTime($anneePublication);
        } else {
            $this->anneePublication = $anneePublication;
        }
        return $this;
    }

    public function getNombreExemplaires(): ?int
    {
        return $this->nombreExemplaires;
    }

    public function setNombreExemplaires(?int $nombreExemplaires): void
    {
        $this->nombreExemplaires = $nombreExemplaires;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function setIsbn(?int $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getImageCouverture(): ?string
    {
        return $this->imageCouverture;
    }

    public function setImageCouverture(?string $imageCouverture): void
    {
        if (is_null($imageCouverture)) {
            throw new \TypeError("L'image est null.");
        }
        if ($imageCouverture == "") {
            throw new \TypeError("Le nom de l'image est vide.");
        }
        if (strlen($imageCouverture) > 500) {
            $imageCouverture = substr($imageCouverture, 0, 500);
        }
        $this->imageCouverture = $imageCouverture;
    }

}