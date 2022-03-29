<?php

namespace App\Entity;

use App\Repository\ClothesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClothesRepository::class)
 */
class Clothes
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
     * @ORM\ManyToOne(targetEntity=ClothesCategory::class, inversedBy="Color")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clothes_category;

    /**
     * @ORM\OneToMany(targetEntity=Guilty::class, mappedBy="vet_1")
     */
    private $guilties;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="clothes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    public function __construct()
    {
        $this->guilties = new ArrayCollection();
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

    public function getClothesCategory(): ?ClothesCategory
    {
        return $this->clothes_category;
    }

    public function setClothesCategory(?ClothesCategory $clothes_category): self
    {
        $this->clothes_category = $clothes_category;

        return $this;
    }

    /**
     * @return Collection<int, Guilty>
     */
    public function getGuilties(): Collection
    {
        return $this->guilties;
    }

    public function addGuilty(Guilty $guilty): self
    {
        if (!$this->guilties->contains($guilty)) {
            $this->guilties[] = $guilty;
            $guilty->setVet1($this);
        }

        return $this;
    }

    public function removeGuilty(Guilty $guilty): self
    {
        if ($this->guilties->removeElement($guilty)) {
            // set the owning side to null (unless already changed)
            if ($guilty->getVet1() === $this) {
                $guilty->setVet1(null);
            }
        }

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }
}
