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

        $dataProduit = $produitRepo->find($id);
        $alldata = $produitRepo->findModel($nom);



        return $this->render('details_produit/details_produit.html.twig', [
            'dataProduit' => $dataProduit,
            'alldata' => $alldata
        ]);
    }
}
