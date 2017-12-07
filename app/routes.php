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

// je ne sais pas s'il faut mettre l'id
$app->get('/offresemploi/{id}', 'WF3\Controller\HomeController::offresAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('offresemploi');


// PAGE DE DETAIL DE L'OFFRE D'EMPLOI
$app->get('/detailoffre/{id}/{idemployer}', 'WF3\Controller\HomeController::detailOffreAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->assert('idemployer', '\d+')
    ->bind('detailoffre');

//page Forum
$app->match('/forum', 'WF3\Controller\HomeController::forumPageAction')
    ->bind('forum');


// formulaire d'inscription
$app->match('/inscription', 'WF3\Controller\HomeController::registerAction')
    ->bind('inscription');

// formulaire de connexion
$app->match('/login', 'WF3\Controller\HomeController::loginAction')
    ->bind('login');

// mot de passe oublié
$app->match('/mdpoublie', 'WF3\Controller\HomeController::resetPassAction')
    ->bind('mdpoublie');

// modifier le mot de passe
$app->match('/mdpoublie/resetform/{id}/{token}', 'WF3\Controller\HomeController::changePassAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->assert('token', '[a-z0-9]+')
    ->bind('mdpoublie/resetform');    

$app->match('forum/subject/responses/{idSubject}', 'WF3\Controller\HomeController::subjectAction')
    ->bind('forumsubject');




////////////AJAX///////////

/*$app->match('/ajax/recherche', 'WF3\Controller\AjaxController::AjaxActionForum')
    ->bind('ajaxResultatForum');*/


