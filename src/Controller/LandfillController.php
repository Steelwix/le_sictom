<?php

namespace App\Controller;

use App\Entity\Frequentation;
use App\Repository\ExtractionRepository;
use App\Repository\FrequentationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandfillController extends AbstractController
{
    #[Route('/extraction', name: 'app_extraction')]
    public function extraction(ExtractionRepository $extractionRepository): Response
    {
        $allExtractions = $extractionRepository->findByLandfill($this->getUser());
        $today = new DateTime();
        $today->format('d-m-Y');
        $extractionOfTheDay = [];
        foreach ($allExtractions as $extraction) {
            if ($today == $extraction->getDatetime()->format('d-m-Y')) {
                $extractionOfTheDay[] = $extraction;
            }
        }
        return $this->render('landfill/extraction.html.twig', ['extractions' => $extractionOfTheDay]);
    }
    #[Route('/frequentation', name: 'app_frequentation')]
    public function frequentation(FrequentationRepository $frequentationRepository): Response
    {
        $allFrequentations = $frequentationRepository->findByLandfill($this->getUser());
        $today = new DateTime();
        $today->format('d-m-Y');
        foreach ($allFrequentations as $frequentation) {
            if ($today == $frequentation->getDatetime()->format('d-m-Y')) {
                $todayFrequentation = $frequentation;
                return $this->render('landfill/frequentation.html.twig', ['frequentation' => $todayFrequentation]);
            } else {
            }
        }
        return $this->render('landfill/frequentation.html.twig', ['frequentation' => null]);
    }
}
