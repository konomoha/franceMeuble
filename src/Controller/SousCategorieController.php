<?php

namespace App\Controller;

use App\Entity\Souscategorie;
use App\Repository\SouscategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SousCategorieController extends AbstractController
{
    #[Route('/subcategory', name: 'boutique_subcategories')]
    public function allSubCategories(SouscategorieRepository $subcatRepo, EntityManagerInterface $manager): Response
    {
        $colonnes = $manager->getClassMetadata(Souscategorie::class)->getFieldNames();

        $subcategories = $subcatRepo->findAll();

        return $this->render('sous_categorie/sous_categories_list.html.twig', [
            'colonnes' => $colonnes,
            'subcategories'=> $subcategories
        ]);
    }

    #[Route('/subcategory/{id}', name: 'boutique_subcategory_show')]
    public function subCategoryShow(Souscategorie $souscategorie, SouscategorieRepository $subcatRepo)
    {
        $subcatData = $subcatRepo->find($souscategorie);

        return $this->render('sous_categorie/sous_categorie.html.twig', [
            'subcatData' => $subcatData
        ]);
    }
}
