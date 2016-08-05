<?php
/**
 * Created by PhpStorm.
 * User: jm
 * Date: 03/08/16
 * Time: 22:45
 */

namespace OC\BackBundle\Form\Type;

use OC\BackBundle\Form\StringToArrayTransformer;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('category', ChoiceType::class, array(
                'placeholder' => 'Choisissez une option',
                'choices' => array(
                    'observateur' => 'observateur',
                    'naturaliste' => 'naturaliste',
                )))
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class);

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}