<?php

namespace App\Entity;

use App\Repository\GuiltyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuiltyRepository::class)
 */
class Guilty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Suspect::class, inversedBy="guilties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suspect;

    /**
     * @ORM\ManyToOne(targetEntity=Clothes::class, inversedBy="guilties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vet_1;

    /**
     * @ORM\ManyToOne(targetEntity=Clothes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $vet_2;

    /**
     * @ORM\ManyToOne(targetEntity=Clothes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $vet_3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuspect(): ?Suspect
    {
        return $this->suspect;
    }

    public function setSuspect(?Suspect $suspect): self
    {
        $this->suspect = $suspect;

        return $this;
    }

    public function getVet1(): ?Clothes
    {
        return $this->vet_1;
    }

    public function setVet1(?Clothes $vet_1): self
    {
        $this->vet_1 = $vet_1;

        return $this;
    }

    public function getVet2(): ?Clothes
    {
        return $this->vet_2;
    }

    public function setVet2(?Clothes $vet_2): self
    {
        $this->vet_2 = $vet_2;

        return $this;
    }

    public function getVet3(): ?Clothes
    {
        return $this->vet_3;
    }

    public function setVet3(?Clothes $vet_3): self
    {
        $this->vet_3 = $vet_3;

        return $this;
    }
}
