<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{  
    #[Route('/favorite', name: 'app_favorite')]
    public function index(): Response
    {   
        $user = $this->getUser();
        $favoriteProperties = $user->getFavorite()->getValues();

        
        return $this->render('favorite/index.html.twig', [
            'favorites' => $favoriteProperties,
            ]);
    }
}
