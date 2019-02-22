<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=50 ,nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $fonction;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $userutilisateur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SimpleUser", cascade={"persist", "remove"})
     */
    private $simutilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getUserutilisateur(): ?User
    {
        return $this->userutilisateur;
    }

    public function setUserutilisateur(?User $userutilisateur): self
    {
        $this->userutilisateur = $userutilisateur;

        return $this;
    }

    public function getSimutilisateur(): ?SimpleUser
    {
        return $this->simutilisateur;
    }

    public function setSimutilisateur(?SimpleUser $simutilisateur): self
    {
        $this->simutilisateur = $simutilisateur;

        return $this;
    }
}
