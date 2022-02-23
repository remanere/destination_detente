<?php

namespace App\Controller\Admin;

use App\Entity\Onglet;
use App\Form\OngletType;
use App\Repository\OngletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/onglet')]
class AdminOngletController extends AbstractController
{
    #[Route('/', name: 'admin_onglet_index', methods: ['GET'])]
    public function index(OngletRepository $ongletRepository): Response
    {
        return $this->render('admin/onglet/index.html.twig', [
            'onglets' => $ongletRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_onglet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $onglet = new Onglet();
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($onglet);
            $entityManager->flush();

            return $this->redirectToRoute('admin_onglet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/onglet/new.html.twig', [
            'onglet' => $onglet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_onglet_show', methods: ['GET'])]
    public function show(Onglet $onglet): Response
    {
        $onglet = $OngletRepository->find($id);

        if(!$onglet)
        {
            $this->addFlash("danger","Onglet introuvable");
            return $this->redirectToRoute("admin_onglet_index");
        }
        return $this->render('admin/onglet/show.html.twig', [
            'onglet' => $onglet,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_onglet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Onglet $onglet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OngletType::class, $onglet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_onglet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/onglet/edit.html.twig', [
            'onglet' => $onglet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_onglet_delete', methods: ['POST'])]
    public function delete(Request $request, Onglet $onglet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$onglet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($onglet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_onglet_index', [], Response::HTTP_SEE_OTHER);
    }
}
