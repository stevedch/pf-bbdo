<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

//covenrt -> convierte las variables de rutas en objetos -> ejm: administracion/notices/{id}/editar.
if (isset($app)) {
    $app['controllers']->convert('document', function ($id) use ($app) {
        if ($id) return $app['repository.document']->find($id);
    });
}
if (isset($app)) {
    $app['controllers']->convert('notice', function ($id) use ($app) {
        if ($id) return $app['repository.notice']->find($id);
    });
}
if (isset($app)) {
    $app['controllers']->convert('user', function ($id) use ($app) {
        if ($id) return $app['repository.user']->find($id);
    });
}

//Página principal de la intranet.
//la funcion match utiliza expresiones regulares para admitir mas de un método-> ejm: POST,GET,PUT,DELETE.
if (isset($app)) $app->get('/', 'bbdo\Controller\IndexController::indexAction')->bind('bbdo_homepage'); //url de inicio de sesión.
if (isset($app)) $app->match('/login', 'bbdo\Controller\UserController::loginAction')->bind('bbdo_login'); //url de inicio de sesión.
if (isset($app)) $app->get('/logout', 'bbdo\Controller\UserController::logoutAction')->bind('bbdo_logout'); //url de cerrar sesión.
//vista de directorio telefónico.
if (isset($app)) $app->get('/directorio/telefonico/', 'bbdo\Controller\IndexController::viewdirectoryAction')->bind('bbdo_directory');
//vista del organigrama.
if (isset($app)) $app->get('/organigrama/', 'bbdo\Controller\IndexController::vieworganizationchartAction')->bind('bbdo_organizationchart');
//Administracion de funciones del usuario.
if (isset($app)) $app->get('/administracion/', 'bbdo\Controller\AdminController::indexAction')->bind('bbdo_administrator'); //Redireccionamiento a la pagina bbdo_chile.admin_users.
if (isset($app)) $app->get('/administracion/usuarios', 'bbdo\Controller\UserAdminController::indexAction')->bind('bbdo_admin_users'); //Genera una vista de la tabla usuario.
if (isset($app)) $app->get('/administracion/usuarios/activos', 'bbdo\Controller\UserAdminController::pageactiveAction')->bind('bbdo_admin_pageactive'); //Genera una vista de la tabla usuario.
if (isset($app)) $app->get('/administracion/usuarios/desactivados', 'bbdo\Controller\UserAdminController::pagedesactiveAction')->bind('bbdo_admin_pagedesactive'); //Genera una vista de la tabla usuario.
if (isset($app)) $app->match('/administracion/usuarios/agregar', 'bbdo\Controller\UserAdminController::addAction')->bind('bbdo_admin_users_add'); //formulario de agregar usuario.
if (isset($app)) $app->match('/administracion/usuarios/{user}/editar', 'bbdo\Controller\UserAdminController::editAction')->bind('bbdo_admin_users_edit'); //formulario de edición usuario.
if (isset($app)) $app->match('/administracion/usuarios/{user}/eliminar', 'bbdo\Controller\UserAdminController::deleteAction')->bind('bbdo_admin_users_delete');
//Publicacion de avisos.
if (isset($app)) $app->get('/avisos/', 'bbdo\Controller\NoticeController::indexAction')->bind('bbdo_index_notice'); //inicio de la página de avisos.
if (isset($app)) $app->match('/avisos/{notice}/vista/', 'bbdo\Controller\NoticeController::viewEmployeeAction')->bind('bbdo_view_notice_employee');
if (isset($app)) $app->match('/avisos/agregar/', 'bbdo\Controller\NoticeController::addAction')->bind('bbdo_admin_notice_add'); //formulario de agregar nuevos avisos.
if (isset($app)) $app->match('/avisos/{notice}/editar/', 'bbdo\Controller\NoticeController::editAction')->bind('bbdo_admin_notice_edit'); //formulario de editar nuevos avisos.
//Ruta de publicación de normas,políticas,procedimientos PDF - visualización usuarios estándar.
if (isset ($app)) $app->get('/ti/documentos/', 'bbdo\Controller\DocumentController::indexAction')->bind('bbdo_ti_document');
//Administración de los documentos.
if (isset ($app)) $app->get('/administracion/ti/documentos/', 'bbdo\Controller\DocumentController::viewDocumentAction')->bind('bbdo_admindocument_view');
if (isset ($app)) $app->match('/administracion/ti/documentos/agregar', 'bbdo\Controller\DocumentController::addAction')->bind('bbdo_admindocument_add');
if (isset ($app)) $app->match('/administracion/ti/documentos/{document}/editar', 'bbdo\Controller\DocumentController::editAction')->bind('bbdo_admindocument_edit');
if (isset ($app)) $app->match('/administracion/ti/documentos/{document}/eliminar', 'bbdo\Controller\DocumentController::deleteAction')->bind('bbdo_admindocument_delete');

//Errores de páginas
if (isset($app)) {
    $app->error(function (\Exception $e, $code) use ($app) {
        if ($app['debug']) {
            return $app;
        }
        // 404.html, or 40x.html, or 4xx.html, or error.html
        $templates = array(
            'errors/' . $code . '.html.twig',
            'errors/' . substr($code, 0, 2) . 'x.html.twig',
            'errors/' . substr($code, 0, 1) . 'xx.html.twig',
            'errors/default.html',
        );
        return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code, $e);
    });
}
