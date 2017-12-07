<?php
namespace WF3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 
use WF3\Domain\User;
use WF3\Domain\Subjects;
use WF3\Domain\Responses;
use WF3\Form\Type\ConnectType;
use WF3\Domain\Employer;
use WF3\Domain\JobOffers;
use WF3\Form\Type\RegisterType;
use WF3\Form\Type\SubjectType;
use WF3\Form\Type\ResponsesType;


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
    public function getAlumniAction(Application $app, $id){
        $user = $app['dao.users']->find($id);
        $alumni = $app['dao.alumni']->findAlumniByUser($id);
        return $app['twig']->render('fichedetaillealumni.html.twig', array('user' => $user,
                                                                           'alumni' => $alumni)); 
    }
    
    //PAGE LISTE DES OFFRES D'EMPLOI
    public function offresAction(Application $app, $idemployer){
        $employeur = $app['dao.employers']->find($idemployer); 
        $offres = $app['dao.joboffers']->findAll();  
        return $app['twig']->render('listeoffresemploi.html.twig', array('offres' => $offres,
                                                                        'employeur' => $employeur)); 
    }
    
    
    //PAGE DE DETAIL DE L'OFFRE D'EMPLOI
    public function detailOffreAction(Application $app, $id, $idemployer){
        //je récupère l'id de l'offre d'emploi
        $detailoffre = $app['dao.joboffers']->getAllOffer($id);
        $employeur = $app['dao.employers']->findEmployerById($idemployer);
        return $app['twig']->render('detailoffre.html.twig', array('detailoffre' => $detailoffre,
                                                                    'employeur' => $employeur)); 

    }
    
 
    ///////////////////////PAGE SUJET FORUM////////////////////////
    public function forumPageAction(Application $app, Request $request){
        $subject = new Subjects();
        $subjects =[];
        $subjectForm = $app['form.factory']->create(subjectType::class, $subject);
        $subjectForm->handleRequest($request);
                 $subjects = $app['dao.subject']->getSubjects();

        if($subjectForm->isSubmitted() AND $subjectForm->isValid()){
        $subject->setUser_id(1);
             $subject->setDate_message(date('Y-m-d H:i:s'));

		 $app['dao.subject']->insert($subject);

	 	
	   }
        return $app['twig']->render('subject_forum.html.twig', array(
            'subjectForm'=>$subjectForm->createView(),
            'subject'=>$subject,
        'subjects'=>$subjects));
   

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

		    $app['dao.users']->insert($user);				
		    $app['session']->getFlashBag()->add('success', 'vous êtes bien enregistré');
		    return $app->redirect($app['url_generator']->generate('home'));			
		}

		// j'envoi le formulaire
		return $app['twig']->render('register.html.twig', array(
			'userForm' => $userForm->createView(),
		));		
	}

		/////////////// CONNEXION //////////////////
	public function loginAction(Application $app, Request $request){

		return $app['twig']->render('login.html.twig', array(
			'error' => $app['security.last_error']($request), 
			'last_username' => $app['session']->get('_security.last_username')
		));
	}	
    
    
     ///////////////////////PAGE REPONSE FORUM////////////////////////
    public function subjectAction(Application $app, Request $request, $idSubject){
        $response = new Responses();
        $responses =[];
        $responsesForm = $app['form.factory']->create(ResponsesType::class, $response);
        $responsesForm->handleRequest($request);
                 $responses = $app['dao.response']->getResponses($idSubject);

        if($responsesForm->isSubmitted() AND $responsesForm->isValid()){
        $response->setUser_id(1);
            $response->setSubject_id($idSubject);
            $response->setDate_message(date('Y-m-d H:i:s'));
		 $app['dao.response']->insert($response);

	 	
	   }
        return $app['twig']->render('responses_forum.html.twig', array(
            'responsesForm'=>$responsesForm->createView(),
            'response'=>$response,
        'responses'=>$responses));
   

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}