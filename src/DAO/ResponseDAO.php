<?php
namespace WF3\DAO;

class ResponseDAO extends DAO{
    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    private $subjectDAO;
    public function setSubjectDAO(SubjectDAO $subjectDAO){
        $this->subjectDAO = $subjectDAO;
    }
    
    
    
    public function getResponses($idSubject){


		$result = $this->bdd->prepare('SELECT * FROM forum_responses  WHERE subject_id = :idSubject ORDER BY date_message ASC');
        $result->bindValue(':idSubject', $idSubject);
        $result->execute();
		$rows = $result->fetchALL(\PDO::FETCH_ASSOC);
        $responses = [];


        foreach($rows as $row){
            $responses[] = $this->buildObject($row);
        }
        return $responses;
	}
    
    
    public function findResponseModif($id){
        $resultat = $this->bdd->prepare('SELECT * FROM ' . $this->tableName .  ' WHERE id = :id');
        $resultat->bindvalue(':id', $id);
        $resultat->execute();
        $row = $resultat->fetch(\PDO::FETCH_ASSOC);
        return $this->buildObject($row);
        
    }
    


    public function updateResponseModif($id, $data){
        
        if(is_object($data)){

        $dataArray = ['message' => $data->getMessage(), 'date_message' => $data->getDate_message(), 'date_edit' => $data->getDate_edit()];
           $data = $dataArray;

       }
        

        
        $sql = 'UPDATE ' . $this->tableName . ' SET ' ;
        
        foreach($data as $key=>$value){
        //on rajoute à la suite de sql avec .=
        $sql .= "$key = :$key, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .=  ' WHERE id = :id';

     
        
        $update = $this->bdd->prepare($sql);
        
        foreach($data as $key=>$value){
            //on va créer les lignes bindvalue correspondantes
            $update->bindvalue(':' .$key, strip_tags($value));
        }
        
        $update->bindvalue(':id', $id, \PDO::PARAM_INT);
        
        if($update->execute()){
            return true;
            }
         
            return false;
    
        
        
    }
    
    
    
    
     //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $article de la classe Article
    	$response = parent::buildObject($row);
    	//getAuthor() renvoie l'id de l'auteur de l'article
    	$idAuteur = $response->getUser_id();
        $idsubject = $response->getSubject_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	if(array_key_exists('user_id', $row) AND is_numeric($row['user_id'])){
        	$auteur = $this->userDAO->find($idAuteur);
            //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur
            $response->setUser_id($auteur);
            
            $subject = $this->subjectDAO->find($idsubject);
            $response->setSubject_id($subject);
        }
        
        //on renvoie l'article
        return $response;
    }

    
    
    /*public function responsesajax(){
        $result = $this->bdd->query('SELECT * FROM forum_responses');
        $rows =  $result->fetchALL(\PDO::FETCH_ASSOC);
        $responses = [];
        foreach($rows as $row){
            $response = $this->buildobject($row);
            $responses[$row['id']] = $response;
        }
        return $responses;
    }*/
}