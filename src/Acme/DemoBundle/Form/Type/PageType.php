<?php

namespace Acme\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                    'label' => 'Títol de la pàgina',
                    'constraints' => new NotBlank(),
                ))
            ->add('label', 'text', array(
                    'label' => 'Text del menú',
                    'constraints' => new NotBlank(),
                ))
            ->add('save', 'submit', array(
                    'label' => 'Guardar'
                ));
    }

    public function getName()
    {
        return 'page';
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//                'data_class' => 'Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page',
//            ));
//    }
}