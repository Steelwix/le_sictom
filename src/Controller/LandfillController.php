<?php

namespace App\Controller;

use App\Entity\Frequentation;
use App\Form\FrequentationFormType;
use App\Repository\ExtractionRepository;
use App\Repository\FrequentationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandfillController extends AbstractController
{
    #[Route('/extraction', name: 'app_extraction')]
    public function extraction(ExtractionRepository $extractionRepository): Response
    {
        $allExtractions = $extractionRepository->findByLandfill($this->getUser());
        $datetime = new DateTime();
        $stringDatetime = $datetime->format('d-m-Y H:i:s');
        $today = date('Y-m-d', strtotime($stringDatetime));
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
        $datetime = new DateTime();
        $stringDatetime = $datetime->format('d-m-Y H:i:s');
        $today = date('Y-m-d', strtotime($stringDatetime));

        foreach ($allFrequentations as $frequentation) {
            $getDayFrequentation = $frequentation->getDay();
            $stringDatetime = $getDayFrequentation->format('d-m-Y H:i:s');
            $frequentationDay = date('Y-m-d', strtotime($stringDatetime));
            if ($today == $frequentationDay) {
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
            $today->format('d-m-Y');
            $frequentation->setDay($today);
            $frequentation->setLandfill($this->getUser());
            $entityManager->persist($frequentation);
            $entityManager->flush();
            return $this->redirectToRoute('app_frequentation');
        }
        return $this->render('landfill/set_frequentation.html.twig', ['frequentationForm' => $form->createView()]);
    }
}
