<?php


namespace WF3\DAO;


use WF3\Domain\Alumni;




class AlumniDao extends DAO 
{
    
    //je crée un attribut qui va contenir un objet de classe UserDAO (la lcasse qui nous permet de manipuler la table users)
	private $userDAO;
	//le setter associé
	public function setUserDAO(UsersDAO $userDAO){
		$this->userDAO = $userDAO;
	}
    
    //méthode de recherche d'un ancien élève par son id
    public function findAlumniByUser($id){
        $result = $this->bdd->prepare('SELECT alumni.id, promo, presentation, skills, status, searchjob, searchtime, job, contract, companytype, wage, companyname, linkedinurl, cv, sponsorship  FROM alumni INNER JOIN users ON alumni.alumni_id = users.id WHERE users.id = :id');
        $result->bindValue(':id', $id);
        $result->execute();
        return $result->fetch(\PDO::FETCH_ASSOC);
    }  
    
    
    
    
    
    
        


  
}


