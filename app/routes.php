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

//pages liste des offres d'emploi
$app->get('/offresemploi', 'WF3\Controller\HomeController::offresAction')
    ->bind('offresemploi');


// PAGE DE DETAIL DE L'OFFRE D'EMPLOI
$app->match('/detailoffre/{id}', 'WF3\Controller\HomeController::detailOffreAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('detailoffre');

//page Forum
$app->match('/forum', 'WF3\Controller\HomeController::forumPageAction')->bind('forum');


// formulaire d'inscription
$app->match('/inscription', 'WF3\Controller\HomeController::registerAction')
    ->bind('inscription');

// formulaire de connexion
$app->match('/login', 'WF3\Controller\HomeController::loginAction')
    ->bind('login');

// mot de passe oublié
$app->match('/mdpoublie', 'WF3\Controller\HomeController::resetPassAction')
    ->bind('mdpoublie');



$app->match('forum/subject/responses', 'WF3\Controller\HomeController::subjectAction')
    ->bind('forumsubject');



////////////AJAX///////////

/*$app->match('/ajax/recherche', 'WF3\Controller\AjaxController::AjaxActionForum')
    ->bind('ajaxResultatForum');*/


