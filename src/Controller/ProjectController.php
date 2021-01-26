<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
// use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/CRUD/admin", name="admin")
     */
    public function admin()
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();

        return $this->render('project/admin.html.twig', [
            'projects' => $projects
            ]);
    }

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
                    ->add('Description', CKEditorType::class)
                    ->add('Image')
                    ->add('Github')
                    ->add('Weblink')
                 
                    ->getForm();
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $Manager->persist($project);
            $Manager->flush();

            return $this->redirectToRoute('admin');
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
/**
 * @Route("/CRUD/project/remove/{id}", name="remove_project")
 */
 public function remove(Project $project): Response
 {
    $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($project);
    $entityManager->flush();
    return $this->redirectToRoute('admin');
 }
}