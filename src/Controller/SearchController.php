<?php

namespace App\Controller;


use App\Entity\Search;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CovoiturageRepository;
use App\Entity\Covoiturage;

class SearchController extends AbstractController
{
    
    #[Route('/home/search', name: 'app_search')]
    public function search(Request $request,CovoiturageRepository $covoiturageRepository, EntityManagerInterface $em): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($search);
            $em->flush($search);
            $covoiturages = $covoiturageRepository->findBySearch($search);
            return $this->render('search/result.html.twig', [
                'covoiturages' => $covoiturages,
                'form' => $form
            ]);
        }
        return $this->render('search/index.html.twig', [
            'form' => $form
        ]);
    }
}
