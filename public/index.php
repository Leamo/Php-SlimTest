<?php

// On charge l'autoloader de composer
require '../vendor/autoload.php';

// On initialise Slim
$app = new \Slim\App();

// On déclare les routes de l'application

// Route 'basique'
$app->get('/', function(\Slim\Http\Request $request, \Slim\Http\Response $response) {
	return $response->getBody()->write('Salut les gens');
});

// Route avec paramètres (à mettre dans l'url)
$app->get('/salut/{nom}', function($request, $response, $args) {
	// le 'getBody' est optionnel grâce à la fonction write de Slim
	return $response->write('Salut '.$args['nom']);
});

// On 'lance' l'application
$app->run();