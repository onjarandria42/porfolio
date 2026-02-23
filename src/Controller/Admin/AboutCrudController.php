<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Hero;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AboutCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('hero', 'Hero')->setRequired(true),

            TextField::new('title', 'Titre de la section'),
            TextareaField::new('description', 'Description courte'),

            ImageField::new('profileImage', 'Photo de profil')
                ->setBasePath('uploads/about')
                ->setUploadDir('public/uploads/about')
                ->setRequired(false)
                ->setHelp('Image max 10 Mo (JPG, PNG, WEBP)'),

            TextField::new('headline', 'Phrase courte'),
            // TextareaField::new('shortDescription', 'Présentation courte'),

            TextField::new('birthday'),
            TextField::new('website'),
            TextField::new('phone'),
            TextField::new('city'),
            TextField::new('age'),
            TextField::new('degree'),
            TextField::new('email'),
            TextField::new('freelanceStatus'),

            TextareaField::new('longDescription', 'Description longue'),

            BooleanField::new('isActive', 'Actif')
                ->setHelp('Si activé, cette About sera affichée pour le Hero correspondant')
        ];
        // Affiche isActive uniquement dans la liste
        if ($pageName === 'index') {
        $fields[] = BooleanField::new('isActive', 'Actif')
            ->setHelp('Clique pour activer ce About (un seul actif par Hero)')
            ->setFormTypeOption('attr', ['class' => 'about-toggle']);
    }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof About && $entityInstance->isActive()) {
            $this->disableOtherAbouts($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof About && $entityInstance->isActive()) {
            $this->disableOtherAbouts($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function disableOtherAbouts(About $currentAbout): void
    {
        $this->entityManager->createQueryBuilder()
            ->update(About::class, 'a')
            ->set('a.isActive', ':false')
            ->where('a.hero = :hero')
            ->andWhere('a.id != :id')
            ->setParameter('false', false)
            ->setParameter('hero', $currentAbout->getHero())
            ->setParameter('id', $currentAbout->getId())
            ->getQuery()
            ->execute();
    }

  public function configureAssets(Assets $assets): Assets
    {
        // Ajouter ton fichier JS
         $assets->addJsFile('js/hero-toggle.js');

        // Retourner l'objet assets tel quel
        return $assets;
    }
}
