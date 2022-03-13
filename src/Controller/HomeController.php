<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\AssortimentRepository;
use App\Repository\CategorieRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategorieRepository $repoCategory, AssortimentRepository $repoAssortiment, ThemeRepository $repoTheme, EntityManagerInterface $manager): Response
    {
        
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $category = $repoCategory->findByGroup('france_meuble');

        $assortiment = $repoAssortiment->findNewest();

        $theme = $repoTheme->findNewest();

        return $this->render('boutique/index.html.twig', [
            'controller_name' => 'HomeController',
            'colonnes'=>$colonnes,
            'category'=>$category,
            'theme'=>$theme,
            'assortiment'=>$assortiment
        ]);
    }

    //############################## CGV ###########################################

  
    #[Route('/CGV', name: 'boutique_cgv')]
    public function cgv(): Response
    {
        return $this->render('boutique/cgv.html.twig', [

        ]);
    }

}
