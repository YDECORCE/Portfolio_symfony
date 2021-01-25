<?php

namespace App\Controller;

// use App\Entity\Admin;
// use App\Form\RegistrationType;
// use Doctrine\Persistence\ObjectManager;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/inscription", name="security_registration")
    */
    // public function registration(Request $request, UserPasswordEncoderInterface $encoder){
    //     $User = new Admin();
    //     $Manager = $this->getDoctrine()->getManager();

    //     $form = $this->createForm(RegistrationType::class, $User);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){
    //         $User->setCreatedAt(new \DateTime()); //Ajout automatique de la date de création del'utilisateur
    //         $hash = $encoder->encodePassword($User, $User->getPassword());

    //         $User->setPassword($hash);

    //         $Manager->persist($User);
    //         $Manager->flush();

    //         return $this->redirectToRoute('login');
    //     }


    //     return $this->render('security/registration.html.twig', [
    //         'registrationform' => $form->createView()
    //     ]);
    // }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
}
