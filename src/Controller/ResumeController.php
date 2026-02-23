<?php

namespace App\Controller;

use App\Entity\ResumeItem;
use App\Repository\ResumeItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResumeController extends AbstractController
{
    #[Route('/resume', name: 'app_resume')]
    public function index(ResumeItemRepository $resumeItemRepository): Response
    {
        $summary = $resumeItemRepository->findActiveByTypeOrdered(ResumeItem::TYPE_SUMMARY);
        $education = $resumeItemRepository->findActiveByTypeOrdered(ResumeItem::TYPE_EDUCATION);
        $experience = $resumeItemRepository->findActiveByTypeOrdered(ResumeItem::TYPE_EXPERIENCE);

        return $this->render('resume/index.html.twig', [
            'summary' => $summary ? reset($summary) : null,  // ✅ PHP way
            'education' => $education,
            'experience' => $experience,
        ]);
    }
}