<?php

namespace App\Controller\Admin;

use App\Entity\HeroJob;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeroJobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HeroJob::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['position' => 'ASC'])
            ->setEntityLabelInPlural('Hero Jobs')
            ->setEntityLabelInSingular('Hero Job');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Intitulé'),

            IntegerField::new('position')
                ->setHelp('Plus petit = affiché en premier'),

            BooleanField::new('isActive', 'Actived'),

            AssociationField::new('hero')
                ->setRequired(true),
        ];
    }
}
