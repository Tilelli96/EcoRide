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
use App\Repository\CovoiturageRepository;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\LitigeRepository;
use App\Entity\Litige;

#[Route('/covoiturage')]
class CovoiturageController extends AbstractController
{
    #[Route('/create', name: 'create_covoiturage')]
    public function create(Request $request, EntityManagerInterface $em, VoitureRepository $vr): Response
    {
        $covoiturage = new Covoiturage();
        $user = $this->getUser();
        $voitures = $vr->findVoitureByUser($user);
        $form = $this->createForm(CovoiturageType::class, $covoiturage, array('voitures' => $voitures));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $covoiturage->setUserId($user);
            $covoiturage->setStatut('à venir');
            $covoiturage->setVoyageurs($user);
            $em->persist($covoiturage);
            $em->flush($covoiturage);
            $this->addFlash('success', 'Enregistré');
            return $this->redirectToRoute("app_search");
        }
        return $this->render('covoiturage/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/historique', name: 'historique_covoiturage')]
    public function show(CovoiturageRepository $covoiturage){
        $user = $this->getUser();
        $covoiturages = $covoiturage->findByHistoricalUser($user);
        $passagerCovoiturages = $covoiturage->findByPassager($user);
        return $this->render('covoiturage/historique.html.twig', [
            'covoiturages' => $covoiturages,
            'passagerCovoiturages' => $passagerCovoiturages
        ]);
    }

    #[Route('/{id}/participer', name: 'covoiturage_participer')]
    public function participate(Covoiturage $covoiturage, EntityManagerInterface $em){
        if(($covoiturage->getNbPlace() - count($covoiturage->getVoyageurs())) >= 0){
            if($this->getUser()->getCredit() >= $covoiturage->getPrixPersonne()){
                $covoiturage->setVoyageurs($this->getUser());
                $em->persist($covoiturage);
                $em->flush();
                $em->persist($this->getUser());
                $em->flush();
                $this->addFlash('success', 'Votre participation a bien été enregistrée');
                return $this->redirectToRoute('app_search');
            }else{
                $this->addFlash('success', 'Credit insuffisant');
                return $this->redirectToRoute('app_search');  
            }
        }else{
            $this->addFlash('success', 'pas de places disponible');
            return $this->redirectToRoute('app_search');
        
        }
        $this->addFlash('success', 'Désolé votre participation n\'a pas pu etre enregistrée');
        return $this->redirectToRoute('app_search');
    }

    #[Route('/{id}/supprimer', name: 'covoiturage_supprimer')]
    public function remove(Covoiturage $covoiturage, EntitymanagerInterface $em, MailerInterface $mailer){
        if($covoiturage->getUserId() === $this->getUser()){
            foreach($covoiturage->getVoyageurs() as $user){
                $email = (new Email())
                            ->from('haidou.tounsia@gmail.com')
                            ->to($user->getEmail())
                            ->subject('Voyage annulé')
                            ->text('votre covoiturage a été annulé');
                $mailer->send($email);
            }
            $em->remove($covoiturage);
            $em->flush();
            $this->addFlash('success', 'votre covoiturage a bien été supprimé');
            return $this->redirectToRoute('app_search');
        }else{
            $covoiturage->removeVoyageur($this->getUser());
            $em->flush();
            $this->addFlash('success', 'votre participation a bien été annulée');
            return $this->redirectToRoute('app_search');
        };
    }

    #[Route('/{id}/enCours',)]
    public function progress(Covoiturage $covoiturage, EntityManagerInterface $em){
        $covoiturage->setStatut('en cours');
        $em->flush();
        $this->addFlash('success', 'votre covoiturage est en cours');
        return $this->redirectToRoute('app_search');
    }

    #[Route('/{id}/passe')]
    public function passed(Covoiturage $covoiturage, EntityManagerInterface $em, MailerInterface $mailer){
        $covoiturage->setStatut('passé');
        $em->flush();
        foreach($covoiturage->getVoyageurs() as $user){
            $email = (new Email())
                        ->from('haidou.tounsia@gmail.com')
                        ->to($user->getEmail())
                        ->subject('Voyage annulé')
                        ->text('Merci de bien vouloir vous rendre à votre espace EcoRide afin de valider votre covoiturage');
            $mailer->send($email);
        }
        $this->addFlash('success', 'Vous etes arrivés à destination');
        return $this->redirectToRoute('app_search');
    }

    #[Route('/{id_C}/{id_U}/valider')]
    public function validate(int $id_C, int $id_U, CovoiturageRepository $co, UserRepository $us, EntitymanagerInterface $em): Response
    {
        $covoiturage = $co->findOneById($id_C);
        $user = $us->findOneById($id_U);
        $user->setCredit($user->getCredit() - $covoiturage->getPrixPersonne());
        $covoiturage->getUserId()->setCredit($covoiturage->getUserId()->getCredit() + ($covoiturage->getPrixPersonne() - 2));
        $em->flush();
        $this->addFlash('success', 'Votre validation a bien été enregistrée');
        return $this->redirectToRoute('app_search');
    }

    #[Route('/{id_C}/{id_U}/ajouter')]
    public function add(int $id_C, int $id_U, CovoiturageRepository $co, UserRepository $us, EntityManagerInterface $em): Response
    {
        $covoiturage = $co->findOneById($id_C);
        $user = $us->findOneById($id_U);
        $litige = new Litige();
        $litige->addCovoiturage($covoiturage);
        $litige->addUser($user);
        $em->persist($litige);
        $em->flush($litige);
        $this->addFlash('success', 'le litige a bien été enregistrer');
        return $this->redirectToRoute('app_search');
    } 
}
