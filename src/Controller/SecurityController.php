<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/inscription", name="security_registration")
    */
    public function registration(Request $request){
        $User = new Admin();
        $Manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(RegistrationType::class, $User);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $User->setCreatedAt(new \DateTime()); //Ajout automatique de la date de création del'utilisateur
            $Manager->persist($User);
            $Manager->flush();

            // return $this->redirectToRoute('project_show', ['id' =>$project->getId()]);
        }


        return $this->render('security/registration.html.twig', [
            'registrationform' => $form->createView()
        ]);
    }
}
