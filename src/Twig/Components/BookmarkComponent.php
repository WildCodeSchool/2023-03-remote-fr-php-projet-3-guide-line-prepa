<?php

namespace App\Twig\Components;

use App\Entity\Sound;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('bookmark')]
final class BookmarkComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Sound $sound;

    private User $user;

    public function __construct(
        private readonly Security $security,
        private readonly UserRepository $userRepository
    ) {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->user = $user;
    }

    #[LiveAction]
    public function toggleBookmark(): void
    {
        if ($this->user->getSoundsBookmarked()->contains($this->sound)) {
            $this->user->removeSoundsBookmarked($this->sound);
            $this->addFlash('warning', $this->sound->getTitle() . ' a bien été retiré de vos favoris.');
        } else {
            $this->addFlash('success', $this->sound->getTitle() . ' a bien été ajouté à vos favoris.');
            $this->user->addSoundsBookmarked($this->sound);
        }
        $this->userRepository->save($this->user, true);
    }

    public function isBookmarked(): bool
    {
        return $this->user->getSoundsBookmarked()->contains($this->sound);
    }
}
