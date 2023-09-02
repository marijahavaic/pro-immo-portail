<?php

namespace App\Controller;

use App\Repository\FavoriteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{  
    #[Route('/favorite', name: 'app_favorite')]
    public function index(FavoriteRepository $favorites, PaginatorInterface $paginator, Request $request): Response
    {   
        $user = $this->getUser();
        $favoriteProperties = $user->getFavorite()->getValues();

        $query = $favorites->findAll();

        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre de résultats par page
        );
        return $this->render('favorite/index.html.twig', [
            'favorites' => $favoriteProperties,
            'favorite' => $pagination,
            ]);
    }
}
