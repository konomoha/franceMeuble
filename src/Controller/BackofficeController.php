<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Entity\Souscategorie;
use App\Form\SousCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'backoffice')]
    public function index(): Response
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }

    #[Route('/backoffice/add', name: 'add_category')]
    #[Route('/backoffice/{id}/edit', name: 'edit_category')]
    public function add(Request $request, EntityManagerInterface $manager, Categorie $category=null): Response
    {
        if(!$category)
        {
            $category = new Categorie;
        }
        
        $formCategory = $this->createForm(CategorieType::class, $category);
        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted())
        {
            $manager->persist($category);//test
            $manager->flush();
            return $this->redirectToRoute('backoffice');
        }
        

        return $this->render('backoffice/categoryform.html.twig', [
            'controller_name' => 'BackofficeController',
            'formCategory' => $formCategory->createView(),
        ]);
    }

    #[Route('/backoffice/subcategorie/add', name: 'add_sub_category')]
    public function addSubCategory(Request $request, EntityManagerInterface $manager):Response
    {
        $souscategorie = new Souscategorie;

        $subcategorieForm = $this->createForm(SousCategorieType::class, $souscategorie);

        $subcategorieForm->handleRequest($request);

        if($subcategorieForm->isSubmitted())
        {
            $manager->persist($souscategorie);//test
            $manager->flush();
            return $this->redirectToRoute('backoffice');
        }

        return $this->render('backoffice/sub_categoryform.html.twig', [
            'controller_name' => 'BackofficeController',
            'subcategorieForm' => $subcategorieForm->createView(),
            
        ]);  
    }

    #[Route('/backoffice/product/add', name: 'add_product')]
    public function addProduct(EntityManagerInterface $manager, Request $request): Response
    {
        $product = new Produit;
        
        $productForm = $this->createForm(Product::class, $product);

        $productForm->handleRequest($request);

        if($productForm->isSubmitted())
        {
            $manager->persist($productForm);//test
            $manager->flush();
            return $this->redirectToRoute('backoffice');
        }

        return $this->render('backoffice/product.html.twig', [
            'controller_name' => 'BackofficeController',
            'productForm'=> $productForm->createView()
            
        ]); 
    }
}
