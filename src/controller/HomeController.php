<?php
namespace WF3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


use WF3\Domain\User;
use WF3\Domain\Subjects;
use WF3\Domain\Responses;
use WF3\Form\Type\ConnectType;
use WF3\Domain\Employer;
use WF3\Domain\JobOffers;
use WF3\Domain\Resetpass;
use WF3\Domain\Alumni;
use WF3\Form\Type\RegisterType;
use WF3\Form\Type\ResetType;
use WF3\Form\Type\ResetpassType;
use WF3\Form\Type\SubjectType;
use WF3\Form\Type\ResponsesType;
use WF3\Form\Type\ContactType;
use WF3\Form\Type\JoboffersType;
use WF3\Form\Type\AlumniType;
use WF3\Form\Type\RechercheUsernameType;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


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
    public function offresAction(Application $app){
        $offres = $app['dao.joboffers']->findAll();  
        return $app['twig']->render('listeoffresemploi.html.twig', array('offres' => $offres)); 
    }
    
    
    //PAGE DE DETAIL DE L'OFFRE D'EMPLOI
    public function detailOffreAction(Application $app, $id){
        $detailoffre = $app['dao.joboffers']->getDetailOffer($id);
        return $app['twig']->render('detailoffre.html.twig', array('detailoffre' => $detailoffre)); 

    }
    
    
    //PAGE FORMULAIRE POUR POSTER UNE OFFRE D'EMPLOI
    public function formulaireOffreAction(Application $app, Request $request){
        //on va vérifier que l'utilisateur est connecté
    	//if(!$app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')){
            //je peux rediriger l'utilisateur non authentifié
            //return $app->redirect($app['url_generator']->generate('home'));
            //throw new AccessDeniedHttpException();
        //}
        
        //on récupère le token si l'utilisateur est connecté
        //$token = $app['security.token_storage']->getToken();
        //if(NULL !== $token){
            //$user = $token->getUser();
        //}

    	//je crée un objet offre vide
    	$offer = new JobOffers();
    	//je crée mon objet formulaire à partir de la classe JoboffersType
    	$offerForm = $app['form.factory']->create(JoboffersType::class, $offer);
    	//on envoie les paramètres de la requête à notre objet formulaire
    	$offerForm->handleRequest($request);
    	//on vérifie si le formulaire a été envoyé
    	//et si les données envoyées sont valides
    	if($offerForm->isSubmitted() && $offerForm->isValid()){
    		
    		//on insère dans la base les éléments de l'offre
    		$app['dao.joboffers']->insert(array(
    			'title'=>$offer->getTitle(),
    			'company'=>$offer->getCompany(),
    			'city'=>$offer->getCity(),
                'description'=>$offer->getDescription(),
                'skills'=>$offer->getSkills(),
                'advantages'=>$offer->getAdvantages(),
                'contract'=>$offer->getContract(),
                'contractduration'=>$offer->getContractduration(),
                'timetable'=>$offer->getTimetable(),
                'recruitername'=>$offer->getRecruitername(),
                'recruitercontact'=>$offer->getRecruitercontact(),
                            
    		));
    		//on stocke en session un message de réussite
    		$app['session']->getFlashBag()->add('success', 'Offre d\'emploi bien reçue. Merci !');

    	}

    	//j'envoie à la vue le formulaire grâce à $offerForm->createView() 
    	return $app['twig']->render('formulaireemploi.html.twig', array(
    			'offerForm' => $offerForm->createView()
    	));
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
		    $app['session']->getFlashBag()->add('success', 'Vous êtes bien enregistré(e). Vous pouvez à présent vous connecter.');
		    		
		}

		// j'envoie le formulaire
		return $app['twig']->render('register.html.twig', array(
			'userForm' => $userForm->createView(),
		));		
	}

		/////////////// CONNEXION //////////////////
	public function loginAction(Application $app, Request $request){

	       return $app['twig']->render('login.html.twig', array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
             $app['session']->getFlashBag()->add('success', 'Vous êtes bien connecté(e). Vous pouvez remplir votre fiche détaillée dans l\'annuaire et/ou poster une offre d\'emploi.'),
         
			
		));
	}	

    /////////////////////// RESET MOT DE PASSE ///////////////////////////
    public function resetPassAction(Application $app, Request $request){
    // on va vérifier que l'utilisateur est connecté



    $resetForm = $app['form.factory']->create(ResetType::class);
    // on envoie les paramètres de la requête à notre objet formulaire
    $resetForm->handleRequest($request); 

    if($resetForm->isSubmitted() && $resetForm->isValid()){
        $data = $resetForm->getData();
        $token = md5(uniqid(rand(), true));
        $user = $app['dao.resetpass']->selectReset($data['email']);   
        $app['dao.resetpass']->insertReset($token, $user['id']);        
        $message = \Swift_Message::newInstance()
                        ->setFrom(array('promo5wf3@gmx.fr'))
                        ->setTo(array($data['email']))
                        ->setBody($app['twig']->render('emailReset.html.twig', 
                            array(
                            'username' => $user['username'],
                            'id' => $user['id'],
                            'email' => $data['email'],
                            'token' => $token
                        )
                    ), 'text/html');
            $app['mailer']->send($message);
    }

    // j'envoi le formulaire
    return $app['twig']->render('reset.html.twig', array(
        'resetForm' => $resetForm->createView(),
        'data' => $resetForm->getData(),
    ));         
}   

    /////////////// FORMULAIRE RESET MOT DE PASSE ///////////////////////////
    public function changePassAction(Application $app, Request $request, $id, $token){
    // on va vérifier que l'utilisateur est connecté

    $user = new User();
    $resetForm = $app['form.factory']->create(ResetpassType::class, $user);
    // on envoie les paramètres de la requête à notre objet formulaire
    $resetForm->handleRequest($request); 

    $token = $request->attributes->get('token');
    $test = $app['dao.resetpass']->findToken($id);

    if($token != $test['token']){
        throw new AccessDeniedHttpException();
    }    
   

    if($resetForm->isSubmitted() && $resetForm->isValid()){
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

        $app['dao.resetpass']->updatePassword($id, $token, $user->getPassword(), $user->getSalt() );
        $app['session']->getFlashBag()->add('success', 'Votre mot de passe a bien été modifié.');
        return $app->redirect($app['url_generator']->generate('home'));     
    }

    // j'envoi le formulaire
    return $app['twig']->render('resetForm.html.twig', array(
        'resetForm' => $resetForm->createView()
    ));         
}   

    
    
     ///////////////////////PAGE REPONSE FORUM////////////////////////
     /* public function subjectAction(Application $app, Request $request, $idSubject, $idUser){
        
        $response = new Responses();
        $responses =[];
        $responsesForm = $app['form.factory']->create(ResponsesType::class, $response);
        $responsesForm->handleRequest($request);
                 $responses = $app['dao.response']->getResponses($idSubject, $idUser);

        if($responsesForm->isSubmitted() AND $responsesForm->isValid()){
        $response->setUser_id($idUser);
         $response->setSubject_id($idSubject);
        $response->setDate_message(date('Y-m-d H:i:s'));
		 $app['dao.response']->insert($response);

	 	
	   }
        return $app['twig']->render('responses_forum.html.twig', array(
            'responsesForm'=>$responsesForm->createView(),
            'response'=>$response,
        'responses'=>$responses));
   

    }*/
    
    /////////////////////////////PAGE REPONSE FORUM////////////////////////////
    public function subjectAction(Application $app, Request $request, $idSubject){
        
        $response = new Responses();
        $responses =[];
        $responsesForm = $app['form.factory']->create(ResponsesType::class, $response);
        $responsesForm->handleRequest($request);
                 $responses = $app['dao.response']->getResponses($idSubject);

        if($responsesForm->isSubmitted() AND $responsesForm->isValid()){
        $response->setUser_id(3);
         $response->setSubject_id($idSubject);
        $response->setDate_message(date('Y-m-d H:i:s'));
		 $app['dao.response']->insert($response);

	 	
	   }
        return $app['twig']->render('responses_forum.html.twig', array(
            'responsesForm'=>$responsesForm->createView(),
            'response'=>$response,
        'responses'=>$responses));
   

    }
    
    
    
    
    
    
    
    ///////////////////////PAGE CONTACT///////////////////
	public function contactAction(Application $app, Request $request){
        $contactForm = $app['form.factory']->create(ContactType::class);
        $contactForm->handleRequest($request);
        
        if ($contactForm->isSubmitted() && $contactForm->isValid())
        {
            $data = $contactForm->getData();
            $message = \Swift_Message::newInstance()
                        ->setSubject($data['subject'])
                        ->setFrom(array('promo5wf3@gmx.fr'))
                        ->setTo(array('pier.bory@gmail.com'))
                        ->setBody($app['twig']->render('contact.email.html.twig',
                            array('name'=>$data['name'],
                                   'email' => $data['email'],
                                   'message' => $data['message']
                            )
                        ), 'text/html');

            $app['mailer']->send($message);


        }
        return $app['twig']->render('contact.html.twig', array(
            'title' => 'Contact Us',
            'contactForm' => $contactForm->createView(),
            'data' => $contactForm->getData()
        ));
	}
    
    
    
    
    	public function alumniAction(Application $app, Request $request){
        $alumni = new Alumni();
		$alumniForm = $app['form.factory']->create(AlumniType::class, $alumni);
		// on envoie les paramètres de la requête à notre objet formulaire
		$alumniForm->handleRequest($request); 
		// si le formulaire a été envoyé
		if($alumniForm->isSubmitted() && $alumniForm->isValid()){


		    $app['dao.alumni']->insert($alumni);				
		    $app['session']->getFlashBag()->add('success', 'vous êtes bien enregistré');
		    return $app->redirect($app['url_generator']->generate('home'));			
		}

		// j'envoi le formulaire
		return $app['twig']->render('alumni.html.twig', array(
			'alumniForm' => $alumniForm->createView(),
		));		
	}
    
    
    
    public function rechercheParUsername(Application $app, Request $request){
        
        $user =[];
        $rechercheForm = $app['form.factory']->create(RechercheUsernameType::class);
        $rechercheForm->handleRequest($request);
        if($rechercheForm->isSubmitted() AND $rechercheForm->isValid()){
            //le formulaire a été envoyé
            //$request->request est égal à $_POST
            //$request->query est égal à $_GET
            $post = $request->request->get('search_engine');
            $user = $app['dao.users']->getUsernameLike($post['name']);
        }
        return $app['twig']->render('recherche.username.html.twig', array(
            'form'=>$rechercheForm->createView(),
            'user'=>$user//,
            //'test'=>$request->files->get('search_engine')['attachment']->getOriginalName()
        ));
    }
    
    
    
    
    
}