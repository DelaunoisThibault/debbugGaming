<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BugController extends AbstractController
{
    /**
     * page de création bug
     * @Route("/bug/new", name="bugCreationPage")
     * @Route("/bug/update/{id<\d+>}", name="bugUpdatePage")
     */
    public function bugForm(): Response
    {
        return $this->render('pages/creationBug.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug'
        ]);
    }
}