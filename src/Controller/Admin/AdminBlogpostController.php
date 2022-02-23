<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use App\Form\BlogpostType;
use App\Repository\BlogpostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/blogpost')]
class AdminBlogpostController extends AbstractController
{
    #[Route('/', name: 'admin_blogpost_index', methods: ['GET'])]
    public function index(BlogpostRepository $blogpostRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $blogpost = $paginator->paginate(
            $blogpostRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        return $this->render('admin/blogpost/index.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }

    #[Route('/new', name: 'admin_blogpost_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blogpost = new Blogpost();
        $form = $this->createForm(BlogpostType::class, $blogpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blogpost);
            $entityManager->flush();

            return $this->redirectToRoute('admin_blogpost_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blogpost/new.html.twig', [
            'blogpost' => $blogpost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_blogpost_show', methods: ['GET'])]
    public function show(Blogpost $blogpost): Response
    {
        return $this->render('admin/blogpost/show.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_blogpost_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blogpost $blogpost, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogpostType::class, $blogpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_blogpost_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/blogpost/edit.html.twig', [
            'blogpost' => $blogpost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_blogpost_delete', methods: ['POST'])]
    public function delete(Request $request, Blogpost $blogpost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogpost->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blogpost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blogpost_index', [], Response::HTTP_SEE_OTHER);
    }
}
