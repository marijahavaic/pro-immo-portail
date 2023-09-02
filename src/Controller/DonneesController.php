<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonneesController extends AbstractController
{
    #[Route('/donnees', name: 'app_donnees')]
    public function index(): Response
    {
        return $this->render('donnees/index.html.twig', [
            'controller_name' => 'DonneesController',
        ]);
    }
}
