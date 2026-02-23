<?php

namespace App\Controller\Admin;

use App\Entity\ResumeItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class ResumeItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ResumeItem::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Élément CV')
            ->setEntityLabelInPlural('Éléments CV')
            ->setSearchFields(['title', 'subtitle', 'description'])
            ->setDefaultSort(['type' => 'ASC', 'position' => 'ASC'])
            ->setPageTitle('index', 'Liste des éléments CV')
            ->setPageTitle('new', 'Ajouter un élément CV')
            ->setPageTitle('edit', 'Modifier l\'élément CV')
            ->setPageTitle('detail', 'Détails de l\'élément CV');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('type', 'Type')
                ->setChoices([
                    'Résumé' => ResumeItem::TYPE_SUMMARY,
                    'Éducation' => ResumeItem::TYPE_EDUCATION,
                    'Expérience' => ResumeItem::TYPE_EXPERIENCE,
                ])
                ->setRequired(true),
            TextField::new('title', 'Titre')
                ->setRequired(true),
            TextField::new('subtitle', 'Sous-titre')
                ->setHelp('Ex: Master of Fine Arts, Senior Developer...')
                ->hideOnIndex(),
            TextField::new('period', 'Période')
                ->setHelp('Ex: 2015 - 2016, 2019 - Present...')
                ->hideOnIndex(),
            TextField::new('location', 'Lieu')
                ->setHelp('Ex: Rochester Institute of Technology, New York...')
                ->hideOnIndex(),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            ArrayField::new('details', 'Détails (liste)')
                ->setHelp('Liste de points (pour expériences)')
                ->hideOnIndex(),
            IntegerField::new('position', 'Position')
                ->setHelp('Ordre d\'affichage'),
            BooleanField::new('isActive', 'Actif'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('type', 'Type')->setChoices([
                'Résumé' => ResumeItem::TYPE_SUMMARY,
                'Éducation' => ResumeItem::TYPE_EDUCATION,
                'Expérience' => ResumeItem::TYPE_EXPERIENCE,
            ]))
            ->add(BooleanFilter::new('isActive', 'Actif'));
    }
}
