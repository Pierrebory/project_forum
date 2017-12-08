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
        $result = $this->bdd->prepare('SELECT joboffers.id AS idJoboffers, title, description, skills, advantages, contract, contractduration, timetable FROM joboffers WHERE title LIKE :title');
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
    
    
    
   
   
    
    
    
    
    
}

    