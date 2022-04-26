<?php

namespace App\Controller;

use App\Repository\BugFixRepository;
use App\Repository\BugRepository;
use App\Repository\BugSolutionRepository;
use App\Repository\CommentRepository;
use App\Repository\ContactMessageRepository;
use App\Repository\EditorRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * page de gestion admin (Bugs)
     * @Route("admin/gestion/bugs", name="adminGestionBugsPage")
     */
    public function adminActionsBugs(BugRepository $bugRepo): Response
    {
        $bugs = $bugRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'bugs' => $bugs
        ]);
    }

    /**
     * page de gestion admin (Bug fix)
     * @Route("admin/gestion/bugsFix", name="adminGestionBugsFixPage")
     */
    public function adminActionsBugsFix(BugFixRepository $bugFixRepo): Response
    {
        $bugFix = $bugFixRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'bugFixs' => $bugFix
        ]);
    }

    /**
     * page de gestion admin (Bug Solution)
     * @Route("admin/gestion/bugsSolutions", name="adminGestionBugsSolutionPage")
     */
    public function adminActionsBugsSolution(BugSolutionRepository $bugSolutionRepo): Response
    {
        $bugSolution = $bugSolutionRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'bugSolutions' => $bugSolution
        ]);
    }

    /**
     * page de gestion admin (Commentaires)
     * @Route("admin/gestion/comments", name="adminGestionCommentsPage")
     */
    public function adminActionsComments(CommentRepository $commentRepo): Response
    {
        $comments = $commentRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'comments' => $comments
        ]);
    }

    /**
     * page de gestion admin (Contact messages)
     * @Route("admin/gestion/contactMessages", name="adminGestionContactMessagesPage")
     */
    public function adminActionsContactMessages(ContactMessageRepository $contactMessagesRepo): Response
    {
        $contactMessages = $contactMessagesRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'contactMessages' => $contactMessages
        ]);
    }

    /**
     * page de gestion admin (Editors)
     * @Route("admin/gestion/editors", name="adminGestionEditorsPage")
     */
    public function adminActionsEditors(EditorRepository $editorRepo): Response
    {
        $editors = $editorRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'editors' => $editors
        ]);
    }

    /**
     * page de gestion admin (Games)
     * @Route("admin/gestion/games", name="adminGestionGamesPage")
     */
    public function adminActionsGames(GameRepository $gameRepo): Response
    {
        $games = $gameRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'games' => $games
        ]);
    }

    /**
     * page de gestion admin (Users)
     * @Route("admin/gestion/users", name="adminGestionUsersPage")
     */
    public function adminActionsUsers(UserRepository $userRepo): Response
    {
        $users = $userRepo->findAll();

        return $this->render('admin/adminPage.html.twig', [
            'pageTitle' => 'Admin',
            'users' => $users
        ]);
    }

}