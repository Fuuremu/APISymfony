<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Clothes::class, mappedBy="color")
     */
    private $clothes;

    public function __construct()
    {
        $this->clothes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Clothes>
     */
    public function getClothes(): Collection
    {
        return $this->clothes;
    }

    public function addClothes(Clothes $clothes): self
    {
        if (!$this->clothes->contains($clothes)) {
            $this->clothes[] = $clothes;
            $clothes->setColor($this);
        }

        return $this;
    }

    public function removeClothes(Clothes $clothes): self
    {
        if ($this->clothes->removeElement($clothes)) {
            // set the owning side to null (unless already changed)
            if ($clothes->getColor() === $this) {
                $clothes->setColor(null);
            }
        }

        return $this;
    }
}
