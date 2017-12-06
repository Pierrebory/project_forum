<?php
namespace WF3\DAO;

class ResponseDAO extends DAO{
    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    public function getResponses(){
		$result = $this->bdd->query('SELECT * FROM forum_responses');
		$rows = $result->fetchALL(\PDO::FETCH_ASSOC);
        foreach($rows as $row){
            $responses[] = $this->buildObject($row);
        }
        return $responses;
	}
    
    
    
    
    
     //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $article de la classe Article
    	$response = parent::buildObject($row);
    	//getAuthor() renvoie l'id de l'auteur de l'article
    	$idAuteur = $response->getUser_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	if(array_key_exists('user_id', $row) AND is_numeric($row['user_id'])){
        	$auteur = $this->userDAO->find($idAuteur);
            //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur
            $response->setUser_id($auteur);
        }
        
        //on renvoie l'article
        return $response;
    }
}