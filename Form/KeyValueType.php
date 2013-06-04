<?php

namespace Elcweb\Bundle\KeyValueStoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KeyValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key')
            ->add('value')
            ->add('description')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elcweb\Bundle\KeyValueStoreBundle\Entity\KeyValue'
        ));
    }

    public function getName()
    {
        return 'elcweb_bundle_keyvaluestorebundle_keyvaluetype';
    }
}
