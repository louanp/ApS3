<?php

namespace App\Controller;

use App\Entity\Casier;
use App\Entity\CentreRelais;
use App\Form\CasierType;
use App\Repository\CasierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CentreRelaisRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CreationCasierController extends AbstractController
{
    #[Route('/Gestioncasier', name: 'gestioncasier')]
    public function index(CentreRelaisRepository $relaisRepository,): Response
    {
        $lesrelais = $relaisRepository->findall();
        return $this->render('creation_casier/CreationCasier.html.twig', [
            'lesCentreRelais' => $lesrelais,
        ]);
    }
    #[Route('/AjoutCasier/{id}', name: 'AjoutCasier')]
    public function AjoutCasier(CentreRelais $lecentre,Request $request,EntityManagerInterface $entityManager,CasierRepository $casierRepository): Response
    {
        //$testnbcasier =false;
        $casier = new Casier();   
        $form = $this->createForm(CasierType::class, $casier);  
        $form->handleRequest($request);
        // $nbcasier = $lecentre->getCapacite();
        // $nbcasierExistant = $casierRepository->count->findBy([
        //     'CentreRelais ' => $lecentre->getId(),
        // ]);
        // if($nbcasier<$nbcasierExistant)
        // {
        //     $testnbcasier =true;
        // }
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $casier -> setLeCentreRelais($lecentre);
            $casier -> setDisponibilite(true);
            $lecentre->addLesCasier($casier);
            //dd($form);
            //dd($casier);
            $entityManager->persist($casier);
            $entityManager->flush();
            return $this->redirectToRoute('gestioncasier');
        }
        return $this->render('creation_casier/AjoutCasier.html.twig', [
            'AjoutCasierForm' => $form->createView(),
            // 'nbcasier' => $nbcasier,
            // 'testnbcasier'=> $testnbcasier,
            
        ]);
    }
    #[Route('/SupprimerCasier/{id}', name: 'SuprimerCasier')]
    public function SuprimmerCasier(CentreRelais $lecentre,Request $request,EntityManagerInterface $entityManager,CasierRepository $casierRepository): Response
    {
        $casierExistant = $casierRepository->findBy([
                'leCentreRelais' => $lecentre->getId(),
        ]);
        if ($request->isMethod('POST')) 
        {
            $suprimerCasier = $request->request->get('Supprimer'); 
            $lecasier = $casierRepository->find($suprimerCasier);
            $entityManager->remove($lecasier);
            $entityManager->flush(); 
        }

        return $this->render('creation_casier/SuprimerCasier.html.twig', [
            'casierExistant'=>$casierExistant,
        ]);
    }
    #[Route('/ModifierCasier/{id}', name: 'ModifierCasier')]
    public function ModifierCasier(CentreRelais $lecentre,CasierRepository $casierRepository): Response
    {
        
        $casierExistant = $casierRepository->findBy([
            'leCentreRelais' => $lecentre->getId(),
        ]);
          
        return $this->render('creation_casier/ModifierCasier.html.twig', [
            'casierExistant'=>$casierExistant,
        ]);

    }
    #[Route('/PageModifierCasier/{id}', name: 'PageModifierCasier')]
    public function PageModifierCasier(Casier $lecasier,Request $request,EntityManagerInterface $entityManager,CasierRepository $casierRepository): Response
    {
        
        $casier = $casierRepository->find($lecasier);
        $form = $this->createForm(CasierType::class, $casier);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) 
            {
                //dd($form);
                //dd($casier);
                $entityManager->flush();
                return $this->redirectToRoute('gestioncasier');
            }
        return $this->render('creation_casier/PageModifCasier.html.twig', [
            'AjoutCasierForm' => $form->createView(),
        ]);

    }
}
