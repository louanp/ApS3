<?php

namespace App\Controller;

use Doctrine\Common\Collections\Collection;
use App\Entity\CentreRelais;
use App\Repository\CentreRelaisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RapportController extends AbstractController
{
   

    #[Route('/rapport', name: 'app_rapport')]
    public function centreUtilise(CentreRelaisRepository $centreRelaisRepository): Response
    {
        $lesCentres = $this->CentreLesPlusUtilise2($centreRelaisRepository);
        //dd($lesCentres);
        return $this->render('rapport/rapport.html.twig', [
            'lesCentres' => $lesCentres,
        ]);
    }

    function RechercheBiggest(int $a, int $b): bool
    {
        if($a > $b)
            return true;
        elseif($b > $a)
            return false;
        else
            return false;
    }

    function Echange(array $tab, int $index1, int $index2): array
    {
        $a = $tab[$index1];
        $tab[$index1] = $tab[$index2];
        $tab[$index2] = $a;
        return $tab;
    }

    function CentreLesPlusUtilise(CentreRelaisRepository $centreRelaisRepository): Array
    {
        $centreRelais = array();
        $lesComptes = array();
        $lesCentre = $centreRelaisRepository->findAll();
        $depart = 0;
        foreach($lesCentre as $centre){
            $lesCommandes = $centre->getCommandes();
            array_push($lesComptes, $lesCommandes->count());
        }

        foreach($lesComptes as $compteur)
        {
            foreach($lesComptes as $compteur2)
            {
                if($this->RechercheBiggest($compteur, $compteur2))
                {
                    array_push($lesComptes, $compteur);
                }
            }
        }
            
        return $centreRelais;
    }
    function cmp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    public function CentreLesPlusUtilise2(CentreRelaisRepository $centreRelaisRepository): Array
    {
        $lesCentres = $centreRelaisRepository->findAll();
        $comptesCentres = array();
        foreach($lesCentres as $centre){
            $lesCommandes = $centre->getCommandes();
            array_push($comptesCentres, $lesCommandes->count());
        }
        usort($lesCentres, function($a, $b){
            return $a->getCommandes()->count() <=> $b->getCommandes()->count();
        });
        usort($comptesCentres, function($a, $b){
            return $a <=> $b;
        });


        //retourner dico avec Clé : nom centre(adresse) / Value : nb commande --> faire fonction qui retourne dico avec 2 tab en paramètres
        return $lesCentres;
    }
    public function rechercheCentreByNbCommande(CentreRelaisRepository $centreRelaisRepository, int $truc): ?CentreRelais
    {
        $lesCentres = $centreRelaisRepository->findAll();
        foreach($lesCentres as $centre){
            if($centre->getCommandes()->count() == $truc)
                return $centre;
        }
    }
}