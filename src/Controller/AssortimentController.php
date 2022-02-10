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

        $assortiment = $repoAssortiment->findAll();

        return $this->render('assortiment/assortiment_list.html.twig', [
            'colonnes'=>$colonnes,
            'assortiment'=>$assortiment
        ]);
        
    }

}
