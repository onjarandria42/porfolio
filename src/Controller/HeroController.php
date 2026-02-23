<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Entity\HeroJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HeroController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

   
    public function hero(): Response
    {
        // Récupère le Hero actif
        $hero = $this->entityManager
            ->getRepository(Hero::class)
            ->findOneBy(['isActive' => true]);

        // Aucun Hero actif trouvé → renvoie variables vides pour Twig
        if (!$hero) {
            return $this->render('hero/index.html.twig', [
                'hero' => null,
                'job'  => [],
            ]);
        }

        // Récupère les HeroJobs actifs et triés par position
        $heroJobs = $hero->getHeroJobs()
            ->filter(fn(HeroJob $job): bool => $job->isActive())
            ->toArray(); // transforme la Collection en tableau

        // Tri par position
        usort($heroJobs, fn(HeroJob $a, HeroJob $b): int => $a->getPosition() <=> $b->getPosition());

        return $this->render('hero/index.html.twig', [
            'hero' => $hero,
            'job'  => $heroJobs,
        ]);
    }

    
}
