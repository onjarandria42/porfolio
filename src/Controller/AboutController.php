<?php

namespace App\Controller;

use App\Entity\About;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {    
        $this->entityManager = $entityManager;
    }

    #[Route(path:"/about", name:"about")]  // j'ai ajouté le / devant about
    public function about(): Response
    {
        $about = $this->entityManager
            ->getRepository(About::class)
            ->findOneBy(["isActive" => true]);
            
        if(!$about) {
            // ✅ render() au lieu de redirectToRoute()
            return $this->render("about/index.html.twig", [
                "about" => null,
                "hero" => [],
            ]);
        }

        return $this->render('about/index.html.twig', [
            'about' => $about,
            
        ]);
    }
}