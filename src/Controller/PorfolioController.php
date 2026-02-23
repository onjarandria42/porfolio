<?php

namespace App\Controller;

use App\Repository\PortfolioCategoryRepository;
use App\Repository\PortfolioItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PorfolioController extends AbstractController
{
    #[Route('/porfolio', name: 'app_porfolio')]
    public function index(
        PortfolioCategoryRepository $categoryRepository,
        PortfolioItemRepository $itemRepository
    ): Response {
        $categories = $categoryRepository->findActiveOrdered();
        $items = $itemRepository->findActiveOrdered();

        return $this->render('porfolio/index.html.twig', [
            'categories' => $categories,
            'items' => $items,
        ]);
    }
}
