<?php

namespace App\Controller;

use DateTime;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/property')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $property = new Property();

        $property->setCreatedAt(new DateTime());

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('Photo')->getData();

            if ($photo) {

                // 2 - Modifier le nom de l'image (nom unique)
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // Transforme le nom de l'image en slug pour l'URL (minuscule, sans accent sans espace)
                $safeFilename = $slugger->slug($originalFilename);

                //Reconstruit le nom de l'image avec un identifiant unique et son extension
                $newFilename = '/images/properties/' .  $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();


                // 3 - Enregistrer l'image dans son répertoire ('articles_images')
                try {
                    $photo->move(
                        $this->getParameter('properties_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
                $property->setPhoto($newFilename);
            }

            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);

            if ($form->get('isRent')->getData()) {
                $property->setIsRent(true);
                $property->setIsOnSale(false);
            } else {
                $property->setIsRent(false);
                $property->setIsOnSale(true);
            }

            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setUpdatedAt(new DateTime());

            $photo = $form->get('Photo')->getData();

            if ($photo) {

                // 2 - Modifier le nom de l'image (nom unique)
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // Transforme le nom de l'image en slug pour l'URL (minuscule, sans accent sans espace)
                $safeFilename = $slugger->slug($originalFilename);

                //Reconstruit le nom de l'image avec un identifiant unique et son extension
                $newFilename = '/images/properties/' .  $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();


                // 3 - Enregistrer l'image dans son répertoire ('articles_images')
                try {
                    $photo->move(
                        $this->getParameter('properties_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
                $property->setPhoto($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
