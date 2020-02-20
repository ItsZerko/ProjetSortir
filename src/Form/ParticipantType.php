<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['attr'=>['label'=>'pseudo']])
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('mail')
            ->add('password', PasswordType::class)
            ->add('passwordVerif',PasswordType::class)
            ->add('site', EntityType::class, ['class'=>Site::class, 'choice_label'=>'nom'])
            ->add('enregistrer', SubmitType::class)
//            rajouter la photo à télécharger
//            ajouter la ville de rattachement
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
