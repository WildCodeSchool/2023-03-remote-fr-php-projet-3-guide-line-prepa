<?php

namespace App\Twig\Components;

use App\Entity\Sound;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('sound')]
final class SoundComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Sound $sound;

    #[LiveProp()]
    public int $index;
}
