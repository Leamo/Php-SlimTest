<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
* Controller Général de l'application
*/
class Controller
{
	private $container;

	function __construct($container)
	{
		$this->container = $container;
	}

	// si on ne connait pas la methode, on prend celle du container
	public function __get($name) {
		return $this->container->get($name);
	}

	// fonction pour simplifier l'écriture du rendu des vues dans les controllers enfants
	public function render(ResponseInterface $response, $file, $params = []) {
		$this->container->view->render($response, $file, $params);
	}

	public function redirect(ResponseInterface $response, $name, $status = 302) {
		return $response->withStatus($status)->withHeader('Location', $this->router->pathFor($name));
	}

	// fonction pour gérer les messages flash (fonctionne avec un MiddleWare)
	public function flash($message, $type = 'success') {

		if (!isset($_SESSION['flash'])) {
			$_SESSION['flash'] = [];
		}

		return $_SESSION['flash'][$type] = $message;
	}
}