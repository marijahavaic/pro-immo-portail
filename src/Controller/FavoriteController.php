<?php

namespace App\Controller;

use App\Repository\FavoriteRepository;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function index(PropertyRepository $properties, UserRepository $users, FavoriteRepository $favorites, Request $request): Response{

        $favorites = $users->getFavorite();

        $favoriteProperties = [];
        foreach ($favorites as $favorite) {
            $favoriteProperties = array_merge($favoriteProperties, $favorite->getProperties()->toArray());
        }

        return $this->render('favorite/index.html.twig', [
            'properties' => $favoriteProperties,
            'users' => $users
        ]);
    }
}
