<?php

namespace App\Command;

use App\Entity\ContactInfo;
use App\Entity\SiteSettings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:init-portfolio-data',
    description: 'Initialize default portfolio data',
)]
class InitPortfolioDataCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Initialisation des données du portfolio');

        // Créer les paramètres du site
        $this->createSiteSettings($io);

        // Créer les infos de contact
        $this->createContactInfo($io);

        $this->entityManager->flush();

        $io->success('Données initialisées avec succès !');
        $io->note('Vous pouvez maintenant vous connecter à l\'admin et personnaliser votre portfolio.');

        return Command::SUCCESS;
    }

    private function createSiteSettings(SymfonyStyle $io): void
    {
        $existing = $this->entityManager->getRepository(SiteSettings::class)->findFirst();
        
        if ($existing) {
            $io->note('Les paramètres du site existent déjà.');
            return;
        }

        $settings = new SiteSettings();
        $settings->setSiteName('Onjarandria Portfolio');
        $settings->setSiteTitle('Onjarandria - Développeur Web Full Stack');
        $settings->setSiteDescription('Portfolio professionnel de Onjarandria, développeur web full stack passionné.');
        $settings->setMetaAuthor('Onjarandria');
        $settings->setMetaKeywords('développeur, web, portfolio, symfony, php, javascript');
        $settings->setMaintenanceMode(false);

        $this->entityManager->persist($settings);
        $io->success('Paramètres du site créés.');
    }

    private function createContactInfo(SymfonyStyle $io): void
    {
        $existing = $this->entityManager->getRepository(ContactInfo::class)->findActive();
        
        if ($existing) {
            $io->note('Les informations de contact existent déjà.');
            return;
        }

        $contactInfo = new ContactInfo();
        $contactInfo->setAddress('Andranomena, Antananarivo, Madagascar');
        $contactInfo->setPhone('+261 38 05 609 48');
        $contactInfo->setEmail('onjarandria42@gmail.com');
        $contactInfo->setMapEmbedUrl('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15102.983428821484!2d47.47014278343269!3d-18.853964710350173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f08052faea7593%3A0x16e2fe008c839ab5!2sAndranomena%2C%20Tananarive!5e0!3m2!1sfr!2smg!4v1769512810656!5m2!1sfr!2smg');
        $contactInfo->setActive(true);

        $this->entityManager->persist($contactInfo);
        $io->success('Informations de contact créées.');
    }
}
