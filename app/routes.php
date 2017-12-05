<?php
// ce fichier contient la liste des routes = url ) que l'on va accepter
//silex va parcourir les routes de haut en bas et s'arrête à la première qui correspond

//page d'accueil qui affiche tout les articles

$app->get('/', 'WF3\Controller\HomeController::homePageAction')
    ->bind('home'); 


//page Annuaire des Anciens élèves
$app->match('/annuaire', 'WF3\Controller\HomeController::annuaireAction')
    ->bind('annuaire');


$app->get('/forum', 'WF3\Controller\HomeController::forumPageAction')->bind('forum');

