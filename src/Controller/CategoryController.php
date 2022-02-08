<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'boutique_categories')]
    public function allCategories(CategorieRepository $repoCategory, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $categories = $repoCategory->findAll();

        return $this->render('category/categories_list.html.twig', [
            'colonnes'=>$colonnes,
            'categories'=>$categories
        ]);
        
    }

    #[Route('/category/{id}', name: 'boutique_category_show')]
    public function categoryShow(Categorie $category, CategorieRepository $catRepo)
    {
        $id = $category->getId();
        $datacat = $catRepo->find($id);

        return $this->render('category/category.html.twig', [
            "datacat"=>$datacat
        ]);
    }

}
