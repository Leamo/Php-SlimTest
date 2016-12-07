<?php

// Get container
$container = $app->getContainer();

// Enregistrement du composant 'view' qui utilisera Twig
$container['view'] = function ($container) {

	$dir = dirname(__DIR__);

    $view = new \Slim\Views\Twig($dir . '/app/Ressources/views', [
        // 'cache' => $dir . '/tmp/cache'
        'debug' => true
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};

// Enregistrement du composant 'mailer' qui utilisera Swiftmailer
$container['mailer'] = function ($container) {
	// transporteur avec Maildev
	$transport = Swift_SmtpTransport::newInstance('localhost',1025);

	$mailer = Swift_Mailer::newInstance($transport);

	return $mailer;
};