<?php

declare(strict_types=1);

namespace ECorp\Infrastructure\Form\IdpClient;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdpClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('redirectUri', TextType::class)
            ->add('grantType', ChoiceType::class, [
                'choices' => ['authorization_code' => 'authorization_code', 'token' => 'token']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IdpClientModel::class
        ]);
    }
}
