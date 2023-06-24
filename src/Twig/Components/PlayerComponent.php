<?php

namespace App\Twig\Components;

use App\Entity\Sound;
use App\Repository\SoundRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('player')]
final class PlayerComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?int $soundId = null;

    public function __construct(private SoundRepository $soundRepository)
    {
    }

    public function getSound(): int|Sound|null
    {
        return $this->soundId ? $this->soundRepository->find($this->soundId) : null;
    }
}
