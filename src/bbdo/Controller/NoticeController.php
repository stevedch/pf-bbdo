<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 26-02-2015
 * Time: 14:14
 */

namespace bbdo\Controller;

use bbdo\Entity\Notice;
use bbdo\Form\Type\NoticeType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class NoticeController
{
    public function indexAction(Request $request, Application $app)
    {
        $limit = 20;
        $total = $app['repository.notice']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $notice = $app['repository.notice']->findAll($limit, $offset);
        return $app['twig']->render('notice/index.html.twig', array(
            'notice' => $notice,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('bbdo_index_notice')
        ));
    }

    public function addAction(Request $request, Application $app)
    {
        $notice = new Notice();
        $form = $app['form.factory']->create(new NoticeType(), $notice);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.notice']->save($notice);
                $message = 'El aviso' . $notice->getNameNotice() . 'se ha publicado';
                $app['session']->getFlashBag()->add('s', $message);
                /*$redirect = $app['url_generator']->generate('bbdo_admin_notice_edit', array('notice' => $notice->getIdNotice()));
                return $app->redirect($redirect);*/
                $redirect = $app['url_generator']->generate('bbdo_homepage', array());
                return $app->redirect($redirect);
            }
        }
        return $app['twig']->render('notice/notice.html.twig', array('form' => $form->createView(), 'title' => 'Añadir nueva Noticia'));
    }

    public function editAction(Request $request, Application $app)
    {
        $notice = $request->attributes->get('notice');
        if (!$notice) {
            $app->abort(404, 'No se encontró el aviso solicitado');
        }
        $form = $app['form.factory']->create(new NoticeType(), $notice);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.notice']->save($notice);
                $message = 'El' . $notice->getNameNotice() . 'aviso ha sido editado.';
                $app['session']->getFlashBag()->add('s', $message);
            }
        }
        return $app['twig']->render('notice/notice.html.twig', array('form' => $form->createView()));
    }


    public function viewEmployeeAction(Request $request, Application $app)
    {
        $noticemployee = $request->attributes->get('notice');
        if (!$noticemployee) {
            $app->abort(404, 'No se encontro ningún aviso');
        }
        return $app['twig']->render('notice/noticemployee.html.twig', array(
            'notice' => $noticemployee
        ));
    }
}