<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CondUtilisationController extends AbstractController
{
    #[Route('/cond/utilisation', name: 'app_cond_utilisation')]
    public function index(): Response
    {
        return $this->render('cond_utilisation/index.html.twig', [
            'controller_name' => 'CondUtilisationController',
        ]);
    }
}
