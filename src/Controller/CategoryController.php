<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\Persistence\ManagerRegistry;
class CategoryController extends AbstractController
{
  
    #[Route('/category/fetch', name: 'app_category')]
    public function index(CategoryRepository $repo): Response
    {
        $catgeories = $repo->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $catgeories,
        ]);
    }

    #[Route('/category/add', name: 'add_category')]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    {
        $em = $doctrine->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_category');
        }
        return $this->renderForm('category/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/category/remove/{id}', name: 'remove_category')]
    public function remove(ManagerRegistry $doctrine,$id): Response
    {
        $em = $doctrine->getManager();
        $category = $doctrine->getRepository(Category::class)->find($id);
        
            $em->remove($category);
            $em->flush();
            return $this->redirectToRoute('app_category');
        
    }

}
