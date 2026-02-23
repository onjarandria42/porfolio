<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use App\Repository\SiteSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SkillsController extends AbstractController
{
    #[Route('/skills', name: 'app_skills')]
    public function index(
        SkillRepository $skillRepository,
        SiteSettingsRepository $siteSettingsRepository
    ): Response {
        $skills = $skillRepository->findActiveOrdered();
        $siteSettings = $siteSettingsRepository->findFirst();

        return $this->render('skills/index.html.twig', [
            'skills' => $skills,
            'siteSettings' => $siteSettings,
        ]);
    }
}
