<?php

namespace Elcweb\KeyValueStoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class KeyValueType
 * @package Elcweb\KeyValueStoreBundle\Form
 */
class KeyValueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key')
            ->add('value')
            ->add('description')
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcweb\KeyValueStoreBundle\Entity\KeyValue'
        ));
    }
}
