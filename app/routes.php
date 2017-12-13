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

//page de messagerie privée pour contacter un ancien élève ou un recruteur
$app->match('/contacter/{id}', 'WF3\Controller\HomeController::messageriePriveeAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('contacter');


//pages liste des offres d'emploi
$app->get('/offresemploi', 'WF3\Controller\HomeController::offresAction')
    ->bind('offresemploi');


// PAGE DE DETAIL DE L'OFFRE D'EMPLOI
$app->match('/detailoffre/{id}', 'WF3\Controller\HomeController::detailOffreAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('detailoffre');

//PAGE FORMULAIRE POUR POSTER UNE OFFRE D'EMPLOI
$app->match('/formulaireemploi', 'WF3\Controller\HomeController::formulaireOffreAction')
    ->bind('formulaireemploi');


//page qui supprime une offre d'emploi
$app->get('/detailoffre/suppression/{id}', 'WF3\Controller\HomeController::deleteOfferAction')
->assert('id', '\d+')
->bind('suppressionoffre');


//page de résultats de recherche d'une offre d'emploi par titre en ajax
$app->match('/rechercheajaxpartitre', 'WF3\Controller\AjaxController::rechercheOffreparTitreAction')
    ->bind('rechercheajaxpartitre');

//page de résultats de recherche des offres d'emploi par ville en ajax
$app->match('/rechercheajaxparville', 'WF3\Controller\AjaxController::rechercheOffreparVilleAction')
    ->bind('rechercheajaxparville');



//page Forum
$app->match('/forum', 'WF3\Controller\HomeController::forumPageAction')
    ->bind('forum');

//affichage du sujet et message quand on clique dessus
$app->match('forum/subject/responses/{idSubject}', 'WF3\Controller\HomeController::subjectAction')
   ->bind('forumsubject');


//Affichage du sujet de forum en ajax
$app->match('forumsubject', 'WF3\Controller\AjaxController::subjectPageAction')
    ->bind('forumsubject');





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
    ->assert('token', '[a-z0-9]{32}')
    ->bind('mdpoublie/resetform');   

// modifier les infos perso
$app->match('/profil/{id}', 'WF3\Controller\HomeController::updateUserAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('profil');    

// modifier les infos perso
$app->match('/profil/{id}/mdp', 'WF3\Controller\HomeController::updatePassAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('profil/mdp');       



$app->match('/contact/moi', 'WF3\Controller\HomeController::contactAction')->bind('contactezmoi');


// formulaire d'inscription des alumnis
$app->match('/inscription/alumni', 'WF3\Controller\HomeController::alumniAction')
    ->bind('inscription/alumni');

$app->get('/user/delete/{id}', 'WF3\Controller\HomeController::deleteUserAction')
->assert('id', '\d+')
->bind('deleteUserAction');

$app->match('/alumni/update/{id}', 'WF3\Controller\HomeController::updateAlumniAction')
->assert('id', '\d+')
->bind('updateAlumniAction');


$app->match('/job/update/{id}', 'WF3\Controller\HomeController::updateJobAction')
->assert('id', '\d+')
->bind('updateJobAction');


$app->match('/recherche', 'WF3\Controller\HomeController::rechercheParUsername')
    ->bind('rechercheParUsername');
////////////AJAX///////////

/*$app->match('/ajax/recherche', 'WF3\Controller\AjaxController::AjaxActionForum')
    ->bind('ajaxResultatForum');*/


