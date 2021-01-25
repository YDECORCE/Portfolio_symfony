<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Repository\ProjectRepository;
// use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(ProjectRepository $repo): Response
    {
        $projects = $repo ->findAll();
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects,
        ]);
    }
    /**
     * @Route("/CRUD/project/new", name="new_project")
     * @Route("/CRUD/project/{id}/edit", name="edit_project")
     */
    public  function form(Project $project = null , Request $request){
        
        if(!$project){
            $project = new Project();
        }
        $Manager = $this->getDoctrine()->getManager();

        $form=$this->createFormBuilder($project)
                    ->add('Title')
                    ->add('Description')
                    ->add('Image')
                    ->add('Github')
                    ->add('Weblink')
                 
                    ->getForm();
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $Manager->persist($project);
            $Manager->flush();

            return $this->redirectToRoute('project_show', ['id' =>$project->getId()]);
        }

      
        return $this->render('project/create.html.twig', [
                'formProject' => $form->createView(),
                'editmode' => $project->getId()!==null

        ]);
    }

    
    /**
     * @Route("/project/{id}", name="project_show")
     */
    public function show(Project $project){
        
        return $this->render('project/show.html.twig', [
            'project'   =>  $project,
            ]);
    }

    
}
