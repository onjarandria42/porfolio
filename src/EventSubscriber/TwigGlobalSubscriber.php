<?php

namespace App\EventSubscriber;

use App\Repository\ContactInfoRepository;
use App\Repository\SiteSettingsRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigGlobalSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private SiteSettingsRepository $siteSettingsRepository;
    private ContactInfoRepository $contactInfoRepository;

    public function __construct(
        Environment $twig,
        SiteSettingsRepository $siteSettingsRepository,
        ContactInfoRepository $contactInfoRepository
    ) {
        $this->twig = $twig;
        $this->siteSettingsRepository = $siteSettingsRepository;
        $this->contactInfoRepository = $contactInfoRepository;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        // Ajoute les paramètres du site à toutes les vues Twig
        $siteSettings = $this->siteSettingsRepository->findFirst();
        if ($siteSettings) {
            $this->twig->addGlobal('siteSettings', $siteSettings);
        }

        // Ajoute les infos de contact à toutes les vues Twig
        $contactInfo = $this->contactInfoRepository->findActive();
        if ($contactInfo) {
            $this->twig->addGlobal('contactInfo', $contactInfo);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
