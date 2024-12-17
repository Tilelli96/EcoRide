<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Covoiturage;
use App\Entity\User;
use App\Entity\A;
use App\Form\AvisType;

class AvisController extends AbstractController
{
    #[Route('/avis.create', name: 'app_avis')]
    public function create(Request $Request, EntityManagerInterface $em ): Response
    {
        $avis = new A();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($Request);
        $user = $this->getCovoiturage()->getUserId();
        if($form->isSubmitted() && $form->isValid()){
            $avis->setStatut('à confirmer');
            $avis->setUserId($user);
            $em->persist();
            $en->flush($avis);
            $this->redirectToRoute('page_accueil');
        }
        
        return $this->render('avis/index.html.twig', [
            'form' => $form,
        ]);
    }
}
