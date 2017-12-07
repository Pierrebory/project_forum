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


