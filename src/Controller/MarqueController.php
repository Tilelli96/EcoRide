<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\User;
use App\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class MarqueController extends AbstractController
{
    #[Route('/marque/create', name: 'create_marque')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('error', 'veuillez vous connecter');
            $this->redirectToRoute('app_login');
        }
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($marque);
            $em->flush();
            $this->addFlash('success', 'Enregistré');
            return $this->redirectToRoute('create_voiture');
        }
        return $this->render('marque/create.html.twig', [
            'form' => $form
        ]);
    }
}
