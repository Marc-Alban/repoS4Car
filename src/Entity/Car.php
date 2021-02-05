<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank(message="Champs modèle ne doit pas être vide")
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $model;

    /**
     * @Assert\NotBlank(message="Champs prix ne doit pas être vide")
     * @Assert\LessThan(value="5000", message="Maximum de 5000€")
     * @Assert\GreaterThan(value="100", message="min de 100€")
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @ORM\OneToMany(targetEntity="Keyword", mappedBy="car", cascade={"persist","remove"})
     */
    private $keywords;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
    }

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist","remove"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carburant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }


    public function setImage($image): void
    {
        $this->image = $image;
    }


    public function getKeywords()
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword)
    {
        $this->keywords->add($keyword);
        $keyword->setCar($this);
    }

    public function removeKeyword(Keyword $keyword)
    {
        $this->keywords->removeElement($keyword);
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }
}
