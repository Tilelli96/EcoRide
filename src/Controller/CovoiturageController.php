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
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

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
                $this->getUser()->setCredit($this->getUser()->getCredit() - $covoiturage->getPrixPersonne());
                $covoiturage->getUserId()->setCredit($covoiturage->getUserId()->getCredit() + ($covoiturage->getPrixPersonne() - 2));
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
                $user->setCredit($user->getCredit() + $covoiturage->getPrixPersonne());
                $covoiturage->getUserId()->setCredit($covoiturage->getUserId()->getCredit() - $covoiturage->getPrixPersonne());
            }
            $em->remove($covoiturage);
            $em->flush();
            $this->addFlash('success', 'votre covoiturage a bien été supprimé');
            return $this->redirectToRoute('app_search');
        }else{
            $covoiturage->removeVoyageur($this->getUser());
            $this->getUser()->setCredit($this->getUser()->getCredit() + ($covoiturage->getPrixPersonne() - 1));
            $covoiturage->getUserId()->setCredit($covoiturage->getUserId()->getCredit() - $covoiturage->getPrixPersonne());
            $em->flush();
            $this->addFlash('success', 'votre participation a bien été annulée');
            return $this->redirectToRoute('app_search');
        };
    }

    #[Route('/{id}/enCours',)]
    public function progress(Covoiturage $covoiturage){
        $covoiturage->setStatut('en cours');
        $this->addFlash('success', 'votre covoiturage est en cours');
        return $this->redirectToRoute('app_search');
    }

    #[Route('/{id}/passe')]
    public function passed(Covoiturage $covoiturage){
        $covoiturage->setStatut('passé');
        foreach($covoiturage->getVoyageurs() as $user){
            $email = (new Email())
                        ->from('haidou.tounsia@gmail.com')
                        ->to($user->getEmail())
                        ->subject('Voyage annulé')
                        ->text('Merci de bien vouloir vous rendre à votre espace EcoRide afin de valider votre covoiturage');
            $mailer->send($email);
        }
    }
}
