# Projet 8 - Améliorez une application existante de ToDo & Co

### Parcours Développeur d'application PHP/Symfony
![Coverage Badge](https://img.shields.io/badge/Coverage-90.78%25-brightgreen)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/67f96301775a4c4886990e2817dec8cc)](https://app.codacy.com/gh/nicolascastagna/ToDo-Co/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)


## Prérequis

- Serveur local sous PHP 8.2 ([MAMP](https://www.wampserver.com/) pour macOs ou [WAMP](https://www.mamp.info/en/mamp/mac/) pour windows)
- [Symfony](https://symfony.com/download)
- Base de donnée MySQL
- [Composer](https://getcomposer.org/)
  
## Installation du projet

**1 - Cloner le dépôt GitHub pour télécharger le projet dans le répertoire de votre choix :**
```
https://github.com/nicolascastagna/ToDo-Co.git
```

**2 - Installer les dépendances en exécutant la commande suivante :**
```
composer install
```

**3 - Renommer le fichier **.env.example** en **.env** et modifier les paramètres de connexion à la base de données**

## Environnement de test

**4 -Créez un fichier .env.test et ajoutez les informations de connexion de votre base de donnée de test**

**5 - Créer la base de données :**   
    
    A. Effectuer les commandes suivantes :
        - php bin/console doctrine:database:create
        - php bin/console doctrine:migrations:migrate
    B. Insertion des fixtures pour les tests :
        - php bin/console doctrine:database:create --env=test
        - php bin/console doctrine:schema:create --env=test 
        - php bin/console doctrine:fixtures:load -n --env=test

**6 - Execution des tests :**  

Lancez cette commande pour éxecuter tous les tests :
```
php vendor/bin/phpunit
```
Pour génerer le rapport de taux de coverage, lancez cette commande :
```
php vendor/bin/phpunit --coverage-html public/testCoverage
```

**7 - Démarrer le serveur symfony :**   

Démarrez le serveur Symfony en exécutant la commande suivante :
```
symfony server:start
```
