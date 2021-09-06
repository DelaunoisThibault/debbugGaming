<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * page d'inscription
     * @Route("/registration", name="registrationPage")
     */
    public function newUser(): Response
    {
        return $this->render('pages/inscription.html.twig', [
            'pageTitle' => 'Inscription'
        ]);
    }

    /**
     * page de connexion
     * @Route("/connection", name="connectionPage")
     */
    public function connexion(): Response
    {
        return $this->render('pages/connection.html.twig', [
            'pageTitle' => 'Connexion'
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