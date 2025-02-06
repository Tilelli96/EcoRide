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
use App\Repository\VoitureRepository;

//#[Route('/covoiturage')]
class CovoiturageController extends AbstractController
{
    #[Route('covoiturage/create', name: 'create_covoiturage')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $covoiturage = new Covoiturage();
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('error', 'veuillez vous connecter');
            $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(CovoiturageType::class, $covoiturage, ['user' => $user]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $covoiturage->setUserId($user);
            $covoiturage->setStatut('à venir');
            $em->persist($covoiturage);
            $em->flush($covoiturage);
            $this->redirectToRoute('app_search');
        }
        return $this->render('covoiturage/index.html.twig', [
            'form' => $form,
        ]);
    }
}
