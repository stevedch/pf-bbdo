<?php
/**
 * Created by PhpStorm.
 * User: Steven/ BBDO Chile
 * Date: 07-02-2015
 * Time: 2:59
 */

namespace bbdo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('run_user', 'text', array(
            'label' => 'Run',
            'required' => true,
            'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
            'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Run'),
        ))
            ->add('name_user', 'text', array(
                'label' => 'Nombres',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('id' => 'name_user', 'novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Nombres '),
            ))
            ->add('lastname_user', 'text', array(
                'label' => 'Apellido paterno',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Apellido paterno'),
            ))
            ->add('second_surname', 'text', array(
                'label' => 'Apellido materno',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Apellido materno'),
            ))
            ->add('birth_date', 'date', array(
                'label' => 'Fecha de nacimiento',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s'),
            ))
            ->add('start_date', 'date', array(
                'label' => 'Fecha de contratación',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s'),
            ))
            ->add('post_user', 'text', array(
                'label' => 'Cargo',
                'required' => true,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Cargo'),
            ))
            ->add('area_user', 'choice', array(
                'label' => 'Area',
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('required' => true, 'novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Area'),
                'choices' => array(
                    '' => 'Seleccione item',
                    'Gerencia' => 'Gerencia',
                    'Planning' => 'Planning',
                    'Administrativo' => 'Administrativo',
                    'Tecnología Información' => 'Tecnología Información',
                    'Recursos Humanos' => 'Recursos Humanos',
                    'Producción Creativo' => 'Producción Creativo',
                    'Produccion Arte' => 'Produccion Arte',
                    'Audiovisual' => 'Audiovisual',
                    'Cuentas' => 'Cuentas',
                ),
            ))
            ->add('mail', 'text', array(
                'label' => 'E-mail',
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('required' => false, 'novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'E-mail')
            ))
            ->add('annex_telephone', 'text', array(
                'label' => 'Anexo telefónico',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('id' => 'annex_telephone', 'novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Anexo telefónico'),
            ))
            ->add('photo_user', 'file', array(
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s')
            ))
            ->add('username', 'text', array(
                'label' => 'Usuario',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Usuario'),
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'options' => array('required' => FALSE, 'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'style' => '', 'placeholder' => 'Contraseña')),
                'first_options' => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Repita la contraseña'),
                'first_name' => 'pass_1',
                'second_name' => 'pass_2',
                'required' => FALSE,
                'invalid_message' => 'Los campos de contraseña deben coincidir.',
            ))
            ->add('status_user', 'choice', array(
                'label' => 'Estado de usuario',
                'attr' => array('required' => true, 'novalidate' => 'novalidate', 'class' => 'form-control box-s'),
                'choices' => array(
                    '' => 'Seleccione item',
                    'Activo' => 'Activo',
                    'Desactivado' => 'Desactivado',
                )
            ))
            ->add('role', 'choice', array(
                'label' => 'Nivel de permiso módulos',
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Rol'),
                'choices' => array(
                    ' ' => 'Seleccione item',
                    'ROLE_SUPER_ADMIN' => 'Super administrador - TI',
                    'ROLE_RRHH_ADMIN' => 'Administrador - RRHH',
                    'ROLE_USER' => 'Usuario Estándar'
                )
            ))
            ->add('role_public', 'choice', array(
                'label' => 'Autorización de publicador',
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Rol'),
                'choices' => array(
                    ' ' => 'Seleccione item',
                    'ROLE_PUBLIC' => 'Publicador',
                )
            ))
            ->add('save', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-default btn-sm', 'style' => 'float:right')));
    }

    public function getName()
    {
        return 'User';
    }

}