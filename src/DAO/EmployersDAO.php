<?php


namespace WF3\DAO;

use WF3\Domain\Employer;


class EmployersDao extends DAO 
{
    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
	private $usersDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $usersDAO){
		$this->usersDAO = $usersDAO;
	}
    

    
    
    //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $employer de la classe Employer
    	$employer = parent::buildObject($row);
    	//getEmployer_id() renvoie l'id de l'employeur
    	$idemployer = $employer->getEmployer_id();
    	//on utilise l'attribut userDAo qui contient l'instance de la classe UserDAO 
    	//pour aller chercher dans la table users les infos de l'employeur correspondant
    	if(array_key_exists('employer_id', $row) AND is_numeric($row['employer_id'])){
        	$employeur = $this->usersDAO->find($idemployer);
        }
        //on remplace employer_id par l'objet $employer de la classe Employer qui contient les infos sur l'employeur
        $employer->setEmployer_id($employeur);
        //on renvoie la fiche complète de l'employeur
        return $employer;
    }

    
    
        


  
}


