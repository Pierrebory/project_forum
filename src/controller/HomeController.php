<?php
namespace WF3\Controller;

use Silex\Application;
//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 

class HomeController{

	//page d'accueil qui affiche tout les articles
	public function homePageAction(Application $app){

	 	return $app['twig']->render('index.html.twig');
	}
    
    
    //page Annuaire qui affiche uniquement les noms des anciens élèves
    public function annuaireAction(Application $app){
        $users = $app['dao.users']->displayName();
        return $app['twig']->render('annuaire.html.twig', array('users' => $users)); 
    }
    
    
  
    
    
    
    
    
 
    
    public function forumPageAction(Application $app){
		$subjects = $app['dao.subject']->getSubjects();

	 	return $app['twig']->render('subject_forum.html.twig', array('subjects' => $subjects));
	}
}