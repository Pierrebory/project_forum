<?php
namespace WF3\Controller;

use Silex\Application;
//cette ligne nous permet d'utiliser le service fourni par symfony pour gérer 
// les $_GET et $_POST
use Symfony\Component\HttpFoundation\Request;

class AjaxController{
    
    //page de recherche d'une offre d'emploi par son titre
    public function rechercheOffreparTitreAction(Application $app, Request $request){
        
        
        //$request->request est égal à $_POST
        //$request->query est égal à $_GET
        $post = $request->request->get('search_engine');
        $joboffers = $app['dao.joboffers']->findOffersByTitle($post['title']);
        
        return $app['twig']->render('ajax/recherche.html.twig', array(
            'joboffers'=>$joboffers
        ));
    }


}