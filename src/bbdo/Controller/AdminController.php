<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 09-02-2015
 * Time: 15:07
 */
namespace bbdo\Controller;

use Silex\Application;

class AdminController
{
    public function indexAction(Application $app)
    {
        return $app->redirect($app['url_generator']->generate('bbdo_admin_users')); //Redireccionamiento a la pagina bbdo_chile.admin_users.
    }
}