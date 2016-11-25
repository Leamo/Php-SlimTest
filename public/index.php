<?php

// On charge l'autoloader de composer
require '../vendor/autoload.php';

/**
* classe servant d'exemple de MiddleWare (code s'éxecutant avant ou après l'entrée dans l'application)
*/
class DemoMidleware
{
	
	public function __invoke($request, $response, $next)
	{
		// action réalisée avant l'entrée dans l'app
		$response->write('<h1>Bienvenue</h1>');

		$response = $next($request, $response);

		// action réalisée après l'exécution de l'app
		$response->write('<h2>Au Revoir</h2>');

		return $response;
	}
}

/**
* classe permettant de gérer un controller
*/
class PageController
{
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function dbAction($request, $response)
	{
		// création d'une requête avec l'objet pdo du container
		$req = $this->container->pdo->prepare('SELECT * FROM posts');
		$req->execute();
		$posts = $req->fetchAll();

		return $response->write('ok');
	}
}

// On initialise Slim
$app = new \Slim\App();

// On instancie le Middleware créé précédemment
$app->add(new DemoMidleware());

// connexion à la base de données à l'aide d'un container pour pouvoir utiliser l'objet dans toutes les fonctions
$container = $app->getContainer();
$container['pdo'] = function() {
	$pdo = new PDO('mysql:dbname=slim;host=localhost','root','');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
};

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

// Route de test d'interaction à la base de données
$app->get('/database', function($request, $response) {
	// création d'une requête avec l'objet pdo du container
	$req = $this->pdo->prepare('SELECT * FROM posts');
	$req->execute();
	$posts = $req->fetchAll();

	return $response->write('ok');
});

// Même utilité qu'au dessus mais en passant par un controller
$app->get('/database/controller', 'PageController:dbAction');

// On 'lance' l'application
$app->run();