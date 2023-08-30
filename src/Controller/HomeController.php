<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PropertyRepository $properties, Request $request): Response
    {
        $properties = $properties->findAll();
        return $this->render('home/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
