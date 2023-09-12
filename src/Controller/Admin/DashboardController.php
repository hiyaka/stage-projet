<?php

namespace App\Controller\Admin;

use App\Entity\Demandes;
use App\Entity\User;
use App\Entity\Salles;
use App\Entity\Statut;
use App\Repository\DemandesRepository;
use App\Repository\StatutRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $demandesRepository;

    public function __construct(DemandesRepository $demandesRepository)
    {
        $this->demandesRepository = $demandesRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(DemandesCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin-Demandes')
            ->renderContentMaximized();
        // ->setLocales(['en', 'fr']) Faut que je regarde comment changer la langue
    }

    public function configureMenuItems(): iterable
    {

        /////////// recuperation des statuts En attente et En cours //////////////////////
        $enAttente = count($this->demandesRepository->findByStatut(1));
        $enCours = count($this->demandesRepository->findByStatut(2));
        $traitee = count($this->demandesRepository->findByStatut(3));
        ////////////////////////////////////////////////////////////////////////////////


        yield MenuItem::section('Demandes');
        yield MenuItem::linkToDashboard('Liste de toutes les demandes <span class="badge badge-warning">' . $enAttente . '</span><span class="badge badge-primary">' . $enCours . '</span><span class="badge badge-success">' . $traitee . '</span>', 'fas fa-list', Demandes::class);
        // yield MenuItem::linkToCrud('Type de demande', 'fas fa-folder-plus', Category::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Liste des utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::section('Le site');
        yield MenuItem::linkToRoute('Mon compte', 'fas fa-user', 'app_account');

        // yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    }
}
