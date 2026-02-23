<?php

namespace App\Controller;

use App\Repository\StatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats')]
    public function index(StatRepository $statRepository): Response
    {
        $stats = $statRepository->findActiveOrdered();

        return $this->render('stats/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
