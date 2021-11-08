<?php

namespace App\Entity;

use App\Repository\CongesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CongesRepository::class)
 */
class Conges
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $iduser;

    /**
     * @ORM\Column(type="date")
     */
    public $startdate;

    /**
     * @ORM\Column(type="integer")
     */
    public $numberdays;

    /**
     * @ORM\Column(type="array")
     */
    public $status = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getNumberdays(): ?int
    {
        return $this->numberdays;
    }

    public function setNumberdays(int $numberdays): self
    {
        $this->numberdays = $numberdays;

        return $this;
    }

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }
}
