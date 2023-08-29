<?php

namespace App\Controller;

use App\Repository\DemandesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(DemandesRepository $demandesRepository): Response
    {

        //récupérations des demandes pour l'utilisateur connecté
        $demandes = $demandesRepository->findByUser($this->getUser());
        // dd($demandes);

        return $this->render('account/compte.html.twig', [
            'demandes' => $demandes
        ]);
    }
}
