<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
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

    #[Route('/add_category', name: 'add_category')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Categorie;

        $formCategory = $this->createForm(CategorieType::class, $category);
        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted())
        {
            $manager->persist($category);//test
            $manager->flush();
            return $this->redirectToRoute('backoffice');
        }
        

        return $this->render('backoffice/add_category.html.twig', [
            'controller_name' => 'BackofficeController',
            'formCategory' => $formCategory->createView(),
        ]);
    }
}
