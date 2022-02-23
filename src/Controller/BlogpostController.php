<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Form\BlogpostType;
use App\Repository\BlogpostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blogpost')]
class BlogpostController extends AbstractController
{
    #[Route('/', name: 'blogpost_index', methods: ['GET'])]
    public function index(BlogpostRepository $blogpostRepository): Response
    {
        return $this->render('blogpost/index.html.twig', [
            'blogposts' => $blogpostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'blogpost_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogpost = new Blogpost();
        $form = $this->createForm(BlogpostType::class, $blogpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blogpost);
            $entityManager->flush();

            return $this->redirectToRoute('blogpost_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blogpost/new.html.twig', [
            'blogpost' => $blogpost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'blogpost_show', methods: ['GET'])]
    public function show(Blogpost $blogpost): Response
    {
        return $this->render('blogpost/show.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }

    #[Route('/{id}/edit', name: 'blogpost_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blogpost $blogpost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogpostType::class, $blogpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('blogpost_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blogpost/edit.html.twig', [
            'blogpost' => $blogpost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'blogpost_delete', methods: ['POST'])]
    public function delete(Request $request, Blogpost $blogpost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogpost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blogpost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blogpost_index', [], Response::HTTP_SEE_OTHER);
    }
}
