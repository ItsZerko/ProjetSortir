<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('RechercheSortie', TextType::class, array('required' => false))


            ->add('RechercheSite', EntityType::class, ['class' => Site ::class, 'choice_label' => 'nom',
                'required' => false])
            ->add('villeRecherchee', TextType::class, array('required' => false))


            ->add('DateDebut', DateType::class, [
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('DateFin', DateType::class,  [
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('rechercher', SubmitType::class);

    }
}
