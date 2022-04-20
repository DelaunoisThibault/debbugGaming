<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /**
     * page de connexion
     * @Route("/connection", name="connectionPag")
     */
    public function connection(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/connection.html.twig', [
            'pageTitle' => 'Connexion',
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * page de profil
     * @Route("/profile", name="profilePage")
     */
    public function showProfile(): Response
    {
        return $this->render('pages/profile.html.twig', [
            'pageTitle' => 'Profil'
        ]);
    }
}