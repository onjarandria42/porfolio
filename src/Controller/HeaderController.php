<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Repository\ContactInfoRepository;
use App\Repository\SiteSettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HeaderController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ContactInfoRepository $contactInfoRepository;
    private SiteSettingsRepository $siteSettingsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContactInfoRepository $contactInfoRepository,
        SiteSettingsRepository $siteSettingsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->contactInfoRepository = $contactInfoRepository;
        $this->siteSettingsRepository = $siteSettingsRepository;
    }

    public function header(): Response
    {
        // Récupère le Hero actif pour la photo de profil et le nom
        $hero = $this->entityManager
            ->getRepository(Hero::class)
            ->findOneBy(['isActive' => true]);

        // Récupère les infos de contact pour les réseaux sociaux
        $contactInfo = $this->contactInfoRepository->findActive();

        // Récupère les paramètres du site
        $siteSettings = $this->siteSettingsRepository->findFirst();

        return $this->render('partials/header.html.twig', [
            'hero' => $hero,
            'contactInfo' => $contactInfo,
            'siteSettings' => $siteSettings,
            
            
        ]);
    }




     // ✅ NOUVELLE MÉTHODE pour les settings du site
    public function siteSettings(): Response
    {
        $siteSettings = $this->siteSettingsRepository->findFirst();

        return $this->render('components/site_settings.html.twig', [
            'siteSettings' => $siteSettings,
        ]);
    }
}
