<?php

namespace App\Controller;


use App\Repository\ExtractionRepository;
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
}
