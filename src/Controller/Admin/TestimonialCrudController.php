<?php

namespace App\Controller\Admin;

use App\Entity\Testimonial;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class TestimonialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Testimonial::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Témoignage')
            ->setEntityLabelInPlural('Témoignages')
            ->setSearchFields(['authorName', 'authorRole', 'content'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des témoignages')
            ->setPageTitle('new', 'Ajouter un témoignage')
            ->setPageTitle('edit', 'Modifier le témoignage')
            ->setPageTitle('detail', 'Détails du témoignage');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('authorName', 'Nom de l\'auteur')
                ->setRequired(true),
            TextField::new('authorRole', 'Rôle/Fonction')
                ->setHelp('Ex: CEO & Founder, Designer...')
                ->hideOnIndex(),
            ImageField::new('authorImage', 'Photo')
                ->setBasePath('uploads/testimonials')
                ->setUploadDir('public/uploads/testimonials')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->hideOnIndex(),
            TextareaField::new('content', 'Contenu')
                ->setRequired(true)
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
