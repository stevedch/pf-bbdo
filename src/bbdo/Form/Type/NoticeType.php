<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 26-02-2015
 * Time: 14:37
 */

namespace bbdo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_notice', 'text', array(
                'label' => 'Título del aviso',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);font-size: 12px;'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Escriba el título del aviso'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('shortdescription_notice', 'textarea', array(
                'label' => 'Avisio de presentación',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);font-size: 12px;'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s w-textarea', 'placeholder' => 'Escriba el aviso previo'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('description_notice', 'textarea', array(
                'label' => 'Descripción del aviso ',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);font-size: 12px;'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s w-textarea', 'placeholder' => 'Escriba el aviso'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('image_notice', 'file', array(
                'label' => 'Imagen',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);font-size: 12px;'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control', 'placeholder' => 'Escriba el aviso'),
            ))
            ->add('save', 'submit', array('label' => 'Publicar', 'attr' => array('class' => 'btn btn-default btn-sm', 'style' => 'float:right')));
    }

    public function getName()
    {
        return 'Notice';
    }

}