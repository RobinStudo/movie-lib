<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"Vous devez saisir un titre")]
    #[ORM\Column(length: 60)]
    private ?string $title = null;

    #[Assert\Length(
        min: 50,
        minMessage: "Vous devez saisir au minimum {{ limit }} caractères",
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Length(
        max: 255,
        maxMessage: "Vous devez saisir moins de  {{ limit }} caractères",
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $releasedAt = null;

    #[ORM\Column]
    private ?bool $isBad = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'directedMovies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $director = null;

    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'actedMovies')]
    private Collection $actors;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getReleasedAt(): ?DateTimeInterface
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(?DateTimeInterface $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function isIsBad(): ?bool
    {
        return $this->isBad;
    }

    public function setIsBad(bool $isBad): self
    {
        $this->isBad = $isBad;

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

    public function getDirector(): ?Person
    {
        return $this->director;
    }

    public function setDirector(?Person $director): self
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Person $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    public function removeActor(Person $actor): self
    {
        $this->actors->removeElement($actor);

        return $this;
    }
}
/*
 * Changer la longueur du titre du film de 80 a 60
 */
