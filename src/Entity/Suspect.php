<?php

namespace App\Entity;

use App\Repository\SuspectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuspectRepository::class)
 */
class Suspect
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Guilty::class, mappedBy="suspect")
     */
    private $guilties;

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

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $guilty->setSuspect($this);
        }

        return $this;
    }

    public function removeGuilty(Guilty $guilty): self
    {
        if ($this->guilties->removeElement($guilty)) {
            // set the owning side to null (unless already changed)
            if ($guilty->getSuspect() === $this) {
                $guilty->setSuspect(null);
            }
        }

        return $this;
    }
}
