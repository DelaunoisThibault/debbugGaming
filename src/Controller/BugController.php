<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\BugSolution;
use App\Form\BugFixFormType;
use App\Form\BugFormType;
use App\Form\BugSolutionFormType;
use App\Repository\BugRepository;
use App\Repository\GameRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            'bugForm' => $bugForm
        ]);
    }

    /**
     * page de création de solution de bug
     * @Route("/bugSolution/new", name="bugSolutionCreationPage")
     * @Route("/bugSolution/update/{id<\d+>}", name="bugSolutionUpdatePage")
     */
    public function bugSolutionForm(Request $request, BugSolution $bugSolution = null, FileUploader $fileUploader, EntityManagerInterface $manager, 
    BugRepository $bugRepository): Response
    {
        $bug= $bugSolution->getIdBug();
        if(!$bugSolution){
            $bugSolution = new BugSolution;
        }
        $bugSolutionForm = $this->createForm(BugSolutionFormType::class, $bugSolution);
        
        $bugSolutionForm->handleRequest($request);
        if(($bugSolutionForm->isSubmitted() && $bugSolutionForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugSolutionForm->get('ImgBugSolution')->getData();
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
            'bugSolutionForm' => $bugSolutionForm
        ]);
    }
}