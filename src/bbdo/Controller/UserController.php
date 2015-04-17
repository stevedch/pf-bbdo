<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 07-02-2015
 * Time: 17:50
 */
namespace bbdo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserController
{
    public function loginAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->createBuilder('form')
            ->add('username', 'text', array(
                'label' => 'Usuario',
                'required' => false,
                'data' => $app['session']->get('_security.last_username'),
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('novalidate' => 'novalidate', 'class' => 'form-control box-s', 'placeholder' => 'Ingrese su usuario'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('password', 'password', array(
                'label' => 'Contraseña',
                'required' => false,
                'label_attr' => array('class' => '', 'style' => 'color:rgba(52, 52, 52, 0.85);'),
                'attr' => array('class' => 'form-control box-s', 'placeholder' => 'Contraseña'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'No puedes dejar este campo en blanco.'
                    ))
                )
            ))
            ->add('login', 'submit', array('label' => 'Iniciar sesión', 'attr' => array('class' => 'btn btn-default btn-sm btn-responsive', 'style' => 'float:right')))
            ->getForm();
        return $app['twig']->render('login/index.html.twig', array(
            'form' => $form->createView(),
            'error' => $app['security.last_error']($request)
        ));
    }

    public function logoutAction(Application $app)
    {
        $app['session']->clear();
        return $app->redirect($app['url_generator']->generate('bbdo_chile.homepage'));
    }


}