<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/inscription", name="security_registration")
    */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder){
        $User = new Admin();
        $Manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(RegistrationType::class, $User);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $User->setCreatedAt(new \DateTime()); //Ajout automatique de la date de création del'utilisateur
            $hash = $encoder->encodePassword($User, $User->getPassword());

            $User->setPassword($hash);

            $Manager->persist($User);
            $Manager->flush();

            return $this->redirectToRoute('login');
        }


        return $this->render('security/registration.html.twig', [
            'registrationform' => $form->createView()
        ]);
    }
    /**
     * @route("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
