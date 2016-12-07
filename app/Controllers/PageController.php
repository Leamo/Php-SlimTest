<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
* Controller chargé d'afficher les pages de l'app
*/
class PageController extends Controller
{
	public function home(RequestInterface $request, ResponseInterface $response)
	{
		// affichage d'une vue avec twig
		$this->render($response, 'pages/home.twig');
	}

	public function getContact(RequestInterface $request, ResponseInterface $response)
	{
		$this->render($response, 'pages/contact.twig');
	}

	public function postContact(RequestInterface $request, ResponseInterface $response)
	{
		$this->flash('Votre message a bien été envoyé');

		$message = \Swift_Message::newInstance('Message de contact')
			->setFrom([$request->getParam('email') => $request->getParam('name')])
			->setTo('mortie@cyber-l.com')
			->setBody("Un mail vous a été envoyé : {$request->getParam('message')}");

		$this->mailer->send($message);

		return $this->redirect($response, 'contact');
	}
}