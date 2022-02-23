<?php

namespace App\Controller;

use App\Repository\OngletRepository;
use App\Repository\BlogpostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(OngletRepository $ongletRepository,BlogpostRepository $blogpostRepository): Response
    {
        //Je vais chercher dans la bdd les categories
        $onglet = $ongletRepository->findAll();

        //Je vais chercher les 8 derniers produits
        $blogpost = $blogpostRepository->findBy(
                [],
                [
                    'id' => 'DESC'
                ],
                8
            );

        //Je les envoie dans la vue
        return $this->render('customer/home.html.twig',[
            'onglet' => $onglet,
            'blogpost' => $blogpost
        ]);
    }
}
