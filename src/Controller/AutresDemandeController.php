<?php

namespace App\Controller;

use App\Entity\Demandes;
use App\Form\AutresType;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutresDemandeController extends AbstractController
{
    #[Route('/compte/autres', name: 'app_account_demande_autres')]
    public function createAutres(Request $request, EntityManagerInterface $em, StatutRepository $statutRepository): Response
    {
        $AutresDemande = new Demandes;

        // je récupère l'user connecté et la je l'assigne à la demande
        $user = $this->getUser();
        $AutresDemande->setUser($user);

        // J'initialise le statut de la demande à "En attente"
        $statut = $statutRepository->findOneBy(['name' => 'En attente']);
        $AutresDemande->setStatut($statut);

        $form = $this->createForm(AutresType::class, $AutresDemande, [
            "validation_groups" => ["with-demandes-description"]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($AutresDemande);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre demande à bien été prise en compte elle va être traitée dans les plus bref délais'
            );

            return $this->redirectToRoute('app_account');
        }

        $formView = $form->createView();

        return $this->render('demande/createAutres.html.twig', [
            'formView' => $formView
        ]);
    }
}
