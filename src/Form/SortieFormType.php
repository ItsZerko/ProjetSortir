<?php

namespace App\Form;

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
use Symfony\Component\OptionsResolver\OptionsResolver;


class SortieFormType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $listener = function (FormEvent $event) {
            $test ='Hello';
            dump($test);
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

                ['class' => Lieu ::class, 'choice_label' => 'nom' ])



                    ->add('enregistrer', SubmitType::class, ['attr'=>['id'=>'save']])
                    ->add('publier', SubmitType::class, ['attr'=>['id'=>'publish']])
                    ->add('annuler', ButtonType::class);


     /*   $builder->add('ville', EntityType::class,
            ['class' => Lieu ::class, 'choice_label' => 'nom']);*/

            }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class


        ]);
    }



}
