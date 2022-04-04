<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailsProduitController extends AbstractController
{
    #[Route('/produit/{id}', name: 'details_produit')]
    public function index(Produit $produit, ProduitRepository $produitRepo): Response
    {
        $id = $produit->getId();
        $nom = $produit->getNom();

        $dataProduit = $produitRepo->find($id);//Nous récupérons toutes les informations du produit ayant un id identique à celui présent dans l'url

        $alldata = $produitRepo->findModel($nom); //Nous récupérons ici toutes les informations concernant les variantes d'un même produit. On s'en servira pour donner à l'internaute la possibilité de sélectionner une couleur de son choix

        return $this->render('details_produit/details_produit.html.twig', [
            'dataProduit' => $dataProduit,
            'alldata' => $alldata
        ]);
    }
}
