<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 26-02-2015
 * Time: 14:14
 */

namespace bbdo\Controller;

use Silex\Application;
use bbdo\Entity\Document;
use bbdo\Form\Type\DocumentType;
use Symfony\Component\HttpFoundation\Request;

class DocumentController
{

    public function indexAction(Request $request, Application $app)
    {
        $limit = 20;
        $total = $app['repository.document']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $document = $app['repository.document']->findAll($limit, $offset);
        return $app['twig']->render('document/index.html.twig', array(
            'document' => $document,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('bbdo_ti_document'),
            'title' => 'DOCUMENTACION EN LINEA',
        ));
    }

    public function viewDocumentAction(Request $request, Application $app)
    {
        $limit = 20;
        $total = $app['repository.document']->getCount();
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $document = $app['repository.document']->findAll($limit, $offset);
        return $app['twig']->render('document/viewdocument.html.twig', array(
            'document' => $document,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('bbdo_admindocument_view'),
            'title' => 'BIBLIOTECA DE ARCHIVOS',
        ));

    }

    public function addAction(Request $request, Application $app)
    {
        $document = new Document();
        $form = $app['form.factory']->create(new DocumentType(), $document);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.document']->save($document);
                $message = 'El documento' . $document->getNameDocument() . 'se ha guardado';
                $app['session']->getFlashBag()->add('s', $message);
                $redirect = $app['url_generator']->generate('bbdo_admindocument_edit', array('document' => $document->getIdDocument()));
                return $app->redirect($redirect);
            }
        }
        return $app['twig']->render('document/addocument.html.twig', array(
            'form' => $form->createView(),
            'document' => $document,
            'title' => 'AÑADIR DOCUMENTOS'
        ));
    }

    public function editAction(Request $request, Application $app)
    {
        $document = $request->attributes->get('document');
        if (!$document) {
            $app->abort(404, 'No se encontró el documento solicitado');
        }
        $form = $app['form.factory']->create(new DocumentType(), $document);
        //var_dump($document) or die();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.document']->save($document);
                $message = 'El' . $document->getNameDocument() . 'documento ha sido editado.';
                $app['session']->getFlashBag()->add('s', $message);
            }
        }
        return $app['twig']->render('document/addocument.html.twig', array(
            'form' => $form->createView(),
            'document' => $document,
            'title' => 'EDITAR DOCUMENTOS'
        ));
    }

    public function deleteAction(Application $app, Request $request)
    {
        $document = $request->attributes->get('document');
        if (!$document) {
            $app->abort(404, 'No se encontró el documnento solicitado');
        }
        $app['repository.document']->delete($document->getIdDocument());
        return $app->redirect($app['url_generator']->generate('bbdo_admindocument_view'));
    }

}