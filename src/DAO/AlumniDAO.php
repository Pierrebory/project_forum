<?php


namespace WF3\DAO;


class AlumniDao extends DAO 
{
    
    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
	private $usersDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $usersDAO){
		$this->usersDAO = $usersDAO;
	}
    
    //méthode de recherche d'un ancien élève par son id
    public function findAlumniByUser($id){
        $result = $this->bdd->prepare('SELECT * FROM alumni INNER JOIN users ON alumni.alumni_id = users.id WHERE users.id = :id');
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);
    }  
    
    
    
      public function findModif($id){
        $resultat = $this->bdd->prepare('SELECT * FROM ' . $this->tableName .  ' WHERE alumni_id = :id');
        $resultat->bindvalue(':id', $id);
        $resultat->execute();
        $row = $resultat->fetch(\PDO::FETCH_ASSOC);
        return $this->buildObject($row);
        
    }
    
    
    
      public function updateModif($id, $data){
        
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
        $sql .=  ' WHERE alumni_id = :id';

     
        
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
    	//qui me renvoie un objet $alumni de la classe Alumni
    	$alumni = parent::buildObject($row);
    	//getAlumni_id() renvoie l'id du user
    	$idalumni = $alumni->getAlumni_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'utilisateur correspondant
    	if(array_key_exists('alumni_id', $row) AND is_numeric($row['alumni_id'])){
        	$ancieneleve = $this->usersDAO->find($idalumni);
        }
        //on remplace l'id de l'alumni par l'objet $ancieneleve de la classe Users qui contient les infos sur l'ancien élève
        $alumni->setAlumni_id($ancieneleve);
        //on renvoie la fiche complète de l'ancien élève
        return $alumni;
    }

    
    
    
        


  
}


