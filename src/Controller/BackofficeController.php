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
    #[Route('/backoffice', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }

    // ################################ AFFICHAGE DE TOUS LES PRODUITS ######################################

    #[Route('backoffice/products', name: 'app_admin_products')]
    public function adminProducts(ProduitRepository $repoProduit, EntityManagerInterface $manager)
    {
        //on récupère ici les noms de tous les champs de la table Produit grâce à la fonction getFieldNames(), elle même issue de la fonction getClassMetadata()
        $colonnes = $manager->getClassMetadata(Produit::class)->getFieldNames();

        //$produits stockera toutes les informations  de tous les produits enregistrés en bdd
        $produits = $repoProduit->findAll();

        return $this->render('backoffice/admin_products.html.twig', [
            'colonnes'=>$colonnes,
            'produits'=>$produits
        ]);
        
    }

    //################################### CREATION ET MODIFICATION DE PRODUITS ##############################

    #[Route('/backoffice/product/add', name: 'app_admin_product_add')]
    #[Route('/backoffice/product/{id}/edit', name: 'app_admin_product_edit')]
    public function addProduct(EntityManagerInterface $manager, Request $request, Produit $produit=null,SluggerInterface $slugger): Response
    {
        //si la condition IF retourne TRUE, cela veut dire que $article contient un article stocké en BDD, on stock la photo actuelle de l'article dans la variable $photoActuelle
        if($produit)
        {
            $photoActuelle = $produit->getPhoto();
        }

        //Si $produit est null cela signifie que nous ajoutons un nouveau produit, on crée donc un objet issu de la classe Produit.
        if(!$produit)
        {
            $produit = new Produit;
        }

        //On crée ici un formulaire avec la méthode createForm() qui attend comme arguments une classe et l'objet $produit;
        $formProduit = $this->createForm(ProductType::class, $produit );

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

            //Si aucune image n'a été uploadée, on renvoie dans la bdd la photo actuelle de l'article
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

            // FIN TRAITEMENT PHOTO////////////////////////////////////////////////////////

            //Message de validation en session
            if(!$produit ->getId())
                $txt = "enregistré";
            else
                $txt = "modifié";

            //Méthode permettant d'enregistrer des messages utilisateurs accessibles en session
            $this->addFlash('success', "Le produit a été $txt avec succès!");

            $manager->persist($produit );
            $manager->flush();

            //Une fois l'insertion/modification exécutée en BDD, on redirige l'internaute vers la liste des produits.
            return $this->redirectToRoute('app_admin_products');
        }

        return $this->render('backoffice/admin_product_form.html.twig', [
            'productForm'=> $formProduit->createView(),
            'editMode' => $produit->getId(),
            'photoActuelle' => $produit->getPhoto()
            
        ]); 
    }

    //############################## AFFICHAGE DES CATEGORIES ###########################################

    #[Route('backoffice/categories', name: 'app_admin_categories')]
    public function adminCategories(CategorieRepository $repoCategory, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Categorie::class)->getFieldNames();

        $category = $repoCategory->findAll();

        return $this->render('backoffice/admin_categories.html.twig', [
            'colonnes'=>$colonnes,
            'category'=>$category
        ]);
        
    }

    //#################################### CREATION ET MODIFICATION DE CATEGORIES #############################

    #[Route('/backoffice/category/add', name: 'app_admin_category_add')]
    #[Route('/backoffice/category/{id}/edit', name: 'app_admin_category_edit')]
    public function add(Request $request, EntityManagerInterface $manager, Categorie $category=null): Response
    {
        if(!$category)
        {
            $category = new Categorie;
        }
        
        $formCategory = $this->createForm(CategorieType::class, $category);

        $formCategory->handleRequest($request);

        if($formCategory->isSubmitted() && $formCategory->isValid())
        {
            if(!$category ->getId())
                $txt = "enregistrée";
            else
                $txt = "modifiée";

            $this->addFlash('success', "La catégorie a été $txt avec succès!");

            $manager->persist($category);//test
            $manager->flush();
            return $this->redirectToRoute('app_admin_categories');
        }
        

        return $this->render('backoffice/admin_category_form.html.twig', [
            'controller_name' => 'BackofficeController',
            'formCategory' => $formCategory->createView(),
        ]);
    }

    //################################ AFFICHAGE DES SOUS-CATEGORIES #######################################

    #[Route('backoffice/subcategories', name: 'app_admin__subcategories')]
    public function adminSubcategories(SouscategorieRepository $repoSubcategorie, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Souscategorie::class)->getFieldNames();

        $subcategory = $repoSubcategorie->findAll();

        return $this->render('backoffice/admin_subcategories.html.twig', [
            'colonnes'=>$colonnes,
            'subcategory'=>$subcategory
        ]);
        
    }

    //################################## AJOUT ET MODIFICATION DE SOUS-CATEGORIES ###########################

    #[Route('/backoffice/subcategory/add', name: 'app_admin__subcategories_add')]
    #[Route('/backoffice/subcategory/{id}/edit', name: 'app_admin__subcategories_edit')]
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

            if(!$souscategorie ->getId())
                $txt = "enregistrée";
            else
                $txt = "modifiée";

            $this->addFlash('success', "La sous-catégorie a été $txt avec succès!");

            $manager->persist($souscategorie);//test
            $manager->flush();
            return $this->redirectToRoute('app_admin__subcategories');
        }

        return $this->render('backoffice/admin_subcategory_form.html.twig', [
            'controller_name' => 'BackofficeController',
            'subcategorieForm' => $subcategorieForm->createView(),
            
        ]);  
    }

    
}