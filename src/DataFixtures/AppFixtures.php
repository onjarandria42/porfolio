<?php

namespace App\DataFixtures;

use App\Entity\ContactInfo;
use App\Entity\PortfolioCategory;
use App\Entity\ResumeItem;
use App\Entity\Service;
use App\Entity\SiteSettings;
use App\Entity\Skill;
use App\Entity\Stat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer les paramètres du site
        $this->loadSiteSettings($manager);
        
        // Créer les infos de contact
        $this->loadContactInfo($manager);
        
        // Créer les compétences
        $this->loadSkills($manager);
        
        // Créer les statistiques
        $this->loadStats($manager);
        
        // Créer les services
        $this->loadServices($manager);
        
        // Créer les catégories de portfolio
        $this->loadPortfolioCategories($manager);
        
        // Créer les éléments de CV
        $this->loadResumeItems($manager);

        $manager->flush();
    }

    private function loadSiteSettings(ObjectManager $manager): void
    {
        $settings = new SiteSettings();
        $settings->setSiteName('Onjarandria Portfolio');
        $settings->setSiteTitle('Onjarandria - Développeur Web Full Stack');
        $settings->setSiteDescription('Portfolio professionnel de Onjarandria, développeur web full stack passionné.');
        $settings->setMetaAuthor('Onjarandria');
        $settings->setMetaKeywords('développeur, web, portfolio, symfony, php, javascript');
        $settings->setMaintenanceMode(false);

        $manager->persist($settings);
    }

    private function loadContactInfo(ObjectManager $manager): void
    {
        $contactInfo = new ContactInfo();
        $contactInfo->setAddress('Andranomena, Antananarivo, Madagascar');
        $contactInfo->setPhone('+261 38 05 609 48');
        $contactInfo->setEmail('onjarandria42@gmail.com');
        $contactInfo->setMapEmbedUrl('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15102.983428821484!2d47.47014278343269!3d-18.853964710350173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f08052faea7593%3A0x16e2fe008c839ab5!2sAndranomena%2C%20Tananarive!5e0!3m2!1sfr!2smg!4v1769512810656!5m2!1sfr!2smg');
        $contactInfo->setActive(true);

        $manager->persist($contactInfo);
    }

    private function loadSkills(ObjectManager $manager): void
    {
        $skills = [
            ['name' => 'HTML', 'percentage' => 100, 'icon' => 'bi-code'],
            ['name' => 'CSS', 'percentage' => 90, 'icon' => 'bi-palette'],
            ['name' => 'JavaScript', 'percentage' => 75, 'icon' => 'bi-filetype-js'],
            ['name' => 'Bootstrap', 'percentage' => 80, 'icon' => 'bi-bootstrap'],
            ['name' => 'PHP', 'percentage' => 80, 'icon' => 'bi-filetype-php'],
            ['name' => 'WordPress/CMS', 'percentage' => 90, 'icon' => 'bi-wordpress'],
            ['name' => 'Photoshop', 'percentage' => 55, 'icon' => 'bi-image'],
            ['name' => 'Symfony', 'percentage' => 80, 'icon' => 'bi-box-seam'],
        ];

        foreach ($skills as $index => $skillData) {
            $skill = new Skill();
            $skill->setName($skillData['name']);
            $skill->setPercentage($skillData['percentage']);
            $skill->setIcon($skillData['icon']);
            $skill->setPosition($index + 1);
            $skill->setActive(true);
            $manager->persist($skill);
        }
    }

    private function loadStats(ObjectManager $manager): void
    {
        $stats = [
            ['label' => 'Happy Clients', 'subtitle' => 'clients satisfaits', 'value' => 232, 'icon' => 'bi-emoji-smile'],
            ['label' => 'Projects', 'subtitle' => 'projets réalisés', 'value' => 521, 'icon' => 'bi-journal-richtext'],
            ['label' => 'Hours Of Support', 'subtitle' => 'heures de support', 'value' => 1453, 'icon' => 'bi-headset'],
            ['label' => 'Hard Workers', 'subtitle' => 'travailleurs dévoués', 'value' => 32, 'icon' => 'bi-people'],
        ];

        foreach ($stats as $index => $statData) {
            $stat = new Stat();
            $stat->setLabel($statData['label']);
            $stat->setSubtitle($statData['subtitle']);
            $stat->setValue($statData['value']);
            $stat->setIcon($statData['icon']);
            $stat->setPosition($index + 1);
            $stat->setActive(true);
            $manager->persist($stat);
        }
    }

    private function loadServices(ObjectManager $manager): void
    {
        $services = [
            ['title' => 'Développement Web', 'description' => 'Création de sites web modernes et responsives.', 'icon' => 'bi-briefcase'],
            ['title' => 'Applications Web', 'description' => 'Développement d\'applications web sur mesure.', 'icon' => 'bi-card-checklist'],
            ['title' => 'E-commerce', 'description' => 'Solutions de vente en ligne complètes.', 'icon' => 'bi-bar-chart'],
            ['title' => 'SEO & Marketing', 'description' => 'Optimisation pour les moteurs de recherche.', 'icon' => 'bi-binoculars'],
            ['title' => 'Design UI/UX', 'description' => 'Conception d\'interfaces utilisateur intuitives.', 'icon' => 'bi-brightness-high'],
            ['title' => 'Maintenance', 'description' => 'Support et maintenance de vos projets.', 'icon' => 'bi-calendar4-week'],
        ];

        foreach ($services as $index => $serviceData) {
            $service = new Service();
            $service->setTitle($serviceData['title']);
            $service->setDescription($serviceData['description']);
            $service->setIcon($serviceData['icon']);
            $service->setPosition($index + 1);
            $service->setActive(true);
            $manager->persist($service);
        }
    }

    private function loadPortfolioCategories(ObjectManager $manager): void
    {
        $categories = [
            ['name' => 'Applications', 'slug' => 'app'],
            ['name' => 'Produits', 'slug' => 'product'],
            ['name' => 'Branding', 'slug' => 'branding'],
            ['name' => 'Livres', 'slug' => 'books'],
        ];

        foreach ($categories as $index => $categoryData) {
            $category = new PortfolioCategory();
            $category->setName($categoryData['name']);
            $category->setSlug($categoryData['slug']);
            $category->setPosition($index + 1);
            $category->setActive(true);
            $manager->persist($category);
        }
    }

    private function loadResumeItems(ObjectManager $manager): void
    {
        // Summary
        $summary = new ResumeItem();
        $summary->setType(ResumeItem::TYPE_SUMMARY);
        $summary->setTitle('Brandon Johnson');
        $summary->setSubtitle('Développeur Web Full Stack passionné');
        $summary->setDescription('Innovant et axé sur les délais, avec plus de 3 ans d\'expérience dans la conception et le développement de solutions web performantes.');
        $summary->setDetails([
            'Portland par 127, Orlando, FL',
            '(123) 456-7891',
            'alice.barkley@example.com'
        ]);
        $summary->setPosition(1);
        $summary->setActive(true);
        $manager->persist($summary);

        // Education
        $education1 = new ResumeItem();
        $education1->setType(ResumeItem::TYPE_EDUCATION);
        $education1->setTitle('Master en Informatique');
        $education1->setSubtitle('Développement Web');
        $education1->setPeriod('2015 - 2016');
        $education1->setLocation('Rochester Institute of Technology, Rochester, NY');
        $education1->setDescription('Spécialisation en développement web et applications mobiles.');
        $education1->setPosition(1);
        $education1->setActive(true);
        $manager->persist($education1);

        $education2 = new ResumeItem();
        $education2->setType(ResumeItem::TYPE_EDUCATION);
        $education2->setTitle('Licence en Informatique');
        $education2->setSubtitle('Programmation');
        $education2->setPeriod('2010 - 2014');
        $education2->setLocation('Rochester Institute of Technology, Rochester, NY');
        $education2->setDescription('Formation complète en programmation et algorithmique.');
        $education2->setPosition(2);
        $education2->setActive(true);
        $manager->persist($education2);

        // Experience
        $experience1 = new ResumeItem();
        $experience1->setType(ResumeItem::TYPE_EXPERIENCE);
        $experience1->setTitle('Développeur Senior');
        $experience1->setSubtitle('Full Stack Developer');
        $experience1->setPeriod('2019 - Present');
        $experience1->setLocation('Experion, New York, NY');
        $experience1->setDescription('Lead technique sur les projets web de l\'entreprise.');
        $experience1->setDetails([
            'Lead sur la conception et le développement de solutions web',
            'Gestion d\'une équipe de 7 développeurs',
            'Supervision de la qualité du code',
            'Gestion de budgets de 2,000$ à 25,000$'
        ]);
        $experience1->setPosition(1);
        $experience1->setActive(true);
        $manager->persist($experience1);

        $experience2 = new ResumeItem();
        $experience2->setType(ResumeItem::TYPE_EXPERIENCE);
        $experience2->setTitle('Développeur Web');
        $experience2->setSubtitle('Frontend Developer');
        $experience2->setPeriod('2017 - 2018');
        $experience2->setLocation('Stepping Stone Advertising, New York, NY');
        $experience2->setDescription('Développement frontend pour clients variés.');
        $experience2->setDetails([
            'Développement de programmes marketing (logos, brochures)',
            'Gestion de 5 projets simultanés',
            'Consultation client sur les meilleures pratiques',
            'Création de 4+ présentations par mois'
        ]);
        $experience2->setPosition(2);
        $experience2->setActive(true);
        $manager->persist($experience2);
    }
}
