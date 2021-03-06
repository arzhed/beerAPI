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
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\Column(type="float")
     */
    private $abv;

    /**
     * @ORM\Column(type="integer")
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this->checkins = new ArrayCollection();
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

    public function setLastMod($last_mod): self
    {
        if (is_string($last_mod)) {
            $last_mod = \DateTime::createFromFormat("U", strtotime($last_mod));
        }
        if (get_class($last_mod) != 'DateTime') {
            throw new \Exception("Beer::setLastMod only takes DateTime");
        }
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        if (is_string($created_at)) {
            $created_at = \DateTime::createFromFormat("U", strtotime($created_at));
        }
        if (get_class($created_at) != 'DateTime') {
            throw new \Exception("Beer::setCreatedAt only takes DateTime");
        }
        $this->created_at = $created_at;

        return $this;
    }

}
