<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom')
            ->add('prenom')
            ->add('username', TextType::class, ['attr'=>['label'=>'Pseudo']])
            ->add('telephone')
            ->add('mail')
            ->add('actif')
            ->add('site', EntityType::class,['class'=>Site::class, 'choice_label'=>'nom'])
            ->add('password', PasswordType::class, ['attr'=>['placeholder'=>'8 caracteres minimum'],'label'=>'Mot de passe'])
            ->add('passwordVerif', PasswordType::class,['attr'=>['placeholder'=>'Resaisir password'],'label'=>'Ressaisir mot de passe'])
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
