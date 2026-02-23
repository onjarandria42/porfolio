<?php

namespace App\Controller\Admin;

use App\Entity\SiteSettings;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SiteSettingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SiteSettings::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Paramètre Site')
            ->setEntityLabelInPlural('Paramètres du Site')
            ->setPageTitle('index', 'Paramètres du site')
            ->setPageTitle('new', 'Ajouter des paramètres')
            ->setPageTitle('edit', 'Modifier les paramètres')
            ->setPageTitle('detail', 'Détails des paramètres');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('siteName', 'Nom du site')
                ->setHelp('Ex: Onjarandria Portfolio'),
            TextField::new('siteTitle', 'Titre du site')
                ->setHelp('Titre affiché dans l\'onglet du navigateur'),
            TextareaField::new('siteDescription', 'Description du site')
                ->setHelp('Description pour SEO')
                ->hideOnIndex(),
            
            ImageField::new('siteLogo', 'Logo')
                ->setBasePath('uploads/settings')
                ->setUploadDir('public/uploads/settings')
                ->setUploadedFileNamePattern('logo-[randomhash].[extension]')
                ->setRequired(false)
                ->hideOnIndex(),
            ImageField::new('favicon', 'Favicon')
                ->setBasePath('uploads/settings')
                ->setUploadDir('public/uploads/settings')
                ->setUploadedFileNamePattern('favicon-[randomhash].[extension]')
                ->setRequired(false)
                ->hideOnIndex(),
            
            TextField::new('metaAuthor', 'Auteur Meta')
                ->hideOnIndex(),
            TextareaField::new('metaKeywords', 'Mots-clés Meta')
                ->setHelp('Séparés par des virgules')
                ->hideOnIndex(),
            
            ImageField::new('cvFile', 'Fichier CV')
                ->setBasePath('uploads/settings')
                ->setUploadDir('public/uploads/settings')
                ->setUploadedFileNamePattern('cv-[randomhash].[extension]')
                ->setRequired(false)
                ->hideOnIndex(),
            
            BooleanField::new('maintenanceMode', 'Mode maintenance')
                ->setHelp('Activer pour mettre le site en maintenance')
                ->hideOnIndex(),
        ];
    }
}
