<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function MongoDB\BSON\toJSON;


class SortieFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $listener = function (FormEvent $event) {

        };
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nbInscriptionMax')
            ->add('infoSortie')
            ->add('lieu', EntityType::class,
                [
                    'class' => Lieu ::class,'placeholder'=>'Lieu',
                    'choice_label' => 'nom',
                    'attr' => [
                        'onchange' => 'updateLieu(this.value)'

                    ]
                ]

            )

            ->add('enregistrer', SubmitType::class)
            ->add('publier', SubmitType::class)
            ->add('annuler', ButtonType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class
        ]);
    }


}
