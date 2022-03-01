<?php 

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\OngletRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogpostController extends AbstractController
{

    #[Route('boutique/onglet/{id}', name: 'boutique_blogpost_show_by_onglet')]
    public function showBlogpostByOnglet(int $id, OngletRepository $ongletRepository)
    {
        $onglet = $ongletRepository->find($id);

        if(!$onglet)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render("customer/blogpost/show_by_onglet.html.twig",[
            'onglet' => $onglet
        ]);
    }
    #[Route('boutique/blogpost/{id}', name: 'boutique_blogpost_detail')]
    public function detailBlogpost(int $id, BlogpostRepository $blogpostRepository)
    {
    
        $blogpost = $blogpostRepository->find($id);

        if(!$blogpost)
        {
            return $this->redirectToRoute("home");
        }

        $onglet = $blogpost->getOnglet();

        $blogpostsOnglet = $onglet->getBlogposts();

        $suggestedBlogposts = [];

        foreach($blogpostsOnglet as $item)
        {
            if($item !== $onglet)
            {
                $suggestedBlogposts[] = $item;
            }
        }

        $suggestedBlogposts = array_slice($suggestedBlogposts,0,4);

        return $this->render("customer/blogpost/detail_blogpost.html.twig",[
            'blogpost' => $blogpost,
            'suggestedBlogposts' => $suggestedBlogposts
        ]);
    }

}

?>