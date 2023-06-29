<?php

namespace App\Controller;

use App\Entity\Instrument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instrument', name: 'app_instrument_')]
class InstrumentController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('instrument/index.html.twig');
    }

    #[Route('/show/{slug}', name: 'show')]
    public function show(Instrument $instrument): Response
    {
        return $this->render('instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }
}
