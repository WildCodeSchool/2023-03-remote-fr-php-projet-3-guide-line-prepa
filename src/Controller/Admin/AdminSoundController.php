<?php

namespace App\Controller\Admin;

use App\Entity\Sound;
use App\Form\SoundType;
use App\Repository\SoundRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sound')]
class AdminSoundController extends AbstractController
{
    #[Route('/', name: 'app_admin_sound_index', methods: ['GET'])]
    public function index(
        SoundRepository $soundRepository,
        Request $request,
        PaginatorInterface $paginator
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
            $query = $soundRepository->findLikeName($search);
        } else {
            $query = $soundRepository->queryFindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            15 /*limit per page*/
        );
        return $this->render('admin_sound/index.html.twig', [
            'sounds' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/new', name: 'app_admin_sound_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SoundRepository $soundRepository): Response
    {
        $sound = new Sound();
        $form = $this->createForm(SoundType::class, $sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $soundRepository->save($sound, true);

            return $this->redirectToRoute('app_admin_sound_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_sound/new.html.twig', [
            'sound' => $sound,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sound_show', methods: ['GET'])]
    public function show(Sound $sound): Response
    {
        return $this->render('admin_sound/show.html.twig', [
            'sound' => $sound,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sound_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sound $sound, SoundRepository $soundRepository): Response
    {
        $form = $this->createForm(SoundType::class, $sound);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $soundRepository->save($sound, true);
            $this->addFlash('success', 'Mise à jour effectuée avec succès.');
            return $this->redirectToRoute('app_admin_sound_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_sound/edit.html.twig', [
            'sound' => $sound,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sound_delete', methods: ['POST'])]
    public function delete(Request $request, Sound $sound, SoundRepository $soundRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sound->getId(), $request->request->get('_token'))) {
            $soundRepository->remove($sound, true);
        }

        return $this->redirectToRoute('app_admin_sound_index', [], Response::HTTP_SEE_OTHER);
    }
}
