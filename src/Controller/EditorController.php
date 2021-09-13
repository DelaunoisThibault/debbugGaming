<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Form\EditorFormType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditorController extends AbstractController
{
    /**
     * page de création d'éditeur
     * @Route("/editor/new", name="editorCreationPage")
     * @Route("/editor/update/{id<\d+>}", name="editorUpdatePage")
     */
    public function editorForm(Request $request, EntityManagerInterface $manager, EditorRepository $editorRepository ): Response
    {
        $editor = new Editor();

        $editorForm =$this->createForm(EditorFormType::class, $editor);
        $editorForm->handleRequest($request);

        if($editorForm->isSubmitted() && $editorForm->isValid()){
            $manager->persist($editor);
            $manager->flush();
            return $this->redirectToRoute('gameCreationPage');
        }

        return $this->render('pages/addEditor.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un éditeur',
            'editorForm' => $editorForm->createView()
        ]);
    }
}