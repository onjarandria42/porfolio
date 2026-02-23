<?php

namespace App\Controller\Admin;

use App\Entity\ContactMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class ContactMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactMessage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Message')
            ->setEntityLabelInPlural('Messages de contact')
            ->setSearchFields(['name', 'email', 'subject', 'message'])
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPageTitle('index', 'Messages reçus')
            ->setPageTitle('detail', 'Détails du message');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom')
                ->setSortable(true),
            EmailField::new('email', 'Email'),
            TextField::new('subject', 'Sujet')
                ->setSortable(true),
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Nouveau' => ContactMessage::STATUS_NEW,
                    'Lu' => ContactMessage::STATUS_READ,
                    'Répondu' => ContactMessage::STATUS_REPLIED,
                    'Archivé' => ContactMessage::STATUS_ARCHIVED,
                ])
                ->renderAsBadges([
                    ContactMessage::STATUS_NEW => 'danger',
                    ContactMessage::STATUS_READ => 'warning',
                    ContactMessage::STATUS_REPLIED => 'success',
                    ContactMessage::STATUS_ARCHIVED => 'secondary',
                ]),
            TextareaField::new('message', 'Message')
                ->hideOnIndex(),
            DateTimeField::new('createdAt', 'Reçu le')
                ->setFormat('dd/MM/yyyy HH:mm'),
            TextareaField::new('notes', 'Notes internes')
                ->hideOnIndex(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('status', 'Statut')->setChoices([
                'Nouveau' => ContactMessage::STATUS_NEW,
                'Lu' => ContactMessage::STATUS_READ,
                'Répondu' => ContactMessage::STATUS_REPLIED,
                'Archivé' => ContactMessage::STATUS_ARCHIVED,
            ]));
    }
}
