<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;

class SuivisColisController extends AbstractController
{
    #[Route('/colisInexsistant', name: 'colisInexsistant')]
    public function index(): Response
    {

        return $this->render('suivis_colis/colisInexistant.html.twig', [
        ]);
    }
    #[Route('/suivisColis/{id}', name: 'app_suivis_colis')]
    public function affichage(Commande $commande): Response
    {
        return $this -> render('suivis_colis/index.html.twig',['lacommande' => $commande]);

    }
}
