<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ProfileFormType;
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('pages/profile.html.twig', [
            'pageTitle' => 'Profil',
            'userData' => $user
        ]);
    }

        /**
     * page de modification de profil
     * @Route("/profile/update/{id<\d+>}", name="updateUser")
     */
    public function updateUser(User $user, Request $request, FileUploader $imageUploader, UserPasswordEncoderInterface $userEncoder): Response
    {
        $userForm = $this->createForm(ProfileFormType::class, $user);
        $userForm->handleRequest($request);
        if($user->getRoles() == ['ROLE_USER']){
            $user->setIsVerified($user->isVerified())
            ->setRoles(['ROLE_USER'])
            ->setLocked($user->getLocked())
            ->setPassword($user->getPassword());
        } elseif($user->getRoles() == ['ROLE_ADMIN']){
            $user->setIsVerified($user->isVerified())
            ->setRoles(['ROLE_ADMIN'])
            ->setLocked($user->getLocked())
            ->setPassword($user->getPassword());
        } elseif($user->getRoles() == ['ROLE_ADMIN','ROLE_USER']){
            $user->setIsVerified($user->isVerified())
            ->setRoles(['ROLE_ADMIN'])
            ->setLocked($user->getLocked())
            ->setPassword($user->getPassword());
        }
        
        if($userForm->isSubmitted() && $userForm->isValid()){
            /** @var UploadedFile $avatarFile */
            $user = $userForm->getData();
            $avatarFile = $userForm->get('avatar')->getData();
            if($avatarFile){
                $avatarFileName = $imageUploader->uploadImageFromForm($avatarFile);
                $user->setAvatar($avatarFileName);
            }
            //$hash = $userEncoder->encodePassword($user, $user->getPassword());
            //$user->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profilePage', []);
        }

        return $this->render('pages/editProfile.html.twig', [
            'pageTitle' => 'Modification profil',
            'userForm' => $userForm->createView()
        ]);
    }

    /**
     * page de lien vers attente activation profil
     * @Route("/waitingActivateProfile", name="waitingProfileActivationPage")
     */
    public function waitingProfileActivation(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('registration/waitingRegistration.html.twig', [
            'pageTitle' => 'Attente activation compte',
            'user' => $user
        ]);
    }
}