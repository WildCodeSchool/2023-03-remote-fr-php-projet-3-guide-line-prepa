<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use App\Repository\SoundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        InstrumentRepository $instrumentRepository,
        SoundRepository $soundRepository
    ): Response {
        $instruments = $instrumentRepository->findBy(criteria: [], limit: 5);
        return $this->render('home/index.html.twig', [
            'instruments' => $instruments,
            'sounds' => $soundRepository->findBy([], orderBy: ['id' => 'DESC'], limit: 4)
        ]);
    }
}
