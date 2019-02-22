<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Demandeur;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SimpleUserRepository")
 */
class SimpleUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime" ,nullable=true)
     */
    private $datanaissance;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $groupesanguin;




    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demandeur", mappedBy="userdemandeur")
     */
    private $demandeurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donneur", mappedBy="usedonneur")
     */
    private $donneurs;

    public function __construct()
    {
        $this->demandeurs = new ArrayCollection();
        $this->donneurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatanaissance(): ?\DateTime
    {
        return $this->datanaissance;
    }

    public function setDatanaissance(\DateTime $datanaissance): self
    {
        $this->datanaissance = $datanaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGroupesanguin(): ?string
    {
        return $this->groupesanguin;
    }

    public function setGroupesanguin(string $groupesanguin): self
    {
        $this->groupesanguin = $groupesanguin;

        return $this;
    }

    /**
     * @return Collection|Demandeur[]
     */
    public function getDemandeurs(): Collection
    {
        return $this->demandeurs;
    }

    public function addDemandeur(Demandeur $demandeur): self
    {
        if (!$this->demandeurs->contains($demandeur)) {
            $this->demandeurs[] = $demandeur;
            $demandeur->setUserdemandeur($this);
        }

        return $this;
    }

    public function removeDemandeur(Demandeur $demandeur): self
    {
        if ($this->demandeurs->contains($demandeur)) {
            $this->demandeurs->removeElement($demandeur);
            // set the owning side to null (unless already changed)
            if ($demandeur->getUserdemandeur() === $this) {
                $demandeur->setUserdemandeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Donneur[]
     */
    public function getDonneurs(): Collection
    {
        return $this->donneurs;
    }

    public function addDonneur(Donneur $donneur): self
    {
        if (!$this->donneurs->contains($donneur)) {
            $this->donneurs[] = $donneur;
            $donneur->setUsedonneur($this);
        }

        return $this;
    }

    public function removeDonneur(Donneur $donneur): self
    {
        if ($this->donneurs->contains($donneur)) {
            $this->donneurs->removeElement($donneur);
            // set the owning side to null (unless already changed)
            if ($donneur->getUsedonneur() === $this) {
                $donneur->setUsedonneur(null);
            }
        }

        return $this;
    }

}
