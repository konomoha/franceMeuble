<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaryamCoutureController extends AbstractController
{
    #[Route('/maryam_couture', name: 'maryam_couture')]
    public function index(CategorieRepository $repoCat): Response
    {
        $categories = $repoCat->findByGroup('maryam_couture');

        return $this->render('maryam_couture/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    ######################################### AFFICHAGE CATEGORIES MARYAM COUTURE #############################################
    #[Route('/maryam_couture/categories', name: 'maryam_couture_categories')]
    public function allCategory(CategorieRepository $repoCat): Response
    {
        $categories = $repoCat->findByGroup('maryam_couture');

        return $this->render('maryam_couture/maryam_couture_categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    

}
