<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssortimentController extends AbstractController
{
    #[Route('/assortiment', name: 'assortiment')]
    public function index(): Response
    {
        return $this->render('assortiment/index.html.twig', [
            'controller_name' => 'AssortimentController',
        ]);
    }

}
