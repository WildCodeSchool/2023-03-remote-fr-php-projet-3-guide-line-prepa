<?php

namespace App\Twig\Components;

use App\Repository\CompanyRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('navigation')]
final class NavigationComponent
{
    public function __construct(private readonly CompanyRepository $companyRepository)
    {
    }

    public function getCompanies(): array
    {
        return $this->companyRepository->findAll();
    }
}
