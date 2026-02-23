<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $passwordField = TextField::new('password', 'Password')
            ->setFormTypeOption('mapped', false)
            ->setFormTypeOption('attr', [
                'autocomplete' => 'new-password',
            ]);

        return [
            IdField::new('id')->hideOnForm(),

            EmailField::new('email'),

            // Mot de passe uniquement à la création
            TextField::new('password'),

            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderExpanded(),
        ];
    }

    /**
     * Hash du mot de passe à la création
     */
    public function persistEntity($entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }

        $plainPassword = $this->getContext()
            ->getRequest()
            ->request
            ->all('User')['password'] ?? null;

        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $plainPassword
            );
            $entityInstance->setPassword($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}