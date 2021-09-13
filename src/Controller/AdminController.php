<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * page de gestion admin
     * @Route("/gestion/bugs", name="adminGestionBugsPage")
     */
    public function adminActionsBugs(): Response
    {
        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin'
        ]);
    }

}