<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ProductType;
use App\Form\CategorieType;
use App\Entity\Souscategorie;
use App\Form\SousCategorieType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SouscategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'backoffice')]
    public function index(): Response
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }

    #[Route('backoffice/products', name: 'backoffice_products')]
    public function adminProducts(ProduitRepository $repoProduit, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Produit::class)->getFieldNames();

        $produits = $repoProduit->findAll();

        return $this->render('backoffice/produits.html.twig', [
            'colonnes'=>$colonnes,
            'produits'=>$produits
        ]);
        
    }

    #[Route('/backoffice/product/add', name: 'add_product')]
    #[Route('/backoffice/product/{id}/edit', name: 'edit_product')]
    public function addProduct(EntityManagerInterface $manager, Request $request, Produit $produit=null,SluggerInterface $slugger): Response
    {
        if($produit)
        {
            $photoActuelle = $produit->getPhoto();
        }

        if(!$produit)
        {
            $produit = new Produit;
        }
        

        // $produit ->setTitre("titre à la con")
        //         ->setContenu("contenu à la con");

        $formProduit = $this->createForm(ProductType::class, $produit );

        //$produit ->setTitre($_POST['titre'])
        //$produit ->setContenu($_POST['contenu'])
        //handleRequest() permet d'envoyer chaque données de $_POST et de kes transmettre aux bons setters de l'objet entité $produit 

        $formProduit->handleRequest($request);

        if($formProduit->isSubmitted() && $formProduit->isValid())
        {
            
            //DEBUT TRAITEMENT DE LA PHOTO
            //On récupère toutes les informations de l'image uploadé dans le formulaire
            $photo = $formProduit->get('photo')->getData();

            // dd($photo);

            if($photo)//si une photo est uploadé dans le formulaire, on entre le IF et on traite l'image
            {
                //On récupère le nom d'origine de la photo
                $nomOriginePhoto = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // dd($nomOriginePhoto);

                //cela est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                $secureNomPhoto = $slugger->slug($nomOriginePhoto);
            
                $nouveauNomFichier = $secureNomPhoto . '-' . uniqid(). '.' .$photo->guessExtension();
                // dd($nouveauNomFichier);

                try // on tente de copier l'image dans le dossier
                {
                    // On copie l'image vers le bon chemin, vers le bon dossier 'public/uploads/photos' (services.yaml)
                    $photo->move(
                        $this->getparameter('photo_directory'),
                        $nouveauNomFichier
                    );
                }
                catch(FileException $e)
                {
                    
                }

                $produit ->setPhoto($nouveauNomFichier);

            }

            //Sinon, aucune image n'a été uploadée, on renvoie dans la bdd la photo actuelle de l'article
            else
            {
                //Si la photo actuelle est définie en BDD, alors en cas de modification, si on ne change pas de photo, on renvoie la photo actuelle en bdd
               if(isset($photoActuelle))
               {
                   $produit ->setPhoto($photoActuelle);
               }

               //Sinon aucune photo n'a été uploadée, on envoie la valeur NULL en BDD pour la photo
               else
               {
                    $produit ->setPhoto(null);
               }
                
            }

            // FIN TRAITEMENT PHOTO

            // dd($produit );

            //Message de validation en session
            if(!$produit ->getId())
                $txt = "enregistré";
            else
                $txt = "modifié";

            //Méthode permettant d'enregistrer des messages utilisateurs accessibles en session
            $this->addFlash('success', "Le produit a été $txt avec succès!");

            $manager->persist($produit );
            $manager->flush();

            //Une fois l'insertion/modification exécutée en BDD, on redirige l'internaute vers le détail de l'article, on transmet l'id à fournir dans l'url en 2ème paramètre de la méthode redirectToRoute()
            return $this->redirectToRoute('products');
        }

        return $this->render('backoffice/productform.html.twig', [
            'productForm'=> $formProduit->createView(),
            'editMode' => $produit->getId(),
            'photoActuelle' => $produit->getPhoto()
            
        ]); 
    }

    #[Route('backoffice/categories', name: 'backoffice_categories')]
    public function adminCategories(CategorieRepository $repoCategory, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $category = $repoCategory->findAll();

        return $this->render('backoffice/categories.html.twig', [
            'colonnes'=>$colonnes,
            'category'=>$category
        ]);
        
    }

    #[Route('/backoffice/category/add', name: 'add_category')]
    #[Route('/backoffice/category/{id}/edit', name: 'edit_category')]
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

    #[Route('backoffice/subcategories', name: 'backoffice_subcategories')]
    public function adminSubcategories(SouscategorieRepository $repoSubcategorie, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $subcategory = $repoSubcategorie->findAll();

        return $this->render('backoffice/subcategories.html.twig', [
            'colonnes'=>$colonnes,
            'subcategory'=>$subcategory
        ]);
        
    }

    #[Route('/backoffice/subcategory/add', name: 'add_sub_category')]
    #[Route('/backoffice/subcategory/{id}/edit', name: 'edit_sub_category')]
    public function addSubCategory(Request $request, EntityManagerInterface $manager, Souscategorie $souscategorie=null):Response
    {
        if(!$souscategorie)
        {
            $souscategorie = new Souscategorie;
        }

        $subcategorieForm = $this->createForm(SousCategorieType::class, $souscategorie);

        $subcategorieForm->handleRequest($request);

        if($subcategorieForm->isSubmitted() && $subcategorieForm->isValid())
        {
            $manager->persist($souscategorie);//test
            $manager->flush();
            return $this->redirectToRoute('backoffice_subcategories');
        }

        return $this->render('backoffice/sub_categoryform.html.twig', [
            'controller_name' => 'BackofficeController',
            'subcategorieForm' => $subcategorieForm->createView(),
            
        ]);  
    }

    
}