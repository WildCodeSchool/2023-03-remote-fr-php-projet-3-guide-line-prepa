<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Repository\InstrumentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instrument', name: 'app_instrument_')]
class InstrumentController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        InstrumentRepository $instrumentRepository,
        Request $request
    ): Response {
        $pagination = $paginator->paginate(
            $instrumentRepository->createQueryBuilder('i')->getQuery(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        return $this->render('instrument/index.html.twig', [
            'instruments' => $pagination
        ]);
    }

    #[Route('/show/{slug}', name: 'show')]
    public function show(Instrument $instrument): Response
    {
        return $this->render('instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }
}
