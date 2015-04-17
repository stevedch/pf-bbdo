<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Silex\Application;
//use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;


$app = new Application();
//$app->register(new DoctrineOrmServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new SecurityServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new FormServiceProvider());


//Conexión ha base de datos  bbdo_chile
$app->register(new DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'mysql_read' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'newbbdo',
            'user' => 'root',
            'password' => 'admin',
            'charset' => 'utf8',
        ),
        'mysql_write' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'newbbdo',
            'user' => 'root',
            'password' => 'admin',
            'charset' => 'utf8',
        ),
    ),
));

$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    "orm.em.options" => array(
        "mappings" => array(
            array(
                "type" => "yml",
                "namespace" => "Entity",
                "path" => realpath(__DIR__ . "/../config/doctrine"),
            ),
        ),
    ),
));

//Registro para el envío de mensajes
$app->register(new SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => array(
        'host' => 'mail.dominio.cl',
        'port' => '25',
        'username' => 'usuariodehos',
        'password' => 'admin123',
        'encryption' => null,
        'auth_mode' => null
    ),
));


//Registro para la seguridad de url - ejm Administrador
$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/',
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/administrator/login_check',
                'username_parameter' => 'form[username]',
                'password_parameter' => 'form[password]',
            ),
            'logout' => true,
            'anonymous' => true,
            'users' => $app->share(function () use ($app) {
                return new bbdo\Repository\UserRepository($app['db'], $app['security.encoder.digest']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_SUPER_ADMIN' => array('ROLE_ADMIN'), //ROLE_SUPER_ADMIN visualización y acceso total ejm: array('ROLE_ADMIN','ROLE_RRHH_ADMIN') -> acceso total sobre todos los roles
        'ROLE_RRHH_ADMIN' => array('ROLE_ADMIN'),
        'ROLE_ADMIN' => array('ROLE_USER'),
        'ROLE_USER' => array('ROLE_ADMIN'),
        'ROLE_PUBLIC' => array('ROLE_ADMIN')
    ),
));


//Protección de urls y redireccionamiento, si el usuario no tiene los privilegios
$app->before(function (Request $request) use ($app) {
    $protected = array(
        '/administracion/' => array('ROLE_SUPER_ADMIN', 'ROLE_RRHH_ADMIN', 'ROLE_ADMIN', 'ROLE_PUBLIC'), //accesso denegado para usuarios que no cumplas los roles del array
        '/me' => 'ROLE_USER',
    );
    $path = $request->getPathInfo();
    foreach ($protected as $protectedPath => $role) {
        if (strpos($path, $protectedPath) !== FALSE && !$app['security']->isGranted($role)) {
            throw new AccessDeniedException();
        }
    }
});

//Registro de los  repositorios
$app['repository.user'] = $app->share(function ($app) {
    return new bbdo\Repository\UserRepository($app['db'], $app['security.encoder.digest']); //Repositorio del usuario
});

$app['repository.notice'] = $app->share(function ($app) {
    return new bbdo\Repository\NoticeRepository($app['db']); //Repositorio de los avisos
});

$app['repository.document'] = $app->share(function ($app) {
    return new bbdo\Repository\DocumentRepository($app['db']); //Repositorio de los documentos
});

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translation.messages' => array(),
));

$app['twig'] = $app->share($app->extend('twig', function ($twig) {
    return $twig;
}));

return $app;