<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Retours;
use App\Form\RetoursType;

use App\Entity\Evaluation;
use App\Entity\Commande;
use App\Form\ModifUserType;
use Symfony\Component\VarDumper\VarDumper;


use Doctrine\ORM\EntityManagerInterface;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class ProfilClientController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profil_client/{id}', name: 'app_profil_client')]
    public function user(User $monUser, Commande $maCommande): Response
    {
        return $this->render('profil_client/profilClient.html.twig', [
            'user' => $monUser,
            'mesCommandes' => $monUser->historicCommande(),
 
        ]);
    }

    #[Route('/profil_client/modification_profil/{id}', name: 'app_profil_client_modif')]
    public function user_modif(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModifUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_profil_client', ['id' => $user->getId()]);
        }

        return $this->render('profil_client/modification_profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/retours/{id}', name: 'app_retours')]
    public function index(Commande $maCommande, Request $request, EntityManagerInterface $entityManager): Response
    {
        $retour = new Retours();
        
        $form = $this->createForm(RetoursType::class, $retour);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->get('Commentaire')->getData();
            
            $entityManager->remove($maCommande);
            
            $retour->setIdCommande($maCommande->getId());
            $retour->setCommentaire($commentaire);
            $retour->setIdCli($maCommande->getUser()->getId());

            
            $entityManager->persist($retour);
            $entityManager->flush();
            
return $this->redirectToRoute('app_profil_client', ['id' => $maCommande->getUser()->getId()]);
        }

        return $this->render('profil_client/retours.html.twig', [
            'controller_name' => 'RetoursController',
            'commande' => $maCommande,
            'form' => $form->createView(),
        ]);
    }
}
?>
