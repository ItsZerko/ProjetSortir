<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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


            ->add('DateDebut', DateType::class, [
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('DateFin', DateType::class,  [
                'required' => false,
                'widget' => 'single_text'
            ])

            ->add('isInscrit', CheckboxType::class, [
                'label'=>'Je suis inscrit/inscrite',
                'required' => false])

            ->add('SortiePasse', CheckboxType::class, [
                'label'=>'La sortie est passée',
                'required'=>false])

            ->add('isOrganisateur', CheckboxType::class, [
                'label'=>'Je suis organisateur/organisatrice',
                'required'=>false])

            ->add('rechercher', SubmitType::class);

    }
}
