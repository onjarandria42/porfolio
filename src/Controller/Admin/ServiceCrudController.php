<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services')
            ->setSearchFields(['title', 'description'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des services')
            ->setPageTitle('new', 'Ajouter un service')
            ->setPageTitle('edit', 'Modifier le service')
            ->setPageTitle('detail', 'Détails du service');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre')
                ->setRequired(true),
            TextareaField::new('description', 'Description')
                ->setHelp('Description détaillée du service')
                ->hideOnIndex(),
            TextField::new('icon', 'Icône')
                ->setHelp('Classe Bootstrap Icons (ex: bi-briefcase, bi-code-slash)')
                ->setRequired(true),
            UrlField::new('link', 'Lien')
                ->setHelp('Lien vers la page de détails (optionnel)')
                ->hideOnIndex(),
            IntegerField::new('position', 'Position')
                ->setHelp('Ordre d\'affichage'),
            BooleanField::new('isActive', 'Actif'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('isActive', 'Actif'));
    }
}
