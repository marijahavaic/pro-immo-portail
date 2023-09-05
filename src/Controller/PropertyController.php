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

                // Modify photo name (unique name)
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // Transform photo name into URL slug (lowercase, no accent, no space)
                $safeFilename = $slugger->slug($originalFilename);

                //Reconstructs photo name with unique identifier and extension
                $newFilename = '/images/properties/' .  $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();


                // Save the image in its directory ('properties_images')
                try {
                    $photo->move(
                        $this->getParameter('properties_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // Add photo name to current object (setPhoto)
                $property->setPhoto($newFilename);
            }

            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);

            // If the "isRent" box is not checked, the "isOnSale" box is automatically checked.
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
// See the card property
    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }
// Edit the property
    #[Route('/{id}/edit', name: 'app_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setUpdatedAt(new DateTime());

            $photo = $form->get('Photo')->getData();

            if ($photo) {

                // Modify photo name (unique name)
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // Transform photo name into URL slug (lowercase, no accent, no space)
                $safeFilename = $slugger->slug($originalFilename);

                //Reconstructs photo name with unique identifier and extension
                $newFilename = '/images/properties/' .  $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();


                // Save the image in its directory ('properties_images')
                try {
                    $photo->move(
                        $this->getParameter('properties_images'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                // Add photo name to current object (setPhoto)
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
// Delete the property
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
