<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use App\Repository\AssortimentRepository;
use App\Repository\ProduitRepository;
use App\Repository\SouscategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ThemeController extends AbstractController
{
    ################################################ LISTE DES THEMES ########################################################"
    #[Route('/theme', name: 'theme')]
    public function allThemes(ThemeRepository $repoTheme): Response
    {
        $theme = $repoTheme->findAll();

        return $this->render('theme/theme_list.html.twig', [
            'theme' => $theme,
        ]);
    }

    ############################################## AFFICHAGE DES THEMES ####################################################

    #[Route('/theme/{id}', name:'boutique_theme_show')]
    public function themeShow(ThemeRepository $repoTheme, Theme $theme, ProduitRepository $repoProduit, SouscategorieRepository $repoSubcat, AssortimentRepository $repoAssortiment): Response
    {
        $id = $theme->getId();

        $themeData = $repoTheme->find($id); // variable qui servira à récupérer toutes les information du thème en fonction de l'id présent dans l'url
        
        $produitData = $repoProduit->findByTheme($id); //Cette variable récupère toutes les données d'un produit ayant un thème précis;

        $subcatData = $repoSubcat->findAll();// On récupère ici toutes les données de toutes les catégories présentes en bdd

        $data = []; //Cet array vide nous peremttra de stocker les noms de catégories précises

        $assortimentdata = [];//Cet array vide nous peremttra de stocker les noms d'assortiments précis

        $subcatTab = []; //Array qui servira à stocké les sous-catégories après filtrage

        $assortimenTab = [];//Array qui servira à stocké les assortiments après filtrage

        foreach($subcatData as $key=>$tab)
        {
            //On entre ici dans l'array multi subcatData puis dans le sous-tableau des produits ($tab->getPoduits())
            foreach($tab->getProduits() as $key=>$tab)
            {
                //Ici, on met en place une condition: si un des produits contenus dans $tab ($tab->getProduits()) a le même thème que celui que l'on a stocké dans la variable $theme plus haut, on le séléctionne et on stock le nom du thème dans l'array $data[] qu'on a déclaré plus haut
                if($tab->getTheme() == $theme)
                {
                    // dump($tab->getSouscategorie());
                    $data[]= $tab->getSouscategorie()->getNom();
                    
                    //Dans la condition if, on met un foreach pour récupérer les id des assortiments de tous les produits ayant un thème identique à $theme
                    foreach($tab->getAssortiment() as $key=>$value)
                    {
                        // dump($value);
                        $assortimentdata[]= $value->getId();
                    }
                    
                }  

            }

        }

        // dump($assortimentdata);

        //On déclare ensuite une variable $subcatName qui contiendra l'array $data sans doublons grâce à la méthode array_unique. Il n'y aura ainsi pas deux fois le même nom de thème dans l'array $subcatName. Sans ce filtrage, il y aurait autant de fois le même nom de thème que de produits le possédant (à noter que array_unique ne fonctionne que pour les chaînes de caractères ou les integers, d'où la nécessité de récupérer uniquement le nom des sous-catégories, ou les id des assortiments à ce stade)

        $subcatName= array_unique($data);

        //Même process que ci-dessus pour la variable $assortimentId
        $assortimentId = array_unique($assortimentdata);

        //Enfin, nous nous servons de l'array subcatName[] pour faire une recherche de sous-catégories en fonction de leur nom avec une méthode mise en place dans SouscategorieRepository. Les informations de chaques catégories ayant des produits à thème précis sont ensuite stocké dans l'array final subcatTab.

        foreach($subcatName as $key=>$value)
        {
            $subcatTab[]= $repoSubcat->findByName($value);
        }

        //On effectue la même recherche pour les assortiment, mais en recherchant cette fois par id
        foreach($assortimentId as $key=>$value)
        {  
            // dump($value);

            $assortimenTab[]= $repoAssortiment->find($value);
        }

        // dump($subcatTab);

        //Je vais avoir besoin d'un méthode pour récupérer tous les produits, catégories et sous catégories liées au thème

        return $this->render('theme/theme_show.html.twig', [
            'themeData'=>$themeData,
            'produitData'=>$produitData,
            'subcatTab'=>$subcatTab,
            'assortimenTab'=>$assortimenTab
        ]);
    }
}
