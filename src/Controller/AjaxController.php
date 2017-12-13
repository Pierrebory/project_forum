<?php
namespace WF3\Controller;

use Silex\Application;
//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 
// les $_GET et $_POST
use Symfony\Component\HttpFoundation\Request;
use WF3\Domain\Subjects;
use WF3\Form\Type\SubjectType;
use WF3\DAO\UsersDAO;

class AjaxController{
    
    //page de recherche d'une offre d'emploi par son titre
    public function rechercheOffreparTitreAction(Application $app, Request $request){
        $joboffers=[];
        
        //$request->request est égal à $_POST
        //$request->query est égal à $_GET
        
        $joboffers = $app['dao.joboffers']->findOffersByTitle($request->query->get('title'));
        
        return $app['twig']->render('ajax/recherche.html.twig', array(
            'joboffers'=> $joboffers
        ));
    }

    // page de recherche d'offres d'emploi par ville
    public function rechercheOffreparVilleAction(Application $app, Request $request){
    
        $joboffers = $app['dao.joboffers']->findOffersByCity($request->query->get('city'));
        
        return $app['twig']->render('ajax/rechercheparville.html.twig', array(
            'joboffers'=> $joboffers
        ));
    }
    
    
     public function subjectPageAction(Application $app, Request $request){
       // je crée un objet Sujet vide
        $subject = new Subjects();

            $user = $app['user'];
         
         //on récupère le token si l'utilisateur est connecté
            $token = $app['security.token_storage']->getToken();
            if(NULL !== $token){
            $user = $token->getUser();
            }
         
            $subject->setDate_message(date('Y-m-d H:i:s'));
            $subject->setUser_id($user->getId());
            $subject->setTitle($request->query->get('subject')['title']);
            $subject->setMessage($request->query->get('subject')['message']);
              
            
            $app['dao.subject']->insert($subject);
            
            $subject->setUser_id($user);
        
            return $app['twig']->render('ajax/subject_forum.html.twig', array(
            'subject'=>$subject
            
            
    ));
    
}

}