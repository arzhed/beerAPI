<?php

namespace App\Entity;

use App\Repository\BeerRepository;
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
     * Set id
     * @param integer $id
     * @return Test
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $brewery_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cat_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $style_id;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $add_user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_mod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brewer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coordinates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

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

    public function getBreweryId(): ?int
    {
        return $this->brewery_id;
    }

    public function setBreweryId(?int $brewery_id): self
    {
        $this->brewery_id = $brewery_id;

        return $this;
    }

    public function getCatId(): ?int
    {
        return $this->cat_id;
    }

    public function setCatId(?int $cat_id): self
    {
        $this->cat_id = $cat_id;

        return $this;
    }

    public function getStyleId(): ?int
    {
        return $this->style_id;
    }

    public function setStyleId(?int $style_id): self
    {
        $this->style_id = $style_id;

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

    public function getAddUser(): ?int
    {
        return $this->add_user;
    }

    public function setAddUser(?int $add_user): self
    {
        $this->add_user = $add_user;

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

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBrewer(): ?string
    {
        return $this->brewer;
    }

    public function setBrewer(?string $brewer): self
    {
        $this->brewer = $brewer;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCoordinates(): ?string
    {
        return $this->coordinates;
    }

    public function setCoordinates(?string $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
}
