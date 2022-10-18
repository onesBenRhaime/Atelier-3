<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    #[Route('/product/fetch', name: 'app_product')]
    public function index(ProductRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/add', name: 'add_product')]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    {
        $em = $doctrine->getManager();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_product');
        }
        return $this->renderForm('product/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/remove/{id}', name: 'remove_product')]
    public function remove(ManagerRegistry $doctrine,$id): Response
    {
        $em = $doctrine->getManager();
        $product = $doctrine->getRepository(Product::class)->find($id);
        
            $em->remove($product);
            $em->flush();
            return $this->redirectToRoute('app_product');
        
    }
}
