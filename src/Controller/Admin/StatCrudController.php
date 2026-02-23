<?php

namespace App\Controller\Admin;

use App\Entity\Stat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class StatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Statistique')
            ->setEntityLabelInPlural('Statistiques')
            ->setSearchFields(['label', 'subtitle'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des statistiques')
            ->setPageTitle('new', 'Ajouter une statistique')
            ->setPageTitle('edit', 'Modifier la statistique')
            ->setPageTitle('detail', 'Détails de la statistique');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label', 'Label')
                ->setRequired(true)
                ->setHelp('Ex: Happy Clients, Projects...'),
            TextField::new('subtitle', 'Sous-titre')
                ->setHelp('Texte descriptif court')
                ->hideOnIndex(),
            IntegerField::new('value', 'Valeur')
                ->setRequired(true)
                ->setHelp('Le chiffre à afficher'),
            TextField::new('icon', 'Icône')
                ->setHelp('Classe Bootstrap Icons (ex: bi-emoji-smile)')
                ->setRequired(true),
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
