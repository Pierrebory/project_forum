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

//page Forum
$app->match('/forum', 'WF3\Controller\HomeController::forumPageAction')->bind('forum');



// formulaire d'inscription
$app->match('/inscription', 'WF3\Controller\HomeController::registerAction')
    ->bind('inscription');

// formulaire de connexion
$app->match('/connexion', 'WF3\Controller\HomeController::registerAction')
    ->bind('connexion');

$app->match('forum/subject/responses', 'WF3\Controller\HomeController::subjectAction')
->bind('forumsubject');