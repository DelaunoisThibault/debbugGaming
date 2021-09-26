<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\BugRepository;
use App\Repository\CommentRepository;
use App\Repository\EditorRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    public function home(BugRepository $bugRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $bugs = $bugRepository->findAllByRecent();
        $bugs = $paginator->paginate(
            $bugs,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/index.html.twig', [
            'pageTitle' => 'Accueil',
            'listBugs' => $bugs
        ]);
    }

    /**
     * page de recherche de bug
     * @Route("/bugSearch", name="bugSearchPage")
     */
    public function bugSearch(BugRepository $bugRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $bugs = $bugRepository->findAllByRecent();
        $bugs = $paginator->paginate(
            $bugs,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/searchBug.html.twig', [
            'pageTitle' => 'Rechercher un bug',
            'listBugs' => $bugs
        ]);
    }

    /**
     * page de bug
     * @Route("/bug/{id<\d+>}", name="bugPage")
     */
    public function bugPage($id, Request $request, CommentRepository $commentsRepo, BugRepository $bugRepository,
                            GameRepository $gameRepository, EditorRepository $editorRepository, EntityManagerInterface $manager): Response
    {
        $bug = $bugRepository->find($id);
        $game = $bug->getIdGame();
        $editor =$editorRepository->find($game->getIdEditor());
        $allComments = $commentsRepo->findByBugId($bug);
        $comment = new Comment();
        $commentsForm = $this->createForm(CommentFormType::class, $comment);
        $commentsForm->handleRequest($request);
        if($commentsForm->isSubmitted() && $commentsForm->isValid()){
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $comment->setDate(new \DateTime())
                ->setIdBug($bug)
                ->setIdUser($user);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('bugPage',[
                'id'=> $bug->getId()
            ]);
        }

        return $this->render('pages/bugPage.html.twig', [
            'pageTitle' => 'Page du bug',
            'bug' => $bug,
            'game' => $game,
            'editor' => $editor,
            'comments' => $allComments,
            'commentsForm' => $commentsForm->createView()
        ]);
    }

    /**
     * page de contact
     * @Route("/contact", name="contactPage")
     */
    public function contactPage(): Response
    {
        return $this->render('pages/contact.html.twig', [
            'pageTitle' => 'Contact'
        ]);
    }



}