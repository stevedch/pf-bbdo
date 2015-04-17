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

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_document', 'text', array(
                'label' => 'Título',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Escriba el título del documento'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('shortdescription_document', 'textarea', array(
                'label' => 'Avisio de presentación',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s w-textarea', 'placeholder' => 'Escriba una descripción del documento'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('file', 'file', array(
                'required' => true,
                'data_class' => null,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s')
            ))
            ->add('status_document', 'choice',
                array(
                    'label' => 'Estado del documento',
                    'attr' => array('required' => true, 'novalidate' => 'novalidate', 'class' => 'form-control box-s'),
                    'choices' => array(
                        'Activo' => 'Activo',
                        'Desactivado' => 'Desactivado',
                    )
                ))
            ->add('save', 'submit', array('label' => 'Publicar', 'attr' => array('class' => 'btn btn-default btn-sm', 'style' => 'float:right')));
    }

    public function getName()
    {
        return 'Document';
    }

}