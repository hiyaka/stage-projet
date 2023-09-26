<?php

namespace App\Controller;

use App\Repository\DemandesRepository;
use App\Repository\MotdRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(Request $request, DemandesRepository $demandesRepository, PaginatorInterface $paginator, MotdRepository $motdRepository): Response
    {

        //récupération du message of the day
        $motd = $motdRepository->findOneBy([]);

        // création de la pagination pour les demandes de l'utilisateur. Avec KnpPaginatorBundle.
        // J'ai retrouvé cette fonction dans le github du bundle "https://github.com/KnpLabs/KnpPaginatorBundle"
        $demandes = $paginator->paginate(
            $demandesRepository->findByUser($this->getUser()), // J'ai mis ici la query
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        //récupérations des demandes pour l'utilisateur connecté
        //$demandes = $demandesRepository->findByUser($this->getUser());
        // dd($demandes);

        return $this->render('account/compte.html.twig', [
            'demandes' => $demandes,
            'motd' => $motd
        ]);
    }
}
