<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class NavigationCSSRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    public function getActiveCSSClass(array $attributes = [], string $path = '', string $cssClass = 'active'): string
    {
        $requestAttributes = explode(
            '::',
            $this->requestStack->getCurrentRequest()->attributes->get('_controller')
        );
        $pathInfo = $this->requestStack->getCurrentRequest()->getPathInfo();
        return match (true) {
            !empty($attributes[0]) &&
            (empty($attributes[1]) || $attributes[1] === $requestAttributes[1]) &&
            'App\\Controller\\' . $attributes[0] === $requestAttributes[0],
                !empty($path) && $path === $pathInfo => $cssClass,
            default => ''
        };
    }
}
