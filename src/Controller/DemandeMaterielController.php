<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\AtriumType;
use App\Form\MaterielType;
use App\Form\VerifSallesType;
use App\Repository\DemandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeMaterielController extends AbstractController
{
    #[Route('/compte/materiel', name: 'app_account_demande_materiel')]
    public function createMateriel(Request $request, EntityManagerInterface $em): Response
    {

        $demandeMateriel = new Demandes;

        // je récupère l'user connecté et la je l'assigne à la demande
        $user = $this->getUser();
        $demandeMateriel->setUser($user);

        $form = $this->createForm(MaterielType::class, $demandeMateriel, [
            "validation_groups" => ["with-demandes-description", "with-demandes-salles"]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($demandeMateriel);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre demande à bien été prise en compte elle va être traitée dans les plus bref délais'
            );

            return $this->redirectToRoute('app_account');
        }

        $formView = $form->createView();

        return $this->render('demande/createMateriel.html.twig', [
            'formView' => $formView,
        ]);
    }


    #[Route('/compte/verifDemandeMateriel', name: 'app_account_verif_demande_materiel')]
    public function verifHistorique(Request $request, DemandesRepository $demandesRepository): Response
    {

        $verifSalles = new Demandes;

        $form = $this->createForm(VerifSallesType::class, $verifSalles, [
            "validation_groups" => ["with-demandes-salles"]
        ]);

        $form->handleRequest($request);

        // J'initialise mes variables dans un tableau vide
        $historiqueDemandes = [];
        $selectSalle = [];


        if ($form->isSubmitted() && $form->isValid()) {

            // Je récupère la salle sélectionnée dans le formulaire
            $selectSalle = $form->get('salles')->getData();

            // je récupère l'historique des demandes liées à la salle
            $historiqueDemandes = $demandesRepository->findBySalles($selectSalle);

            // return $this->render('demande/verifDemandeMateriel.html.twig', [
            //     'historiqueDemandes' => $historiqueDemandes
            // ]);
        }


        $formView = $form->createView();

        return $this->render('demande/verifDemandeMateriel.html.twig', [
            'formView' => $formView,
            'historiqueDemandes' => $historiqueDemandes,
            'selectSalle' => $selectSalle
        ]);
    }
}
