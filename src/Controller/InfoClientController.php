<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class InfoClientController extends AbstractController
{
    #[Route('/info_client', name: 'app_info_client')]
    public function index(UserRepository $userRepository): Response
    {
        $lesclient =  $userRepository->findall();

        return $this->render('info_client/index.html.twig', [
            'lesclient' => $lesclient,
        ]);
    }
}
