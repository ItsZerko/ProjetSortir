<?php

namespace App\Form;

use App\Entity\Participant;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom')
            ->add('prenom')
            ->add('username')
            ->add('telephone')
            ->add('mail')
            ->add('actif')
            ->add('password', PasswordType::class, ['attr'=>['placeholder'=>'8 caracteres minimum']])
            ->add('passwordVerif', PasswordType::class,['attr'=>['placeholder'=>'Resaisir password']])
            ->add('envoyer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
