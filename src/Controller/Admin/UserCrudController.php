<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index', 'Gestion des utilisateurs')
            ->setFormOptions([
                'validation_groups' => ['register']
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('lastName')
                ->setLabel('Nom'),
            TextField::new('firstName')
                ->setLabel('Prénom'),
            EmailField::new('email')
                ->hideOnForm(),
            ChoiceField::new('roles')
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ])
                ->allowMultipleChoices(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        // $deleteUsers = Action::new('deleteAllUsers', 'Supprimer tous les utilisateurs', 'fa fa-trash');
        // $deleteUsers->linkToCrudAction('deleteAllUsersMethod');


        return $actions
            ->remove('index', 'new')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
        // ->add('deleteAllUsers', $deleteUsers);
    }

    /////////////////////////// Supprimer tous les users ///////////////////////////////////
    // public function deleteAllUsersMethod(UserRepository $userRepository, EntityManagerInterface $em)
    // {

    //     // 1. récupérer tous les users
    //     $users = $userRepository->findAll();
    //     // 2. suprimer chaque users
    //     foreach ($users as $user) {
    //         $em->remove($user);
    //     }
    //     //3. exécuter la suppression en base de donnée
    //     $em->flush();

    //     return $this->redirectToRoute('admin');
    // }
}
