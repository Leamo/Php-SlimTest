<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

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
		$errors = [];

		Validator::email()->validate($request->getParam('email')) || $errors['email'] = "Votre email n'est pas valide";
		Validator::notEmpty()->validate($request->getParam('name')) || $errors['name'] = "Veuillez indiquer votre nom";
		Validator::notEmpty()->validate($request->getParam('message')) || $errors['message'] = "Veuillez laisser un message";

		if (empty($errors)) {
			$message = \Swift_Message::newInstance('Message de contact')
			->setFrom([$request->getParam('email') => $request->getParam('name')])
			->setTo('mortie@cyber-l.com')
			->setBody("Un mail vous a été envoyé : {$request->getParam('message')}");

			$this->mailer->send($message);

			$this->flash('Votre message a bien été envoyé');
		} else {
			$this->flash('Certains champs n\'ont pas été remplis correctement','error');
			$this->flash($errors,'errors');
			return $this->redirect($response, 'contact', 400);
		}

		

		return $this->redirect($response, 'contact');
	}
}