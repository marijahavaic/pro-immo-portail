<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PropertyRepository $properties, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $properties->findAll();

        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre de résultats par page
        );

        return $this->render('home/index.html.twig', [
            'properties' => $pagination
        ]);
    }
    }
