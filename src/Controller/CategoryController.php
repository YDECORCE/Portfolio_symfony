<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $repo): Response
    {
        $category = $repo ->findAll();
        return $this->render('category/index.html.twig', [
            'Categories' => $category,
        ]);
    }
/**
     * @Route("/onecategory/{id}", name="showbycategory")
     */
    public function showbycategory(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'Category' => $category,
        ]);
    }

}
