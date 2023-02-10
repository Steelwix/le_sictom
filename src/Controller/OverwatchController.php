<?php

namespace App\Controller;

use App\Entity\Extraction;
use App\Entity\Frequentation;
use App\Repository\ExtractionRepository;
use App\Repository\FrequentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OverwatchController extends AbstractController
{
    #[Route('/overview/frequentation', name: 'app_ov_frequentation')]
    public function overviewFrequentation(FrequentationRepository $frequentationRepository): Response
    {
        $everyFrequentation = $frequentationRepository->findAll();
        $dates = array();
        foreach ($everyFrequentation as $frequentation) {
            $frequentationDay = $frequentation->getDay()->format('d-m-Y');
            $stringDay = date('d-m-Y', strtotime($frequentationDay));
            if (!in_array($stringDay, $dates)) {
                $dates[] = array($stringDay => $frequentation);
            } else {
                $index = array_search($stringDay, $dates);
                $dates[$index][] = $frequentation;
            }
        }
        return $this->render('overwatch/frequentation.html.twig', ['dates' => $dates]);
    }
    #[Route('/overview/extraction', name: 'app_ov_extraction')]
    public function overviewExtraction(ExtractionRepository $extractionRepository): Response
    {
        $everyExtraction = $extractionRepository->findAll();
        $dates = array();
        foreach ($everyExtraction as $extraction) {
            $extractionDay = $extraction->getDatetime()->format('d-m-Y');
            $stringDay = date('d-m-Y', strtotime($extractionDay));
            if (!in_array($stringDay, $dates)) {
                $dates[] = array($stringDay => $extraction);
            } else {
                $index = array_search($stringDay, $dates);
                $dates[$index][] = $extraction;
            }
        }
        return $this->render('overwatch/extraction.html.twig', ['dates' => $dates]);
    }
}
