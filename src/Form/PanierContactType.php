<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PanierContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom',TextType::class, [
                'attr'=>['placeholder'=>'Votre prénom']
            ])
            ->add('nom',TextType::class,[
                'attr'=>['placeholder'=>'Votre nom']
            ])
            ->add('email', EmailType::class,[
                'attr'=>['placeholder'=>'Votre email']
            ])
            ->add('telephone', NumberType::class,[
                'attr'=>['placeholder'=>'Votre numéro téléphone']
            ])
            ->add('adresse',TextType::class,[
                'attr'=>['placeholder'=>'Votre adresse']
            ])
            ->add('Commander', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
