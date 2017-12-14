<?php
namespace WF3\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WF3\Form\Type\AlumniType;
use WF3\Domain\Alumni;
use WF3\Form\Type\JoboffersType;
use WF3\Domain\JobOffers;




class AdminController{

    //page d'accueil du back office
    public function indexAction(Application $app){
       
        $users = $app['dao.users']->findAll();
        return $app['twig']->render('admin/index.admin.html.twig', array(
                                        
                                        'users' =>$users
                                    ));
    }



 public function updateAdminAlumniAction(Application $app, Request $request, $id){
          if(!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')){
            //je peux rediriger l'utilisateur non authentifié                     
            //return $app->redirect($app['url_generator']->generate('home'));
            throw new AccessDeniedHttpException();
        }
        //on récupère l'utilisateur connecté qui veut faire la suppression
        //on récupère le token si l'utilisateur est connecté
        //on récupère les infos de l'article
        $alumni = $app['dao.alumni']->findModif($id);
        
        //on crée le formulaire et on lui passe l'article en paramètre
        //il va utiliser $article pour pré remplir les champs
        $alumniForm = $app['form.factory']->create(AlumniType::class, $alumni);

        $alumniForm->handleRequest($request);

        if($alumniForm->isSubmitted() && $alumniForm->isValid()){
            //si le formulaire a été soumis
            //on update avec les données envoyées par l'utilisateur
            $app['dao.alumni']->updateModif($id, $alumni);
        }

       return $app['twig']->render('modification.alumni.html.twig', array(
           'alumniForm' => $alumniForm->createView(),
          'alumni' => $alumni)); 

    }


     public function deleteAdminUserAction(Application $app, $id){
        $article = $app['dao.users']->delete($id);
        //on crée un message de réussite dans la session
        $app['session']->getFlashBag()->add('success', 'fiche bien supprimé');
        //on redirige vers la page d'accueil
        return $app->redirect($app['url_generator']->generate('home'));
    }


    
  





public function updateAdminOffreAction(Application $app, Request $request, $id){
          if(!$app['security.authorization_checker']->isGranted('ROLE_ADMIN')){
            //je peux rediriger l'utilisateur non authentifié
            //return $app->redirect($app['url_generator']->generate('home'));
            throw new AccessDeniedHttpException();
        }
       
        //on récupère les infos de l'article
        $jobOffert = $app['dao.joboffers']->findJobModif($id);
         
        //on crée le formulaire et on lui passe l'article en paramètre
        //il va utiliser $article pour pré remplir les champs
        $offerForm = $app['form.factory']->create(JobOffersType::class, $jobOffert);

        $offerForm->handleRequest($request);

        if($offerForm->isSubmitted() && $offerForm->isValid()){
            //si le formulaire a été soumis
            //on update avec les données envoyées par l'utilisateur
            $app['dao.joboffers']->updateJobModif($id, $jobOffert);
        }

       return $app['twig']->render('modification.jobOffert.html.twig', array(
           'offerForm' => $offerForm->createView(),
          'jobOffert' => $jobOffert)); 

    }


    public function deleteAdminOffreAction(Application $app, $id){
        $article = $app['dao.joboffers']->delete($id);
        //on crée un message de réussite dans la session
        $app['session']->getFlashBag()->add('success', 'offre bien supprimé');
        //on redirige vers la page d'accueil
        return $app->redirect($app['url_generator']->generate('home'));
    }


    public function deleteAdminSubjectAction(Application $app, $id){
        $article = $app['dao.subject']->delete($id);
        //on crée un message de réussite dans la session
        $app['session']->getFlashBag()->add('success', 'offre bien supprimé');
        //on redirige vers la page d'accueil
        return $app->redirect($app['url_generator']->generate('home'));
    }


    public function deleteAdminResponseAction(Application $app, $id){
        $article = $app['dao.response']->delete($id);
        //on crée un message de réussite dans la session
        $app['session']->getFlashBag()->add('success', 'offre bien supprimé');
        //on redirige vers la page d'accueil
        return $app->redirect($app['url_generator']->generate('home'));
    }

}