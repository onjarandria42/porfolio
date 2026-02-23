<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactType;
use App\Repository\ContactInfoRepository;
use App\Service\ContactMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ContactMailService $contactMailService,
        ContactInfoRepository $contactInfoRepository
    ): Response {
        // ✅ Gérer le cas où findActive() retourne un tableau ou null
        $contactInfoResult = $contactInfoRepository->findActive();
        $contactInfo = is_array($contactInfoResult) ? (reset($contactInfoResult) ?: null) : $contactInfoResult;
        
        $message = new ContactMessage();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($message);
                $entityManager->flush();

                $notificationSent = $contactMailService->sendContactNotification($message);
                $confirmationSent = $contactMailService->sendConfirmationEmail($message);

                if ($notificationSent && $confirmationSent) {
                    $this->addFlash('success', '🎉 Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
                } else {
                    $this->addFlash('warning', '⚠️ Votre message a été enregistré mais nous avons rencontré un problème technique. Nous vous contacterons bientôt.');
                }

                return $this->redirectToRoute('app_contact');
            } catch (\Exception $e) {
                $this->addFlash('error', '❌ Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.');
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'contactInfo' => $contactInfo,
        ]);
    }

    #[Route('/contact/submit', name: 'app_contact_submit', methods: ['POST'])]
    public function submit(
        Request $request,
        EntityManagerInterface $entityManager,
        ContactMailService $contactMailService
    ): Response {
        $message = new ContactMessage();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($message);
                $entityManager->flush();

                $contactMailService->sendContactNotification($message);
                $contactMailService->sendConfirmationEmail($message);

                return $this->json([
                    'success' => true,
                    'message' => '🎉 Votre message a été envoyé avec succès !'
                ]);
            } catch (\Exception $e) {
                return $this->json([
                    'success' => false,
                    'message' => '❌ Une erreur est survenue lors de l\'envoi.'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $this->json([
            'success' => false,
            'errors' => $errors,
            'message' => 'Veuillez corriger les erreurs dans le formulaire.'
        ], Response::HTTP_BAD_REQUEST);
    }
}