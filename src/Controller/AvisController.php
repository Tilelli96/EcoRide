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
use App\Repository\ARepository;

#[Route('/avis')]
final class AvisController extends AbstractController
{
    #[Route('/{id}/index', name: 'avis_index')]
    public function index(EntityManagerInterface $em, ARepository $avisRepository, User $user): Response
    {
        $avis = $avisRepository->findByUser($user);
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
        if($form->isSubmitted() && $form->isValid()){
            $avis->setStatut('à confirmer');
            $avis->setcreatedBy($this->getUser());
            $avis->setUserId($user);
            $em->persist($avis);
            $em->flush($avis);
            $this->redirectToRoute('app_search');
        }
        
        return $this->render('avis/create.html.twig', [
            'form' => $form,
        ]);
    }
}
