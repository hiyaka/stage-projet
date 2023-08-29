<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/', name: 'app_security_login')]
    public function login(AuthenticationUtils $utils): Response
    {

        // L'utilisateur se directement redirigé vers son compte si il essai d'acceder au Login
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        // Ce sont les errors de login récupéré grace a AuthenticationUtils et personalisé dans UserAuthenticator
        $error = $utils->getLastAuthenticationError();
        // $lastMail = $utils->getLastUsername();

        $form = $this->createForm(LoginType::class);

        return $this->render('security/login.html.twig', [
            'formView' => $form->createView(),
            'error' => $error,
            // 'lastMail' => $lastMail
        ]);
    }
    #[Route('/logout', name: 'app_security_logout')]
    public function logout()
    {
    }
}
