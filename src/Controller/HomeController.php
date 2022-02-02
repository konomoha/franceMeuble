<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategorieRepository $repoCategory, EntityManagerInterface $manager): Response
    {
        
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $category = $repoCategory->findAll();

        return $this->render('boutique/index.html.twig', [
            'controller_name' => 'HomeController',
            'colonnes'=>$colonnes,
            'category'=>$category
        ]);
    }

    //############################## AFFICHAGE DES CATEGORIES ###########################################

    #[Route('/categories', name: 'boutique_categories')]
    public function boutiqueCategories(CategorieRepository $repoCategory, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $category = $repoCategory->findAll();

        return $this->render('boutique/categories_list.html.twig', [
            'colonnes'=>$colonnes,
            'category'=>$category
        ]);
        
    }

    #[Route('/CGV', name: 'boutique_cgv')]
    public function cgv(): Response
    {
        return $this->render('boutique/cgv.html.twig', [

        ]);
    }

}
