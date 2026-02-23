<?php

namespace App\Controller\Admin;

use App\Entity\PortfolioItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PortfolioItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PortfolioItem::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet Portfolio')
            ->setEntityLabelInPlural('Projets Portfolio')
            ->setSearchFields(['title', 'description'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des projets')
            ->setPageTitle('new', 'Ajouter un projet')
            ->setPageTitle('edit', 'Modifier le projet')
            ->setPageTitle('detail', 'Détails du projet');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre')
                ->setRequired(true),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads/portfolio')
                ->setUploadDir('public/uploads/portfolio')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(true),
            AssociationField::new('category', 'Catégorie')
                ->setRequired(true),
            UrlField::new('link', 'Lien externe')
                ->setHelp('Lien vers le projet en ligne')
                ->hideOnIndex(),
            UrlField::new('detailLink', 'Lien détails')
                ->setHelp('Lien vers la page de détails')
                ->hideOnIndex(),
            IntegerField::new('position', 'Position')
                ->setHelp('Ordre d\'affichage'),
            BooleanField::new('isActive', 'Actif'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('category', 'Catégorie'))
            ->add(BooleanFilter::new('isActive', 'Actif'));
    }
}
