<?php

namespace App\Entity;

use App\Repository\ClothesCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClothesCategoryRepository::class)
 */
class ClothesCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Clothes::class, mappedBy="clothes_category")
     */
    private $Color;

    public function __construct()
    {
        $this->Color = new ArrayCollection();
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
    public function getColor(): Collection
    {
        return $this->Color;
    }

    public function addColor(Clothes $color): self
    {
        if (!$this->Color->contains($color)) {
            $this->Color[] = $color;
            $color->setClothesCategory($this);
        }

        return $this;
    }

    public function removeColor(Clothes $color): self
    {
        if ($this->Color->removeElement($color)) {
            // set the owning side to null (unless already changed)
            if ($color->getClothesCategory() === $this) {
                $color->setClothesCategory(null);
            }
        }

        return $this;
    }
}
