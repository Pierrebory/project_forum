<?php
namespace WF3\DAO;

class JoboffersDAO extends DAO{

	//je crée un attribut qui va contenir un objet de classe UserDAO (la classe qui nous permet de manipuler la table users)
	private $userDAO;
	//le setter associé
	public function setUserDAO(UserDAO $userDAO){
		$this->userDAO = $userDAO;
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
    
    
    
    
}

    