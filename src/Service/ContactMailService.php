<?php

namespace App\Service;

use App\Entity\ContactMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Psr\Log\LoggerInterface;

class ContactMailService
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;
    private string $adminEmail;
    private string $siteName;

    public function __construct(
        MailerInterface $mailer,
        LoggerInterface $logger,
        string $adminEmail = 'onjarandria42@gmail.com',
        string $siteName = 'Onjarandria Portfolio'
    ) {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->adminEmail = $adminEmail;
        $this->siteName = $siteName;
    }

    /**
     * Envoie un email de notification à l'administrateur
     */
    public function sendContactNotification(ContactMessage $message): bool
    {
        try {
            $email = (new Email())
                ->from(new Address($message->getEmail(), $message->getName()))
                ->to(new Address($this->adminEmail, 'Admin'))
                ->replyTo(new Address($message->getEmail(), $message->getName()))
                ->subject(sprintf('[%s] Nouveau message: %s', $this->siteName, $message->getSubject()))
                ->html($this->buildNotificationHtml($message));

            $this->mailer->send($email);
            
            $this->logger->info('Email de notification envoyé avec succès', [
                'from' => $message->getEmail(),
                'subject' => $message->getSubject()
            ]);

            return true;
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de l\'envoi de l\'email de notification', [
                'error' => $e->getMessage(),
                'from' => $message->getEmail(),
                'subject' => $message->getSubject()
            ]);

            return false;
        }
    }

    /**
     * Envoie un email de confirmation à l'expéditeur
     */
    public function sendConfirmationEmail(ContactMessage $message): bool
    {
        try {
            $email = (new Email())
                ->from(new Address($this->adminEmail, $this->siteName))
                ->to(new Address($message->getEmail(), $message->getName()))
                ->subject(sprintf('[%s] Confirmation de votre message', $this->siteName))
                ->html($this->buildConfirmationHtml($message));

            $this->mailer->send($email);
            
            $this->logger->info('Email de confirmation envoyé avec succès', [
                'to' => $message->getEmail(),
                'subject' => $message->getSubject()
            ]);

            return true;
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de l\'envoi de l\'email de confirmation', [
                'error' => $e->getMessage(),
                'to' => $message->getEmail()
            ]);

            return false;
        }
    }

    /**
     * Construit le HTML pour l'email de notification
     */
    private function buildNotificationHtml(ContactMessage $message): string
    {
        return sprintf('
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #333;">Nouveau message de contact</h2>
                <p><strong>De :</strong> %s (%s)</p>
                <p><strong>Sujet :</strong> %s</p>
                <p><strong>Date :</strong> %s</p>
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                <h3>Message :</h3>
                <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px;">
                    %s
                </div>
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                <p style="font-size: 12px; color: #666;">
                    Ce message a été envoyé depuis le formulaire de contact de %s.
                </p>
            </div>
        ', 
            htmlspecialchars($message->getName()),
            htmlspecialchars($message->getEmail()),
            htmlspecialchars($message->getSubject()),
            $message->getCreatedAt()->format('d/m/Y H:i:s'),
            nl2br(htmlspecialchars($message->getMessage())),
            $this->siteName
        );
    }

    /**
     * Construit le HTML pour l'email de confirmation
     */
    private function buildConfirmationHtml(ContactMessage $message): string
    {
        return sprintf('
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #333;">Confirmation de votre message</h2>
                <p>Bonjour %s,</p>
                <p>Nous avons bien reçu votre message et nous vous en remercions.</p>
                <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <p><strong>Sujet :</strong> %s</p>
                    <p><strong>Message :</strong></p>
                    <p>%s</p>
                </div>
                <p>Nous vous répondrons dans les plus brefs délais.</p>
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                <p style="font-size: 12px; color: #666;">
                    Cordialement,<br>
                    L\'équipe %s
                </p>
            </div>
        ', 
            htmlspecialchars($message->getName()),
            htmlspecialchars($message->getSubject()),
            nl2br(htmlspecialchars($message->getMessage())),
            $this->siteName
        );
    }
}
