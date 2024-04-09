<?php

namespace App\Controller;

use App\Entity\CentreRelais;
use App\Entity\Casier;
use App\Entity\Commande;
use App\Form\CreationCommandeType;
use App\Repository\CasierRepository;
use App\Repository\CentreRelaisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationCommandeController extends AbstractController
{
    

    #[Route('/createCommande', name: 'app_createCommande')]
    public function createCommande(Request $request, EntityManagerInterface $entityManager, CentreRelaisRepository $centreRelaisRepository, CasierRepository $casierRepository)
    {
        date_default_timezone_set("Europe/Paris");
        $dateEstimLivraison = new \DateTime('2001-09-11');
        $dateCommande = new \DateTime();
        $commande = new Commande();
        $commande->setEstimationLivraison($dateEstimLivraison);
        $commande->setLongitude(0);
        $commande->setLatitude(0);
        $commande->setEtat(1);
        $commande->setDestination('null');
        $commande->setDateCommande($dateCommande);

        // if ($request->isMethod('POST')) {

        //     $centreRelais = $request->request->get('centreRelais');//Les données sont null, voir pourquoi
        //     $longueur = $request->request->get('longueur');
        //     $largeur = $request->request->get('largeur');
        //     $hauteur = $request->request->get('hauteur');
        //     $casierID = $this->RechercheCasierID($centreRelais, $longueur, $largeur, $hauteur, $centreRelaisRepository, $casierRepository);
        //     $centreRelaisID = $this->rechercheCentreRelaisId($centreRelaisRepository, $centreRelais);
    
        //     $commande->setCasier($casierID);
        //     $commande->setCentreRelais($centreRelaisID);
        // }

        $form = $this->createForm(CreationCommandeType::class, $commande);
        // $form = $this->createForm(CreationCommandeType::class, $commande, [
        //     'CentreRelaisRepository' => $centreRelaisRepository,
        // ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //dd($data);
            $longueur = $data->getLongueur();
            $largeur = $data->getLargeur();
            $hauteur = $data->getHauteur();
            $centreRelais = $data->getCentreRelais();
            $centreRelaisAdresse = $data->getCentreRelais()->getAdresse();
            $casier = $this->RechercheCasier($centreRelaisAdresse, $longueur, $largeur, $hauteur, $centreRelaisRepository, $casierRepository);

            if($casier == null){
                echo '<script type="text/javascript">
                    var msg = "Le centre relais choisi ne contient pas de casier ayant la taille nécessaire pour votre colis.";
                    if(window.confirm(msg)) {
                        // On a répondu OK, on redirige par exemple l\'utilisateur ailleurs
                        window.location.href = "http://localhost:8000/createCommande";
                    } else {
                        // Ici c\'est qu\'on a répondu "Annulé" et je ne sais pas ce qu\'il faut faire dans ton cas ^^
                    }
                    </script>
                ';
            }

            $centreRelaisID = $this->rechercheCentreRelaisId($centreRelaisRepository, $centreRelaisAdresse);
            $user = $this->getUser();

            if($casier == null){
                $casierNull = new Casier();
                $commande->setCasier($casierNull);
            }

            $commande->setCasier($casier);
            $commande->setCentreRelais($centreRelais);
            $commande->setUser($user);

            $entityManager->persist($commande); //transforme l'objet en ligne SQL (fait le mapping)
            $entityManager->flush(); // Top départ de l'envoie

            return $this->redirectToRoute('accueil');
        }

        return $this->render('creation_commande/createCommande.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
    
    public function getCentresRelaisDispo(CentreRelaisRepository $centresReloRepository): array
    {
        $lesCentresDispo = array();
        $lesCentres = $centresReloRepository->findAll();
        foreach ($lesCentres as $centre)
        {
            $bouboule = false;
            $lesCasiers = $centre->getLesCasiers();
            foreach($lesCasiers as $casier)
            {
                if($casier->isDisponibilite())
                {
                    $bouboule = true;
                }
            }
            if($bouboule){array_push($lesCentresDispo, $centre);}
        }
        return $lesCentres;
    }

    public function rechercheCentreRelaisId(CentreRelaisRepository $centreRelaisRepository, string $adresse): ?int
    {
        $centre = $centreRelaisRepository->findOneBy(['adresse' => $adresse]);
        return $centre->getId();
    }

    public function RechercheCasier(string $centreRelais, int $longueur, int $largeur, int $hauteur, CentreRelaisRepository $centreRelaisRepository, CasierRepository $casierRepository): ?Casier
    {
        $centre = $this->rechercheCentreRelaisId($centreRelaisRepository, $centreRelais);
        $lesCasier = $casierRepository->findAll();
        foreach($lesCasier as $casier){
            if($casier->getLeCentreRelais()->getId() == $centre){
                if($casier->getLongueur() > $longueur && $casier->getLargeur() > $largeur && $casier->getHauteur() > $hauteur && $casier->isDisponibilite()){
                    return $casier;
                }
            }
        }
        return null;
    }
}