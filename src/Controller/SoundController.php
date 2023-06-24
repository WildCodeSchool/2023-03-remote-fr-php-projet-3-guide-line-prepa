<?php

namespace App\Controller;

use App\Repository\SoundRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sounds', name: 'app_sound_')]
class SoundController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        SoundRepository $soundRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $pagination = $paginator->paginate(
            $soundRepository->queryFindAll(),
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );
        return $this->render('sound/index.html.twig', [
            'sounds' => $pagination,
        ]);
    }
}
