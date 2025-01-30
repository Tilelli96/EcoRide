<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Covoiturage;
use App\Form\CovoiturageType;
use App\Entity\User;

//#[Route('/covoiturage')]
class CovoiturageController extends AbstractController
{
    #[Route('covoiturage/create', name: 'create_covoiturage')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $covoiturage = new Covoiturage();
        $form = $this->createForm(CovoiturageType::class, $covoiturage);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid()){
            $covoiturage->setUserId($user);
            $covoiturage->setStatut('à venir');
            $em->persist($covoiturage);
            $em->flush($covoiturage);
            $this->redirectToRoute('page_accueil');
        }
        return $this->render('covoiturage/index.html.twig', [
            'form' => $form,
        ]);
    }
}
