<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ARepository;
use App\Entity\A;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/employer')]
class EmployerController extends AbstractController
{
    #[Route('/', name: 'app_employer')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('employer.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/avis', name: 'employer_avis')]
    public function avis(ARepository $avi): Response
    {
        $avis = $avi->FindByStatut();
        return $this->render('employer/avis.html.twig', [
            'avis' => $avis,
        ]);
    }

    #[Route('/{id}/valider')]
    public function validate(A $avis, EntityManagerInterface $em): Response
    {
        $avis->setStatut('validé');
        $em->flush();
        $this->addFlash('success', 'L\'avis a bien été validé');
        return $this->redirectToRoute('employer_avis');
    }

    #[Route('/{id}/supprimer')]
    public function remove(A $avis, EntityManagerInterface $em): Response
    {
        $em->remove($avis);
        $em->flush();
        $this->addFlash('success', 'L\'avis a bien été supprimé');
        return $this->redirectToRoute('employer_avis');
    }
}
