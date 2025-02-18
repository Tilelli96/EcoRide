<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CovoiturageRepository;
use App\Entity\Covoiturage;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(CovoiturageRepository $co): Response
    {
        $covoiturage = $co->countCovoituragesPerDay();
        $gainsParJour = $co->getGainsParJour();
        return $this->render('admin/graphique.html.twig', [
            'covoiturages' => $covoiturage,
            'gains' => $gainsParJour
        ]);
    }

    #[Route('/créer')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('password')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_EMPLOYE']);
            $user->setNote(0);
            $user->setCredit(0);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'votre compte est créé');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/create.html.twig', [
            'form' => $form,
        ]);
    }
}
