<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{  
    

    #[Route('/favorite', name: 'app_favorite')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Création d'un nouvel objet Favorite
        $favorite = new Favorite();

        // Ajout des relations
        $favorite->addUser($user);
        $favorite->addProperty($property);

        // Enregistrement en base de données
        $entityManager->persist($favorite);
        $entityManager->flush();
        return $this->render('favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }
}
