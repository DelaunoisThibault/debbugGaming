<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorController extends AbstractController
{
    /**
     * page de création d'éditeur
     * @Route("/admin/editor/new", name="editorCreationPage")
     * @Route("/admin/editor/update/{id<\d+>}", name="editorUpdatePage")
     */
    public function editorForm(): Response
    {
        return $this->render('pages/addEditor.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un éditeur'
        ]);
    }
}