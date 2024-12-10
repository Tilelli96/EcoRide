<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\User;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class VoitureController extends AbstractController
{
    #[Route('/create_voiture', name: 'create_voiture')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($voiture);
            $em->flush();
            $this->addFlash('success', 'Enregistré');
            return $this->redirectToRoute('page_accueil');
        }
        return $this->render('voiture/create.html.twig', [
            'form' => $form
        ]);
    }
}
