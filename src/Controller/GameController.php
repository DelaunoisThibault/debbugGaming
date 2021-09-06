<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * page de création de jeu
     * @Route("/admin/game/new", name="gameCreationPage")
     * @Route("/admin/game/update/{id<\d+>}", name="gameUpdatePage")
     */
    public function gameForm(): Response
    {
        return $this->render('pages/addGame.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un jeu'
        ]);
    }
}