<?php

namespace App\Controller\Admin;

use App\Entity\Demandes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

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
            AssociationField::new('salles')
                ->hideOnForm()
                ->setLabel('Salle'),
            AssociationField::new('user')
                ->hideOnForm()
                ->setLabel('Crée par'),
            TextEditorField::new('description')
                ->setLabel('La demande'),
            TextEditorField::new('rapport')
                ->setLabel('Le rapport'),
            TextField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyWhenUpdating(),
            ImageField::new('file')
                ->setBasePath('/uploads/demandeImage')
                ->onlyOnIndex(),
            AssociationField::new('category')
                ->setLabel('Le type de demande')
                ->hideOnForm(),
            AssociationField::new('statut')
                ->setLabel('Statut'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove('index', 'new')
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
