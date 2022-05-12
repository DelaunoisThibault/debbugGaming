<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\BugSolution;
use App\Form\BugFixFormType;
use App\Form\BugFormType;
use App\Form\BugSolutionFormType;
use App\Repository\BugRepository;
use App\Repository\BugFixRepository;
use App\Repository\CommentRepository;
use App\Repository\BugSolutionRepository;
use App\Repository\GameRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class BugController extends AbstractController
{
    /**
     * page de création bug
     * @Route("/bug/new", name="bugCreationPage")
     * @Route("/bug/update/{id<\d+>}", name="bugUpdatePage")
     */
    public function bugForm(Request $request, Bug $bug = null, FileUploader $fileUploader, EntityManagerInterface $manager, BugRepository $bugRepository, 
    GameRepository $gameRepository): Response
    {
        if(!$bug){
            $bug = new Bug();
        }
        $bugForm = $this->createForm(BugFormType::class, $bug);

        $bugForm->handleRequest($request);
        if(($bugForm->isSubmitted() && $bugForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugForm->get('descriptionImgBug')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bug->setDescriptionImgBug($imageFileName);
            }
            $bug = $bugForm->getData();

            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $bug->setIdUser($user);
            $bug->setPublished(false);

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

            return $this->redirectToRoute('bugPage', [
                'id' => $bug->getId()
            ]);
        }

        return $this->render('pages/creationBug.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug',
            'bugForm' => $bugForm->createView()
        ]);
    }

    /**
     * suppression de bug 
     * @Route("/bug/delete/{id<\d+>}", name="deleteBug")
     */
    public function deleteBug(int $id, BugRepository $bugRepo, PaginatorInterface $paginator, Request $request, BugSolutionRepository $bugSolutionRepo, CommentRepository $commentRepo): Response
    {
        $bugs = $bugRepo->findAllByRecent();
        $bug = $bugRepo->find($id);
        $bugSolutions = $bugSolutionRepo->findByBugId($bug);
        $bugFix = $bug->getIdBugFix();
        $comments = $commentRepo->findByBugId($bug);
        $entityManager = $this->getDoctrine()->getManager();
        $bugs = $paginator->paginate(
            $bugs,
            $request->query->getInt('page', 1),
            3
        );

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
        

        return $this->redirectToRoute('homePage', [
            'pageTitle' => 'Accueil',
            'listBugs' => $bugs
        ]);

    }

    /**
     * page de création de solution de bug
     * @Route("/bug/{idBug<\d+>}/bugSolution/new", name="bugSolutionCreationPage")
     */
    public function bugSolutionForm(int $idBug, Request $request, FileUploader $fileUploader, BugRepository $bugRepository): Response
    {
        $bugSolution = new BugSolution;
        $bug= $bugRepository->find($idBug);
        
        $bugSolutionForm = $this->createForm(BugSolutionFormType::class, $bugSolution);
        
        $bugSolutionForm->handleRequest($request);
        if(($bugSolutionForm->isSubmitted() && $bugSolutionForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugSolutionForm->get('imgBugSolution')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bugSolution->setImgBugSolution($imageFileName);
            }
            $bugSolution = $bugSolutionForm->getData();
            $bugSolution->setIdBug($bug);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bugSolution);
            $entityManager->flush();

            return $this->redirectToRoute('bugPage', [
                'id' => $bug->getId()
            ]);
        }

        return $this->render('pages/addBugSolution.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug',
            'bugSolutionForm' => $bugSolutionForm->createView()
        ]);
    }

    /**
     * page de mise à jour de solution de bug
     * @Route("/bugSolution/update/{id<\d+>}", name="bugSolutionUpdatePage")
     */
    public function bugSolutionUpdateForm(Request $request, BugSolution $bugSolution = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    BugRepository $bugRepository): Response
    {
        $bug = $bugRepository->find($bugSolution->getIdBug());
        $bugSolutionForm = $this->createForm(BugSolutionFormType::class, $bugSolution);
        
        $bugSolutionForm->handleRequest($request);
        if(($bugSolutionForm->isSubmitted() && $bugSolutionForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugSolutionForm->get('imgBugSolution')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bugSolution->setImgBugSolution($imageFileName);
            }
            $bugSolution = $bugSolutionForm->getData();
            $bugSolution->setIdBug($bug);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bugSolution);
            $entityManager->flush();

            return $this->redirectToRoute('bugPage', [
                'id' => $bug->getId()
            ]);
        }

        return $this->render('pages/addBugSolution.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug',
            'bugSolutionForm' => $bugSolutionForm->createView()
        ]);
    }

    /**
     * suppression d'une solution de bug 
     * @Route("/bugSolution/delete/{id<\d+>}", name="deleteBugSolution")
     */
    public function deleteBugSolution(int $id, BugSolutionRepository $bugSolutionRepo): Response
    {
        $bugSolution = $bugSolutionRepo->find($id);
        $bug= $bugSolution->getIdBug();
        $entityManager = $this->getDoctrine()->getManager();

        if (!$bugSolution){
            throw $this->createNotFoundException(
                'No bug solution found for id '.$id
            );
        }

        $entityManager->remove($bugSolution);
        $entityManager->flush();

        return $this->redirectToRoute('bugPage', [
            'id' => $bug->getId()
        ]);

    }
}