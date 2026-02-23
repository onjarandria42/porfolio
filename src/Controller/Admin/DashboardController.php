<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\ContactInfo;
use App\Entity\ContactMessage;
use App\Entity\Hero;
use App\Entity\HeroJob;
use App\Entity\PortfolioCategory;
use App\Entity\PortfolioItem;
use App\Entity\ResumeItem;
use App\Entity\Service;
use App\Entity\SiteSettings;
use App\Entity\Skill;
use App\Entity\Stat;
use App\Entity\Testimonial;
use App\Entity\User;
use App\Repository\ContactMessageRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
   
 
    private ContactMessageRepository $contactMessageRepository;

    public function __construct(ContactMessageRepository $contactMessageRepository)
    {
        $this->contactMessageRepository = $contactMessageRepository;
    }

    public function index(): Response
    {
        // Redirige vers le dashboard avec stats
        return $this->render('admin/dashboard.html.twig', [
            'new_messages_count' => $this->contactMessageRepository->countNewMessages(),
        ]);
    }
    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<span class="fs-4">Onjarandria</span><span class="fs-6 d-block text-muted">Portfolio Admin</span>')
            ->setFaviconPath('assets/img/onjaniaina.png')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        $newMessagesCount = $this->contactMessageRepository->countNewMessages();
        
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        
        // Section Contenu Principal
        yield MenuItem::section('Contenu Principal');
        yield MenuItem::linkToCrud('Hero', 'fa fa-user-circle', Hero::class)
            ->setController(HeroCrudController::class);
        yield MenuItem::linkToCrud('Métiers Hero', 'fa fa-briefcase', HeroJob::class)
            ->setController(HeroJobCrudController::class);
        yield MenuItem::linkToCrud('À propos', 'fa fa-info-circle', About::class)
            ->setController(AboutCrudController::class);
        
        // Section Compétences & Stats
        yield MenuItem::section('Compétences & Stats');
        yield MenuItem::linkToCrud('Compétences', 'fa fa-code', Skill::class)
            ->setController(SkillCrudController::class);
        yield MenuItem::linkToCrud('Statistiques', 'fa fa-chart-bar', Stat::class)
            ->setController(StatCrudController::class);
        
        // Section CV
        yield MenuItem::section('Curriculum Vitae');
        yield MenuItem::linkToCrud('Éléments CV', 'fa fa-file-alt', ResumeItem::class)
            ->setController(ResumeItemCrudController::class);
        
        // Section Portfolio
        yield MenuItem::section('Portfolio');
        yield MenuItem::linkToCrud('Catégories', 'fa fa-folder', PortfolioCategory::class)
            ->setController(PortfolioCategoryCrudController::class);
        yield MenuItem::linkToCrud('Projets', 'fa fa-images', PortfolioItem::class)
            ->setController(PortfolioItemCrudController::class);
        
        // Section Services
        yield MenuItem::section('Services');
        yield MenuItem::linkToCrud('Services', 'fa fa-cogs', Service::class)
            ->setController(ServiceCrudController::class);
        
        // Section Témoignages
        yield MenuItem::section('Témoignages');
        yield MenuItem::linkToCrud('Témoignages', 'fa fa-comments', Testimonial::class)
            ->setController(TestimonialCrudController::class);
        
        // Section Contact
        yield MenuItem::section('Contact');
        yield MenuItem::linkToCrud('Infos Contact', 'fa fa-address-card', ContactInfo::class)
            ->setController(ContactInfoCrudController::class);
        
        $messageMenu = MenuItem::linkToCrud('Messages', 'fa fa-envelope', ContactMessage::class)
            ->setController(ContactMessageCrudController::class);
        if ($newMessagesCount > 0) {
            $messageMenu->setBadge($newMessagesCount, 'danger');
        }
        yield $messageMenu;
        
        // Section Configuration
        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Paramètres Site', 'fa fa-cog', SiteSettings::class)
            ->setController(SiteSettingsCrudController::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class)
            ->setController(UserCrudController::class);
        
        // Section Liens
        yield MenuItem::section('Liens');
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-arrow-left', '/');
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('admin/custom-admin.css')
            ->addJsFile('admin/hero-toggle.js');
    }
}
