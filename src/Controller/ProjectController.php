<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/project/new", name="new_project")
     */
    public  function create(Request $request){
        $project = new Project();
        $form=$this->createFormBuilder($project)
                    ->add('Title')
                    ->add('Description')
                    ->add('Image')
                    ->add('Github')
                    ->add('Weblink')
                 
                    ->getForm();
        $form ->handleRequest($request);

        dump($project);

        return $this->render('project/create.html.twig', [
                'formProject' => $form->createView()
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
