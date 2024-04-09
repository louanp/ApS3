<?php

namespace App\Controller;

use App\Entity\CentreRelais;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CentreRelaisRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CentreRelaisType;

class ModifCentreRelaisController extends AbstractController
{
    #[Route('/modifCentreRelais', name: 'app_modif_centre_relais')]
    public function index(CentreRelaisRepository $relaisRepository, EntityManagerInterface $entityManager,Request $request): Response
    {
        $state ='ajouter';

        $lesrelais = $relaisRepository->findall();
       
        if ($request->isMethod('POST')) 
        {
            $state = $request->request->get('Modifier');
            if (isset($state))
            {
                $state = $request->request->get('Modifier');
            }
            else
            {
                $state = $request->request->get('state');
            }
            if ($state ==null)
            {
                $state='ajouter';
            }
            $suprimmer = $request->request->get('Supprimer');
            if (isset($suprimmer) === true)
            {
                $suprimerRelais = $request->request->get('idRelais'); 
                $lerelais = $relaisRepository->find($suprimerRelais);
                $entityManager->remove($lerelais);
                $entityManager->flush(); 
            }
            
        }
        if ($state ==='ajouter')
        {    
            $CentreRelais = new CentreRelais();
            $form = $this->createForm(CentreRelaisType::class, $CentreRelais);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $entityManager->persist($CentreRelais);
                $entityManager->flush();
                return $this->redirectToRoute('app_modif_centre_relais', ['state'=>$state]);
            } 
            return $this->render('modifCentreRelais/modifRelais.html.twig', [
                'lesCentreRelais' => $lesrelais,
                'CentreRelaisType' => $form->createView(),
                'state' => $state, 
            ]);        
        }
        else
        {
            $idRelais = $request->request->get('idRelais');
            $state ='modifier';
            $CentreRelais = $relaisRepository->find($idRelais);
            $form = $this->createForm(CentreRelaisType::class, $CentreRelais);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $entityManager->flush();
                return $this->redirectToRoute('app_modif_centre_relais',[ 'state'=>$state]);
            }
            return $this->render('modifCentreRelais/modifRelais.html.twig',[ 
                    'lesCentreRelais' => $lesrelais,
                    'CentreRelaisType' => $form->createView(),
                    'state' => $state,
                    'idrelais' => $idRelais,
                ]);
        }
     }
    public function rechercheRelais(CentreRelaisRepository $centreRelaisRepository, int $id): ?CentreRelais
    {
        return $centreRelaisRepository->find($id);
    }
}
