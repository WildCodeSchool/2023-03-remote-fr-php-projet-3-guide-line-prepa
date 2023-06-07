<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(InstrumentRepository $instrumentRepository): Response
    {
        $instruments = $instrumentRepository->findAll();
        return $this->render('home/index.html.twig', [
            'instruments' => $instruments
        ]);
    }
}
