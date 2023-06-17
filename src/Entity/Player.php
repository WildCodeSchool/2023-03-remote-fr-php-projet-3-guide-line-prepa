<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: Sound::class)]
    private Collection $sounds;

    public function __construct()
    {
        $this->sounds = new ArrayCollection();
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
     * @return Collection<int, Sound>
     */
    public function getSounds(): Collection
    {
        return $this->sounds;
    }

    public function addSound(Sound $sound): self
    {
        if (!$this->sounds->contains($sound)) {
            $this->sounds->add($sound);
            $sound->setPlayer($this);
        }

        return $this;
    }

    public function removeSound(Sound $sound): self
    {
        if ($this->sounds->removeElement($sound)) {
            // set the owning side to null (unless already changed)
            if ($sound->getPlayer() === $this) {
                $sound->setPlayer(null);
            }
        }

        return $this;
    }
}
