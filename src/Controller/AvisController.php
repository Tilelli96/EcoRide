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

#[Route('/avis')]
final class AvisController extends AbstractController
{
    #[Route('/{id}/index', name: 'avis_index')]
    public function index(EntityManagerInterface $em, User $user): Response
    {
        $repository = $em->getRepository(A::class);
        $avis = $repository->findBy(
            ['user_id' => 'user.getId()']
        );
        return $this->render('avis/index.html.twig', [
            'avis' => $avis,
        ]);
    }

    #[Route('/{id}/create', name: 'app_avis')]
    public function create(Request $Request, EntityManagerInterface $em, User $user ): Response
    {
        $avis = new A();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($Request);
        if($form->isSubmited() && $form->isValid()){
            $avis->setStatut('à confirmer');
            $avis->setUserId($user);
            $em->persist($avis);
            $em->flush($avis);
            $this->redirectToRoute('page_accueil');
        }
        
        return $this->render('avis/create.html.twig', [
            'form' => $form,
        ]);
    }
}
