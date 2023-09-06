<?php

namespace App\Controller\Admin;

use App\Entity\Demandes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DemandesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Demandes::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Demande')
            ->setEntityLabelInPlural('Demandes')
            ->setPageTitle('index', 'Gestion des demandes');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            DateField::new('createdAt')
                ->hideOnForm()
                ->setLabel('Date de création'),
            AssociationField::new('user')
                ->hideOnForm()
                ->setLabel('Crée par'),
            TextEditorField::new('description')
                ->setLabel('La demande'),
            TextEditorField::new('rapport')
                ->setLabel('Le rapport'),
            AssociationField::new('category')
                ->setLabel('Le type de demande')
                ->hideOnForm(),
            AssociationField::new('statut')
                ->setLabel('Statut')
        ];
    }
}
