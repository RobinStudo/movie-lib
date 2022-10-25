<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $birthdate = null;

    #[ORM\OneToMany(mappedBy: 'director', targetEntity: Movie::class)]
    private Collection $directedMovies;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actors')]
    private Collection $actedMovies;

    public function __construct()
    {
        $this->directedMovies = new ArrayCollection();
        $this->actedMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getDirectedMovies(): Collection
    {
        return $this->directedMovies;
    }

    public function addDirectedMovie(Movie $directedMovie): self
    {
        if (!$this->directedMovies->contains($directedMovie)) {
            $this->directedMovies->add($directedMovie);
            $directedMovie->setDirector($this);
        }

        return $this;
    }

    public function removeDirectedMovie(Movie $directedMovie): self
    {
        if ($this->directedMovies->removeElement($directedMovie)) {
            if ($directedMovie->getDirector() === $this) {
                $directedMovie->setDirector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getActedMovies(): Collection
    {
        return $this->actedMovies;
    }

    public function addActedMovie(Movie $actedMovie): self
    {
        if (!$this->actedMovies->contains($actedMovie)) {
            $this->actedMovies->add($actedMovie);
            $actedMovie->addActor($this);
        }

        return $this;
    }

    public function removeActedMovie(Movie $actedMovie): self
    {
        if ($this->actedMovies->removeElement($actedMovie)) {
            $actedMovie->removeActor($this);
        }

        return $this;
    }

    public function getFilmography(): Collection
    {
        return new ArrayCollection(
            array_merge($this->getDirectedMovies()->toArray(), $this->getActedMovies()->toArray())
        );
    }
}
