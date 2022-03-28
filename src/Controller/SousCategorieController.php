<?php

namespace App\Controller;

use App\Entity\Souscategorie;
use App\Repository\ProduitRepository;
use App\Repository\SouscategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SousCategorieController extends AbstractController
{
    // ############################################ LISTE DES SOUS-CATEGORIES ################################################

    #[Route('/subcategory', name: 'boutique_subcategories')]
    public function allSubCategories(SouscategorieRepository $subcatRepo, EntityManagerInterface $manager): Response
    {
        // Nous récupérons ici toutes les informations des catégories présentes en bdd. Elles sont ensuite transmises au template sous_categories_list afin de le réutiliser dans les menus de navigation.

        $colonnes = $manager->getClassMetadata(Souscategorie::class)->getFieldNames();

        $subcategories = $subcatRepo->findAll();

        return $this->render('sous_categorie/sous_categories_list.html.twig', [
            'colonnes' => $colonnes,
            'subcategories'=> $subcategories
        ]);
    }

    // ############################################ AFFICHAGE D'UNE SOUS-CATEGORIE ############################################

    #[Route('/subcategory/{id}', name: 'boutique_subcategory_show')]
    public function subCategoryShow(Souscategorie $souscategorie, SouscategorieRepository $subcatRepo, ProduitRepository $productRepo)
    {
        // On récupère ici l'id de la sous-catégorie sélectionnée. l'array subcatData contient toutes les informations de la sous-catégorie. On se sert également de la méthode construite dans ProduitRepository : findGroup(). Cette méthode attend un id en argument et permet de trouver tous les produits appartenant à une sous-catégorie précise. Elle regroupe ensuite tous les produits trouvés par nom et retourne le résultat sous la forme d'un array.

        $subcatData = $subcatRepo->find($souscategorie);

        $id = $souscategorie->getId();
        
        $products = $productRepo->findGroup($id);
    
        return $this->render('sous_categorie/sous_categorie.html.twig', [
            'subcatData' => $subcatData,
            'products' => $products
        ]);
    }
}
