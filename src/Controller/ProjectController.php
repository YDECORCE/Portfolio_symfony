<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
// use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
                    ->add('Image', FileType::class, [
                        'label' => 'Image',

                // unmapped means that this field is not associated to any entity property
                        'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                        'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                        'constraints' => [
                                new File([
                                    'maxSize' => '1024k',
                                    'mimeTypes' => [
                                    'image/png',
                                    'image/jpg','image/jpeg','image/gif'
                                        ],
                        'mimeTypesMessage' => 'Merci d\'uploader un fichier image valide',
                                ])
                                    ],
                    ])
                    ->add('Github', UrlType::class)
                    ->add('Weblink', UrlType::class)
                 
                    ->getForm();
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $brochureFile=$form->get('Image')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('Images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $this->redirectToRoute('admin');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $project->setImage($newFilename);


            $Manager->persist($project);
            $Manager->flush();

            return $this->redirectToRoute('admin');
        }
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