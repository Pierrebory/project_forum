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
        $users = $app['dao.users']->findAll();
        return $app['twig']->render('annuaire.html.twig', array('users' => $users)); 
    }
    
    
  //page détaillée d'un ancien élève
    public function getAlumniAction(Application $app, $userid){
        $user = $app['dao.users']->displayAlumni($userid);
        return $app['twig']->render('fichedetailleealumni.html.twig', array('user' => $user)); 
    }
    
    
    
 
    
    public function forumPageAction(Application $app){
		$subject = $app['dao.subject']->getSubject();

	 	return $app['twig']->render('subject_forum.html.twig', array('subject' => $subject));
	}
}