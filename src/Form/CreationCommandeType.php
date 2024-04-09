<?php

namespace App\Form;

use App\Entity\CentreRelais;
use App\Entity\Commande;
use App\Repository\CentreRelaisRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //  $z =1;
        // $centreRelaisRepository = new CentreRelaisRepository();
        // $builder
        //     ->add('longueur')
        //     ->add('largeur')
        //     ->add('hauteur')
        //     ->add('poid')
        //     // ->add('destination')
        //     ->add('centreRelais', ChoiceType::class, [
        //          'class' => CentreRelaisRepository::class,
        //         'choices' => $this->CentreRelaisRepository->monQueryBuilder(),
        //         'choice_label' => function ($choice, $key, $value){
        //             return $choice->getAdresse();
        //         },
        //     ])
        //     ->add('COMMANDER', SubmitType::class,['label'=>'COMMANDER'])
        // ;
        $builder
            ->add('longueur')
            ->add('largeur')
            ->add('hauteur')
            ->add('poid')
            ->add('centreRelais', EntityType::class, [
                'class' => CentreRelais::class,
                'query_builder' => function (CentreRelaisRepository $centreRelaisRepository) {
                    return $centreRelaisRepository->createQueryBuilder('cr')
                        ->join('cr.lesCasiers', 'c')
                        ->andWhere('c.disponibilite = :disponibilite')
                        ->setParameter('disponibilite', 1)
                        ->orderBy('cr.capacite', 'ASC');
                        // Vous pouvez ajouter d'autres conditions de filtrage ici
                },
                'choice_label' => 'adresse', // Propriété de l'entité à afficher
                // ... autres options ...
            ])
            ->add('COMMANDER', SubmitType::class,['label'=>'ENVOYER'])
        ;

    }
    //Voir ce qui est fait sur gg doc ap slam

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Commande::class,
        ]);
    }
}