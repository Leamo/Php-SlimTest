# Projet Test Slim Framework

Ce projet a pour but de tester Slim framework

## Arborescence

- vendor : dossier géré par composer
- public : dossier racine du site, contient le code accessible au public
  + demo.php : fichier fonctionnant tout seul et montrant le fonctionnement des composants de base de Slim
  + index.php : fichier d'initialisation de l'app
- app : dossier contenant le code fonctionnel de l'app
  + container.php : fichier gérant tout ce qui est injecté au container
  + Controllers : dossier contenant les Controllers
  + Ressources : dossier contenant les éléments front comme les vues
- tmp : dossier contenant des fichiers temporaires
  + cache : dossier contenant les fichiers du cache (twig)

## Principes de base de Slim

### [Middleware](https://www.slimframework.com/docs/concepts/middleware.html)

Le Middleware permets d'exécuter du code avant ou après l'application Slim.
On peut par exemple manipuler facilement les objets Request et Response pour vérifier/modifier des données.
Attention : l'ordre dans lequel sont appelés les Middlewares est important -> le dernier inscrit sera le premier appelé.

### [Container](https://www.slimframework.com/docs/concepts/di.html)

Le container peut être récupérer dans toute l'application.
Il permets de récupérer simplement les objets qui lui sont attribués.
Le container est appelé avec la variable `$this` 

### [Rooter](https://www.slimframework.com/docs/objects/request.html#route-object)

Le rooter permets de gérer l'affichage et les données affichées en fonction de l'URL donnée.


## Base de Données

Pour tester ce framework nous avons besoin de créer cette base de données sur notre serveur MySQL :

CREATE DATABASE `slim`;

CREATE TABLE `slim`.`posts` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)); 

INSERT INTO `posts` (`name`) VALUES ('Article 1'), ('Article 2');

## Composer

Le framework slim est chargé à l'aide de composer.
Ce dernier propose un système d'autoloader et il est plus propre de passer par lui pour toutes les déclarations d'autoloading. Il suffit pour cela de les rajouter dans le fichier composer.json et de ne pas oublier de recharger l'autoload de composer à chaque fois à l'aide de la commande `composer dump-autoload`
