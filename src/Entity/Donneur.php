<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonneurRepository")
 */
class Donneur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SimpleUser", inversedBy="donneurs")
     */
    private $usedonneur;

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

    public function getUsedonneur(): ?SimpleUser
    {
        return $this->usedonneur;
    }

    public function setUsedonneur(?SimpleUser $usedonneur): self
    {
        $this->usedonneur = $usedonneur;

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
