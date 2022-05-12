<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\BugFix;
use App\Entity\BugSolution;
use App\Entity\ContactMessage;
use App\Entity\Game;
use App\Entity\Editor;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\BugFixRepository;
use App\Repository\BugRepository;
use App\Repository\BugSolutionRepository;
use App\Repository\CommentRepository;
use App\Repository\ContactMessageRepository;
use App\Repository\EditorRepository;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdminBugFormType;
use App\Form\AdminBugSolutionType;
use App\Form\AdminEditCommentType;
use App\Form\AdminUserType;
use App\Form\AdminBugFixFormType;
use App\Form\ContactMessageFormType;
use App\Form\EditorFormType;
use App\Form\AdminGameFormType;
use App\Repository\ResetPasswordRequestRepository;
use GMP;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /* Get data for tables */

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

    /*Update and delete*/

    // Bug
    /**
     * page de création d'un bug en admin
     * @Route("admin/adminBug/new", name="bugAdminCreationPage")
     * @Route("admin/adminBug/update/{id<\d+>}", name="bugAdminUpdatePage")
     */
    public function adminBugForm(Request $request, Bug $bug = null, FileUploader $fileUploader, EntityManagerInterface $manager, BugRepository $bugRepository, 
    GameRepository $gameRepository): Response 
    {
        $bugs = $bugRepository->findAll();
        
        if(!$bug){
            $bug = new Bug();
        }
        $bugForm = $this->createForm(AdminBugFormType::class, $bug);

        $bugForm->handleRequest($request);
        if(($bugForm->isSubmitted() && $bugForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugForm->get('descriptionImgBug')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bug->setDescriptionImgBug($imageFileName);
            }
            $bug = $bugForm->getData();

            $gameRelated = $bug->getIdGame();
            $allBugsFromGame = $bugRepository->findByGameId($gameRelated);
            $bugCount = count($allBugsFromGame);
            if($bugCount <=  2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(0);
            } elseif($bugCount <=  4 && $bugCount > 2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(1);
            } elseif($bugCount <=  6 && $bugCount > 4) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(2);
            } elseif($bugCount <=  8 && $bugCount > 6) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(3);
            } elseif($bugCount <=  10 && $bugCount > 8) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(4);
            } else {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(5);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bug);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionBugsPage', [
                'pageTitle' => 'Admin',
                'bugs' => $bugs
            ]);
        }

        return $this->render('admin/adminBug.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug',
            'bugForm' => $bugForm->createView()
        ]);
    }

    /**
     * suppression de bug dans db
     * @Route("/admin/adminBug/delete/{id<\d+>}", name="adminDeleteBug")
     */
    public function adminDeleteBug(int $id, BugRepository $bugRepo, BugFixRepository $bugFixRepo, BugSolutionRepository $bugSolutionRepo, CommentRepository $commentRepo): Response
    {
        $bugs = $bugRepo->findAll();
        $bug = $bugRepo->find($id);
        $bugSolutions = $bugSolutionRepo->findByBugId($bug);
        $bugFix = $bug->getIdBugFix();
        $comments = $commentRepo->findByBugId($bug);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$bug){
            throw $this->createNotFoundException(
                'No bug found for id '.$id
            );
        }

        if($bugFix){
            $entityManager->remove($bugFix);
        }
        if($bugSolutions){
            foreach ($bugSolutions as $bugSolution){
                $entityManager->remove($bugSolution);
            }
        }
        if($comments){
            foreach ($comments as $comment){
                $entityManager->remove($comment);
            }
        }
        
        $gameRelated = $bug->getIdGame();
            $allBugsFromGame = $bugRepo->findByGameId($gameRelated);
            $bugCount = (count($allBugsFromGame))-1;
            if($bugCount <=  2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(0);
            } elseif($bugCount <=  4 && $bugCount > 2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(1);
            } elseif($bugCount <=  6 && $bugCount > 4) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(2);
            } elseif($bugCount <=  8 && $bugCount > 6) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(3);
            } elseif($bugCount <=  10 && $bugCount > 8) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(4);
            } else {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(5);
            }
        $entityManager->remove($bug);
            

        $entityManager->flush();

        return $this->redirectToRoute('adminGestionBugsPage', [
            'bugs' => $bugs
        ]);

    }

    // Bug Fix
    /**
     * page de création d'un bugFix en admin
     * @Route("admin/adminBugFix/new", name="bugFixAdminCreationPage")
     * @Route("admin/adminBugFix/update/{id<\d+>}", name="bugFixAdminUpdatePage")
     */
    public function adminBugFixForm(Request $request, BugFix $bugFix = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    BugFixRepository $bugFixRepository): Response 
    {
        $bugFixs = $bugFixRepository->findAll();
        
        if(!$bugFix){
            $bugFix = new BugFix();
        }
        $bugFixForm = $this->createForm(AdminBugFixFormType::class, $bugFix);

        $bugFixForm->handleRequest($request);
        if(($bugFixForm->isSubmitted() && $bugFixForm->isValid())){        
            $bugFix = $bugFixForm->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bugFix);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionBugsFixPage', [
                'bugFixs' => $bugFixs,
                'pageTitle' => 'Admin'
            ]);
        }

        return $this->render('admin/adminBugFix.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug fix',
            'bugFixForm' => $bugFixForm->createView()
        ]);
    }

    /**
     * suppression de bugFix dans db
     * @Route("/admin/adminBugFix/delete/{id<\d+>}", name="adminDeleteBugFix")
     */
    public function adminDeleteBugFix(int $id, Request $request, BugFix $bugFix = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    BugFixRepository $bugFixRepository): Response
    {
        $bugFixs = $bugFixRepository->findAll();
        $bugFix = $bugFixRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$bugFix){
            throw $this->createNotFoundException(
                'No bug Fix found for id '.$id
            );
        }

        $entityManager->remove($bugFix);
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionBugsFixPage', [
            'bugFixs' => $bugFixs
        ]);

    }

    // Bug Solution
    /**
     * page de création d'une solution de bug en admin
     * @Route("admin/adminBugSolution/new", name="bugSolutionAdminCreationPage")
     * @Route("admin/adminBugSolution/update/{id<\d+>}", name="bugSolutionAdminUpdatePage")
     */
    public function adminBugSolutionForm(Request $request, BugSolution $bugSolution = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    BugSolutionRepository $bugSolutionRepository): Response 
    {
        $bugSolutions = $bugSolutionRepository->findAll();
        
        if(!$bugSolution){
            $bugSolution = new BugSolution();
        }
        $bugSolutionForm = $this->createForm(AdminBugSolutionType::class, $bugSolution);

        $bugSolutionForm->handleRequest($request);
        if(($bugSolutionForm->isSubmitted() && $bugSolutionForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugSolutionForm->get('imgBugSolution')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bugSolution->setImgBugSolution($imageFileName);
            }
            $bugSolution = $bugSolutionForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bugSolution);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionBugsSolutionPage', [
                'pageTitle' => 'Admin',
                'bugSolutions' => $bugSolutions
            ]);
        }

        return $this->render('admin/adminBugSolution.html.twig', [
            'pageTitle' => 'Créer/mettre à jour une solution de bug',
            'bugSolutionForm' => $bugSolutionForm->createView()
        ]);
    }

    /**
     * suppression d'une solution de bug dans db
     * @Route("/admin/adminBugSolution/delete/{id<\d+>}", name="adminDeleteBugSolution")
     */
    public function adminDeleteBugSolution(int $id, BugSolutionRepository $bugSolutionRepo): Response
    {
        $bugSolutions = $bugSolutionRepo->findAll();
        $bugSolution = $bugSolutionRepo->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$bugSolution){
            throw $this->createNotFoundException(
                'No bug solution found for id '.$id
            );
        }

        $entityManager->remove($bugSolution);
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionBugsSolutionPage', [
            'bugSolutions' => $bugSolutions
        ]);

    }

    // Commentaires
    /**
     * page de création d'un commentaire en admin
     * @Route("admin/adminComment/new", name="commentAdminCreationPage")
     * @Route("admin/adminComment/update/{id<\d+>}", name="commentAdminUpdatePage")
     */
    public function adminCommentForm(Request $request, Comment $comment = null, CommentRepository $commentRepo, EntityManagerInterface $manager): Response 
    {
        $comments = $commentRepo->findAll();
        
        if(!$comment){
            $comment = new Comment();
        }
        $commentForm = $this->createForm(AdminEditCommentType::class, $comment);

        $commentForm->handleRequest($request);
        if(($commentForm->isSubmitted() && $commentForm->isValid())){
            $comment = $commentForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionCommentsPage', [
                'pageTitle' => 'Admin',
                'comments' => $comments
            ]);
        }

        return $this->render('admin/adminComment.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un commentaire',
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * suppression d'un commentaire dans db
     * @Route("/admin/adminComment/delete/{id<\d+>}", name="adminDeleteComment")
     */
    public function adminDeleteComment(int $id, CommentRepository $commentRepo): Response
    {
        $comment = $commentRepo->find($id);
        $comments = $commentRepo->findAll();
        $entityManager = $this->getDoctrine()->getManager();

        if (!$comment){
            throw $this->createNotFoundException(
                'No comment found for id '.$id
            );
        }

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionCommentsPage', [
            'comments' => $comments
        ]);

    }

    // Messages contact
    /**
     * @Route("/admin/contactMessage/create", name="adminContactPage")
     * @Route("/admin/contactMessage/update/{id<\d+>}", name="contactMessageUpdatePage")
     */
    public function adminContact(ContactMessage $contactMessage = null, Request $request, ContactMessageRepository $contactRepo): Response
    {
        if(!$contactMessage){
            $contactMessage = new ContactMessage();
        }

        $contactForm = $this->createForm(ContactMessageFormType::class, $contactMessage);
        $contactMessages = $contactRepo->findAll();
        $contactForm->handleRequest($request);
        if(($contactForm->isSubmitted() && $contactForm->isValid())){

            $contactMessage = $contactForm->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionContactMessagesPage', [
                'contactMessages' => $contactMessages
            ]);
        }

        return $this->render('admin/adminContactMessages.html.twig', [
            'pageTitle' => 'Contact',
            'contactForm' => $contactForm->createView()
        ]);
    }

    /**
     * page de contact
     * @Route("/admin/contactMessage/delete/{id<\d+>}", name="contactMessageDeletePage")
     */
    public function adminContactDelete(int $id, ContactMessageRepository $contactRepo): Response
    {
        $contactMessages = $contactRepo->findAll();
        $contactMessage = $contactRepo->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contactMessage);
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionContactMessagesPage', [
            'contactMessages' => $contactMessages
        ]);
    }

    
    // Game
    /**
     * page de création d'un jeu en admin
     * @Route("admin/adminGame/new", name="gameAdminCreationPage")
     * @Route("admin/adminGame/update/{id<\d+>}", name="gameAdminUpdatePage")
     */
    public function adminGameForm(Request $request, Game $game = null, EntityManagerInterface $manager, GameRepository $gameRepository): Response 
    {
        $games = $gameRepository->findAll();
        
        if(!$game){
            $game = new Game();
        }
        $gameForm = $this->createForm(AdminGameFormType::class, $game);

        $gameForm->handleRequest($request);
        if(($gameForm->isSubmitted() && $gameForm->isValid())){
            $game = $gameForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionGamesPage', [
                'pageTitle' => 'Admin',
                'games' => $games
            ]);
        }

        

        return $this->render('admin/adminGame.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un jeu',
            'gameForm' => $gameForm->createView()
        ]);
    }

    /**
     * suppression d'un jeu dans db
     * @Route("/admin/adminGame/delete/{id<\d+>}", name="adminDeleteGame")
     */
    public function adminDeleteGame(int $id, GameRepository $gameRepo, BugRepository $bugRepo, BugFixRepository $bugFixRepo, BugSolutionRepository $bugSolutionRepo, CommentRepository $commentRepo): Response
    {
        $games = $gameRepo->findAll();
        $game = $gameRepo->find($id);
        $bugs = $bugRepo->findByGameId($game);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$game){
            throw $this->createNotFoundException(
                'No game found for id '.$id
            );
        }

        $entityManager->remove($game);
        foreach ($bugs as $bug){
            $bugSolutions = $bugSolutionRepo->findByBugId($bug);
            $bugFix = $bug->getIdBugFix();
            $comments = $commentRepo->findByBugId($bug);
            if($bugFix){
                $entityManager->remove($bugFix);
            }
            foreach ($bugSolutions as $bugSolution){
                if($bugSolution){
                    $entityManager->remove($bugSolution);
                }
            }
            foreach ($comments as $comment){
                if($comment){
                    $entityManager->remove($comment);
                } 
            }
            $entityManager->remove($bug);
        }
        
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionGamesPage', [
            'games' => $games
        ]);

    }

    // Editor
    /**
     * page de création d'un éditeur en admin
     * @Route("admin/adminEditor/new", name="editorAdminCreationPage")
     * @Route("admin/adminEditor/update/{id<\d+>}", name="editorAdminUpdatePage")
     */
    public function adminEditorForm(Request $request, EntityManagerInterface $manager, Editor $editor = null,  EditorRepository $editorRepo): Response 
    {
        $editors = $editorRepo->findAll();
        
        if(!$editor){
            $editor = new Editor();
        }
        $editorForm = $this->createForm(EditorFormType::class, $editor);

        $editorForm->handleRequest($request);
        if(($editorForm->isSubmitted() && $editorForm->isValid())){
            $editor = $editorForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionEditorsPage', [
                'pageTitle' => 'Admin',
                'editors' => $editors
            ]);
        }

        return $this->render('pages/addEditor.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un éditeur',
            'editorForm' => $editorForm->createView()
        ]);
    }

    /**
     * suppression d'un éditeur dans db
     * @Route("/admin/adminEditor/delete/{id<\d+>}", name="adminDeleteEditor")
     */
    public function adminDeleteEditor(int $id, EditorRepository $editorRepo, GameRepository $gameRepo, BugRepository $bugRepo, BugSolutionRepository $bugSolutionRepo, 
    CommentRepository $commentRepo): Response
    {
        $editors = $editorRepo->findAll();
        $editor = $editorRepo->find($id);
        $games = $gameRepo->findByEditorId($editor);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$editor){
            throw $this->createNotFoundException(
                'No editor found for id '.$id
            );
        }

        $entityManager->remove($editor);
        foreach($games as $game){
            $bugs = $bugRepo->findByGameId($game);
            foreach ($bugs as $bug){
                $bugSolutions = $bugSolutionRepo->findByBugId($bug);
                $bugFixs = $bug->getIdBugFix();
                $comments = $commentRepo->findByBugId($bug);
                if($bugFixs){
                    $entityManager->remove($bugFixs);
                }
                foreach ($bugSolutions as $bugSolution){
                    if($bugSolution){
                        $entityManager->remove($bugSolution);
                    } 
                }
                foreach ($comments as $comment){
                    if($comment){
                        $entityManager->remove($comment);
                    }
                }
                $entityManager->remove($bug);
            }
            $entityManager->remove($game);
        }
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionEditorsPage', [
            'editors' => $editors
        ]);

    }

    // Users
    /**
     * page de création d'un utilisateur en admin
     * @Route("admin/adminUser/new", name="userAdminCreationPage")
     * @Route("admin/adminUser/update/{id<\d+>}", name="userAdminUpdatePage")
     */
    public function adminUserForm(Request $request, User $user = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    UserRepository $userRepo, UserPasswordEncoderInterface $passwordEncoder): Response 
    {
        $users = $userRepo->findAll();
        
        if(!$user){
            $user = new User();
        }
        $userForm = $this->createForm(AdminUserType::class, $user);

        $userForm->handleRequest($request);
        if(($userForm->isSubmitted() && $userForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $userForm->get('avatar')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $user->setAvatar($imageFileName);
            }
            $user = $userForm->getData();
            $hash = $passwordEncoder->encodePassword($user, $userForm->get('plainPassword')->getData());
            $user->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('adminGestionUsersPage', [
                'pageTitle' => 'Admin',
                'users' => $users
            ]);
        }

        

        return $this->render('admin/adminUser.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un utilisateur',
            'userForm' => $userForm->createView()
        ]);
    }

    /**
     * suppression d'un utilisateur dans db
     * @Route("/admin/adminUser/delete/{id<\d+>}", name="adminDeleteUser")
     */
    public function adminDeleteUser(int $id, UserRepository $userRepo, BugRepository $bugRepo, ResetPasswordRequestRepository $resetPasswordRequestRepo, BugSolutionRepository $bugSolutionRepo, 
    CommentRepository $commentRepo): Response
    {
        $users = $userRepo->findAll();
        $user = $userRepo->find($id);
        $userComments = $commentRepo->findByUserId($user);
        $bugs = $bugRepo->findByUserId($user);
        $resetPasswordRequests = $resetPasswordRequestRepo->findByUserId($user);
        $entityManager = $this->getDoctrine()->getManager();

        if (!$user){
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        
        foreach ($bugs as $bug){
            $bugSolutions = $bugSolutionRepo->findByBugId($bug);
            $bugFix = $bug->getIdBugFix();
            $bugComments = $commentRepo->findByBugId($bug);
            if($bugFix){
                $entityManager->remove($bugFix);
            }
            foreach ($bugSolutions as $bugSolution){
                if($bugSolution){
                    $entityManager->remove($bugSolution);
                } 
            }
            foreach ($userComments as $userComment){
                if($userComment){
                    $entityManager->remove($userComment);
                }
            }
            foreach ($bugComments as $bugComment){
                if($bugComment){
                    $entityManager->remove($bugComment);
                }
            }
            $gameRelated = $bug->getIdGame();
            $allBugsFromGame = $bugRepo->findByGameId($gameRelated);
            $bugCount = (count($allBugsFromGame))-1;
            if($bugCount <=  2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(0);
            } elseif($bugCount <=  4 && $bugCount > 2){
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(1);
            } elseif($bugCount <=  6 && $bugCount > 4) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(2);
            } elseif($bugCount <=  8 && $bugCount > 6) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(3);
            } elseif($bugCount <=  10 && $bugCount > 8) {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(4);
            } else {
                $gameRelated->setNameGame($gameRelated->getNameGame());
                $gameRelated->setYearOfPublication($gameRelated->getYearOfPublication());
                $gameRelated->setIdEditor($gameRelated->getIdEditor());
                $gameRelated->setBugRating(5);
            }
            $entityManager->remove($bug);
        }
        foreach($resetPasswordRequests as $resetPasswordRequest){
            if($resetPasswordRequest){
                $entityManager->remove($resetPasswordRequest);
            }
        }
        $entityManager->remove($user);
       
        $entityManager->flush();

        return $this->redirectToRoute('adminGestionUsersPage', [
            'users' => $users
        ]);

    }

}