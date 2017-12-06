<?php
namespace WF3\DAO;

use WF3\Domain\JobOffers;


class JoboffersDAO extends DAO{

	//je crée un attribut qui va contenir un objet de classe employerDAO (la classe qui nous permet de manipuler la table employers)
	private $employersDAO;
	//le setter associé
	public function setEmployersDAO(EmployersDAO $employersDAO){
		$this->employersDAO = $employersDAO;
	}

    
    //méthode pour accéder à une offfre d'emploi détaillée par son id
    public function getAllOffer($id){
      $result = $this->bdd->prepare('SELECT joboffers.id, title, city, date_offer, description, skills, advantages, contract, contractduration, timetable FROM joboffers INNER JOIN employers ON joboffers.employer_id = employers.id WHERE joboffers.id = :id');
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
        $result = $this->bdd->prepare('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers INNER JOIN employers ON joboffers.employer_id = employers.id WHERE title LIKE :title');
        $result->bindValue(':title', '%' . $title . '%');
        $result->execute();
        return $result->fetchALL(\PDO::FETCH_ASSOC);
    }
    
    
    //méthode de recherche d'emploi par la société
    public function findOffersByCompany($company){
		$result = $this->bdd->query('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers INNER JOIN employers ON joboffers.employer_id = employers.id WHERE company LIKE :company');
        $result->bindValue(':company', '%' . $company . '%');
        $result->execute();
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}
    
    
    
    //méthode de recherche d'emploi par la date
    public function findOffersBydate($dateoffer){
		$result = $this->bdd->query('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers INNER JOIN employers ON joboffers.employer_id = employers.id WHERE date_offer LIKE :dateoffer');
        $result->bindValue(':dateoffer', $dateoffer);
        $result->execute();
		return $result->fetchALL(\PDO::FETCH_ASSOC);
	}
    
    
    //je réécris ma méthode buildObject 
    public function buildObject($row){
    	//j'exécute le code de buildObject dans DAO
    	//qui me renvoie un objet $joboffers de la classe Joboffers
    	$joboffer = parent::buildObject($row);
    	//getEmployer_id() renvoie l'id de l'employer
    	$idemployer = $joboffer->getEmployer_id();
    	//on utilise l'attribut employersDAo qui contient l'instance de la classe employerDAO 
    	//pour aller chercher dans la table employers les infos de l'employeur correspondant
    	if(array_key_exists('employer_id', $row) AND is_numeric($row['employer_id'])){
        	$employer = $this->employersDAO->find($idemployer);
        }
        //on remplace l'id de l'employer par l'objet $employer de la classe EmployersDAO qui contient les infos sur l'employeur
        $joboffer->setEmployer_id($employer);
        //on renvoie la fiche complète de l'offre d'emploi avec les infos de l'employeur
        return $joboffer;
    }
   
    
}

    