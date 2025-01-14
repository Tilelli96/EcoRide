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
    #[Route('/{id}_create_voiture', name: 'create_voiture')]
    public function create(Request $request, EntityManagerInterface $em, int $id): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if(!$user){
            $this->addFlash('error', 'veuillez vous connecter');
            $this->redirectToRoute('app_register');
        }
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $voiture->setUserId($user);
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
