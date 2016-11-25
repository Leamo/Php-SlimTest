# Projet Test Slim Framework

Ce projet a pour but de tester Slim framework

## Arborescence

- vendor : dossier géré par composer
- public : dossier racine du site, contient le code accessible au public

## Principes de base de Slim

### [Middleware](https://www.slimframework.com/docs/concepts/middleware.html)

Le Middleware permets d'exécuter du code avant ou après l'application Slim.
On peut par exemple manipuler facilement les objets Request et Response pour vérifier/modifier des données.

### [Container](https://www.slimframework.com/docs/concepts/di.html)

Le container peut être récupérer dans toute l'application.
Il permets de récupérer simplement les objets qui lui sont attribués.
Le container est appelé avec la variable `$this` 

### Controller



## Base de Données

Pour tester ce framework nous avons besoin de créer cette base de données sur notre serveur MySQL :

CREATE DATABASE `slim`;

CREATE TABLE `slim`.`posts` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)); 

INSERT INTO `posts` (`name`) VALUES ('Article 1'), ('Article 2');