<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{

    /**
     * page d'inscription
     * @Route("/registration", name="registrationPage")
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $userEncoder): Response
    {
        $newUser = new User();
        $newUser->setRoles(['ROLE_USER'])
            ->setLocked(false)
            ->setAvatar('user_icon.png');
        $userForm = $this->createForm(RegistrationFormType::class, $newUser);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $hash = $userEncoder->encodePassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hash);

            $entityManager->persist($newUser);
            $entityManager->flush();
            return $this->redirectToRoute('connectionPage', []);
        }

        return $this->render('pages/inscription.html.twig', [
            'pageTitle' => 'Inscription',
            'userForm' => $userForm->createView()
        ]);
    }

    /**
     * page de connexion
     * @Route("/connection", name="connectionPage")
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
}