<?php

namespace App\Twig\Components;

use App\Entity\Sound;
use App\Repository\SoundRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('player')]
final class PlayerComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?int $soundId = null;

    public function __construct(
        private readonly SoundRepository $soundRepository,
        private readonly RequestStack $requestStack
    ) {
    }

    #[LiveAction]
    public function playSound(#[LiveArg] int $soundId): void
    {
        $this->requestStack->getSession()->set('soundPlaying', $soundId);
        $this->soundId = $soundId;
    }
    public function getSound(): int|Sound|null
    {
        return $this->soundId ? $this->soundRepository->find($this->soundId) : null;
    }
}
