<?php
namespace WF3\DAO;

use WF3\Domain\JobOffers;


class PrivatemessageDAO extends DAO{

	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    

    
    
    
    
    //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $article de la classe Article
    	$privatemessage = parent::buildObject($row);
    	//getAuthor() renvoie l'id de l'auteur de l'offre d'emploi
    	
        $idreceiver = $privatemessage->getUsers_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	
        
        if(array_key_exists('receiver_id', $row) AND is_numeric($row['receiver_id'])){
        	$user = $this->userDAO->find($idreceiver);
        }
        
        
        //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur
    
        $privatemessage->setUsers_id($user);
        //on renvoie l'article
        return $privatemessage;
    }
   

    
    
    
}

    