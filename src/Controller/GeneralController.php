<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
    /**
     * page d'accueil
     * @Route("/", name="homePage")
     */
    public function home(): Response
    {
        return $this->render('pages/index.html.twig', [
            'pageTitle' => 'Accueil'
        ]);
    }

    /**
     * page de recherche de bug
     * @Route("/bugSearch", name="bugSearchPage")
     */
    public function bugSearch(): Response
    {
        return $this->render('pages/searchBug.html.twig', [
            'pageTitle' => 'Rechercher un bug'
        ]);
    }

    /**
     * page de bug
     * @Route("/bugPage", name="bugPage")
     */
    public function bugPage(): Response
    {
        return $this->render('pages/bugPage.html.twig', [
            'pageTitle' => 'Page du bug'
        ]);
    }

    /**
     * page de contact
     * @Route("/contactPage", name="contactPage")
     */
    public function contactPage(): Response
    {
        return $this->render('pages/contact.html.twig', [
            'pageTitle' => 'Contact'
        ]);
    }

}