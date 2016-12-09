<?php
use App\Controllers\PageController;
use App\Middlewares\FlashMiddleware;
use App\Middlewares\OldMiddleware;
use App\Middlewares\TwigCSRFMiddleware;

// On charge l'autoloader de composer
require '../vendor/autoload.php';

session_start();

// On initialise Slim (avec l'affichage d'erreurs)
$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true
	]
]);

require '../app/container.php';

$container = $app->getContainer();

// Middleware
$app->add(new FlashMiddleware($container->view->getEnvironment()));
$app->add(new OldMiddleware($container->view->getEnvironment()));
$app->add(new TwigCSRFMiddleware($container->view->getEnvironment(), $container->csrf));
$app->add($container->get('csrf'));

// Pages
$app->get('/', PageController::class . ':home')->setName('root');
$app->get('/contact', PageController::class . ':getContact')->setName('contact');

// gestion du formulaire
$app->post('/contact', PageController::class . ':postContact');

$app->run();