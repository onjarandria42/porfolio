<?php

namespace App\Controller;

use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestimonialsController extends AbstractController
{
    #[Route('/testimonials', name: 'app_testimonials')]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        $testimonials = $testimonialRepository->findActiveOrdered();

        return $this->render('testimonials/index.html.twig', [
            'testimonials' => $testimonials,
        ]);
    }
}
