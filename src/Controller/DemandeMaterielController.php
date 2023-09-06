<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\MaterielType;
use App\Repository\DemandesRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeMaterielController extends AbstractController
{
    #[Route('/compte/materiel', name: 'app_account_demande_materiel')]
    public function createMateriel(Request $request, EntityManagerInterface $em, DemandesRepository $demandesRepository, StatutRepository $statutRepository): Response
    {

        $demandeMateriel = new Demandes;

        // je récupère l'user connecté et la je l'assigne à la demande
        $user = $this->getUser();
        $demandeMateriel->setUser($user);

        // J'initialise le statut de la demande à "En attente"
        $statut = $statutRepository->findOneBy(['name' => 'En attente']);
        $demandeMateriel->setStatut($statut);

        // dd($demandeMateriel);


        // J'initialise mes variables dans un tableau vide
        $historiqueDemandes = [];
        $selectSalle = [];

        $form = $this->createForm(MaterielType::class, $demandeMateriel, [
            "validation_groups" => ["with-demandes-salles"]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // pagination des historiques
            // $historiqueDemandes = $paginator->paginate(
            //     $demandesRepository->findBySalles($selectSalle), // J'ai mis ici la query
            //     $request->query->getInt('page', 1), /*page number*/
            //     2 /*limit per page*/
            // );


            // Je récupère la salle sélectionnée dans le formulaire
            $selectSalle = $form->get('salles')->getData();
            // je récupère l'historique des demandes liées à la salle
            $historiqueDemandes = $demandesRepository->findBySalles($selectSalle);

            //condition de validation si la description est pas vide alors on flush
            if (!empty($form->get('description')->getData())) {

                $em->persist($demandeMateriel);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Votre demande à bien été prise en compte elle va être traitée dans les plus bref délais'
                );

                return $this->redirectToRoute('app_account');
            }
        }

        $formView = $form->createView();

        return $this->render('demande/createMateriel.html.twig', [
            'formView' => $formView,
            'historiqueDemandes' => $historiqueDemandes,
            'selectSalle' => $selectSalle
        ]);
    }
}
