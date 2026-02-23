<?php

namespace App\Controller;

use App\Repository\ContactInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SocialLinksController extends AbstractController
{
    public function social(ContactInfoRepository $contactInfoRepository): Response
    {
        $contactInfoResult = $contactInfoRepository->findActive();
        $contactInfo = is_array($contactInfoResult) 
            ? (reset($contactInfoResult) ?: null) 
            : $contactInfoResult;

        return $this->render('components/social_links.html.twig', [
            'contactInfo' => $contactInfo,
        ]);
    }
}