<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferencedPersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        $builder->add('lastName', null, array(
            'label' => 'Last Name',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('firstName', null, array(
            'label' => 'First Name',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('birthDate', null, array(
            'label' => 'Birth Date',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('deathDate', null, array(
            'label' => 'Death Date',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('sameAsPeopleEntityId', null, array(
            'label' => 'Same As People Entity Id',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('referencedPersonUri', null, array(
            'label' => 'Referenced Person Uri',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                        $builder->add('books');
                
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ReferencedPerson'
        ));
    }
}
