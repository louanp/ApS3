<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use App\Repository\CentreRelaisRepository;
use App\Entity\CentreRelais;
use App\Repository\CasierRepository;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(CommandeRepository $commandeRepository, Request $request): Response
    {   
        
        if ($request->isMethod('POST')) {
            $numCommande = $request->request->get('numcommande');
            if ($numCommande == null) 
            {
                return $this->redirectToRoute('colisInexsistant');
            }
            else
            {
                 $commande = $this->rechercheColisId($commandeRepository, $numCommande);
            //dd($commande);

                if ($commande != null) {
                    return $this->redirectToRoute('app_suivis_colis', ['id' => $commande->getId()]);
                }
                else
                {
                    return $this->redirectToRoute('colisInexsistant');
                }
            }

        }

        //$role = $this->getUser()->getRoles();
        //sdd($role);
        return $this->render('acceuil/accueil.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    
    ///creation_commande/createCommande.html.twig
    public function rechercheColisId(CommandeRepository $commandeRepository, int $id): ?Commande
    {
        return $commandeRepository->find($id);
    }
    

    #[Route('/accueilAdmin', name: 'accueilAdmin')]
    public function AccueilAdmin(CentreRelaisRepository $relaisRepository, Request $request,UserRepository $userRepository,CasierRepository $casierRepository,CommandeRepository $commandeRepository): Response
    {
        $lesrelais = $relaisRepository->findall();
        $lesclient =  $userRepository->findall();
        return $this->render('acceuil/accueilAdmin.html.twig', [
            'lesCentreRelais' => $lesrelais,
            'lesclient' => $lesclient,
            
        
        ]);
        // faire une autre case avec les centre en tension( nombre de casier plein, le temps que m'est un client a retirer son colis, )
        // modifier commande pour lui attribuer un casier pour "réserver" pour s'assurer que l'orsque l'on commande on recoive bien le colis dans le centre demandé 
    }
    

    
   
}
