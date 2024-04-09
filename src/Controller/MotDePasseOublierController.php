<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MotDePasseOublierController extends AbstractController
{
    #[Route('/mdpOublie', name: 'app_mot_de_passe_oublier')]
    public function index(): Response
    {

        return $this->render('mot_de_passe_oublier/index.html.twig', [
            'controller_name' => 'MotDePasseOublierController',
        ]);
    }
}
