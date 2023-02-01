<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Entity\Material;
use App\Entity\NumberPlate;
use App\Form\CreateCarrierFormType;
use App\Form\CreateMaterialFormType;
use App\Form\CreateNumberPlateFormType;
use App\Repository\NumberPlateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatriceController extends AbstractController
{
    #[Route('/matrice', name: 'app_matrice')]
    public function matrice(): Response
    {
        return $this->render('matrice/index.html.twig', []);
    }
    #[Route('/matrice/create/carrier', name: 'app_create_carrier')]
    public function createCarrier(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carrier = new Carrier;
        $form = $this->createForm(CreateCarrierFormType::class, $carrier);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($carrier);
            $entityManager->flush();
            return $this->redirectToRoute('app_matrice');
        }
        return $this->render('matrice/create_carrier.html.twig', ['carrierForm' => $form->createView()]);
    }
    #[Route('/matrice/create/material', name: 'app_create_material')]
    public function createMaterial(Request $request, EntityManagerInterface $entityManager): Response
    {
        $material = new Material;
        $form = $this->createForm(CreateMaterialFormType::class, $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($material);
            $entityManager->flush();
            return $this->redirectToRoute('app_matrice');
        }
        return $this->render('matrice/create_material.html.twig', ['materialForm' => $form->createView()]);
    }
    #[Route('/matrice/create/numberplate', name: 'app_create_number_plate')]
    public function createNumberPlate(Request $request, EntityManagerInterface $entityManager, NumberPlateRepository $numberPlateRepository): Response
    {
        $numberPlate = new NumberPlate;
        $form = $this->createForm(CreateNumberPlateFormType::class, $numberPlate);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $number = $form->get('number')->getData();
            $duplicateNumbers = $numberPlateRepository->findByNumber($number);
            foreach ($duplicateNumbers as $duplicateNumber) {
                if ($duplicateNumber->getNumber() == $number) {
                    $this->addFlash('danger', 'Cette plaque existe déjà');
                    return $this->redirectToRoute('app_create_number_plate');
                }
            }
            $entityManager->persist($numberPlate);
            $entityManager->flush();
            return $this->redirectToRoute('app_matrice');
        }
        return $this->render('matrice/create_number_plate.html.twig', ['numberPlateForm' => $form->createView()]);
    }
}
