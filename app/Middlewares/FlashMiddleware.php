<?php

namespace App\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

/**
* Middleware pour la gestion des messages flash
*/
class FlashMiddleware
{
	private $twig;

	// injection de dépendance pour récupérer Twig dans la classe
	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
	}
	
	public function __invoke(Request $request, Response $response, $next)
	{
		// renvoie une variable globale à toutes les vues
		$this->twig->addGlobal('flash', isset($_SESSION['flash']) ? $_SESSION['flash'] : []);

		// on supprime ensuite la session flash
		if (isset($_SESSION['flash'])) {
			unset($_SESSION['flash']);
		}

		return $next($request, $response);
	}
}