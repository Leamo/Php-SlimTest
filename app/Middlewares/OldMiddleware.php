<?php

namespace App\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

/**
* Middleware pour la gestion des anciennes valeurs du formulaire
*/
class OldMiddleware
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
		$this->twig->addGlobal('old', isset($_SESSION['old']) ? $_SESSION['old'] : []);

		// on supprime ensuite la session old
		if (isset($_SESSION['old'])) {
			unset($_SESSION['old']);
		}

		$response = $next($request, $response);

		// Si l'envoi présente une erreur (code 400)
		if ($response->getStatusCode() === 400) {
			$_SESSION['old'] = $request->getParams();
		}

		return $response;
	}
}