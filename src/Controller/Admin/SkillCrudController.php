<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Compétence')
            ->setEntityLabelInPlural('Compétences')
            ->setSearchFields(['name', 'icon'])
            ->setDefaultSort(['position' => 'ASC'])
            ->setPageTitle('index', 'Liste des compétences')
            ->setPageTitle('new', 'Ajouter une compétence')
            ->setPageTitle('edit', 'Modifier la compétence')
            ->setPageTitle('detail', 'Détails de la compétence');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom')
                ->setRequired(true)
                ->setHelp('Ex: HTML, CSS, JavaScript, PHP...'),
            IntegerField::new('percentage', 'Pourcentage')
                ->setRequired(true)
                ->setHelp('Valeur entre 0 et 100'),
            TextField::new('icon', 'Icône')
                ->setHelp('Classe Bootstrap Icons (ex: bi-code-slash)')
                ->hideOnIndex(),
            IntegerField::new('position', 'Position')
                ->setHelp('Ordre d\'affichage (plus petit = premier)'),
            BooleanField::new('isActive', 'Actif')
                ->setHelp('Décocher pour masquer cette compétence'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('isActive', 'Actif'));
    }
}
