<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameFormType;
use App\Repository\BugRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * page de création de jeu
     * @Route("/game/new", name="gameCreationPage")
     * @Route("/game/update/{id<\d+>}", name="gameUpdatePage")
     */
    public function gameForm(Request $request, EntityManagerInterface $manager): Response
    {
        $game = new Game();

        $gameForm =$this->createForm(GameFormType::class, $game);
        $gameForm->handleRequest($request);

        if($gameForm->isSubmitted() && $gameForm->isValid()){
            $game->setBugRating(0);
            $manager->persist($game);
            $manager->flush();
            return $this->redirectToRoute('bugCreationPage');
        }

        return $this->render('pages/addGame.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un jeu',
            'gameForm' => $gameForm->createView()
        ]);
    }
}