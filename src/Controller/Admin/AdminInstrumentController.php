<?php

namespace App\Controller\Admin;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Repository\InstrumentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instrument')]
class AdminInstrumentController extends AbstractController
{
    #[Route('/', name: 'app_admin_instrument_index', methods: ['GET'])]
    public function index(
        InstrumentRepository $instrumentRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $form = $this->createFormBuilder(null, [
            'method' => 'get',
            'csrf_protection' => false
        ])
            ->add('search', SearchType::class, [
                'attr' => ['autofocus' => true]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $instrumentRepository->findLikeName($search);
        } else {
            $query = $instrumentRepository->queryFindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            15 /*limit per page*/
        );
        return $this->render('admin_instrument/index.html.twig', [
            'instruments' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/new', name: 'app_admin_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InstrumentRepository $instrumentRepository): Response
    {
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instrumentRepository->save($instrument, true);

            return $this->redirectToRoute('app_admin_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_instrument/new.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_instrument_show', methods: ['GET'])]
    public function show(Instrument $instrument): Response
    {
        return $this->render('admin_instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instrument $instrument, InstrumentRepository $instrumentRepository): Response
    {
        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instrumentRepository->save($instrument, true);

            return $this->redirectToRoute('app_admin_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_instrument/edit.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_instrument_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Instrument $instrument,
        InstrumentRepository $instrumentRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $instrument->getId(), $request->request->get('_token'))) {
            $instrumentRepository->remove($instrument, true);
        }

        return $this->redirectToRoute('app_admin_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}
