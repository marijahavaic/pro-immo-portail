<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(PropertyRepository $properties, PaginatorInterface $paginator, Request $request, MailerInterface $mailer): Response
    {
        $query = $properties->findBy([], ['createdAt' => 'DESC']);
        $user = $this->getUser();

        $pagination = $paginator->paginate(
            $query, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            10 // Nombre de résultats par page
        );

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('Nom')->getData();
            $prenom = $form->get('Prenom')->getData();
            $email = $form->get('Email')->getData();
            $tel = $form->get('Telephone')->getData();
            $message = $form->get('Message')->getData();

            // On envoie l'email avec les données du formulaire
            $contactMessage = (new Email())
                ->from($email)
                ->to('hello@pip.fr')
                ->subject('Vous avez reçu un nouveau message de ' . $nom . ' ' . $prenom)
                ->html("
                    <p>Vous avez reçu un nouveau message de la part de ' . $nom . ' ' . $prenom.</p>
                    <p>Le message :</p>
                    <p>' . $message . '</p>
                    <p>Voici ses coordonnées :</p>
                    <ul>
                        <li>Email : ' . $email . '</li>
                        <li>Téléphone : ' . $tel . '</li>
                    </ul>
                ");

            $mailer->send($contactMessage);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_home');
        }

        $result = $form->getData();

        return $this->render('home/index.html.twig', [
            'properties' => $pagination,
            'user' => $user,
            'form' => $form,
            'result' => $result,
        ]);
    }
}
