<?php
namespace WF3\DAO;

use WF3\Domain\JobOffers;


class JoboffersDAO extends DAO{

	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    
    //méthode pour accéder à une offfre d'emploi détaillée par son id
    public function getDetailOffer($id){
        $result = $this->bdd->prepare('SELECT joboffers.id, title, date_offer, company, joboffers.city, description, skills, advantages, contract, contractduration, timetable, recruitername, recruitercontact FROM joboffers INNER JOIN users ON joboffers.users_id = users.id WHERE joboffers.id = :id ');
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);  
    }
    
    
    
    
    //méthode pour accéder aux offres d'emploi de la plus récente à la plus ancienne
	public function getLastOffers(){
		$result = $this->bdd->query('SELECT * FROM joboffers ORDER BY date_offers DESC');
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}

    
	//méthode de recherche d'une offre d'emploi par le titre
	 public function findOffersByTitle($title){
        $result = $this->bdd->prepare('SELECT id, title, company, city, date_offer, description, skills, advantages, contract, contractduration, timetable, recruitername, recruitercontact FROM joboffers WHERE title LIKE :title');
        $result->bindValue(':title', '%' . $title . '%');
        $result->execute();
        return $result->fetchALL(\PDO::FETCH_ASSOC);
    }
    
    
    //méthode de recherche d'emploi par la société
    public function findOffersByCompany($company){
		$result = $this->bdd->query('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers WHERE company LIKE :company');
        $result->bindValue(':company', '%' . $company . '%');
        $result->execute();
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}
    
    
    
    //méthode de recherche d'emploi par la date
    public function findOffersBydate($dateoffer){
		$result = $this->bdd->query('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers WHERE date_offer LIKE :dateoffer');
        $result->bindValue(':dateoffer', $dateoffer);
        $result->execute();
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}
    
    
    
     public function findJobModif($id){
        $resultat = $this->bdd->prepare('SELECT * FROM ' . $this->tableName .  ' WHERE users_id = :id');
        $resultat->bindvalue(':id', $id);
        $resultat->execute();
        $row = $resultat->fetch(\PDO::FETCH_ASSOC);
        return $this->buildObject($row);
        
    }
    
    
    
      public function updateJobModif($id, $data){
        
        if(is_object($data)){

           //on va transformer l'objet en tableau php        
           $dataArray = [];

           //on crée un tableau qui contient les noms des méthodes de notre objet
           $methods = get_class_methods($data);

           //je fais une boucle sur mes méthodes
           foreach($methods as $method){
               //si ma méthode est un setter (commence par set)
               //et que le getter correspondant existe
               if(preg_match('#^set#', $method) AND method_exists($data, str_replace('set', 'get', $method))){
                   //je récupère le getter
                   $getter = str_replace('set', 'get', $method);
                   //je rempli mon tableau avec en clé le nom de l'attribut (donc on enlève set et on met en minuscules)
                   //en valuer , le résultat de mon appel au getter
                   $dataArray[strtolower(str_replace('set', '', $method))] = $data->$getter();
               }
           }

           $data = $dataArray;

       }
        

        
        $sql = 'UPDATE ' . $this->tableName . ' SET ' ;
        
        foreach($data as $key=>$value){
        //on rajoute à la suite de sql avec .=
        $sql .= "$key = :$key, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .=  ' WHERE users_id = :id';

     
        
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
    	$joboffers = parent::buildObject($row);
    	//getAuthor() renvoie l'id de l'auteur de l'offre d'emploi
    	$iduser = $joboffers->getUsers_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	if(array_key_exists('users_id', $row) AND is_numeric($row['users_id'])){
        	$user = $this->userDAO->find($iduser);
        }
        //on remplace l'id de l'auteur par l'objet $auteur de la classe User qui contient les infos sur l'auteur
        $joboffers->setUsers_id($user);
        //on renvoie l'article
        return $joboffers;
    }
   

    
    
    
}

    