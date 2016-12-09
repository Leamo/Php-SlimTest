<?php

// Get container
$container = $app->getContainer();

// Enregistrement du composant 'debug' : mettre à 'true' en mode dev
$container['debug'] = function () {
    return true;
};

// Enregistrement du composant 'csrf' pour la gestion des tokens CSRF
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

// Enregistrement du composant 'view' qui utilisera Twig
$container['view'] = function ($container) {

	$dir = dirname(__DIR__);

    $view = new \Slim\Views\Twig($dir . '/app/Ressources/views', [
        'cache' => $container->debug ? false : $dir . '/tmp/cache',
        'debug' => $container->debug
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    if ($container->debug) {
        $view->addExtension(new \Twig_Extension_Debug());
    }

    return $view;
};

// Enregistrement du composant 'mailer' qui utilisera Swiftmailer
$container['mailer'] = function ($container) {
	if ($container->debug) {
        // transporteur avec Maildev
	    $transport = Swift_SmtpTransport::newInstance('localhost',1025);
    } else {
        $transport = Swift_MailTransport::newInstance();
    }

	$mailer = Swift_Mailer::newInstance($transport);

	return $mailer;
};