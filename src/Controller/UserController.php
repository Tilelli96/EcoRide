<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\HttpFoundation\Request;


class UserController extends AbstractController
{
    #[Route('/inscription', name: 'user.inscription')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $user->setRoles(['utilisateur']);
                /** @var string $Password */
                $Password = $form->get('password')->getData();
                // encode the plain password
                $user->setPassword($userPasswordHasher->hashPassword($user, $Password));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_register');
        }
        return $this->render('user/index.html.twig', [
            'form' => $form,
        ]);
    }
}
