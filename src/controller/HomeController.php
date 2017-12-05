<?php
namespace WF3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 
use WF3\Domain\User;
use WF3\Form\Type\RegisterType;
use WF3\Form\Type\SubjectType;

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
    
    
    
 
    
    public function forumPageAction(Application $app, Request $request){
         $subjectForm = $app['form.factory']->create(subjectType::class);
        $subjectForm->handleRequest($request);
        if($subjectForm->isSubmitted() AND $subjectForm->isValid()){
            
		$subjects = $app['dao.subject']->getSubjects();

	 	return $app['twig']->render('subject_forum.html.twig', array(
            'form'=>$subjectForm->createView(),
            'subjects' => $subjects));
	}
    }

	//////////// FORMULAIRE INSCRIPTION ////////////
    public function registerAction(Application $app, Request $request){
		$user = new User();
		$userForm = $app['form.factory']->create(RegisterType::class, $user);
		// on envoie les paramètres de la requête à notre objet formulaire
		$userForm->handleRequest($request); 
		// si le formulaire a été envoyé
		if($userForm->isSubmitted() && $userForm->isValid()){

	        $salt = substr(md5(time()), 0, 23);
	        $user->setSalt($salt);
	        //on récupère le mot de passe en clair (envoyé par l'utilisateur)
	        $plainPassword = $user->getPassword();
	        // on récupère l'encoder de silex
	        $encoder = $app['security.encoder.bcrypt'];
	        // on encode le mdp
	        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
	        //on remplace le mdp en clair par le mdp crypté
	        $user->setPassword($password);

		    $app['dao.user']->insert($user);				
		    $app['session']->getFlashBag()->add('success', 'vous êtes bien enregistré');
		    return $app->redirect($app['url_generator']->generate('home'));			
		}

		// j'envoi le formulaire
		return $app['twig']->render('register.html.twig', array(
			'userForm' => $userForm->createView(),
		));		
	}	
}