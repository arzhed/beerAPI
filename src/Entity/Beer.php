<?php

namespace App\Entity;

use App\Repository\BeerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BeerRepository::class)
 */
class Beer
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $abv;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ibu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_mod;

    /**
     * @ORM\OneToMany(targetEntity=Checkin::class, mappedBy="beer")
     */
    private $checkins;

    /**
     * @ORM\ManyToOne(targetEntity=Brewery::class, inversedBy="beers")
     */
    private $brewery;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="beers")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Style::class, inversedBy="beers")
     */
    private $style;

    public function __construct()
    {
        $this->checkins = new ArrayCollection();
    }
    
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

    public function getAbv(): ?float
    {
        return $this->abv;
    }

    public function setAbv(?float $abv): self
    {
        $this->abv = $abv;

        return $this;
    }

    public function getIbu(): ?int
    {
        return $this->ibu;
    }

    public function setIbu(?int $ibu): self
    {
        $this->ibu = $ibu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLastMod(): ?\DateTimeInterface
    {
        return $this->last_mod;
    }

    public function setLastMod(?\DateTimeInterface $last_mod): self
    {
        $this->last_mod = $last_mod;

        return $this;
    }

    /**
     * @return Collection|Checkin[]
     */
    public function getCheckins(): Collection
    {
        return $this->checkins;
    }

    public function addCheckin(Checkin $checkin): self
    {
        if (!$this->checkins->contains($checkin)) {
            $this->checkins[] = $checkin;
            $checkin->setBeer($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): self
    {
        if ($this->checkins->removeElement($checkin)) {
            // set the owning side to null (unless already changed)
            if ($checkin->getBeer() === $this) {
                $checkin->setBeer(null);
            }
        }

        return $this;
    }

    public function getBrewery(): ?Brewery
    {
        return $this->brewery;
    }

    public function setBrewery(?Brewery $brewery): self
    {
        $this->brewery = $brewery;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStyle(): ?Style
    {
        return $this->style;
    }

    public function setStyle(?Style $style): self
    {
        $this->style = $style;

        return $this;
    }
}
