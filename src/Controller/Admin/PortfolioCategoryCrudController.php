<?php

namespace App\Controller\Admin;

use App\Entity\PortfolioCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class PortfolioCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PortfolioCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie Portfolio')
            ->setEntityLabelInPlural('Catégories Portfolio')
            ->setSearchFields(['name', 'slug'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des catégories')
            ->setPageTitle('new', 'Ajouter une catégorie')
            ->setPageTitle('edit', 'Modifier la catégorie')
            ->setPageTitle('detail', 'Détails de la catégorie');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom')
                ->setRequired(true),
            TextField::new('slug', 'Slug')
                ->setHelp('Identifiant unique pour le filtre (ex: app, product, branding)')
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
