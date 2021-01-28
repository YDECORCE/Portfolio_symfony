<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Category;
use App\Form\ProjectType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
// use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $categories =$this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('project/admin.html.twig', [
            'projects' => $projects,
            'categories' => $categories
            ]);
    }

    /**
     * @Route("/project", name="project")
     */
    public function index(ProjectRepository $repo, CategoryRepository $repocategory): Response
    {
        $projects = $repo ->findAll();
        $categories=$repocategory ->findAll();
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projects,
            'categories' => $categories
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
        else{

            $oldimage=$project->getImage();

        }
        $Manager = $this->getDoctrine()->getManager();

        $form=$this->createForm(ProjectType::class,$project);
                    
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if ($project->getImage() !== null) {
                
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
                }
            }
            else{
                $project->setImage($oldimage);
            }


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
 public function removeProject(Project $project): Response
 {
    $entityManager=$this->getDoctrine()->getManager();
    $entityManager->remove($project);
    $entityManager->flush();
    return $this->redirectToRoute('admin');
 }


    /**
     * @Route("/CRUD/category/new", name="new_category")
     * @Route("/CRUD/category/{id}/edit", name="edit_category")
     */
    public  function categoryform(Category $category = null , Request $request){
        
        if(!$category){
            $category = new Category();
        }
        $Manager = $this->getDoctrine()->getManager();

        $form=$this->createForm(CategoryType::class,$category);
                    
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $Manager->persist($category);
            $Manager->flush();

            return $this->redirectToRoute('admin');
        }
        
      
        return $this->render('project/createcategory.html.twig', [
                'formcategory' => $form->createView(),
                'editmode' => $category->getId()!==null

        ]);
    
    }

/**
 * @Route("/CRUD/category/remove/{id}", name="remove_category")
 */
public function removeCategory(Category $category): Response
{
   $entityManager=$this->getDoctrine()->getManager();
   $entityManager->remove($category);
   $entityManager->flush();
   return $this->redirectToRoute('admin');
}

}