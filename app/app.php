<?php
//on utilise des composants Symfony qui vont nous permettre d'avoir des erreurs plus précises
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Silex\Provider;

//On enregistre ces services dans l'application Silex
ErrorHandler::register();
ExceptionHandler::register();

$app->register(new Provider\HttpFragmentServiceProvider());
$app->register(new Provider\ServiceControllerServiceProvider());

//On enregistre le service dbal
$app->register(new Silex\Provider\DoctrineServiceProvider());

//on enregistre le service twig
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

//enregistrement du service Symfony asset 
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
   'security.firewalls' => array(
       'secured' => array(
           'pattern' => '^/',
           'anonymous' => true,
           'logout' => true,
           'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
           'users' => function () use ($app) {
               return new WF3\DAO\UsersDAO($app['db'], 'users', 'WF3\Domain\User');
           },
           'logout' => array('logout_path' => '/logout', 'invalidate_session' => true)
       ),
   ),
   'security.role_hierarchy' => array(
      'ROLE_ADMIN' => array('ROLE_USER')
    ),
   'security.access_rules' => array(
      array('^/admin', 'ROLE_ADMIN')
    )
));





//service web profiler de symfony
$app->register(new Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    'profiler.mount_prefix' => '/_profiler', // this is the default
));
//ajout du odule dbal au webprofiler
$app->register(new Sorien\Provider\DoctrineProfilerServiceProvider());

//enregistrement du composant form
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

//enregistrement du service Validator
$app->register(new Silex\Provider\ValidatorServiceProvider());

//enregistrement du service SwiftMailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
//swiftmailer
$app['swiftmailer.options'] = array(
    'host' => 'mail.gmx.com',
    'port' => '465',
    'username' => 'promo5wf3@gmx.fr',
    'password' => 'ttttttttt33',
    'encryption' => 'SSL',
    'auth_mode' => null
);



//on enregistre un nouveau service :
//on pourra ainsi accéder à notre classe UsersDAO grâce à $app['dao.users'] 
$app['dao.users'] = function($app){
    
	return new WF3\DAO\UsersDAO($app['db'], 'users', 'WF3\Domain\User');
};




$app['dao.subject'] = function($app){
	$subjectDAO = new WF3\DAO\SubjectDAO($app['db'], 'forum_subjects', 'WF3\Domain\Subjects');
    $subjectDAO->setUserDAO($app['dao.users']);
    return $subjectDAO;

};

$app['dao.response'] = function($app){
	$responseDAO = new WF3\DAO\ResponseDAO($app['db'], 'forum_responses', 'WF3\Domain\Responses');
    $responseDAO->setUserDAO($app['dao.users']);
    $responseDAO->setSubjectDAO($app['dao.subject']);
    return $responseDAO;

};

$app['dao.resetpass'] = function($app){
  $resetpassDAO = new WF3\DAO\ResetpassDAO($app['db'], 'resetpass', 'WF3\Domain\Reset');
    $resetpassDAO->setUserDAO($app['dao.users']);
    return $resetpassDAO;

};



$app['dao.alumni'] = function($app){
	$AlumniDAO = new WF3\DAO\AlumniDAO($app['db'], 'alumni', 'WF3\Domain\Alumni');
    $AlumniDAO->setUserDAO($app['dao.users']);
    return $AlumniDAO;
};


$app['dao.joboffers'] = function($app){
    $joboffersDAO = new WF3\DAO\JoboffersDAO($app['db'], 'joboffers', 'WF3\Domain\JobOffers');
    $joboffersDAO->setUserDAO($app['dao.users']);
    return $joboffersDAO;
};


$app['dao.privatemessage'] = function($app){
    $privatemessageDAO = new WF3\DAO\PrivatemessageDAO($app['db'], 'privatemessage', 'WF3\Domain\PrivateMessage');
    $privatemessageDAO->setUserDAO($app['dao.users']);
    return $privatemessageDAO;
    
};



//set globals variables
$app->before(function () use ($app) {
    if($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')){
      $app['twig']->addGlobal('messagesCounter', $app['dao.privatemessage']->unreadMessages($app['security.token_storage']->getToken()->getUser()->getId()));
    }
});