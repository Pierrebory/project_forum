<?php

/*namespace WF3\Controller;

use Silex\Application;
//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 
// les $_GET et $_POST
use Symfony\Component\HttpFoundation\Request;
use WF3\Form\Type\ResponsesType;


class AjaxController{
    
    //page de recherche par auteur
    public function AjaxActionForum(Application $app, Request $request){
        
        
        //$request->request est égal à $_POST
        //$request->query est égal à $_GET
        $message = $request->request->get('responses')['message'];
        
         $responsesForm = $app['form.factory']->create(ResponsesType::class, $message);
        $responsesForm->handleRequest($request);
        
        $responses = $app['dao.response']->getResponses($message);     
         if($responsesForm->isSubmitted() AND $responsesForm->isValid()){
        $response->setUser_id(1);
            
            $response->setDate_message(date('Y-m-d H:i:s'));
		 $app['dao.response']->insert($response);

	 	
	   }
        return $app['twig']->render('ajax/recherche.html.twig', array(
            'responses'=>$responses
        ));
    }


}*/
