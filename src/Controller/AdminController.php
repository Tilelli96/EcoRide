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
use App\Repository\UserRepository;
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

    #[Route('/utilisateurs', name: 'admin_utilisateurs')]
    public function search(Request $request, UserRepository $userRepository): Response
    {
        $keyword = $request->query->get('q', ''); // Récupère la valeur saisie
        $user = $userRepository->findBySearch($keyword);

        return $this->render('admin/utilisateur.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/suspendre')]
    public function suspend(User $user, EntityManagerInterface $em) : Response
    {
        foreach ($user->getCovoiturages() as $covoiturage) {
            $covoiturage->removeVoyageur($user);
            $em->persist($covoiturage);
        }
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'l\'utilisateur a bien été supprimé' );
        return $this->redirectToRoute('app_admin');
    }

}
