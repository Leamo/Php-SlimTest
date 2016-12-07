<?php
use App\Controllers\PageController;
use App\Middlewares\FlashMiddleware;

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

// Pages
$app->get('/', PageController::class . ':home');
$app->get('/contact', PageController::class . ':getContact')->setName('contact');

// gestion du formulaire
$app->post('/contact', PageController::class . ':postContact');

$app->run();