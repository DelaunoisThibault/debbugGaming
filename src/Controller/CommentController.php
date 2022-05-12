<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\BugRepository;
use App\Entity\Bug;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * modification d'un commentaire dans db
     * @Route("/comment/update/{id<\d+>}", name="updateComment")
     */
    public function updateComment(int $id, BugRepository $bugRepo, Request $request, EntityManagerInterface $manager, CommentRepository $commentRepo): Response
    {
        $comment = $commentRepo->find($id);
        $bug = $bugRepo->find($comment->getIdBug());

        $commentsForm = $this->createForm(CommentFormType::class, $comment);
        $commentsForm->handleRequest($request);

        if($commentsForm->isSubmitted() && $commentsForm->isValid()){
            $comment->setIdBug($bug)
                ->setIdUser($comment->getIdUser());

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('bugPage',[
                'id'=> $bug->getId()
            ]);
        }

        return $this->render('pages/editComment.html.twig', [
            'pageTitle' => 'Modification de commentaire',
            'commentsForm' => $commentsForm->createView()
        ]);

    }

    /**
     * suppression d'un commentaire dans db
     * @Route("/comment/delete/{id<\d+>}", name="deleteComment")
     */
    public function deleteComment(int $id, BugRepository $bugRepo, CommentRepository $commentRepo): Response
    {
        $commentary = $commentRepo->find($id);
        $bug = $bugRepo->find($commentary->getIdBug());
        $entityManager = $this->getDoctrine()->getManager();

        if (!$commentary){
            throw $this->createNotFoundException(
                'No commentary found for id '.$id
            );
        }

        $entityManager->remove($commentary);
        $entityManager->flush();

        return $this->redirectToRoute('bugPage',[
            'id'=> $bug->getId()
        ]);

    }
}
