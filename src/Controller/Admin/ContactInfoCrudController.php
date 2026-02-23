<?php

namespace App\Controller\Admin;

use App\Entity\ContactInfo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ContactInfoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactInfo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Info Contact')
            ->setEntityLabelInPlural('Infos Contact')
            ->setPageTitle('index', 'Informations de contact')
            ->setPageTitle('new', 'Ajouter des infos contact')
            ->setPageTitle('edit', 'Modifier les infos contact')
            ->setPageTitle('detail', 'Détails des infos contact');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('address', 'Adresse')
                ->hideOnIndex(),
            TextField::new('phone', 'Téléphone')
                ->hideOnIndex(),
            TextField::new('email', 'Email')
                ->hideOnIndex(),
            UrlField::new('mapEmbedUrl', 'URL Google Maps Embed')
                ->setHelp('Lien iframe Google Maps')
                ->hideOnIndex(),
            
            // Réseaux sociaux
            UrlField::new('linkedin', 'LinkedIn')
                ->hideOnIndex(),
            UrlField::new('github', 'GitHub')
                ->hideOnIndex(),
            UrlField::new('twitter', 'Twitter/X')
                ->hideOnIndex(),
            UrlField::new('facebook', 'Facebook')
                ->hideOnIndex(),
            UrlField::new('instagram', 'Instagram')
                ->hideOnIndex(),
            
            BooleanField::new('isActive', 'Actif')
                ->setHelp('Une seule info contact doit être active'),
        ];
    }
}
