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

//Affichage du dernier message privé en ajax
$app->match('/derniermessageprive', 'WF3\Controller\AjaxController::lastPrivateMessageAction')
    ->bind('derniermessageprive');    

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

//PAGE DE MODIFICATION D'UNE OFFRE D'EMPLOI
$app->match('/job/update/{id}', 'WF3\Controller\HomeController::updateJobAction')
->assert('id', '\d+')
->bind('updateJobAction');


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
    ->assert('idSubject', '\d+')
   ->bind('forumsubject');


//Affichage du sujet de forum en ajax
$app->match('subject', 'WF3\Controller\AjaxController::subjectPageAction')
    ->bind('subject');

//affichage des réponses du Forum en Ajax
$app->match('responses', 'WF3\Controller\AjaxController::responsesPageAction')
    ->bind('responses');


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
$app->match('/mdp/{id}', 'WF3\Controller\HomeController::updatePasswordAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('mdp');       

// page messagerie avec toutes les conversations
$app->match('/messagerie/{id}', 'WF3\Controller\HomeController::conversationsAction')
    ->assert('id', '\d+')//\d+ équivaut à la regex[0-9]
    ->bind('messagerie');           



$app->match('/contact/moi', 'WF3\Controller\HomeController::contactAction')
    ->bind('contactezmoi');


// formulaire d'inscription des alumnis
$app->match('/inscription/alumni', 'WF3\Controller\HomeController::alumniAction')
    ->bind('inscription/alumni');

$app->get('/user/delete/{id}', 'WF3\Controller\HomeController::deleteUserAction')
->assert('id', '\d+')
->bind('deleteUserAction');

$app->match('/alumni/update/{id}', 'WF3\Controller\HomeController::updateAlumniAction')
->assert('id', '\d+')
->bind('updateAlumniAction');






$app->match('/recherche', 'WF3\Controller\HomeController::rechercheParUsername')
    ->bind('rechercheParUsername');


//Page d'information accès restreint
$app->match('/accesrestreint')
->bind('accesrestreint');


//ADMIN

$app->get('/admin', 'WF3\Controller\AdminController::indexAction')->bind('homeAdmin');


$app->match('/admin/alumni/update/{id}', 'WF3\Controller\AdminController::updateAdminAlumniAction')
->assert('id', '\d+')
->bind('updateAdminAlumniAction');

$app->get('/admin/user/delete/{id}', 'WF3\Controller\AdminController::deleteAdminUserAction')
->assert('id', '\d+')
->bind('deleteAdminUserAction');


$app->match('/admin/offre/update/{id}', 'WF3\Controller\AdminController::updateAdminOffreAction')
->assert('id', '\d+')
->bind('updateAdminOffreAction');

$app->get('/admin/offre/delete/{id}', 'WF3\Controller\AdminController::deleteAdminOffreAction')
->assert('id', '\d+')
->bind('deleteAdminOffreAction');


$app->get('/admin/subject/delete/{id}', 'WF3\Controller\AdminController::deleteAdminSubjectAction')
->assert('id', '\d+')
->bind('deleteAdminSubjectAction');

$app->get('/admin/response/delete/{id}', 'WF3\Controller\AdminController::deleteAdminResponseAction')
->assert('id', '\d+')
->bind('deleteAdminResponseAction');

$app->match('/admin/subject/update/{id}', 'WF3\Controller\AdminController::updateAdminSubjectAction')
->assert('id', '\d+')
->bind('updateAdminSubjectAction');

$app->match('/admin/response/update/{id}', 'WF3\Controller\AdminController::updateAdminResponseAction')
->assert('id', '\d+')
->bind('updateAdminResponseAction');

$app->match('/response/update/{id}', 'WF3\Controller\HomeController::updateResponseAction')
->assert('id', '\d+')
->bind('updateResponseAction');

$app->match('/subject/update/{id}', 'WF3\Controller\HomeController::updateSubjectAction')
->assert('id', '\d+')
->bind('updateSubjectAction');