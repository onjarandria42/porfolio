<?php

namespace App\Controller\Admin;

use App\Entity\Hero;
use App\Form\HeroJobType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeroCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
 
    public static function getEntityFqcn(): string
    {
        return Hero::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullName', 'Fullname'),

            ImageField::new('image', label: 'Background Image')
                ->setBasePath('uploads/hero')
                ->setUploadDir('public/uploads/hero')
                ->setRequired(false)
                ->setHelp('Image max 10 Mo (JPG, PNG, WEBP)'),
        
                ImageField::new('profileImage', label: 'Profile Image')
                ->setBasePath('uploads/hero')
                ->setUploadDir('public/uploads/hero')
                ->setRequired(false)
                ->setHelp('Image max 10 Mo (JPG, PNG, WEBP)'),

            BooleanField::new('isActive', 'Actived')
            ->setFormTypeOption('attr', ['class' => 'hero-toggle']),

            CollectionField::new('heroJobs', 'Jobs')
                ->setEntryType(HeroJobType::class)
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->setFormTypeOptions([
                    'by_reference' => false,
                ]),
        ];
    }


    public function configureAssets(Assets $assets): Assets
    {
        // Ajouter ton fichier JS
         $assets->addJsFile('js/hero-toggle.js');

        // Retourner l'objet assets tel quel
        return $assets;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Hero && $entityInstance->isActive()) {
            $this->disableOtherHeroes($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Hero && $entityInstance->isActive()) {
            $this->disableOtherHeroes($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function disableOtherHeroes(Hero $currentHero): void
    {
        $this->entityManager->createQueryBuilder()
            ->update(Hero::class, 'h')
            ->set('h.isActive', ':false')
            ->where('h.id != :id')
            ->setParameter('false', false)
            ->setParameter('id', $currentHero->getId())
            ->getQuery()
            ->execute();
    }


    
}



