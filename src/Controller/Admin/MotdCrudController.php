<?php

namespace App\Controller\Admin;

use App\Entity\Motd;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MotdCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Motd::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Message du jour')
            ->setPageTitle('index', 'Gestion du motd');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('content')
                ->setLabel('Le message'),
        ];
    }
}
