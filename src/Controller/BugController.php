<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Form\BugFixFormType;
use App\Form\BugFormType;
use App\Repository\BugRepository;
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
    public function bugForm(Request $request, Bug $bug = null, FileUploader $fileUploader, EntityManagerInterface $manager, BugRepository $bugRepository): Response
    {
        if(!$bug){
            $bug = new Bug();
        }
        $bugForm = $this->createForm(BugFormType::class, $bug);
        //$bugFIxForm = $this->createForm(BugFixFormType::class, $bugFix);

        $bugForm->handleRequest($request);
        if(($bugForm->isSubmitted() && $bugForm->isValid())){
            /** @var UploadedFile $avatarFile */
            $imageFile = $bugForm->get('descriptionImgBug')->getData();
            if($imageFile){
                $imageFileName = $fileUploader->uploadImageFromForm($imageFile);
                $bug->setDescriptionImgBug($imageFileName);
            }
            $bug = $bugForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bug);
            $entityManager->flush();

            return $this->redirectToRoute('bugPage', [
                'id' => $bug->getId()
            ]);
        }

        /*$totalBugsForGame = $bugRepository->createQueryBuilder('a')
            ->andWhere('a.idGame = $game')
            ->select('count(a.id')
            ->getQuery()
            ->getSingleScalarResult();
        $bugRate = ($totalBugsForGame*0.33);
        */

        return $this->render('pages/creationBug.html.twig', [
            'pageTitle' => 'Créer/mettre à jour un bug'
        ]);
    }
}