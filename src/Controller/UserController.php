<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\FileUploader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /**
     * page de connexion
     * @Route("/connection", name="connectionPag")
     */
    public function connection(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/connection.html.twig', [
            'pageTitle' => 'Connexion',
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * page de profil
     * @Route("/profile", name="profilePage")
     */
    public function showProfile(): Response
    {
        return $this->render('pages/profile.html.twig', [
            'pageTitle' => 'Profil'
        ]);
    }

        /**
     * page de modification de profil
     * @Route("/profile/update/{id<\d+>}", name="updateUser")
     */
    public function updateUser(User $user, Request $request, FileUploader $imageUploader, UserPasswordEncoderInterface $userEncoder): Response
    {
        $userForm = $this->createForm(EditProfileFormType::class, $user);
        $userForm->handleRequest($request);
        $user->setIsVerified($user->isVerified())
            ->setLocked($user->getLocked())
            ->setPassword($user->getPassword());


        if($userForm->isSubmitted() && $userForm->isValid()){
            /** @var UploadedFile $avatarFile */
            $user = $userForm->getData();
            $avatarFile = $userForm->get('avatar')->getData();
            if($avatarFile){
                $avatarFileName = $imageUploader->uploadImageFromForm($avatarFile);
                $user->setAvatar($avatarFileName);
            }
            $hash = $userEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profilePage', []);
        }

        return $this->render('pages/changerProfil.html.twig', [
            'pageTitle' => 'Modification profil',
            'userForm' => $userForm->createView()
        ]);

    }
}