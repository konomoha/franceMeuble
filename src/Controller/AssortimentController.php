<?php

namespace App\Controller;

use App\Entity\Assortiment;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AssortimentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AssortimentController extends AbstractController
{
    #[Route('/assortiments', name: 'boutique_assortiments')]
    public function allAssortiments(AssortimentRepository $repoAssortiment, EntityManagerInterface $manager)
    {
        $colonnes = $manager->getClassMetadata(Assortiment::class)->getFieldNames();

        $assortiment = $repoAssortiment->findAll(); //On récupère ici toutes les informations liées aux collections, cette fonction nous permettra d'intégrer ces informations dans n'importe quel layout.

        return $this->render('assortiment/assortiment_list.html.twig', [
            'colonnes'=>$colonnes,
            'assortiment'=>$assortiment
        ]);
        
    }

    // #[Route('/assortiment/{id}', name: 'boutique_assortiment_show')]
    // public function assortimentShow(Assortiment $assortiment, AssortimentRepository $repoAssortiment): Response
    // {

    //     $id = $assortiment->getId();
    //     $datassortiment = $repoAssortiment->find($id);

    //     return $this->render('assortiment/assortiment_show.html.twig', [
    //         'datassortiment' => $datassortiment
    //     ]);

    // }

}
