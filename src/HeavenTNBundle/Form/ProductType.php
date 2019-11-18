<?php

namespace HeavenTNBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productname')
            ->add('price')
            ->add('quantite')
            ->add('description',TextareaType::class,array('attr'=>array('class'=>'ckeditor','placeholder'=>'Description')))
            ->add('productimage', FileType::class, array('attr' => array('class' => 'form-control'),'data_class' => null))
            ->add('category',EntityType::class,array(
                'class' =>'HeavenTNBundle\Entity\Category',
                'choice_label' =>'name',
                'multiple' => false
            ))
            ->add('minAlert')
        ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HeavenTNBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'heaventnbundle_product';
    }


}
