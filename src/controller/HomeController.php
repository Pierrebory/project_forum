<?php
namespace WF3\Controller;

use Silex\Application;
//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 

class HomeController{

	//page d'accueil qui affiche tout les articles
	public function homePageAction(Application $app){
		

	 	return $app['twig']->render('index.html.twig');
	}
 
    
    public function forumPageAction(Application $app){
		$subject = $app['dao.subject']->getSubject();

	 	return $app['twig']->render('subject_forum.html.twig', array('subject' => $subject));
	}
}