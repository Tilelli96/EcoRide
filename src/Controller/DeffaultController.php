<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeffaultController extends AbstractController
{
    #[Route('/index', name: 'page_accueil')]
    public function index(): Response
    {
        return $this->render('deffault/index.html.twig', [
            'controller_name' => 'michou',
        ]);
    }
}
