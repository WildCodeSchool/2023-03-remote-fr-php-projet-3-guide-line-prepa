<?php

namespace App\Twig\Components;

use App\Repository\InstrumentRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('search')]
final class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $search = '';

    public function __construct(
        private readonly InstrumentRepository $instrumentRepository
    ) {
    }

    public function searchInstruments(): array
    {
        return mb_strlen($this->search) ? $this->instrumentRepository->findLikeName($this->search)->getResult() : [];
    }
}
