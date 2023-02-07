<?php

namespace App\Controller;

use App\Entity\Extraction;
use App\Entity\Frequentation;
use App\Form\ExtractionFormType;
use App\Form\FrequentationFormType;
use App\Repository\ExtractionRepository;
use App\Repository\FrequentationRepository;
use App\Service\DateCompare;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandfillController extends AbstractController
{
    #[Route('/extraction', name: 'app_extraction')]
    public function extraction(ExtractionRepository $extractionRepository,  DateCompare $dateCompare): Response
    {
        $allExtractions = $extractionRepository->findByLandfill($this->getUser());
        $extractionOfTheDay = [];
        foreach ($allExtractions as $extraction) {
            if ($dateCompare->compareDayWithToday($extraction->getDatetime())) {
                $extractionOfTheDay[] = $extraction;
            }
        }
        return $this->render('landfill/extraction.html.twig', ['extractions' => $extractionOfTheDay]);
    }
    #[Route('/frequentation', name: 'app_frequentation')]
    public function frequentation(FrequentationRepository $frequentationRepository, DateCompare $dateCompare): Response
    {
        $allFrequentations = $frequentationRepository->findByLandfill($this->getUser());

        foreach ($allFrequentations as $frequentation) {
            if ($dateCompare->compareDayWithToday($frequentation->getDay())) {
                $todayFrequentation = $frequentation;
                return $this->render('landfill/frequentation.html.twig', ['frequentation' => $todayFrequentation]);
            } else {
            }
        }
        return $this->render('landfill/frequentation.html.twig', ['frequentation' => null]);
    }
    #[Route('/set/frequentation', name: 'app_set_frequentation')]
    public function setFrequentation(Request $request, EntityManagerInterface $entityManager): Response
    {
        $frequentation = new Frequentation;
        $form = $this->createForm(FrequentationFormType::class, $frequentation);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $today = new DateTime();
            $frequentation->setDay($today);
            $frequentation->setLandfill($this->getUser());
            $entityManager->persist($frequentation);
            $entityManager->flush();
            return $this->redirectToRoute('app_frequentation');
        }
        return $this->render('landfill/set_frequentation.html.twig', ['frequentationForm' => $form->createView()]);
    }
    #[Route('/set/extraction', name: 'app_set_extraction')]
    public function setExtraction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $extraction = new Extraction;
        $form = $this->createForm(ExtractionFormType::class, $extraction);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_extraction');
        }
        return $this->render('landfill/set_extraction.html.twig', ['extractionForm' => $form->createView()]);
    }
}
