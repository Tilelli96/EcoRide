<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\searchController;

class DeffaultController extends AbstractController
{
    #[Route('/home', name: 'page_accueil')]
    public function index(): Response
    {
        return $this->render('deffault/index.html.twig');
    } 
}
