<?php
// ce fichier contient la liste des routes = url ) que l'on va accepter
//silex va parcourir les routes de haut en bas et s'arrête à la première qui correspond

//page d'accueil qui affiche tout les articles

$app->get('/', 'WF3\Controller\HomeController::homePageAction')
    ->bind('home'); 


//page Annuaire des Anciens élèves
$app->get('/annuaire', 'WF3\Controller\HomeController::annuaireAction')
    ->bind('annuaire');

//page détaillée d'un ancien élève
$app->match('/annuaire/{id}', 'WF3\Controller\HomeController::getAlumniAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('fichedetaillee');


$app->match('/forum', 'WF3\Controller\HomeController::forumPageAction')->bind('forum');


//page Forum
$app->get('/forum', 'WF3\Controller\HomeController::forumPageAction')->bind('forum');


// formulaire d'inscription
$app->match('/register', 'WF3\Controller\HomeController::registerAction')
    ->bind('register');


$app->match('forum/subject/{id}', 'WF3\Controller\HomeController::subjectAction')
->assert('id', '\d+')
->bind('voirsubject');