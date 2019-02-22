<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeurRepository")
 */
class Demandeur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SimpleUser", inversedBy="demandeurs")
     */
    private $userdemandeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gpe;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUserdemandeur(): ?SimpleUser
    {
        return $this->userdemandeur;
    }

    public function setUserdemandeur(?SimpleUser $userdemandeur): self
    {
        $this->userdemandeur = $userdemandeur;

        return $this;
    }

    public function getGpe(): ?string
    {
        return $this->gpe;
    }

    public function setGpe(string $gpe): self
    {
        $this->gpe = $gpe;

        return $this;
    }


}
